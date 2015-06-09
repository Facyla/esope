<?php
/* d3js plugin
* 
 * @author : 
 */

// Initialise log browser
elgg_register_event_handler('init','system','elgg_webdav');


/* Initialise the theme */
function elgg_webdav(){
	global $CONFIG;
	
	// CSS et JS
	elgg_extend_view('css', 'elgg_webdav/css');
	
	// Register WebDAV libraries
	elgg_register_library('elgg:webdav:sabreDAV', elgg_get_plugins_path() . 'elgg_webdav/vendors/SabreDAV/vendor/autoload.php');
	
	/*
	// Enable server
	if (elgg_get_plugin_setting('enable_webdav', 'elgg_webdav') == 'yes') 
	*/
	
	// WebDAV page handler
	elgg_register_page_handler('webdav', 'elgg_webdav_page_handler');
	
}


/* WebDAV home page and endpoints */
function elgg_webdav_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_webdav/pages/elgg_webdav';
	switch($page[0]) {
		case 'endpoint':
		case 'server':
			if (!include_once "$base/server.php") return false;
			break;
		
		case 'public':
			// Read-only filesystem
			if (!include_once "$base/server_public.php") return false;
			break;
		
		case 'member':
			if (!include_once "$base/server_member.php") return false;
			break;
		
		case 'user':
			// GUID is mandatory to provide better security and RESTful URI
			if (!empty($page[1])) set_input($guid, $page[1]);
			if (!include_once "$base/server_user.php") return false;
			break;
		
		case 'group':
			// GUID is mandatory to provide better security and RESTful URI
			if (!empty($page[1])) set_input($guid, $page[1]);
			if (!include_once "$base/server_group.php") return false;
			break;
		
		default:
			if (!include_once "$base/index.php") return false;
	}
	return true;
}


