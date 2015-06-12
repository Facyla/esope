<?php
/**
 * theme_futuringcities plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'theme_futuringcities_init');


/**
 * Init theme_futuringcities plugin.
 */
function theme_futuringcities_init() {
	global $CONFIG;
	
	// Extend CSS with custom styles
	elgg_extend_view('css', 'theme_futuringcities/css');
	
	// HOMEPAGE - Replace public and loggedin homepage
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_futuringcities_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_futuringcities_public_index');
		}
	}
	
	// Get a plugin setting
	/*
	$setting = elgg_get_plugin_setting('setting_name', 'theme_futuringcities');
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'theme_futuringcities');
	}
	*/
	
	// Register a page handler on "theme_futuringcities/"
	//elgg_register_page_handler('theme_futuringcities', 'theme_futuringcities_page_handler');
	
	
	
}


// Page handler
// Loads pages located in theme_futuringcities/pages/theme_futuringcities/
/*
function theme_futuringcities_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_futuringcities/pages/theme_futuringcities';
	switch ($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include "$base/example_page.php";
			break;
		default:
			include "$base/example_page.php";
	}
	return true;
}
*/


// Theme inria logged in index page
function theme_futuringcities_index(){
	include(elgg_get_plugins_path() . 'theme_futuringcities/pages/theme_futuringcities/loggedin_homepage.php');
	return true;
}

// Theme inria public index page
function theme_futuringcities_public_index() {
	include(elgg_get_plugins_path() . 'theme_futuringcities/pages/theme_futuringcities/public_homepage.php');
	return true;
}



