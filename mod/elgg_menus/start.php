<?php
/**
 * elgg_menus plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'elgg_menus_init');


/**
 * Init elgg_menus plugin.
 */
function elgg_menus_init() {
	global $CONFIG; // All site useful vars
	
	
	elgg_extend_view('css', 'elgg_menus/css');
	elgg_extend_view('css/admin', 'elgg_menus/css');
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:elgg_menus');
	elgg_register_library('elgg:elgg_menus', elgg_get_plugins_path() . 'elgg_menus/lib/elgg_menus.php');
	
	// Register JS script - use with : elgg_load_js('elgg_menus');
	elgg_register_js('elgg_menus', '/mod/elgg_menus/vendors/elgg_menus.js', 'head');
	
	// Register CSS - use with : elgg_load_css('elgg_menus');
	elgg_register_simplecache_view('css/elgg_menus');
	$elgg_menus_css = elgg_get_simplecache_url('css', 'elgg_menus');
	elgg_register_css('elgg_menus', $elgg_menus_css);
	*/
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'elgg_menus');
	
	elgg_register_admin_menu_item('configure', 'menus', 'appearance');
	
}


/*
function elgg_menus_function() {
	
}
*/



