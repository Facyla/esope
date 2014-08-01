<?php
/**
 * plugin_template plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'plugin_template_init');


/**
 * Init plugin_template plugin.
 */
function plugin_template_init() {
	global $CONFIG; // All site useful vars
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'plugin_template');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'plugin_template');
	}
	
	// Register a page handler on "plugin_template/"
	elgg_register_page_handler('plugin_template', 'plugin_template_page_handler');
	
	
}


// Page handler
// Loads pages located in plugin_template/pages/plugin_template/
function plugin_template_page_handler($page) {
	$base = elgg_get_plugins_path() . 'plugin_template/pages/plugin_template';
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
function plugin_template_function() {
	
}
*/



