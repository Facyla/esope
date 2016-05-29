<?php
/**
 * phpword plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'phpword_init');


/**
 * Init phpword plugin.
 */
function phpword_init() {
	
	elgg_extend_view('css', 'phpword/css');
	
	// Register a PHP library
	elgg_register_library('elgg:phpword', elgg_get_plugins_path() . 'phpword/vendors/PHPWord/src/PhpWord/Autoloader.php');
	
	/* Some useful elements :
	
	// Register actions
	// Actions should be defined in actions/phpword/action_name.php
	$action_base = elgg_get_plugins_path() . 'systems_game/actions/';
	elgg_register_action('systems_game/edit', $action_base . 'edit.php');
	elgg_register_action('systems_game/delete', $action_base . 'delete.php');
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/phpword');
	$css_url = elgg_get_simplecache_url('css', 'phpword');
	
	// Register JS script - use with : elgg_load_js('phpword');
	$js_url = elgg_get_plugins_path() . 'phpword/vendors/phpword.js';
	elgg_register_js('phpword', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('phpword');
	$css_url = elgg_get_plugins_path() . 'phpword/vendors/phpword.css';
	elgg_register_css('phpword', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'phpword');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'phpword');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'phpword_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','phpword_someevent');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "phpword_icon_hook");
	
	// override the default url to view a phpword object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'phpword_set_url');
	
	*/
	
	// Register a page handler on "phpword/"
	elgg_register_page_handler('phpword', 'phpword_page_handler');
	
	
}


// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'phpword/lib/phpword/hooks.php');
include_once(elgg_get_plugins_path() . 'phpword/lib/phpword/events.php');
include_once(elgg_get_plugins_path() . 'phpword/lib/phpword/functions.php');


// Page handler
// Loads pages located in phpword/pages/phpword/
function phpword_page_handler($page) {
	$base = elgg_get_plugins_path() . 'phpword/pages/phpword/';
	$samples_base = elgg_get_plugins_path() . 'phpword/vendors/PHPWord/samples/';
	
	// Load a PHP library (can also be loaded from the page_handler or from specific views)
	elgg_load_library('elgg:phpword');
	\PhpOffice\PhpWord\Autoloader::register();
	
	switch ($page[0]) {
		/*
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		*/
		case 'samples':
			if (!include $samples_base . $page[1]) {
				include $samples_base . 'index.php';
			}
			break;
		
		default:
			include $base . 'index.php';
	}
	return true;
}


/* Other functions
 * always use plugin prefix : phpword_
 * if many, put functions in lib/phpword/functions.php
function phpword_function() {
	
}
*/



