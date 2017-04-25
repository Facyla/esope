<?php
/**
 * content_facets plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'content_facets_init');


/**
 * Init content_facets plugin.
 */
function content_facets_init() {
	
	elgg_extend_view('css', 'content_facets/css');
	
	// Main functionnality
	elgg_extend_view('output/longtext', 'content_facets/longtext_extend');
	
	// Main library
	elgg_register_library('elgg:content_facets', elgg_get_plugins_path() . 'content_facets/classes/ElggContentFacets.php');
	
	// External libraries
	elgg_register_library('elgg:content_facets:vendors', elgg_get_plugins_path() . 'content_facets/vendor/autoload.php');
	/*
	elgg_register_library('elgg:content_facets:essence', elgg_get_plugins_path() . 'content_facets/vendor/essence/essence/lib/Essence/Essence.php');
	elgg_register_library('elgg:content_facets:multiplayer', elgg_get_plugins_path() . 'content_facets/vendor/fg/multiplayer/lib/Multiplayer/Multiplayer.php');
	*/
	
	
	/* Some useful elements :
	
	// Register actions
	// Actions should be defined in actions/content_facets/action_name.php
	$action_base = elgg_get_plugins_path() . 'systems_game/actions/';
	elgg_register_action('systems_game/edit', $action_base . 'edit.php');
	elgg_register_action('systems_game/delete', $action_base . 'delete.php');
	
	// Register a PHP library
	elgg_register_library('elgg:content_facets', elgg_get_plugins_path() . 'content_facets/lib/content_facets.php');
	// Load a PHP library (can also be loaded from the page_handler or from specific views)
	elgg_load_library('elgg:content_facets');
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/content_facets');
	$css_url = elgg_get_simplecache_url('css', 'content_facets');
	
	// Register JS script - use with : elgg_load_js('content_facets');
	$js_url = elgg_get_plugins_path() . 'content_facets/vendors/content_facets.js';
	elgg_register_js('content_facets', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('content_facets');
	$css_url = elgg_get_plugins_path() . 'content_facets/vendors/content_facets.css';
	elgg_register_css('content_facets', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'content_facets');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'content_facets');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'content_facets_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','content_facets_someevent');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "content_facets_icon_hook");
	
	// override the default url to view a content_facets object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'content_facets_set_url');
	
	*/
	
	// Register a page handler on "content_facets/"
	elgg_register_page_handler('content_facets', 'content_facets_page_handler');
	
	
}


// Include page handlers, hooks and events functions
/*
include_once(elgg_get_plugins_path() . 'content_facets/lib/content_facets/hooks.php');
include_once(elgg_get_plugins_path() . 'content_facets/lib/content_facets/events.php');
include_once(elgg_get_plugins_path() . 'content_facets/lib/content_facets/functions.php');
*/


// Page handler
// Loads pages located in content_facets/pages/content_facets/
function content_facets_page_handler($page) {
	$base = elgg_get_plugins_path() . 'content_facets/pages/content_facets';
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
 * always use plugin prefix : content_facets_
 * if many, put functions in lib/content_facets/functions.php
function content_facets_function() {
	
}
*/




