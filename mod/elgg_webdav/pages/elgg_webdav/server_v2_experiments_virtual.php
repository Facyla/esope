<?php
/**
 * Elgg WebDAV home page
 *
 * @package ElggWebDAV
 */


// Set up default paths
global $CONFIG;
$base_path = elgg_get_data_path() . 'webdav';
$public_path = $base_path . '/public';
$data_path = $base_path . '/data';
$locks_path = $data_path . '/locks';
// Full server URL, without domain
$base_uri = parse_url($CONFIG->url . 'webdav/server');
$base_uri = $base_uri['path'];
if (!file_exists($base_path)) { mkdir($base_path, 0777); }
if (!file_exists($public_path)) { mkdir($public_path, 0777); }
if (!file_exists($data_path)) { mkdir($data_path, 0777); }
if (!file_exists($locks_path)) { mkdir($locks_path, 0777); }



// Configure and launch WebDAV server
//use Sabre\DAV;
use
    Sabre\DAV,
    Sabre\HTTP\URLUtil;
// The autoloader
elgg_load_library('elgg:webdav:sabreDAV');


// Authentication through Elgg
use Sabre\DAV\Auth;
$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($username, $password) {
	$debug = false;
	// Return result quickly if already logged in
	if (elgg_is_logged_in()) {
		if ($debug) error_log("WebDAV : $username authenticated");
		return true;
	}
	// check the username and password here, and then just return true or false.
	error_log("WebDAV : authenticating $username");
	// check if logging in with email address
	if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
		$username = $users[0]->username;
	}
	// Check authentication : much used so be as quick as possible
	$authenticated = elgg_authenticate($username, $password);
	if ($authenticated === true) {
		if ($debug) error_log("WebDAV : $username authentication verified => loging in");
		$user = get_user_by_username($username);
		login($user, true); // Keep authenticated to avoid checking every time
		// re-register at least the core language file for users with language other than site default
		//register_translations(elgg_get_root_path() . "languages/");
		return true;
	}
	return false;
});
$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend, '');



/* Esope files directory logic structure : 
 * Multiple structures ? by container + by owner + access level
 * Groups & user directory ?
	Groups
		Group A
		Group B
		etc.
	User files
		User A
		User B
		etc.
*/

// Custom Node class
abstract class EsopeNode implements DAV\INode {
	/** The path to the current node
	 * @var string
	 */
	protected $path;
	/**
	 * Sets up the node, expects a full path name
	 * @param string $path
	 */
	function __construct($path) {
		$this->path = $path;
		// @TODO switch depending on tree type : container, owner, personnal space...
	}
	/** Returns the name of the node
	 * @return string
	 */
	function getName() {
		if ($this->path instanceof ElggEntity) {
			if (elgg_instanceof($this->path, 'group') || elgg_instanceof($this->path, 'user') || elgg_instanceof($this->path, 'site')) {
				return $this->path->name;
				return 'container-' . $this->path->guid;
			} else {
				return $this->path->title;
				return 'object-' . $this->path->guid;
			}
		}
		// Fallback to regular filesystem mode
		list(, $name)  = URLUtil::splitPath($this->path);
		return $name;
	}
	/** Renames the node
	 * @param string $name The new name
	 * @return void
	 */
	function setName($name) {
		if ($this->path instanceof ElggEntity) {
			throw new DAV\Exception\NotFound('Cannot create files in virtual file system');
		}
		list($parentPath, ) = URLUtil::splitPath($this->path);
		list(, $newName) = URLUtil::splitPath($name);
		$newPath = $parentPath . '/' . $newName;
		rename($this->path,$newPath);
		$this->path = $newPath;
	}
	/** Returns the last modification time, as a unix timestamp
	 * @return int
	 */
	function getLastModified() {
		if ($this->path instanceof ElggEntity) return $this->path->time_updated;
		// Fallback to regular filesystem mode
		return filemtime($this->path);
	}
	
