<?php
/**
 * theme_propage_paca plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'theme_propage_paca_init');


/**
 * Init theme_propage_paca plugin.
 */
function theme_propage_paca_init() {
	global $CONFIG; // All site useful vars
	
	elgg_extend_view('css', 'theme_propage_paca/css');
	elgg_extend_view('css/digest/core', 'css/digest/extend_core');
	
	// Extend digest
	// Note : unextending does not work here, but changing priority works.. to remove modules, use empty views.
	elgg_extend_view('digest/elements/site', 'digest/elements/site/news_group', 100);
	elgg_extend_view('digest/elements/site', 'digest/elements/site/profile', 200);
	elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
	
	elgg_extend_view('groups/sidebar/members', 'theme_propage_paca/extend_group_sidebar', 800);
	
	// HOMEPAGE - Replace public and loggedin homepage
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_propage_paca_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_propage_paca_public_index');
		}
	}
	
}



// Theme PROPAGE PACA logged in index page
function theme_propage_paca_index(){
	include(elgg_get_plugins_path() . 'theme_propage_paca/pages/theme_propage_paca/loggedin_homepage.php');
	return true;
}

// Theme PROPAGE PACA public index page
function theme_propage_paca_public_index() {
	include(elgg_get_plugins_path() . 'theme_propage_paca/pages/theme_propage_paca/public_homepage.php');
	return true;
}


