<?php
/**
 * togetherjs plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'togetherjs_init');


/**
 * Init togetherjs plugin.
 */
function togetherjs_init() {
	global $CONFIG; // All site useful vars
	
	
	elgg_extend_view('css', 'togetherjs/css');
	
	// @TODO : make it a setting
	if (elgg_is_logged_in()) {
		elgg_extend_view('page/elements/head', 'togetherjs/extend_head');
		elgg_extend_view('page/elements/footer', 'togetherjs/extend_body');
	}
	
	/*
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'togetherjs');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'togetherjs');
	}
	
	// Register a page handler on "togetherjs/"
	elgg_register_page_handler('togetherjs', 'togetherjs_page_handler');
	*/
	
	
}

/*
// Page handler
// Loads pages located in togetherjs/pages/togetherjs/
function togetherjs_page_handler($page) {
	$base = elgg_get_plugins_path() . 'togetherjs/pages/togetherjs';
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
function togetherjs_function() {
	
}
*/




