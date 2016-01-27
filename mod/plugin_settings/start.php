<?php
/**
 * plugins_settings plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'plugins_settings_init');


/**
 * Init plugins_settings plugin.
 */
function plugins_settings_init() {
	
	elgg_extend_view('css', 'plugins_settings/css');
	
	/* Some useful elements :
	
	// Register a PHP library
	elgg_register_library('elgg:plugins_settings', elgg_get_plugins_path() . 'plugins_settings/lib/plugins_settings.php');
	// Load a PHP library (can also be loaded from the page_handler or from specific views)
	elgg_load_library('elgg:plugins_settings');
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/plugins_settings');
	$css_url = elgg_get_simplecache_url('css', 'plugins_settings');
	
	// Register JS script - use with : elgg_load_js('plugins_settings');
	$js_url = elgg_get_plugins_path() . 'plugins_settings/vendors/plugins_settings.js';
	elgg_register_js('plugins_settings', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('plugins_settings');
	$css_url = elgg_get_plugins_path() . 'plugins_settings/vendors/plugins_settings.css';
	elgg_register_css('plugins_settings', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'plugins_settings');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'plugins_settings');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'plugins_settings_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','plugins_settings_someevent');
	
	*/
	
	
}



/* Other functions
 * always use plugin prefix : plugins_settings_
 * if many, put functions in lib/plugins_settings/functions.php
function plugins_settings_function() {
	
}
*/



