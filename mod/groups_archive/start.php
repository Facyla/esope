<?php
/**
 * groups_archive plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright FlorianDANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'groups_archive_init');


/**
 * Init groups_archive plugin.
 */
function groups_archive_init() {
	
	elgg_extend_view('css', 'groups_archive/css');
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:groups_archive');
	elgg_register_library('elgg:groups_archive', elgg_get_plugins_path() . 'groups_archive/lib/groups_archive.php');
	
	// Register JS script - use with : elgg_load_js('groups_archive');
	elgg_register_js('groups_archive', '/mod/groups_archive/vendors/groups_archive.js', 'head');
	
	// Register CSS - use with : elgg_load_css('groups_archive');
	elgg_register_simplecache_view('css/groups_archive');
	$groups_archive_css = elgg_get_simplecache_url('css', 'groups_archive');
	elgg_register_css('groups_archive', $groups_archive_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'groups_archive');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'groups_archive');
	}
	*/
	
	// Register a page handler on "groups_archive/"
	elgg_register_page_handler('groups-archive', 'groups_archive_page_handler');
	
	
}



// Page handler
// Loads pages located in plugin_template/pages/plugin_template/
function groups_archive_page_handler($page) {
	$base = elgg_get_plugins_path() . 'groups_archive/pages/groups_archive';
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




