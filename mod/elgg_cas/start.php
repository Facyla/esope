<?php
/**
 * Elgg CAS authentication
 * 
 * @package elgg_cas
 * @license http://www.gnu.org/licenses/gpl.html
 * @author Florian DANIEL
 */

elgg_register_event_handler('init', 'system', 'elgg_cas_init'); // Init

/**
 * CAS Authentication init
 * 
 */
function elgg_cas_init() {
	global $CONFIG;
	
	// CSS et JS
	elgg_extend_view('css/elgg', 'elgg_cas/css');
	
	// Extend login form
	elgg_extend_view('forms/login', 'elgg_cas/login_extend', 300);
	
	// Add CAS library
	elgg_register_library('elgg:elgg_cas', elgg_get_plugins_path() . 'elgg_cas/lib/CAS-1.3.2/CAS.php');
	
	// CAS page handler
	elgg_register_page_handler('cas_auth', 'elgg_cas_page_handler');
	$enable_ws_auth = elgg_get_plugin_setting('enable_ws_auth', 'elgg_cas');
	if ($enable_ws_auth == 'yes') {
		elgg_register_page_handler('cas_auth_ws', 'elgg_cas_page_handler_ws');
	}
	
	// Redirection pour déconnexion CAS après la fin du logout
	elgg_register_event_handler('logout','user','elgg_cas_logout_handler', 1);
	
	// Autologin attempt
	$autologin = elgg_get_plugin_setting('autologin', 'elgg_cas', false);
	if (($autologin == 'yes') && !elgg_is_logged_in()) {
		elgg_register_event_handler("pagesetup", "system", "elgg_cas_autologin");
	}
	
	// CAS registration
	//$casregister = elgg_get_plugin_setting('casregister', 'elgg_cas', false);
	
}


// CAS auth page handler
function elgg_cas_page_handler($page) {
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

// Same, but for webservices auth
function elgg_cas_page_handler_ws($page) {
	$base = elgg_get_plugins_path() . 'elgg_cas/pages/elgg_cas';
	if (!isset($page[0])) { $page[0] = 'login'; }
	
	switch($page[0]) {
		case 'logout': set_input('logout', 'logout');
		case 'login':
		default:
			if (!include_once "$base/cas_login_ws.php") return false;
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


function elgg_cas_autologin() {
	global $CONFIG;
	if ((elgg_get_viewtype() == 'default') && (full_url() == $CONFIG->url)) {
		// CAS autologin
		elgg_load_library('elgg:elgg_cas');
		//require_once elgg_get_plugins_path() . 'elgg_cas/lib/elgg_cas/config.php';
		$cas_host = elgg_get_plugin_setting('cas_host', 'elgg_cas', '');
		$cas_context = elgg_get_plugin_setting('cas_context', 'elgg_cas', '/cas');
		$cas_port = (int) elgg_get_plugin_setting('cas_port', 'elgg_cas', 443);
		$cas_server_ca_cert_path = elgg_get_plugin_setting('ca_cert_path', 'elgg_cas', '');
	
		if (!empty($cas_host) && !empty($cas_port) && !empty($cas_context)) {
			global $cas_client_loaded;
			if (!$cas_client_loaded) {
				phpCAS::setDebug();
				phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
				$cas_client_loaded = true;
				if (!empty($cas_server_ca_cert_path)) {
					phpCAS::setCasServerCACert($cas_server_ca_cert_path);
				} else {
					phpCAS::setNoCasServerValidation();
				}
			}
			if (phpCAS::checkAuthentication()) {
				system_message(elgg_echo('elgg_cas:casdetected'));
				$cas_login_included = true;
				include_once elgg_get_plugins_path() . 'elgg_cas/pages/elgg_cas/cas_login.php';
			}
		}
	}
}


