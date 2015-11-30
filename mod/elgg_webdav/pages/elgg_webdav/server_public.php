<?php
/**
 * Elgg WebDAV group shared repository
 *
 * @package ElggWebDAV
 */

elgg_push_breadcrumb(elgg_echo('elgg_webdav'), 'webdav');
elgg_push_breadcrumb(elgg_echo('elgg_webdav:public'), 'webdav/public');


/**********************************************/
/* Define paths (and optionnally create them) */
/**********************************************/

$base_path = elgg_get_data_path() . 'webdav';
$public_path = $base_path . '/public';
$data_path = $base_path . '/data';
$locks_path = $data_path . '/locks';
if (!file_exists($base_path)) { mkdir($base_path, 0770); }
if (!file_exists($public_path)) { mkdir($public_path, 0770); }
if (!file_exists($data_path)) { mkdir($data_path, 0770); }
if (!file_exists($locks_path)) { mkdir($locks_path, 0770); }
// Relative endpoint URL, without domain
$base_uri = parse_url(elgg_get_site_url() . 'webdav/public');
$base_uri = $base_uri['path'];



/*************************************/
/* Load (and define) lib and classes */
/*************************************/

use Sabre\DAV;
// The autoloader
elgg_load_library('elgg:webdav:sabreDAV');

// Public directory
class PublicDirectory extends DAV\Collection {
	private $myPath;
	function __construct($myPath) {
		$this->myPath = $myPath;
	}

	function getChildren() {
		$children = array();
		// Loop through the directory, and create objects for each node
		foreach(scandir($this->myPath) as $node) {
			// Ignoring files staring with .
			if ($node[0]==='.') continue;
			$children[] = $this->getChild($node);
		}
		return $children;
	}

	function getChild($name) {
		$path = $this->myPath . '/' . $name;
		// We have to throw a NotFound exception if the file didn't exist
		if (!file_exists($path)) {
			throw new DAV\Exception\NotFound('The file with name: ' . $name . ' could not be found');
		}
		// Some added security
		if ($name[0]=='.')  throw new DAV\Exception\NotFound('Access denied');
		if (is_dir($path)) {
				return new PublicDirectory($path);
		} else {
				return new PublicFile($path);
		}
	}

	function childExists($name) {
		return file_exists($this->myPath . '/' . $name);
	}

	function getName() {
		return basename($this->myPath);
	}
}

// Read-only filesystem
class PublicFile extends DAV\File {
	private $myPath;

	function __construct($myPath) { $this->myPath = $myPath; }

	function getName() { return basename($this->myPath); }

	function get() { return fopen($this->myPath,'r'); }

	function getSize() { return filesize($this->myPath); }

	function getETag() { return '"' . md5_file($this->myPath) . '"'; }
}


/**************************************/
/* Configure and launch WebDAV server */
/**************************************/

// Set up the public (readonly) directory
$rootDirectory = new PublicDirectory($public_path);
// Set up a new server at chosen root
// The server object is responsible for making sense out of the WebDAV protocol
$server = new DAV\Server($rootDirectory);

// If your server is not on your webroot, make sure the following line has the correct information
$server->setBaseUri($base_uri);


// ADD PLUGINS
// The lock manager is reponsible for making sure users don't overwrite each others changes.
$lockBackend = new DAV\Locks\Backend\File($locks_path);
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);
// This ensures that we get a pretty index in the browser, but it is optional.
//$server->addPlugin(new DAV\Browser\Plugin());
require_once('EsopeBrowserPlugin.php');
// Set false to disable upload form
$server->addPlugin(new DAV\Browser\EsopePlugin(false));


// Fire up the server
$server->exec();


