<?php
/**
 * citadel_converter plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'citadel_converter_init');


/**
 * Init citadel_converter plugin.
 */
function citadel_converter_init() {
	
	elgg_extend_view('css', 'citadel_converter/css');
	
	
	// Register a PHP library
	elgg_register_library('elgg:citadel_converter', elgg_get_plugins_path() . 'citadel_converter/lib/citadel_converter/citadel_converter.php');
	
	// Register a page handler on "citadel_converter/"
	elgg_register_page_handler('citadel_converter', 'citadel_converter_page_handler');
	
	// Page menu
	elgg_register_plugin_hook_handler('register', 'menu:page', 'citadel_converter_page_menu');
	
	
	/* Some useful elements :
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/citadel_converter');
	$css_url = elgg_get_simplecache_url('css', 'citadel_converter');
	
	// Register JS script - use with : elgg_load_js('citadel_converter');
	$js_url = elgg_get_plugins_path() . 'citadel_converter/vendors/citadel_converter.js';
	elgg_register_js('citadel_converter', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('citadel_converter');
	$css_url = elgg_get_plugins_path() . 'citadel_converter/vendors/citadel_converter.css';
	elgg_register_css('citadel_converter', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'citadel_converter');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'citadel_converter');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'citadel_converter_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','citadel_converter_someevent');
	
	*/
	
}


// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'citadel_converter/lib/citadel_converter/hooks.php');
include_once(elgg_get_plugins_path() . 'citadel_converter/lib/citadel_converter/events.php');


// Page handler
// Loads pages located in citadel_converter/pages/citadel_converter/
function citadel_converter_page_handler($page) {
	// Load a PHP library
	elgg_load_library('elgg:citadel_converter');
	
	$base = elgg_get_plugins_path() . 'citadel_converter/pages/citadel_converter';
	switch ($page[0]) {
		case 'convert':
			include "$base/convert.php";
			break;
		case 'template':
			include "$base/template.php";
			break;
		default:
			include "$base/index.php";
	}
	return true;
}



