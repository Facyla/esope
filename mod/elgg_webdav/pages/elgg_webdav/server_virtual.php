<?php
/**
 * Elgg WebDAV virtual folders support
 *
 * @package ElggWebDAV
 */

/* This page implements virtual folders support :
 * Structure : 
 - private : personal files
 - public : all site files (depending on access) - readonly
 - groups => groups files - readonly except for groups members and admins
 - users => members files - readonly except own folder
 */

elgg_push_breadcrumb(elgg_echo('elgg_webdav'), 'webdav');
elgg_push_breadcrumb(elgg_echo('elgg_webdav:virtual'), 'webdav/virtual');


// Load SabreDAV library
elgg_load_library('elgg:webdav:sabreDAV');


/**********************************************/
/* Define paths (and optionally create them) */
/**********************************************/

$base_path = elgg_get_data_path() . 'webdav';
$data_path = $base_path . '/data';
$locks_path = $data_path . '/locks';
$tmp_path = $base_path . '/tmp';
//$public_path = $base_path . '/public';
if (!file_exists($base_path)) { mkdir($base_path, 0770); }
if (!file_exists($data_path)) { mkdir($data_path, 0770); }
if (!file_exists($locks_path)) { mkdir($locks_path, 0770); }
if (!file_exists($tmp_path)) { mkdir($tmp_path, 0770); }
//if (!file_exists($public_path)) { mkdir($public_path, 0770); }

// As server is not on webroot, so we need to set it to the correct information (eg. /elgg/webdav/virtual)
// Relative endpoint URL, without domain
$base_uri = parse_url(elgg_get_site_url() . 'webdav/virtual');
$base_uri = $base_uri['path'];


/*************************************/
/* Load (and define) lib and classes */
/*************************************/

// Define auth plugin : authentication through Elgg
$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($username, $password) {
	$debug = elgg_get_plugin_setting('debug', 'elgg_webdav', false);
	// Return result quickly if already logged in
	if (elgg_is_logged_in()) {
		if ($debug) { error_log("WebDAV : $username authenticated"); }
		return true;
	}
	// check the username and password here, and then just return true or false.
	if ($debug) { error_log("WebDAV : authenticating $username"); }
	// check if logging in with email address
	if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
		$username = $users[0]->username;
	}
	// Check authentication : much used so be as quick as possible
	$authenticated = elgg_authenticate($username, $password);
	if ($authenticated === true) {
		if ($debug) { error_log("WebDAV : $username authentication verified => logging in"); }
		$user = get_user_by_username($username);
		// Keep user authenticated to avoid checking every time
		login($user, true);
		return true;
	}
	return false;
});
$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend, '');


/*  Virtual folders support */

/* Top level (abstract) collections
 * These do not link to actual files but are used to organize logically the WebDAV repository
 *  - each top level Collection should implement Collection helper classes
 *  - but not Node helper class (lastModified, delete, setName) which are non-sense in that context
 */

// PRIVATE (personal) folder : lists owner files (not those in groups !)
// @TODO list folders if enabled
class PrivateCollection extends Sabre\DAV\Collection {
	protected $user_guid;
	function __construct() {
		$this->user_guid = elgg_get_logged_in_user_guid();
	}
	// Return user personal files (or also in groups ?)
	// @TODO return sub-folders if enabled
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->user_guid, 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return 'private'; }
	// Edit functions
	function createFile($name, $data = null) {
		if (elgg_is_logged_in()) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => $this->user_guid, 'access_id' => 0));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:permissiondenied'));
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
}

// PUBLIC folder : list all accessible files, in read-only mode
class PublicCollection extends Sabre\DAV\Collection {
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return 'public'; }
	// Edit functions - readonly folder
	// Note : should we allow new files here ? better not because we cannot do that on web site !! 
	// => use groups or personal account instead
	function createFile($name, $data = null) {
		/*
		// Only members can create new files
		if (elgg_is_logged_in()) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => elgg_get_site_entity()->guid));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After successful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		*/
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:readonly'));
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:readonly'));
		/*
		if (elgg_is_logged_in()) {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
		}
		*/
	}
}