	/** Returns the root path
	 * @return string
	 */
	function getRoot() {
		//list($rootPath, ) = URLUtil::splitPath($this->path);
		$rootPath = elgg_get_data_path() . 'webdav/public';
		return $rootPath;
	}
	/** Returns the relative path
	 * @return string
	 */
	function getRelative() {
		//list($parentPath, ) = URLUtil::splitPath($this->path);
		$rootPath = $this->getRoot();
		$relativePath = str_replace($rootPath, "", $this->path);
		return $relativePath;
	}
}


// Custom directory class
class EsopeDirectory extends EsopeNode implements DAV\ICollection, DAV\IQuota {
	/**
	 * Creates a new file in the directory
	 *
	 * Data will either be supplied as a stream resource, or in certain cases
	 * as a string. Keep in mind that you may have to support either.
	 *
	 * After successful creation of the file, you may choose to return the ETag
	 * of the new file here.
	 *
	 * The returned ETag must be surrounded by double-quotes (The quotes should
	 * be part of the actual string).
	 *
	 * If you cannot accurately determine the ETag, you should not return it.
	 * If you don't store the file exactly as-is (you're transforming it
	 * somehow) you should also not return an ETag.
	 *
	 * This means that if a subsequent GET to this new file does not exactly
	 * return the same contents of what was submitted here, you are strongly
	 * recommended to omit the ETag.
	 *
	 * @param string $name Name of the file
	 * @param resource|string $data Initial payload
	 * @return null|string
	 */
	function createFile($name, $data = null) {
		$newPath = $this->path . '/' . $name;
		file_put_contents($newPath,$data);
	}

	/**
	 * Creates a new subdirectory
	 *
	 * @param string $name
	 * @return void
	 */
	function createDirectory($name) {
		$newPath = $this->path . '/' . $name;
		mkdir($newPath);
	}

	/**
	 * Returns a specific child node, referenced by its name
	 *
	 * This method must throw DAV\Exception\NotFound if the node does not
	 * exist.
	 *
	 * @param string $name
	 * @throws DAV\Exception\NotFound
	 * @return DAV\INode
	 */
	function getChild($name) {
		
		// Handle special folders
		if (elgg_instanceof($name, 'group')) {
			return new EsopeDirectory($name);
		} else if (elgg_instanceof($name, 'object')) {
			return new EsopeFile($name);
		}
		
		if (strpos($name, 'container-') !== false) {
			$guid = substr($name, 10);
			$entity = get_entity($guid);
			error_log("GUID group : $cut => $guid / $entity->name");
			return $entity->name;
		}
		if (strpos($name, 'object-') !== false) {
			$guid = substr($name, 7);
			$entity = get_entity($guid);
			error_log("GUID object : $cut => $guid / $entity->title");
			return $entity->title;
		}
		
		list($parentPath, ) = URLUtil::splitPath($this->path);
		$relativePath = $this->getRelative();
		$rootPath = $this->getRoot();
		error_log("DIR PATH : $rootPath => $relativePath => {$name} // FROM {$this->path}");
		
		$path = $this->path . '/' . $name;
		if (!file_exists($path)) {
			//throw new DAV\Exception\NotFound('File with name ' . $path . ' could not be located');
			return new EsopeFile($name);
		}
		if (is_dir($path)) {
			return new Directory($path);
		} else {
			return new File($path);
		}
	}

	/**
	 * Returns an array with all the child nodes
	 *
	 * @return DAV\INode[]
	 */
	function getChildren() {
		$nodes = [];
		//foreach(scandir($this->path) as $node) if($node!='.' && $node!='..') $nodes[] = $this->getChild($node);
		
		// @TODO Are we in a group ?  see this from relative url
		$own = elgg_get_logged_in_user_entity();
		$groups = $own->getGroups('', 0);
		if ($groups) foreach($groups as $node) {
			$nodes[] = $this->getChild($node);
		}
		// Own files
		$container_guid = $own->guid;
		$relative = $this->getRelative();
		error_log("RELATIVE : $relative");
		if ($container_guid) {
			$group = get_entity($group_guid);
			$objects = elgg_get_entities(array('type' => 'object', 'subtype' => '', 'limit' => 0, 'owner_guid' => $container_guid));
			foreach($objects as $node) {
				$nodes[] = $this->getChild($node);
			}
		}
		
		// Personnal space files files
		$container_guid = $own->guid;
		$relative = $this->getRelative();
		error_log("RELATIVE : $relative");
		if ($container_guid) {
			$group = get_entity($group_guid);
			$objects = elgg_get_entities(array('type' => 'object', 'subtype' => '', 'limit' => 0, 'container_guid' => $container_guid));
			foreach($objects as $node) {
				$nodes[] = $this->getChild($node);
			}
		}
		
		return $nodes;
	}

