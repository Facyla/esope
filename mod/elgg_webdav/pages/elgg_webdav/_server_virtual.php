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


// Virtual folders support

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
		foreach($files as $ent) { $result[] = $this->getChild($ent); }
		return $result;
	}
	function getChild($entity) { return new EsopeDAVFile($entity->guid); }
	
	// @TODO
	function createFile($name, $data = null) {
		throw new Exception\Forbidden('Permission denied to create file (filename ' . $name . ')');
	}
	function createDirectory($name) {
		throw new Exception\Forbidden('Permission denied to create directory');
	}
	
	function getName() { return 'private'; }
}

// Public folder : list all accessible files, in read-only mode
class PublicCollection extends Sabre\DAV\Collection {
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'limit' => 0));
		foreach($files as $ent) { $result[] = $this->getChild($ent); }
		return $result;
	}
	function getChild($entity) { return new EsopeDAVFile($entity->guid); }
	function getName() { return 'public'; }
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
			$result[] = $this->getChild($group);
		}
		return $result;
	}
	function getChild($group) { return new GroupCollection($group); }
	function getName() { return 'groups'; }
}
// Group files
class GroupCollection extends Sabre\DAV\Collection {
	protected $group;
	function __construct($group) {
		$this->group = $group;
	}
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->group->guid, 'limit' => 0, 'distinct' => true));
		foreach($files as $ent) {
			$result[] = $this->getChild($ent);
		}
		return $result;
	}
	function getChild($entity) { return new EsopeDAVFile($entity->guid); }
	function getName() { return $this->group->name; }
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
			$result[] = $result[] = $this->getChild($user);
		}
		return $result;
	}
	function getChild($user) { return new UserCollection($user); }
	function getName() { return 'users'; }
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
		foreach($files as $ent) {
			$result[] = $this->getChild($ent);
		}
		return $result;
	}
	function getChild($entity) { return new EsopeDAVFile($entity->guid); }
	function getName() { return $this->user->name; }
}


// Elgg virtual File
class EsopeDAVFile extends Sabre\DAV\File {
	private $entity;
	function __construct($guid) {
		$this->entity = get_entity($guid);
	}
	function getName() {
		//return $this->entity->title;
		return $this->entity->originalfilename;
	}
	function get() {
		//return readfile($this->entity->getFilenameOnFilestore());
		return fopen($this->entity->getFilenameOnFilestore(), 'r');
	}
	function getSize() {
		//return $this->entity->getSize();
		return filesize($this->entity->getFilenameOnFilestore());
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


