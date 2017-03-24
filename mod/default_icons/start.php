<?php
/**
 * default_icons plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'default_icons_init');


/**
 * Init default_icons plugin.
 */
function default_icons_init() {
	
	elgg_extend_view('css', 'default_icons/css');
	
	// Main plugin classes
	elgg_register_library('facyla:elgg:default_icons', elgg_get_plugins_path() . 'default_icons/classes/ElggDefaultIcons.php');
	elgg_load_library('facyla:elgg:default_icons');
	
	// Register PHP libraries
	//elgg_register_library('sebsauvage:vizhash', elgg_get_plugins_path() . 'default_icons/vendor/sebsauvage/vizhash/vizhash_gd.php');
	// Better packaged as classes
	elgg_register_library('splitbrain:php-ringicon', elgg_get_plugins_path() . 'default_icons/vendor/splitbrain/php-ringicon/src/RingIcon.php');
	elgg_register_library('exorithm:unique_image', elgg_get_plugins_path() . 'default_icons/classes/ExorithmUniqueImage.php');
	elgg_register_library('sebsauvage:vizhash', elgg_get_plugins_path() . 'default_icons/classes/SebsauvageVizHash.php');
	elgg_register_library('tiborsaas:ideinticon', elgg_get_plugins_path() . 'default_icons/vendors/tiborsaas/Ideinticon/identicon.class.php');
	
	// Load a PHP library (can also be loaded from the page_handler or from specific views)
	//elgg_load_library('sebsauvage:vizhash');
	//elgg_load_library('splitbrain:php-ringicon');
	
	
	/* Some useful elements :
	
	// Register actions
	// Actions should be defined in actions/default_icons/action_name.php
	$action_base = elgg_get_plugins_path() . 'systems_game/actions/';
	elgg_register_action('systems_game/edit', $action_base . 'edit.php');
	elgg_register_action('systems_game/delete', $action_base . 'delete.php');
	
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/default_icons');
	$css_url = elgg_get_simplecache_url('css', 'default_icons');
	
	// Register JS script - use with : elgg_load_js('default_icons');
	$js_url = elgg_get_plugins_path() . 'default_icons/vendors/default_icons.js';
	elgg_register_js('default_icons', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('default_icons');
	$css_url = elgg_get_plugins_path() . 'default_icons/vendors/default_icons.css';
	elgg_register_css('default_icons', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'default_icons');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'default_icons');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'default_icons_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','default_icons_someevent');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "default_icons_icon_hook");
	
	// override the default url to view a default_icons object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'default_icons_set_url');
	
	*/
	
	// Register a page handler on "default_icons/"
	elgg_register_page_handler('default_icons', 'default_icons_page_handler');
	
	
}


// Include page handlers, hooks and events functions
/*
include_once(elgg_get_plugins_path() . 'default_icons/lib/default_icons/hooks.php');
include_once(elgg_get_plugins_path() . 'default_icons/lib/default_icons/events.php');
include_once(elgg_get_plugins_path() . 'default_icons/lib/default_icons/functions.php');
*/


// Page handler
// Loads pages located in default_icons/pages/default_icons/
function default_icons_page_handler($page) {
	$base = elgg_get_plugins_path() . 'default_icons/pages/default_icons';
	switch ($page[0]) {
		/*
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		*/
		case 'icon':
		default:
			if (!empty($page[1])) { set_input('seed', $page[1]); }
			// This will not remain
			if (!empty($page[2])) { set_input('algorithm', $page[2]); }
			if (!empty($page[3])) { set_input('width', $page[3]); }
			if (!empty($page[4])) { set_input('num', $page[4]); }
			if (!empty($page[5])) { set_input('mono', $page[5]); }
			include "$base/index.php";
	}
	return true;
}


/* Other functions
 * always use plugin prefix : default_icons_
 * if many, put functions in lib/default_icons/functions.php
function default_icons_function() {
	
}
*/



