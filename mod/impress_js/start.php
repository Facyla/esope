<?php
/**
 * impress_js plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'impress_js_init');


/**
 * Init impress_js plugin.
 */
function impress_js_init() {
	global $CONFIG; // All site useful vars
	
	
	elgg_extend_view('css', 'impress_js/css');
	
	// Register main Impress JS script
	elgg_register_js('impress.js', '/mod/impress_js/vendors/impress.js/js/impress.js', 'footer');
	// Add audio plugin
	elgg_register_js('impress-audio', '/mod/impress_js/vendors/impress-audio/js/impress-audio.js', 'footer');
	
	// Editors
	// Strut
	elgg_register_js('swfobject.js', '/mod/impress_js/vendors/Strut/preview_export/download_assist/swfobject.js', 'head');
	// Note : Strut js has to be loaded using a specific property
	//elgg_register_js('impress.strut', '/mod/impress_js/vendors/Strut/scripts/libs/require.js', 'footer');
	
	
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:impress_js');
	elgg_register_library('elgg:impress_js', elgg_get_plugins_path() . 'impress_js/lib/impress_js.php');
	
	// Register CSS - use with : elgg_load_css('impress_js');
	elgg_register_simplecache_view('css/impress_js');
	$impress_js_css = elgg_get_simplecache_url('css', 'impress_js');
	elgg_register_css('impress_js', $impress_js_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'impress_js');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'impress_js');
	}
	*/
	
	// Register a page handler on "impress_js/"
	elgg_register_page_handler('impress_js', 'impress_js_page_handler');
	
	
}


// Page handler
// Loads pages located in impress_js/pages/impress_js/
function impress_js_page_handler($page) {
	$base = elgg_get_plugins_path() . 'impress_js/pages/impress_js';
	switch ($page[0]) {
		case 'view':
			include "$base/view.php";
			break;
		case 'edit':
			include "$base/edit.php";
			break;
		default:
			include "$base/index.php";
	}
	return true;
}


// Other useful functions
// prefixed by plugin_name_
/*
function impress_js_function() {
	
}
*/



