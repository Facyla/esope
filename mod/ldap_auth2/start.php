<?php
/**
* Elgg LDAP synchronisation
*
* @package Elgg.ldap_auth
* @license 
* @author Simon Bouland <simon.bouland@inria.fr>
* @link http://elgg.com
* 
* @updated Stéphane Ribas & Florian Daniel
*/

// Register the initialisation function
elgg_register_event_handler('init','system','ldap_auth_init');

/**
 * Init plugin ldap_auth
 */
function ldap_auth_init() {
	if (!include_once 'settings.php') {
		register_error(elgg_echo('ldap_auth:missingsettings'));
	}
	
	// LDAP helper functions for Elgg interfacing
	elgg_register_library('elgg:ldap_auth', dirname(__FILE__) . '/lib/ldap_auth.php');

	// Register the authentication handler
	register_pam_handler('ldap_auth_handler_authenticate', 'sufficient', 'user');

	// Update infos from LDAP
	elgg_register_event_handler('login','user', 'ldap_auth_handler_update');
	
}


/** Hook to update user profile at each login 
 * 
 * @param string $event  must be login
 * @param string $object_type must be user
 * @param ElggUser $user
 * @return boolean
 * Note : always return true because we want to try updating data, but not block login process
 */
function ldap_auth_handler_update($event, $object_type, $user){
	if ( ($event == 'login') && ($object_type == 'user') && $user && elgg_instanceof($user, 'user')) {
		elgg_load_library("elgg:ldap_auth");
		// Update LDAP fields
		$return = ldap_auth_check_profile($user);
		//error_log("LDAP_AUTH start.php ldap_auth_handler_update failed : " . $return);
	}
	return true;
}


/**
 * Hook into the PAM system which accepts a username and password and attempts to authenticate
 * it against a known user @ LDAP server.
 *
 * @param array $credentials Associated array of credentials passed to
 *                           Elgg's PAM system. This function expects
 *                           'username' and 'password' (cleartext).
 *
 * @return bool
 * @throws LoginException
 * @access private
 */
function ldap_auth_handler_authenticate($credentials = array()) {
	// Nothing to do if LDAP module not installed
	if (!function_exists('ldap_connect')) {
		error_log("DEBUG : LDAP PHP extension is not installed !");
		throw new LoginException(elgg_echo('LoginException:ContactAdmin:missingLDAP'));
	}
	
	if (is_array($credentials) && isset($credentials['username']) && isset($credentials['password'])) {
		$username = $credentials['username'];
		$password = $credentials['password'];
	} else {
		throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
	}
	
	// Perform the authentication
	elgg_load_library("elgg:ldap_auth");
	return ldap_auth_login($username, $password);
}


