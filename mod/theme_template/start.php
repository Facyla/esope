<?php
/**
 * theme_template plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'theme_template_init');


/**
 * Init theme_template plugin.
 */
function theme_template_init() {
	
	// Extend CSS with custom styles
	elgg_extend_view('css', 'theme_template/css');
	elgg_extend_view('css/admin', 'theme_template/admin_css');
	
	// HOMEPAGE - Replace public and loggedin homepage
	/*
	if (elgg_is_logged_in()) {
		elgg_unregister_page_handler('esope_index');
		elgg_register_page_handler('', 'theme_template_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_page_handler('esope_public_index');
			elgg_register_page_handler('', 'theme_template_public_index');
		}
	}
	*/
	
	// Get a plugin setting
	/*
	// Plugin settings form : plugins/theme_template/settings
	$setting = elgg_get_plugin_setting('setting_name', 'theme_template');
	
	// User plugin settings form : plugins/theme_template/usersettings
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'theme_template');
	}
	*/
	
	// Register a page handler on "theme_template/"
	elgg_register_page_handler('theme_template', 'theme_template_page_handler');
	
	
	
}


// Page handler
// Loads pages located in theme_template/pages/theme_template/
function theme_template_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_template/pages/theme_template';
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


// Other useful functions
// prefixed by plugin_name_
/*
function theme_template_function() {
	
}
*/

// Theme logged in index page
function theme_template_index($page) {
	include(elgg_get_plugins_path() . 'theme_template/pages/theme_template/loggedin_homepage.php');
	return true;
}

// Theme public index page
function theme_template_public_index($page) {
	include(elgg_get_plugins_path() . 'theme_template/pages/theme_template/public_homepage.php');
	return true;
}



