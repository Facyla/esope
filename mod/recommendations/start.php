<?php
/**
 * recommendations plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'recommendations_init');


/**
 * Init recommendations plugin.
 */
function recommendations_init() {
	
	elgg_extend_view('css', 'recommendations/css');
	
	// Register PHP library - use with : elgg_load_library('elgg:recommendations');
	elgg_register_library('elgg:recommendations', elgg_get_plugins_path() . 'recommendations/lib/recommendations/functions.php');
	
	/*
	// Register JS script - use with : elgg_load_js('recommendations');
	elgg_register_js('recommendations', '/mod/recommendations/vendors/recommendations.js', 'head');
	
	// Register CSS - use with : elgg_load_css('recommendations');
	elgg_register_simplecache_view('css/recommendations');
	$recommendations_css = elgg_get_simplecache_url('css', 'recommendations');
	elgg_register_css('recommendations', $recommendations_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'recommendations');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'recommendations');
	}
	*/
	
	// Register a page handler on "recommendations/"
	elgg_register_page_handler('recommendations', 'recommendations_page_handler');
	
	
}


// Page handler
// Loads pages located in recommendations/pages/recommendations/
function recommendations_page_handler($page) {
	elgg_load_library('elgg:recommendations');
	
	set_input('username', $page[0]);
	$base = elgg_get_plugins_path() . 'recommendations/pages/recommendations';
	switch ($page[1]) {
		case 'friends':
			break;
		case 'groups':
			break;
		case 'content':
			break;
		default:
			include "$base/index.php";
	}
	return true;
}



