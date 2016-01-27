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
	
	/* Some useful elements :
	
	// Register a PHP library
	elgg_register_library('elgg:plugin_template', elgg_get_plugins_path() . 'plugin_template/lib/plugin_template.php');
	// Load a PHP library (can also be loaded from the page_handler or from specific views)
	elgg_load_library('elgg:plugin_template');
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/plugin_template');
	$css_url = elgg_get_simplecache_url('css', 'plugin_template');
	
	// Register JS script - use with : elgg_load_js('plugin_template');
	$js_url = elgg_get_plugins_path() . 'plugin_template/vendors/plugin_template.js';
	elgg_register_js('plugin_template', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('plugin_template');
	$css_url = elgg_get_plugins_path() . 'plugin_template/vendors/plugin_template.css';
	elgg_register_css('plugin_template', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'plugin_template');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'plugin_template');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'plugin_template_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','plugin_template_someevent');
	
	*/
	
	// Register a page handler on "plugin_template/"
	elgg_register_page_handler('plugin_template', 'plugin_template_page_handler');
	
	
}


// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'plugin_template/lib/plugin_template/hooks.php');
include_once(elgg_get_plugins_path() . 'plugin_template/lib/plugin_template/events.php');


// Page handler
// Loads pages located in plugin_template/pages/plugin_template/
function plugin_template_page_handler($page) {
	$base = elgg_get_plugins_path() . 'plugin_template/pages/plugin_template';
	switch ($page[0]) {
		/*
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		*/
		default:
			include "$base/index.php";
	}
	return true;
}


/* Other functions
 * always se plugin prefix : plugin_template_
 * if many, put functions in lib/plugin_template/functions.php
function plugin_template_function() {
	
}
*/



