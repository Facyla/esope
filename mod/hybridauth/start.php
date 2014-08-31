<?php
/* Hybridauth integration */

/* Initialise le plugin */
function hybridauth_init() {
	elgg_extend_view('css','hybridauth/css');
	elgg_register_page_handler('hybridauth','hybridauth_page_handler');
	
	if (elgg_get_plugin_setting('login_enable', 'hybridauth') == 'yes') {
		elgg_extend_view('forms/login', 'hybridauth/login');
	}
	if (elgg_get_plugin_setting('register_enable', 'hybridauth') == 'yes') {
		elgg_extend_view('forms/register', 'hybridauth/login');
	}
	
	
	// Short code processing library (from Wordpress)
	$root = elgg_get_plugins_path();
	elgg_register_library('hybridauth', $root."hybridauth/vendors/hybridauth/hybridauth/Hybrid/Auth.php");
	elgg_register_library('elgg:hybridauth', $root."hybridauth/lib/hybridauth/hybridauth.php");
	
}


// Gestion des URL
function hybridauth_page_handler($page) {
	if (!isset($page[0])) { $page[0] = ''; }
	
	elgg_load_library('hybridauth');
	//require_once elgg_get_plugins_path() . "hybridauth/vendors/hybridauth/hybridauth/Hybrid/Auth.php";
	
	switch($page[0]) {
		case 'endpoint':
			include(dirname(__FILE__) . "/vendors/hybridauth/hybridauth/index.php");
			break;
			
		case 'twitter':
			if (elgg_get_plugin_setting($page[0].'_enable', 'hybridauth') == 'yes') 
			include(dirname(__FILE__) . "/pages/hybridauth/twitter.php");
			break;
			
		case 'linkedin':
			if (elgg_get_plugin_setting($page[0].'_enable', 'hybridauth') == 'yes') 
			include(dirname(__FILE__) . "/pages/hybridauth/linkedin.php");
			break;
		case 'linkedin_profile_update':
			include(dirname(__FILE__) . "/pages/hybridauth/linkedin_profile_update.php");
			break;
			
		case 'google':
			if (elgg_get_plugin_setting($page[0].'_enable', 'hybridauth') == 'yes') 
			include(dirname(__FILE__) . "/pages/hybridauth/google.php");
			break;
			
		case 'facebook':
			if (elgg_get_plugin_setting($page[0].'_enable', 'hybridauth') == 'yes') 
			include(dirname(__FILE__) . "/pages/hybridauth/facebook.php");
			break;
			
		default:
			include(dirname(__FILE__) . "/pages/hybridauth/index.php");
	}
	return true;
}



// Initialise log browser
elgg_register_event_handler('init','system','hybridauth_init');

