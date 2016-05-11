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

// Include custom classes
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/PrivateCollection.php';
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/PublicCollection.php';
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/GroupsCollection.php';
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/UsersCollection.php';

require_once elgg_get_plugins_path() . 'elgg_webdav/classes/GroupCollection.php';
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/UserCollection.php';
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/FolderCollection.php';
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/EsopeDAVFile.php';


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

// Classes : PublicCollection, PrivateCollection, GroupsColelction, UsersCollection



/* File level Collections :
 * These actually link to real files, which are handled by the Elgg File system
 * And optionally to other content types (which could even be edited through WebDAV)
 *  - each file level Collection should implement Collection helper classes
 *  - it should also implement Node helper class (lastModified, delete, setName) for files
 */
// Classes : GroupCollection, UserCollection, FolderCollection, EsopeDAVFile




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
// The root node (tree origin) needs to be passed to the server object
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
require_once elgg_get_plugins_path() . 'elgg_webdav/classes/EsopeBrowserPlugin.php';
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


