<?php
if (!require_once dirname(dirname(__FILE__)) . '/settings.php') {
	register_error("LDAP : missing LDAP settings file settings.php in plugin root folder - Il manque le fichier de configuration LDAP settings.php dans la racine du dossier du plugin.");
}

/**
 * ldap_auth helper functions
 *
 * @package Elgg.ldap_auth
 */

/**
 * Login process when using LDAP
 *
 * @param string $username the LDAP login.
 * @param string $password the coresponding LDAP password.
 * 
 * @return bool
 * @throws LoginException
 * @access private
 */
function ldap_auth_login($username, $password) {
	/* Notes : normalement les caractères spéciaux sont bien traités.. il ne devrait pas y avoir de raison qu'ils ne passent pas.
	Pour afficher le mot de passe en clair, utiliser htmlentities($password, ENT_QUOTES,'UTF-8');
	On n'a normalement pas besoin d'utiliser stripslashes (qui supprime les antislashs si ceux-ci sont utilisés)
	$password2 = get_input('password', '', false); $password3 = $_GET["password"]; $password4 = $_POST["password"];
	//$pwd = stripslashes($password); $pwd2 = stripslashes($password2); $pwd3 = stripslashes($password3); $pwd4 = stripslashes($password4);
	$pwd = $password; $pwd2 = $password2; $pwd3 = $password3; $pwd4 = $password4;
	error_log("DEBUG LDAP ldap_auth_login : $username : $pwd  2= $pwd2  3= $pwd3  4= $pw4"); // @TODO
	$pwd = htmlentities($pwd, ENT_QUOTES,'UTF-8'); $pwd2 = htmlentities($pwd2, ENT_QUOTES,'UTF-8'); $pwd3 = htmlentities($pwd3, ENT_QUOTES,'UTF-8'); $pwd4 = htmlentities($pwd4, ENT_QUOTES,'UTF-8');
	register_error("DEBUG LDAP ldap_auth_login : $username : $pwd  2= $pwd2  3= $pwd3  4= $pw4"); // @TODO
	*/
	
	if ( !ldap_auth_is_banned($username) ) {
		if (ldap_auth_is_valid($username, $password)) {
			if ($user = get_user_by_username($username)) {
				return login($user);
			}
			if ($user = ldap_auth_create_profile($username, $password)) {
				return login($user);
			}
		}
	}
	return true;
}

/**
 * Check if LDAP credentials are valid
 *
 * @param string $username the LDAP login.
 * @param string $password the coresponding LDAP password.
 *
 * @return bool Return true on success
 * @throws LoginException
 * @access private
 */
function ldap_auth_is_valid($username, $password) {
	$auth = new LdapServer(ldap_auth_settings_auth());
	//we need to bind anonymously to do search for rdn
	if ($auth->bind()) {
		//we need the rdn to perform a bind with password
		$rdn = $auth->search('inriaLogin=' . $username);
		if ($rdn && count($rdn) == 1) {
			//we check if credentials are valid
			if ($auth->bind($rdn[0], $password)) {
				return true;
			} else {
				throw new LoginException(elgg_echo('LoginException:PasswordFailure'));
			}
		} else {
			throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
		}
	}
	return false;
}

/**
 * Check if LDAP account is closed
 *
 * @param string $username the LDAP login.
  * 
 * @return bool
 * @throws LoginException
 * @access private
 */
function ldap_auth_is_banned($username) {
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ($auth->bind()) {
		$result = $auth->search('inriaLogin=' . $username, array('inriaentrystatus'));
		if ($result && $result[0]['inriaentrystatus'][0] == 'closed') {
			throw new LoginException(elgg_echo('LoginException:LDAP:ClosedUser'));
		} else {
			return false;
		}
	}
	return true;
}

/* Bannit dans ELgg les users bannis du LDAP - Pose la question des accès externes */
function ldap_auth_update_status(ElggUser $user){
	if (ldap_auth_is_banned($user->username)) {
		$user->banned = 'yes';
		return $user->save();
	} else {
		return true;
	}
}


/**
 * Create user by username
 *
 * @param string $username The user's username
 *
 * @return ElggUser|false Depending on success
 */
