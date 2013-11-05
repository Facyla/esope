<?php
/**
 * Elgg CAS authentication
 * 
 * @package elgg_cas
 * @license http://www.gnu.org/licenses/gpl.html
 * @author Florian DANIEL
 */

elgg_register_event_handler('init', 'system', 'elgg_cas_init'); // Init
elgg_register_event_handler("plugins_boot", "system", "elgg_cas_autologin"); // Autologin attempt

/**
 * CAS Authentication init
 * 
 */
function elgg_cas_init() {
	global $CONFIG;
	
	// CSS et JS
	elgg_extend_view('css/elgg', 'elgg_cas/css');
	
	// Extend login form
	elgg_extend_view('forms/account/login', 'elgg_cas/login_extend');
	
	// Add CAS library
	elgg_register_library('elgg:elgg_cas', elgg_get_plugins_path() . 'elgg_cas/lib/CAS-1.3.2/CAS.php');
	
	// CAS page handler
	elgg_register_page_handler('cas_auth', 'elgg_cas_page_handler');
	
	// Redirection pour déconnexion CAS après la fin du logout
	elgg_register_event_handler('logout','user','elgg_cas_logout_handler', 1);
	
}


function elgg_cas_autologin() {
	global $CONFIG;
	// CAS autologin
	$autologin = elgg_get_plugin_setting('autologin', 'elgg_cas', false);
	if ($autologin && !elgg_is_logged_in()) {
		require_once elgg_get_plugins_path() . 'elgg_cas/lib/CAS-1.3.2/CAS.php';
		require_once elgg_get_plugins_path() . 'elgg_cas/lib/elgg_cas/config.php';
		if ($cas_host && $cas_port && $cas_context) {
			phpCAS::setDebug();
			phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
			global $cas_client_loaded;
			$cas_client_loaded = true;
			phpCAS::setNoCasServerValidation();
			if (phpCAS::checkAuthentication()) {
				//system_message('Identification CAS détectée. Voulez-vous <a href="' . $CONFIG->url . 'cas_auth">vous connecter avec CAS</a> ?');
				system_message(elgg_echo('elgg_cas:casdetected'));
				include_once elgg_get_plugins_path() . 'elgg_cas/pages/elgg_cas/cas_login.php';
			}
		} else {
			register_error('elgg_cas:missingparams');
		}
	}
}


function elgg_cas_page_handler($page) {
	elgg_load_library('elgg:elgg_cas');
	require_once elgg_get_plugins_path() . 'elgg_cas/lib/elgg_cas/config.php';
	
	$base = elgg_get_plugins_path() . 'elgg_cas/pages/elgg_cas';
	if (!isset($page[0])) { $page[0] = 'login'; }
	
	switch($page[0]) {
		case 'logout': set_input('logout', 'logout');
		case 'login':
		default:
			if (!include_once "$base/cas_login.php") return false;
	}
	return true;
}


function elgg_cas_logout_handler($event, $object_type, $object) {
	global $CONFIG;
	$user = elgg_get_logged_in_user_entity();
	if ($user->is_cas_logged) {
		// Unset CAS login marker - we might use another way another time..
		$user->is_cas_logged = false;
		forward($CONFIG->url . 'cas_auth/?logout');
	} else return;
}

