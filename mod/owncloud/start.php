<?php
/**
 * owncloud plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'owncloud_init');


/**
 * Init owncloud plugin.
 */
function owncloud_init() {
	
	elgg_extend_view('css', 'owncloud/css');
	
	// Register PHP library - use with : elgg_load_library('elgg:owncloud');
	elgg_register_library('elgg:owncloud', elgg_get_plugins_path() . 'owncloud/lib/owncloud/functions.php');
	
	/*
	// Register JS script - use with : elgg_load_js('owncloud');
	elgg_register_js('owncloud', '/mod/owncloud/vendors/owncloud.js', 'head');
	
	// Register CSS - use with : elgg_load_css('owncloud');
	elgg_register_simplecache_view('css/owncloud');
	$owncloud_css = elgg_get_simplecache_url('css', 'owncloud');
	elgg_register_css('owncloud', $owncloud_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'owncloud');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'owncloud');
	}
	*/
	
	// Register a page handler on "owncloud/"
	elgg_register_page_handler('owncloud', 'owncloud_page_handler');
	
	
}


// Page handler
// Loads pages located in owncloud/pages/owncloud/
function owncloud_page_handler($page) {
	elgg_load_library('elgg:owncloud');
	$base = elgg_get_plugins_path() . 'owncloud/pages/owncloud';
	switch ($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		default:
			include "$base/index.php";
	}
	return true;
}


// Other useful functions
// prefixed by plugin_name_
/*
function owncloud_function() {
	
}
*/



