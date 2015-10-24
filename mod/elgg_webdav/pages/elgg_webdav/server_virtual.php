<?php
/**
 * Elgg WebDAV virtual folders support
 *
 * @package ElggWebDAV
 */

/* @TODO : implements virtual folders support :
 * Structure : private / users / groups / public -> folders* -> files
 - private
 - site
 - group => guid
 - member => guid
 * @TODO : implement ACL for read/write access to folders and files
 */

elgg_push_breadcrumb(elgg_echo('elgg_webdav'), 'webdav');
elgg_push_breadcrumb(elgg_echo('elgg_webdav:virtual'), 'webdav/virtual');


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
//if (!file_exists($public_path)) { mkdir($public_path, 0770); }
// Relative endpoint URL, without domain
$base_uri = parse_url(elgg_get_site_url() . 'webdav/virtual');
$base_uri = $base_uri['path'];

// Reset base path accordingly to logged in user settings
// Note that server will be reloaded after login, so we will have this info as soon as we're authenticated
/*
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	if ($guid) {
		// Force access to group folder only
		$group = get_entity($guid);
		if (elgg_instanceof($group, 'group') && $group->isMember($own)) {
			elgg_push_breadcrumb(elgg_echo('elgg_webdav:group', array($group->name)), 'webdav/group');
			$public_path .= '/' . $guid;
			//$base_uri .= '/' . $guid;
			// Create custom group folder if it doesn't exist
			if (!file_exists($public_path)) { mkdir($public_path, 0770); }
		}
	}
}
*/



/*************************************/
/* Load (and define) lib and classes */
/*************************************/

// Load SabreDAV library
elgg_load_library('elgg:webdav:sabreDAV');


// Define auth plugin : authentication through Elgg
$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($username, $password) {
	$debug = false;
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
		/* Use this only in group collection
		// Check group access
		$guid = get_input('guid', false);
		$group = get_entity($guid);
		// Ensure we are accessing a group folder we're member of
		if (elgg_instanceof($group, 'group') && $group->isMember($user)) {
			return true;
		}
		*/
		return true;
	}
	return false;
});
$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend, '');


/*  Virtual folders support
 * 
 * Top level Collections :
 * These do not link to actual files but are used to organize logically the WebDAV repository
 *  - each top level Collection should implement Collection helper classes
 *  - but not Node helper class (lastModified, delete, setName) which are non-sense in that context
 * 
 * File level Collections :
 * These actually link to real files, which are handled by the Elgg File system
 * And optionally to other content types (which could be even be edited through WebDAV)
 *  - each file level Collection should implement Collection helper classes
 *  - it should also implement Node helper class (lastModified, delete, setName) for files
 */

// Top-level (abstract) collections

// Private (personal) folder :lists owner files
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
	
	// Note : not overrided = childExists($name), getChild()
	function createFile($name, $data = null) {
		if (elgg_is_logged_in()) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => $this->user_guid));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden('An error occured when creating the file');
		}
		throw new Sabre\DAV\Exception\Forbidden('Permission denied to create file in this folder');
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden('Directory creation is not implemented yet in Elgg WebDAV');
	}
}

// Public folder : list all accessible files, in read-only mode
class PublicCollection extends Sabre\DAV\Collection {
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return 'public'; }
	
	// Edit functions
	function createFile($name, $data = null) {
		// Only members can create new files
		if (elgg_is_logged_in()) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => elgg_get_site_entity()->guid));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden('An error occured when creating the file');
		}
		throw new Sabre\DAV\Exception\Forbidden('Permission denied to create file in this folder');
	}
	function createDirectory($name) {
		//if (elgg_is_logged_in()) {}
		throw new Sabre\DAV\Exception\Forbidden('Directory creation is not implemented yet in Elgg WebDAV');
	}
}