function ldap_auth_create_profile($username, $password) {
	// Noms d'utilisateurs de moins de 6 caractères : on ajoute un padding de "0"
	$new_username = $username;
	while (strlen($new_username) <= 6) { $new_username .= '0'; }
	//the local password can't be use because ldap auth is call before any other authentifaction method 
	if ($user_guid = register_user($new_username, $password, $username, $username . "@inria.fr")) {
		$user = get_user($user_guid);
		//update profile with ldap infos
		$user->ldap_username = $username;
		ldap_auth_check_profile($user);
		// Success, credentials valid and account has been created
		return $user;
	}
	return null;
}

/**
 * Search for user info in LDAP directories
 * And update Elgg profile
 *
 * @param ElggUser $user The user
 *
 * @return bool Return true on success
 */

function ldap_auth_check_profile(ElggUser $user) {
	if (!$user && $user instanceof ElggUser) return false;
	// require settings.php
	$mail = new LdapServer(ldap_auth_settings_mail());
	$info = new LdapServer(ldap_auth_settings_info());
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ( $info->bind() && $auth->bind() && $mail->bind()){
		$ldap_mail = $mail->search('inriaLogin=' .  $user->username, array('inriaMail'));
			
		if ($ldap_mail && count($ldap_mail) == 1) {
			$ldap_infos = $info->search('mail=' . $ldap_mail[0]['inriaMail'][0], array_keys(ldap_auth_settings_info_fields()));
			if ($ldap_infos && count($ldap_infos) == 1) {
				return ldap_auth_update_profile($user, $ldap_infos, $ldap_mail, ldap_auth_settings_info_fields());
			} else {
				//we use auth as alternative info source 
				$ldap_infos = $auth->search('inriaLogin=' . $user->username, array_keys(ldap_auth_settings_auth_fields()));
				$ldap_infos = ldap_auth_clean_group_name($ldap_infos);
				if ($ldap_infos && count($ldap_infos) == 1) {
					return ldap_auth_update_profile($user, $ldap_infos, $ldap_mail, ldap_auth_settings_auth_fields());
				}
			}
		}
	}
	return false;
}
/**
 * Update Elgg profile
 *
 * @param ElggUser 	$user 		The user to update
 * @param array 	$ldap_infos Search result of the form $ldap_infos
 * @param array 	$ldap_mail 	Search result of the form $ldap_mail[0]['inriaMail'][0]
 * @param array 	$fields		ldap_auth_settings_info_fields() or ldap_auth_settings_auth_fields()
 *
 * @return bool Return true on success
 */
function ldap_auth_update_profile(ElggUser $user, Array $ldap_infos, Array $ldap_mail, Array $fields) {
	if (count($ldap_infos) == 1 && count($ldap_mail) == 1) {
		if ($user->email != $ldap_mail[0]['inriaMail'][0]) {
			$user->email = $ldap_mail[0]['inriaMail'][0];
		}
		foreach ($ldap_infos[0] as $key => $val) {
			if ($key == 'cn') {
				$user->name = $val[0];
			} else {
				if (isset($val[0])) {
					$new = $val[0];
					$current = $user->$fields[$key];
					if ($current != $new) {
						if (!create_metadata($user->getGUID(), $fields[$key], $val[0], 'text', $user->getOwner(), ACCESS_LOGGED_IN)) {
							error_log("ldap_auth_update_profile : failed createmetada guid " . $user->getGUID() . " name " . $fields[$key] . " val " . $val[0]);
						}
					}
				} else {
					error_log("ldap_auth_update_profile : {$user->name} ldap_info {$key} corresponding to {$fields[$key]} is empty ");
				}
			}
		}
	} else {
		return false;
	}
}

/**
 * inriagroupmemberof fields are different in LDAP auth and info directories
 * 
 * @param array $infos Search result to clean
 * @return array $infos Well Formated
 */
function ldap_auth_clean_group_name(array $infos) {
	$res = $infos;
	$cn = explode(',',$infos[0]['inriagroupmemberof'][0],2);
	$group = explode('=',$cn[0]);
	$name = explode('-',$group[1]);
	$res[0]['inriagroupmemberof'][0] = $name[0];
	return $res;
}

