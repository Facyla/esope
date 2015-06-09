<?php
/**
 * Elgg WebDAV group shared repository
 *
 * @package ElggWebDAV
 */



global $CONFIG;

elgg_push_breadcrumb(elgg_echo('elgg_webdav'), 'webdav');
elgg_push_breadcrumb(elgg_echo('elgg_webdav:member'), 'webdav/member');


/**********************************************/
/* Define paths (and optionnally create them) */
/**********************************************/

$base_path = elgg_get_data_path() . 'webdav';
$public_path = $base_path . '/member';
$data_path = $base_path . '/data';
$locks_path = $data_path . '/locks';
if (!file_exists($base_path)) { mkdir($base_path, 0770); }
if (!file_exists($public_path)) { mkdir($public_path, 0770); }
if (!file_exists($data_path)) { mkdir($data_path, 0770); }
if (!file_exists($locks_path)) { mkdir($locks_path, 0770); }
// Relative endpoint URL, without domain
$base_uri = parse_url($CONFIG->url . 'webdav/member');
$base_uri = $base_uri['path'];



/*************************************/
/* Load (and define) lib and classes */
/*************************************/

use Sabre\DAV;
// The autoloader
elgg_load_library('elgg:webdav:sabreDAV');

// Define plugin : authentication through Elgg
use Sabre\DAV\Auth;
$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($username, $password) {
	$debug = false;
	// Return result quickly if already logged in
	if (elgg_is_logged_in()) {
		if ($debug) error_log("WebDAV : $username authenticated");
		return true;
	}
	// check the username and password here, and then just return true or false.
	if ($debug) error_log("WebDAV : authenticating $username");
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
		return true;
	}
	return false;
});
$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend, '');



/**************************************/
/* Configure and launch WebDAV server */
/**************************************/

$rootDirectory = new DAV\FS\Directory($public_path);
// Set up a new server at chosen root
// The server object is responsible for making sense out of the WebDAV protocol
$server = new DAV\Server($rootDirectory);

// If your server is not on your webroot, make sure the following line has the correct information
$server->setBaseUri($base_uri);


// ADD PLUGINS
// Add authentication
$server->addPlugin($authPlugin);
// The lock manager is reponsible for making sure users don't overwrite each others changes.
$lockBackend = new DAV\Locks\Backend\File($locks_path);
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);
// This ensures that we get a pretty index in the browser, but it is optional.
//$server->addPlugin(new DAV\Browser\Plugin());
require_once('EsopeBrowserPlugin.php');
$server->addPlugin(new DAV\Browser\EsopePlugin());


// Fire up the server
$server->exec();


