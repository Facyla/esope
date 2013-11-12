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
	require_once 'settings.php';
	
	//helper functions
	elgg_register_library('elgg:ldap_auth', elgg_get_plugins_path() . 'ldap_auth/lib/ldap_auth.php');
	
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
	if( $event == 'login' && $object_type == 'user' && $user && $user instanceof ElggUser){
		elgg_load_library("elgg:ldap_auth");
		// UPdate metadata fields
		$return = ldap_update_user_status($user);
		error_log("Profile updated");
		// Update LDAP fields
		$return = ldap_auth_check_profile($user);
		error_log("LDAP fields updated");
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
function ldap_auth_handler_authenticate(array $credentials = array()) {
	// @TODO : debug Inria : le "problème" est que le mot de passe est filtré (get_input) via Elgg, donc on a besoin de récupérer directement le GET/POST et de savoir si c'est identique ou pas.
	
	// Nothing to do if LDAP module not installed
	if (!function_exists('ldap_connect')) {
		error_log("DEBUG : LDAP PHP extension is not installed !");
		throw new LoginException(elgg_echo('LoginException:ContactAdmin:missingLDAP'));
	}

	if (is_array($credentials) && ($credentials['username']) && ($credentials['password'])) 	{
		$username = $credentials['username'];
		$password = $credentials['password'];
		/* Use more direct functions to get the paswword ?
		$password2 = get_input('password', '', false); $password3 = $_GET["password"]; $password4 = $_POST["password"];
		register_error("DEBUG LDAP : $username : $password = $password2 = $password3 = $password4"); // @TODO
		error_log("DEBUG LDAP : $username : $password = $password2 = $password3 = $password4"); // @TODO
		*/
	} else {
		throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
	}
	
	// Perform the authentication
	elgg_load_library("elgg:ldap_auth");
	return ldap_auth_login($username, $password);
}



/* Met à jour les infos des membres
 * Existe dans le LDAP : compte Inria
 * Pas dans le LDAP : compte externe
 * Inactif ou période expirée : marque comme archivé
 */
function ldap_update_user_status($user) {
	system_message("Hook login");
	if (elgg_instanceof($user, 'user')) {
		system_message("Informations du compte mises à jour");
		elgg_load_library("elgg:ldap_auth");
		if (ldap_user_exists($user->username)) {
			if ($user->membertype != 'internal') $user->membertype = 'internal';
			if (ldap_auth_is_closed($user->username)) {
				//$user->banned = 'yes'; // Don't ban automatically, refusing access on various criteria is enough
				if ($user->memberstatus != 'closed') $user->memberstatus = 'closed';
			} else {
				if ($user->memberstatus != 'active') $user->memberstatus = 'active';
			}
		} else {
			if ($user->membertype != 'external') $user->membertype = 'external';
			// External access has some restrictions : if account was not used for more than 1 year => disable
			if ( (time() - $user->last_action) > 31622400) {
				if ($user->memberstatus != 'closed') $user->memberstatus = 'closed';
			} else {
				if ($user->memberstatus != 'active') $user->memberstatus = 'active';
			}
		}
		//return $user->save();
	}
	return true;
}