// GROUPS folder + subgroups support if enabled
class GroupsCollection extends Sabre\DAV\Collection {
	protected $groups;
	function __construct($parent = false) {
		// Note : list all groups (and not only own) because we can read them on web site
		//$this->groups = elgg_get_logged_in_user_entity()->getGroups('', 0);
		// Note : it seems to make more sense not to list subgroups here and rather display them in the tree
		// We could check plugin setting to behave the same as on site but this would result in 2 navigation paths
		//if (elgg_is_active_plugin('au_subgroups') && (elgg_get_plugin_setting('display_subgroups', 'au_subgroups') != 'yes')) {
		if (elgg_is_active_plugin('au_subgroups')) {
			// Do not list subgroups here but make it a tree
			$dbprefix = elgg_get_config('dbprefix');
			$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0, 'wheres' => array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )")));
			$this->groups = $groups;
		} else {
			$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0));
			$this->groups = $groups;
		}
	}
	// List folders = groups
	function getChildren() {
		$result = [];
		foreach($this->groups as $group) {
			// @Note : do not throw error if file tool not enabled, because embed tool lets use file too, 
			// and there still may exist files in group...
			//if ($group->file_enable == 'yes') {} else {}
			$result[] = new GroupCollection($group);
		}
		return $result;
	}
	function getName() { return 'groups'; }
	// Edit functions - readonly folder
	// Cannot create files in groups list...
	function createFile($name, $data = null) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	// Cannot create groups from WebDAV
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:groupcreate'));
	}
}

// USERS folder
class UsersCollection extends Sabre\DAV\Collection {
	protected $users;
	function __construct() {
		$this->users = elgg_get_entities(array('type' => 'user', 'limit' => 0));
	}
	function getChildren() {
		$result = [];
		foreach($this->users as $user) {
			$result[] = new UserCollection($user);
		}
		return $result;
	}
	function getName() { return 'users'; }
	// Edit functions - readonly folder
	// Cannot create files or folders in users list...
	function createFile($name, $data = null) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	// Cannot create users from WebDAV
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:usercreate'));
	}
}


/* File level Collections :
 * These actually link to real files, which are handled by the Elgg File system
 * And optionally to other content types (which could even be edited through WebDAV)
 *  - each file level Collection should implement Collection helper classes
 *  - it should also implement Node helper class (lastModified, delete, setName) for files
 */

