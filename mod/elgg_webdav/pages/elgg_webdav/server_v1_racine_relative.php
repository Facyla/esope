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
use Sabre\DAV;
// The autoloader
elgg_load_library('elgg:webdav:sabreDAV');

// Authenticate through Elgg
use Sabre\DAV\Auth;
$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($username, $password) {
	$debug = true;

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


// Perform auth first and reload page
if (!elgg_is_logged_in()) {
	// Now we're creating a whole bunch of objects
	$rootDirectory = new DAV\FS\Directory($public_path);
	// The server object is responsible for making sense out of the WebDAV protocol
	$server = new DAV\Server($rootDirectory);
	// Add authentication
	$server->addPlugin($authPlugin);
	// Reload page
	forward('webdav/server');
	exit;
}


// Now assume we're logged in

// Set paths accordingly to user settings :
$own = elgg_get_logged_in_user_entity();
// Update paths to logged in user logic
$base_path = elgg_get_data_path() . 'webdav';
$public_path = $base_path . '/public/' . $own->guid;
$locks_path = $base_path . '/data/locks/' . $own->guid;
if (!file_exists($public_path)) { mkdir($public_path, 0770); }
if (!file_exists($locks_path)) { mkdir($locks_path, 0770); }


// Now create the server
$rootDirectory = new DAV\FS\Directory($public_path);
// The server object is responsible for making sense out of the WebDAV protocol
$server = new DAV\Server($rootDirectory);
// Add authentication
$server->addPlugin($authPlugin);

// If your server is not on your webroot, make sure the following line has the correct information
$server->setBaseUri($base_uri);
// The lock manager is reponsible for making sure users don't overwrite each others changes.
$lockBackend = new DAV\Locks\Backend\File($locks_path);
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);
// This ensures that we get a pretty index in the browser, but it is optional.
$server->addPlugin(new DAV\Browser\Plugin());
// All we need to do now, is to fire up the server
$server->exec();


