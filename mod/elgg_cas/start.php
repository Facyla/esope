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
	
	// CSS et JS
	elgg_extend_view('css/elgg', 'elgg_cas/css');
	
	// Extend login form
	elgg_extend_view('forms/login', 'elgg_cas/login_extend', 300);
	
	// Expose CAS backend also in walled garden mode
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'elgg_cas_public_pages');
	
	// Add CAS library (default to version 1.3.4)
	/* Note : when used with openssl 0.9.8k, please choose lib 1.3.2 and apply patch (see README)
	 * The patch is already made in 1.3.2, in CAS/Request/ CurlRequest and CurlMultiRequest
	 * Since SSL3 security issues, you may want to update it to (requires testing) :
	 *    curl_setopt($handle, CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1_2);
	 */
	$cas_library = elgg_get_plugin_setting('cas_library', 'elgg_cas');
	switch($cas_library) {
		case '1.3.2':
			elgg_register_library('elgg:elgg_cas', elgg_get_plugins_path() . 'elgg_cas/vendors/phpCAS-1.3.2/CAS.php');
			break;
		case '1.3.3':
			elgg_register_library('elgg:elgg_cas', elgg_get_plugins_path() . 'elgg_cas/vendors/phpCAS-1.3.3/CAS.php');
			break;
		default:
			elgg_register_library('elgg:elgg_cas', elgg_get_plugins_path() . 'elgg_cas/vendors/phpCAS-1.3.4/CAS.php');
	}
	
	// CAS page handler
	elgg_register_page_handler('cas_auth', 'elgg_cas_page_handler');
	$enable_ws_auth = elgg_get_plugin_setting('enable_ws_auth', 'elgg_cas');
	if ($enable_ws_auth == 'yes') {
		elgg_register_page_handler('cas_auth_ws', 'elgg_cas_page_handler_ws');
	}
	
	// Redirection pour déconnexion CAS après la fin du logout
	elgg_register_event_handler('logout:after','user','elgg_cas_logout_handler');
	
	// Autologin attempt
	if (!elgg_is_logged_in()) {
		$autologin = elgg_get_plugin_setting('autologin', 'elgg_cas', false);
		if ($autologin == 'yes') {
			elgg_register_event_handler("pagesetup", "system", "elgg_cas_autologin");
		}
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


// Intercept logout and disconnect from CAS
function elgg_cas_logout_handler($event, $object_type, $user) {
	// Skip logout if run programmatically (eg. from CLI or cron)
	if (elgg_in_context('cron') || (php_sapi_name() == 'cli')) { return; }
	
	if (elgg_instanceof($user, 'user') && $user->is_cas_logged) {
		// Unset CAS login marker - we might use another way another time..
		$user->is_cas_logged = false;
		forward('cas_auth/?logout');
	}
	return;
}


// Load CAS client and check authentication
// Return true if client is loaded
function elgg_cas_load_client($debug = false) {
	static $cas_client_loaded = false;
	if ($debug) { echo "CAS active<br />"; }
	
	if (!$cas_client_loaded) {
		elgg_load_library('elgg:elgg_cas');
		// CAS config
		//require_once elgg_get_plugins_path() . 'elgg_cas/lib/elgg_cas/config.php';
		$cas_host = elgg_get_plugin_setting('cas_host', 'elgg_cas', '');
		$cas_context = elgg_get_plugin_setting('cas_context', 'elgg_cas', '/cas');
		$cas_port = (int) elgg_get_plugin_setting('cas_port', 'elgg_cas', 443);
		$cas_server_ca_cert_path = elgg_get_plugin_setting('ca_cert_path', 'elgg_cas', '');
		if (empty($cas_host) || empty($cas_port) || empty($cas_context)) { return false; }
	
		if ($debug) {
			// enable debug log in /tmp/phpCAS.log - can grow a lot if not rotated (and its' not rotated by default)
			phpCAS::setDebug();
		}
		phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
		if (!empty($cas_server_ca_cert_path)) {
			phpCAS::setCasServerCACert($cas_server_ca_cert_path);
		} else {
			phpCAS::setNoCasServerValidation();
		}
		$cas_client_loaded = true;
	}
	
	return $cas_client_loaded;
}

// Load CAS client and check authentication
// Return true if authenticated
function elgg_cas_check_authentication($debug = false) {
	static $is_cas_authenticated = false;
	if ($debug) { echo "CAS active<br />"; }
	
	if (elgg_cas_load_client($debug)) {
		if (phpCAS::checkAuthentication()) {
			$is_cas_authenticated = true;
			if ($debug) { echo "AUTH OK<br />"; }
		}
	}
	
	return $is_cas_authenticated;
}


// Automatically log in currently logged in CAS user
function elgg_cas_autologin() {
	if ((elgg_get_viewtype() == 'default') && (current_page_url() == elgg_get_site_url())) {
		/*
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
		*/
		$checkAuth = elgg_cas_check_authentication();
		if ($checkAuth) {
			system_message(elgg_echo('elgg_cas:casdetected'));
			$cas_login_included = true;
			include_once elgg_get_plugins_path() . 'elgg_cas/pages/elgg_cas/cas_login.php';
		}
	}
}

/** Login client from CAS authentication
 * @return false|ElggUser
 */
function elgg_cas_login($debug = false) {
	static $logged_user = false;
	if (!elgg_instanceof($logged_user, 'user')) {
		$checkAuth = elgg_cas_check_authentication($debug);
		if ($checkAuth) {
			$username = phpCAS::getUser();
			if ($debug) { echo "Username : $username<br />"; }
			$user = get_user_by_username($username);
			// Need to log in user so access levels apply
			if (elgg_instanceof($user, 'user')) {
				if (!$user->isBanned()) {
					if ($debug) { echo "User not banned<br />"; }
					$logged_user = $user; // store user logged by CAS
					login($user);
					return $user;
				}
			}
		}
	}
	return false;
}

// Permet l'accès à diverses pages en mode "walled garden"
function elgg_cas_public_pages($hook, $type, $return, $params) {
	// Main CAS auth backend
	$return[] = 'cas_auth';
	$return[] = 'cas_auth/.*';
	$enable_ws_auth = elgg_get_plugin_setting('enable_ws_auth', 'elgg_cas');
	if ($enable_ws_auth == 'yes') {
		// Main WS CAS auth backend
		$return[] = 'cas_auth_ws';
		$return[] = 'cas_auth_ws/.*';
	}
	
	return $return;
}


