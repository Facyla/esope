<?php
/**
 * plugin_template plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'plugin_template_init');


/**
 * Init plugin_template plugin.
 */
function plugin_template_init() {
	
	elgg_extend_view('css', 'plugin_template/css');
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:plugin_template');
	elgg_register_library('elgg:plugin_template', elgg_get_plugins_path() . 'plugin_template/lib/plugin_template.php');
	
	// Register JS script - use with : elgg_load_js('plugin_template');
	elgg_register_js('plugin_template', '/mod/plugin_template/vendors/plugin_template.js', 'head');
	
	// Register CSS - use with : elgg_load_css('plugin_template');
	elgg_register_simplecache_view('css/plugin_template');
	$plugin_template_css = elgg_get_simplecache_url('css', 'plugin_template');
	elgg_register_css('plugin_template', $plugin_template_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'plugin_template');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'plugin_template');
	}
	*/
	
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
function plugin_template_function() {
	
}
*/