// Groups folder
class GroupsCollection extends Sabre\DAV\Collection {
	protected $groups;
	function __construct() {
		// @TODO : List all or own groups ?
		//$this->groups = elgg_get_logged_in_user_entity()->getGroups('', 0);
		$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0));
		$this->groups = $groups;
	}
	function getChildren() {
		$result = [];
		foreach($this->groups as $group) {
			// @TODO : throw error if file tool not enabled ? but there still may exist files in group...
			//if ($group->file_enable == 'yes') {} else {}
			$result[] = new GroupCollection($group);
		}
		return $result;
	}
	function getName() { return 'groups'; }
	
	// Edit functions
	// Cannot create files in groups list...
	function createFile($name, $data = null) {
		throw new Sabre\DAV\Exception\Forbidden('Cannot create new files here');
	}
	// Cannot create groups from WebDAV
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden('Cannot create new groups from WebDAV');
	}
}

// Users folder
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
	
	// Edit functions
	// Cannot create files in users list...
	function createFile($name, $data = null) {
		throw new Sabre\DAV\Exception\Forbidden('Permission denied to create file in this folder');
	}
	// Cannot create users from WebDAV
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden('Cannot create new users from WebDAV');
	}
}


// File-level collections

// Group files
class GroupCollection extends Sabre\DAV\Collection {
	protected $group;
	function __construct($group) {
		$this->group = $group;
	}
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->group->guid, 'limit' => 0, 'distinct' => true));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return $this->group->name; }
	
	// Edit functions
	function createFile($name, $data = null) {
		$own = elgg_get_logged_in_user_entity();
		// Only group members can create new files
		if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $own->guid, 'container_guid' => $this->group->guid));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden('An error occured when creating the file');
		}
		throw new Sabre\DAV\Exception\Forbidden('Only groups members can create new content');
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden('Directory creation is not implemented yet in Elgg WebDAV');
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
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => $this->user_guid));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden('An error occured when creating the file');
		}
		throw new Sabre\DAV\Exception\Forbidden('Permission denied to create file in this folder');
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden('Directory creation is not implemented yet in Elgg WebDAV');
	}
}


// Elgg virtual File
class EsopeDAVFile extends Sabre\DAV\File {
	private $entity;
	function __construct($guid) {
		$this->entity = get_entity($guid);
		if (!elgg_instanceof($this->entity, 'object', 'file')) {
			throw new Sabre\DAV\Exception\Forbidden('Cannot access to this file');
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
	
	// @TODO
	function put($data) {
		throw new Sabre\DAV\Exception\Forbidden('Permission denied to change data');
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
			throw new Sabre\DAV\Exception\Forbidden('Permission denied to change data');
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
	function delete() {
		// Allow only owner to delete files, or anyone who has edit rights ?
		//if ($this->entity->canEdit()) {
		if (elgg_get_logged_in_user_guid()) {
			$this->entity->delete();
		} else {
			throw new Sabre\DAV\Exception\Forbidden('Permission denied to delete node');
		}
	}
	function setName($name) {
		if ($this->entity->canEdit()) {
			$this->entity->originalfilename = $name; // prefered way
			if (empty($this->entity->title)) { $this->entity->title = $name; }// Also set title if none set
		} else {
			throw new Sabre\DAV\Exception\Forbidden('Permission denied to rename file');
		}
	}
}



/**************************************/
/* Configure and launch WebDAV server */
/**************************************/

// Set the virtual FS 

// Define the main collection levels
$tree[] = new PublicCollection();
if (elgg_is_logged_in()) {
	$tree[] = new PrivateCollection();
	$tree[] = new GroupsCollection();
	$tree[] = new UsersCollection();
}
// The root node (tree origin) needs to be passed to the server object.
$server = new \Sabre\DAV\Server($tree);

// As server is not on webroot, make sure the following line has the correct information
// Relative endpoint URL, without domain
$base_uri = parse_url(elgg_get_site_url() . 'webdav/virtual');
$base_uri = $base_uri['path'];
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