	/**
	 * Checks if a child exists.
	 *
	 * @param string $name
	 * @return bool
	 */
	function childExists($name) {
		if ($name instanceof ElggEntity) return true;
		$path = $this->path . '/' . $name;
		return file_exists($path);
	}

	/**
	 * Deletes all files in this directory, and then itself
	 *
	 * @return void
	 */
	function delete() {
		foreach($this->getChildren() as $child) $child->delete();
		rmdir($this->path);
	}

	/**
	 * Returns available diskspace information
	 *
	 * @return array
	 */
	function getQuotaInfo() {
		return [
			disk_total_space($this->path)-disk_free_space($this->path),
			disk_free_space($this->path)
		];
	}
}


// Custom file class
class EsopeFile extends EsopeNode implements DAV\IFile {
	/**
	 * Updates the data
	 *
	 * @param resource $data
	 * @return void
	 */
	function put($data) {
		file_put_contents($this->path,$data);
	}

	/**
	 * Returns the data
	 *
	 * @return string
	 */
	function get() {
		return fopen($this->path,'r');
	}

	/**
	 * Delete the current file
	 *
	 * @return void
	 */
	function delete() {
		unlink($this->path);
	}

	/**
	 * Returns the size of the node, in bytes
	 *
	 * @return int
	 */
	function getSize() {
		if (elgg_instanceof($this->path, 'object')) {
			if (elgg_instanceof($this->path, 'object', 'file')) {
				return $this->path->getFilestoreSize();
			} else {
				return strlen($this->path->description);
			}
		}
		if (elgg_instanceof($this->path, 'group')) return 0;
		return filesize($this->path);
	}

	/**
	 * Returns the ETag for a file
	 *
	 * An ETag is a unique identifier representing the current version of the file. If the file changes, the ETag MUST change.
	 * The ETag is an arbitrary string, but MUST be surrounded by double-quotes.
	 *
	 * Return null if the ETag can not effectively be determined
	 *
	 * @return mixed
	 */
	function getETag() {
		return null;
	}

	/**
	 * Returns the mime-type for a file
	 *
	 * If null is returned, we'll assume application/octet-stream
	 *
	 * @return mixed
	 */
	function getContentType() {
		return null;
	}
}



// Set root directory
//$rootDirectory = new DAV\FS\Directory($public_path);
// Virtual directory. We will be exposing that directory to WebDAV
$rootDirectory = new EsopeDirectory($public_path);

// The object tree needs in turn to be passed to the server class
// The server object is responsible for making sense out of the WebDAV protocol
$server = new DAV\Server($rootDirectory);


/* PLUGINS */
// Add authentication
$server->addPlugin($authPlugin);

// The lock manager is reponsible for making sure users don't overwrite each others changes.
$lockBackend = new DAV\Locks\Backend\File($locks_path);
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);

// This ensures that we get a pretty index in the browser, but it is optional.
$server->addPlugin(new DAV\Browser\Plugin());


// Set paths accordingly to user settings :
// @TODO : note access is the same for all users
/*
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
		// Create custom paths if needed
		$base_path = elgg_get_data_path() . 'webdav';
		$public_path = $base_path . '/public/' . $own->guid;
		$locks_path = $base_path . '/data/locks/' . $own->guid;
		if (!file_exists($public_path)) { mkdir($public_path, 0770); }
		if (!file_exists($locks_path)) { mkdir($locks_path, 0770); }
}
*/




// If your server is not on your webroot, make sure the following line has the correct information
$server->setBaseUri($base_uri);

// All we need to do now, is to fire up the server
$server->exec();