// Group files
class GroupCollection extends Sabre\DAV\Collection {
	protected $group;
	function __construct($group) {
		$this->group = $group;
	}
	function getChildren() {
		$result = [];
		//Sub-groups structure inside group : seems to make more sense that not listing them in a group folder
		//if (elgg_is_active_plugin('au_subgroups') && (elgg_get_plugin_setting('display_subgroups', 'au_subgroups') != 'yes')) {
		if (elgg_is_active_plugin('au_subgroups')) {
			$subgroups = AU\SubGroups\get_subgroups($this->group, 0);
			foreach($subgroups as $subgroup) {
				$result[] = new GroupCollection($subgroup);
			}
		}
		// List files and optionally folders
		if (elgg_is_active_plugin('file_tools') && file_tools_use_folder_structure()) {
			// Support folder structure inside group if enabled : subfolders and folders files
			// Folders
			$folders = file_tools_get_folders($this->group->guid);
			foreach($folders as $folder) {
				$result[] = new FolderCollection($this->group, $folder['folder']);
			}
			// Files
			$dbprefix = elgg_get_config("dbprefix");
			$files_options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->group->guid, 'limit' => 0, 'distinct' => true);
			$files_options["joins"][] = "JOIN " . $dbprefix . "objects_entity oe ON oe.guid = e.guid";
			$files_options["wheres"][] = 
				"NOT EXISTS (
						SELECT 1 FROM " . $dbprefix . "entity_relationships r
						WHERE r.guid_two = e.guid AND
						r.relationship = '" . FILE_TOOLS_RELATIONSHIP . "')";
			$files = elgg_get_entities_from_relationship($files_options);
		} else {
			// All group files
			$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->group->guid, 'limit' => 0, 'distinct' => true));
		}
		// List files
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() {
		// Tell it's a special folder (subgroup) if displaying in a group folder
		// @TODO which would be most obvious way to tell it's a subgroup and not a regular folder ?
		if (elgg_is_active_plugin('au_subgroups')) {
			$parentgroup = AU\SUBGROUPS\get_parent_group($this->group);
			if ($parentgroup) { return '[subgroup] '. $this->group->name; }
			//if ($parentgroup) { return '[ '. $this->group->name . ' ]'; }
		}
		return $this->group->name;
	}
	
	// Edit functions
	function createFile($name, $data = null) {
		$own = elgg_get_logged_in_user_entity();
		// Only group members can create new files
		if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {
			// Access is set to group members
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $own->guid, 'container_guid' => $this->group->guid, 'access_id' => $this->group->group_acl));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	function createDirectory($name) {
		if (elgg_is_active_plugin('file_tools') && file_tools_use_folder_structure()) {
			$own = elgg_get_logged_in_user_entity();
			if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {
				$parent_guid = 0; // parent folder GUID
				$directory = file_tools_check_foldertitle_exists($name, $this->group->guid, $parent_guid);
				// @TODO : when moving a folder, we need to create it first, then delete the previous one
				if (!$existingfolder) {
error_log("GroupCollection createDirectory : no existing folder : nice !");
					$directory = new ElggObject();
					$directory->subtype = FILE_TOOLS_SUBTYPE;
					$directory->owner_guid = elgg_get_logged_in_user_guid();
					$directory->container_guid = $this->group->guid;
					// Default acess to group ACL or group access_id ?
					//$directory->access_id = $this->group->access_id;
					$directory->access_id = $this->group->group_acl;
					$directory->title = $name;
					$directory->parent_guid = $parent_guid;
					$order = elgg_get_entities_from_metadata(array(
						"type" => "object", "subtype" => FILE_TOOLS_SUBTYPE,
						"metadata_name_value_pairs" => array("name" => "parent_guid", "value" => $parent_guid),
						"count" => true
					));
					$directory->order = $order;
					$directory->save();
				// If exists, assume we're moving it, but still check we're allowed to do so !
				} else if ($directory->canEdit() && !empty($directory->parent_guid)) {
					$directory->parent_guid = $parent_guid;
				}
				return '"' . $directory->time_updated . $directory->guid . '"';
			}
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
}

// Folder content : subfolders and files
class FolderCollection extends Sabre\DAV\Collection {
	protected $container;
	protected $folder;
	protected $subfolders;
	protected $files;
	function __construct($container, $folder) {
		$this->container = $container;
		$this->folder = $folder;
	}
	function getSubfolders() {
		if (!isset($this->subfolders)) {
			$this->subfolders = file_tools_get_sub_folders($this->folder);
		}
		return $this->subfolders;
	}
	function getFolderFiles() {
		if (!isset($this->files)) {
			$dbprefix = elgg_get_config("dbprefix");
			$files_options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->container->guid, 'limit' => 0, 'distinct' => true);
			//$files_options["joins"][] = "JOIN " . $dbprefix . "objects_entity oe ON oe.guid = e.guid";
			$files_options["relationship"] = FILE_TOOLS_RELATIONSHIP;
			$files_options["relationship_guid"] = $this->folder->guid;
			$files_options["inverse_relationship"] = false;
			$this->files = elgg_get_entities_from_relationship($files_options);
		}
		return $this->files;
	}
	function getChildren() {
		$result = [];
		// Subfolders
		if ($this->getSubfolders()) {
			foreach($this->getSubfolders() as $subfolder) {
				$result[] = new FolderCollection($this->container, $subfolder);
			}
		}
		// Folders files
		if ($this->getFolderFiles()) {
			foreach($this->getFolderFiles() as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		}
		// Return folders and files list
		return $result;
	}
	function getName() { return $this->folder->title; }
	
	// Edit functions
	function setName($name) {
		// Cannot rename to an existing name (in the same container)
		$existingfolder = file_tools_check_foldertitle_exists($name, $this->container->guid, $this->folder->guid);
		if (!$existingfolder && $this->folder->canEdit()) {
			$this->folder->title = sanitise_string($name);
			$this->folder->save();
			return '"' . $this->folder->time_updated . $this->folder->guid . '"';
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:alreadyexists'));
	}
	function createFile($name, $data = null) {
		$own = elgg_get_logged_in_user_entity();
		// Only group members can create new files
		if (elgg_is_logged_in() && ((elgg_instanceof($this->container, 'group') && $this->container->isMember($own)) || $this->container->canEdit())) {
			// Access is set to group members
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $own->guid, 'container_guid' => $this->container->guid, 'access_id' => $this->container->group_acl));
			if (elgg_instanceof($file, 'object', 'file')) {
				// Set parent folder
				//remove_entity_relationships($file->guid, FILE_TOOLS_RELATIONSHIP, true);
				add_entity_relationship($this->folder->guid, FILE_TOOLS_RELATIONSHIP, $file->guid);
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	// @TODO check if allowed and enable to create new subfolder (inherit parent properties)
	function createDirectory($name) {
		if (file_tools_use_folder_structure()) {
			$own = elgg_get_logged_in_user_entity();
			if (elgg_is_logged_in() && ((elgg_instanceof($this->container, 'group') && $this->container->isMember($own)) || $this->container->canEdit())) {
				$parent_guid = $this->folder->guid; // parent folder GUID
				$existingfolder = file_tools_check_foldertitle_exists($name, $this->container->guid, $parent_guid);
				if (!$existingfolder) {
					$directory = new ElggObject();
					$directory->subtype = FILE_TOOLS_SUBTYPE;
					$directory->owner_guid = elgg_get_logged_in_user_guid();
					$directory->container_guid = $this->container->guid;
					// Default acess to parent folder access
					$directory->access_id = $this->folder->access_id;
					$directory->title = $name;
					$directory->parent_guid = $parent_guid;
					$order = elgg_get_entities_from_metadata(array(
						"type" => "object", "subtype" => FILE_TOOLS_SUBTYPE,
						"metadata_name_value_pairs" => array("name" => "parent_guid", "value" => $parent_guid),
						"count" => true
					));
					$directory->order = $order;
					$directory->save();
				}
				return '"' . $directory->time_updated . $directory->guid . '"';
			}
		}
		//if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
	function getLastModified() {
		return $this->folder->time_updated;
	}
	function delete() {
		/* VERY IMPORTANT : when moving files and folders, WebDAV deletes the old file and creates a new one, 
		 * resulting in losing all Elgg-specific properties, metadata, annotations and relations
		 * So we better not enable this until it's handled !!
		 */
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:toodangerousyet'));
		// @TODO Important : do NOT delete folder content ? But mounted filesystem tells to do so to server (delete all files + folder recursively)
		// file_tools behaviour is to remove the folder so subfolders and contained files ends up in root directory (or we could move to parent)
		if ($this->folder->canEdit()) {
			/*
			// @TODO move children files and folders to parent folder
			// file_tools_change_children_access($folder, $change_files = true)
			$parent_guid = $this->folder->parent_guid;
			// Move subfolders 1 level upper
			if ($this->getSubfolders()) {
				foreach($this->getSubfolders() as $subfolder) {
					$subfolder->parent_guid = $parent_guid;
					//$subfolder->save();
				}
			}
			if ($this->getFolderFiles()) {
				foreach($this->getFolderFiles() as $file) {
					remove_entity_relationships($file->guid, FILE_TOOLS_RELATIONSHIP, true);
					add_entity_relationship($parent_guid, FILE_TOOLS_RELATIONSHIP, $file->guid);
				}
			}
			*/
			if ($this->folder->delete()) {
				// @TODO return something to trigger tree update ?
			} else {
				throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:couldnotdelete'));
			}
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notallowed'));
		}
	}
}

// User files
class UserCollection extends Sabre\DAV\Collection {
	protected $user;
	function __construct($user) {
		$this->user = $user;
	}
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->user->guid, 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return $this->user->name; }
	
	// Edit functions
	function createFile($name, $data = null) {
		// Only owner can edit its own files
		if (elgg_is_logged_in() && ($this->user->guid == elgg_get_logged_in_user_guid())) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => $this->user_guid, 'access_id' => 0));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create') . " - Only owner user can create files here.");
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:readonly'));
	}
	// Directory creation is not implemented yet
	function createDirectory($name) {
		// Only owner can edit its own files
		//if (elgg_is_logged_in() && ($this->user->guid == elgg_get_logged_in_user_guid())) {}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
}


// Elgg File mapper
class EsopeDAVFile extends Sabre\DAV\File {
	private $entity;
	function __construct($guid) {
		$this->entity = get_entity($guid);
		if (!elgg_instanceof($this->entity, 'object', 'file')) {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:noaccess'));
		}
	}
	function getName() {
		return $this->entity->originalfilename;
		//return $this->entity->title;
	}
	function get() {
		return $this->entity->grabFile();
		// reafile() is used in file/download but returns directly (here we prefer to pass content)
		//return readfile($this->entity->getFilenameOnFilestore());
		//return fopen($this->entity->getFilenameOnFilestore(), 'r');
	}
	function getSize() {
		// Failsafe behaviour : don't return directly value (in case there are errors it will not lag)
		$size = $this->entity->getSize();
		if ($size) { return $size; }
		return null;
		//return filesize($this->entity->getFilenameOnFilestore());
	}
	
	// Update file content
	function put($data) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:updatedata'));
		if ($this->entity->canEdit()) {
			// Convert data to string if it is a resource (mostly)
			if (is_resource($data)) {
				$data = stream_get_contents($data);
			}
			// Open the file to guarantee the directory exists
			$this->entity->open("write");
			$this->entity->write($data);
			$this->entity->close();
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:updatedata'));
		}
	}
	// ETag has to be unique and change when file changes
	function getETag() {
		return $this->entity->time_updated . $this->entity->guid;
	}
	function getContentType() {
		$mime = $this->entity->getMimeType();
		//if (!$mime) { $mime = "application/octet-stream"; }
		if ($mime) { return $mime; }
		return null;
	}
	function getLastModified() {
		return $this->entity->time_updated;
	}
	// @TODO : allow deletion or not, and whom ?
	// @TODO : we could also disable the file, and remove it after a certain time (enable restoring files)
	function delete() {
		/* VERY IMPORTANT : when moving files, WebDAV deletes the old file and creates a new one, 
		 * resulting in losing all Elgg-specific properties, metadata, annotations and relations
		 * So we better not enable this until it's handled !!
		 */
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:toodangerousyet'));
		// Allow only owner to delete files, or anyone who has edit rights ?
		//if (elgg_get_logged_in_user_guid()) {
		//if ($this->entity->canEdit()) {
		if ($this->entity->owner_guid == elgg_get_logged_in_user_guid()) {
			$this->entity->delete();
			//$this->entity->disable();
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:delete'));
		}
	}
	function setName($name) {
		if ($this->entity->canEdit()) {
			$this->entity->originalfilename = $name; // prefered way
			if (empty($this->entity->title)) { $this->entity->title = $name; }// Also set title if none set
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:rename'));
		}
	}
}



/**************************************/
/* Configure and launch WebDAV server */
/**************************************/

// Set the virtual FS 
// Define the main collection levels
// @TODO : Note that requiring authentication actually forbids any public access... 
// @TODO : Public access should be implemented elsewhere...
$tree[] = new PublicCollection();
// Other features are for members only
if (elgg_is_logged_in()) {
	$tree[] = new PrivateCollection();
	$tree[] = new GroupsCollection();
	$tree[] = new UsersCollection();
}
// The root node (tree origin) needs to be passed to the server object.
$server = new \Sabre\DAV\Server($tree);

// Relative endpoint URL, without domain
$server->setBaseUri($base_uri);


// ADD PLUGINS

// Add authentication
$server->addPlugin($authPlugin);

// Support for LOCK and UNLOCK
// The lock manager is reponsible for making sure users don't overwrite each others changes.
$lockBackend = new Sabre\DAV\Locks\Backend\File($locks_path);
$lockPlugin = new Sabre\DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);

// Support for HTML frontend
// This ensures that we get a pretty index in the browser, but it is optional.
//$server->addPlugin(new Sabre\DAV\Browser\Plugin());
require_once('EsopeBrowserPlugin.php');
// @TODO avoid listing properties ?
$server->addPlugin(new Sabre\DAV\Browser\EsopePlugin());

// WebDAV Sync
//$server->addPlugin(new Sabre\DAV\Sync\Plugin());

// Guess content types
//$server->addPlugin(new \Sabre\DAV\Browser\GuessContentType());

// Temporary file filter (avoids OS temporary files)
// @TODO : requires a cron to clean the tmp directory... see http://sabre.io/dav/temporary-files/
/*
$tempFF = new \Sabre\DAV\TemporaryFileFilterPlugin($tmp_path);
$server->addPlugin($tempFF);
*/

// FIRE UP THE SERVER
$server->exec();


