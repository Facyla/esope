<?php
/**
 * plugin_template plugin
 *
 */

elgg_register_event_handler('init', 'system', 'plugin_template_init'); // Init


/**
 * Init plugin_template plugin.
 */
function theme_test_init() {
	global $CONFIG; // All site useful vars
	elgg_extend_view('css/elgg', 'theme_test/css');
	//$messages_send = elgg_get_plugin_setting('messages_send', 'plugin_template');

		// HOMEPAGE
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_inria_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_inria_public_index');
		}
	}
}


// Other useful functions
// prefixed by plugin_name_



// INDEX PAGES

// Theme inria logged in index page
function theme_inria_index(){
	global $CONFIG;
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/loggedin_homepage.php');
	return true;
}

// Theme inria public index page
function theme_inria_public_index() {
	global $CONFIG;
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/public_homepage.php');
	return true;
}

