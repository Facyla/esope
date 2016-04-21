<?php
/**
 * theme_afpa_dsp plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'theme_afpa_dsp_init');


/**
 * Init theme_afpa_dsp plugin.
 */
function theme_afpa_dsp_init() {
	
	// Extend CSS with custom styles
	elgg_extend_view('css', 'theme_afpa_dsp/css');
	elgg_extend_view('css/admin', 'theme_afpa_dsp/admin_css');
	
	// HOMEPAGE - Replace public and loggedin homepage
	/*
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_afpa_dsp_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_afpa_dsp_public_index');
		}
	}
	*/
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'theme_afpa_dsp');
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'theme_afpa_dsp');
	}
	
	// Register a page handler on "theme_afpa_dsp/"
	elgg_register_page_handler('theme_afpa_dsp', 'theme_afpa_dsp_page_handler');
	
	
	
}


// Page handler
// Loads pages located in theme_afpa_dsp/pages/theme_afpa_dsp/
function theme_afpa_dsp_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_afpa_dsp/pages/theme_afpa_dsp';
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
function theme_afpa_dsp_function() {
	
}
*/

// Theme logged in index page
function theme_afpa_dsp_index(){
	include(elgg_get_plugins_path() . 'theme_afpa_dsp/pages/theme_afpa_dsp/loggedin_homepage.php');
	return true;
}

// Theme public index page
function theme_afpa_dsp_public_index() {
	include(elgg_get_plugins_path() . 'theme_afpa_dsp/pages/theme_afpa_dsp/public_homepage.php');
	return true;
}



