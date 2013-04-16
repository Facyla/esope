<?php
/**
* Elgg LDAP synchronisation
*
* @package Elgg.ldap_auth
* @license 
* @author Simon Bouland <simon.bouland@inria.fr>
* @link http://elgg.com
*/

// Register the initialisation function
elgg_register_event_handler('init','system','ldap_auth_init');

/**
 * Init plugin ldap_auth
 */
function ldap_auth_init()
{
	require_once 'settings.php';

	//helper functions
	elgg_register_library('elgg:ldap_auth', elgg_get_plugins_path() . 'ldap_auth/lib/ldap_auth.php');
	
	// Register the authentication handler
	register_pam_handler('ldap_auth_handler_authenticate');
	
	
	elgg_register_event_handler('login','user', 'ldap_auth_handler_update');

}
/** Hook to update user profile at each login 
 * 
 * @param string $event  must be login
 * @param string $object_type must be user
 * @param ElggUser $user
 * @return boolean
 */
function ldap_auth_handler_update($event, $object_type, $user){
	if( $event == 'login' && $object_type == 'user' && $user && $user instanceof ElggUser){
		elgg_load_library("elgg:ldap_auth");
		return ldap_auth_check_profile($user);
	}else{
		return true;
	}
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
function ldap_auth_handler_authenticate(array $credentials = array())
{
	// Nothing to do if LDAP module not installed
	if (!function_exists('ldap_connect')){
		throw new LoginException(elgg_echo('LoginException:ContactAdmin:missingLDAP'));
	}

	if (is_array($credentials) && ($credentials['username']) && ($credentials['password']))
	{
		$username = $credentials['username'];
		$password = $credentials['password'];
	}
	else
	{
		throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
	}

	// Perform the authentication
	elgg_load_library("elgg:ldap_auth");
	return ldap_auth_login($username, $password);
}
