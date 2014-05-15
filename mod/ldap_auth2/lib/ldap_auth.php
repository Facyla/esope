<?php
if (!include_once dirname(dirname(__FILE__)) . '/settings.php') {
	register_error(elgg_echo('ldap_auth:missingsettings'));
}

/**
 * ldap_auth helper functions
 *
 * @package Elgg.ldap_auth
 */

/**
 * Login process using LDAP
 *
 * @param string $username the LDAP login.
 * @param string $password the coresponding LDAP password.
 * 
 * @return bool
 * @throws LoginException
 * @access private
 */
/** Note : normalement les caractères spéciaux sont bien traités par cette fonction
 * Pour afficher le mot de passe en clair, utiliser htmlentities($password, ENT_QUOTES,'UTF-8');
 * Eviter d'utiliser stripslashes (supprime les antislashs si ceux-ci sont utilisés)
*/
function ldap_auth_login($username, $password) {
	if ( !ldap_auth_is_closed($username) ) {
		if (ldap_auth_is_valid($username, $password)) {
			if ($user = get_user_by_username($username)) {
				ldap_auth_check_profile($user);
				return login($user);
			}
			if ($user = ldap_auth_create_profile($username, $password)) {
				return login($user);
			}
		}
	}
	// Return nothing means handler wants to be skipped
}

/**
 * Check if LDAP account exists
 *
 * @param string $username the LDAP login.
 * 
 * @return bool
 * @throws LoginException
 * @access private
 */
function ldap_user_exists($username) {
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$status_field_name = elgg_get_plugin_setting('status_field_name', 'ldap_auth', 'inriaentrystatus');
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ($auth->bind()) {
		$result = $auth->search("$username_field_name=$username", array($status_field_name));
		//$result = $auth->search("$username_field_name=$username", array($username_field_name)); // No need to check any other field than username..
		if ($result) { return true; }
	}
	// Error or not found : same as doesn't exist
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
function ldap_auth_is_closed($username) {
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$status_field_name = elgg_get_plugin_setting('status_field_name', 'ldap_auth', 'inriaentrystatus');
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ($auth->bind()) {
		$result = $auth->search("$username_field_name=$username", array($status_field_name));
		if ($result && $result[0][$status_field_name][0] == 'closed') {
			return true;
			// No need to throw exception on a simple test - we need it for other tests
			//throw new LoginException(elgg_echo('LoginException:LDAP:ClosedUser'));
		} else {
			return false;
		}
	}
	// Error or not found : same as closed (not a valid ldap login)
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
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	if ($auth->bind()) {
		//we need the rdn to perform a bind with password
		$rdn = $auth->search("$username_field_name=$username");
		if ($rdn && count($rdn) == 1) {
			//we check if credentials are valid
			if ($auth->bind($rdn[0], $password)) {
				return true;
			} else {
				return false;
				//throw new LoginException(elgg_echo('LoginException:PasswordFailure'));
			}
		} else {
			return false;
			//throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
		}
	}
	return false;
}


/**
 * Create user by username
 *
 * @param string $username The user's username
 *
 * @return ElggUser|false Depending on success
 */
function ldap_auth_create_profile($username, $password) {
	$generic_register_email = elgg_get_plugin_setting('generic_register_email', 'ldap_auth', "noreply@inria.fr");
	$new_username = $username;
	/* Noms d'utilisateurs de moins de 6 caractères : on ajoute un padding de "0"
	 * Only use this if Elgg needs username >= 4 chars, but you'd better add in engine/settings.php file:
	 * $CONFIG->minusername = 4;
	*/
	//while (strlen($new_username) < 4) { $new_username .= '0'; }
	
	// Note : local password can't be used because ldap_auth is called before other authentication methods
	//if ($user_guid = register_user($new_username, $password, $username, $username . "@inria.fr")) {
	// Email : we use a noreply email until it is updated by LDAP
	// @TODO : get LDAP email / name first, then check for existing account, and optionnaly update
	if ($user_guid = register_user($new_username, $password, $username, $generic_register_email, true)) {
		$user = get_user($user_guid);
		//update profile with ldap infos
		$user->ldap_username = $username;
		if (!ldap_auth_check_profile($user)) {
			error_log("LDAP_auth : cannot update profile $user_guid on registration");
		}
		// Success, credentials valid and account has been created
		return $user;
	} else {
		error_log("LDAP_auth : cannot automatically create user $username");
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
// @TODO : add a hook to let plugin write their own methods
function ldap_auth_check_profile(ElggUser $user) {
	
	// Hook : return anything but "continue" will stop and return hook result
	$hook_result = elgg_trigger_plugin_hook("ldap_auth:check_profile", "user", array("user" => $user), "continue");
	if ($hook_result != 'continue') return $hook_result;
	
	$mail_field_name = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'inriaMail');
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	if (!$user && $user instanceof ElggUser) return false;
	// require settings.php
	$mail = new LdapServer(ldap_auth_settings_mail());
	$info = new LdapServer(ldap_auth_settings_info());
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ( $info->bind() && $auth->bind() && $mail->bind()) {
		$ldap_mail = $mail->search("$username_field_name={$user->username}", array($mail_field_name));
		$user_mail = $ldap_mail[0][$mail_field_name][0];
		$user_uid = $ldap_mail[0]['uid'][0];
		// There should be only 1 email <=> 1 username, but don't update in doubt
		if ($ldap_mail && count($ldap_mail) == 1) {
			$ldap_infos = $info->search("$mail_field_name=$user_mail", array_keys(ldap_auth_settings_info_fields()));
			// Note : if we have more than 1 result, it means the info has been updated ! so keep the latest result
			if ($ldap_infos && count($ldap_infos) > 1) { $ldap_infos = array(end($ldap_infos)); }
			if ($ldap_infos && count($ldap_infos) == 1) {
				return ldap_auth_update_profile($user, $ldap_infos, $ldap_mail, ldap_auth_settings_info_fields());
			} else {
				//we still can use auth as alternative info source - less infos
				$ldap_infos = $auth->search("$username_field_name={$user->username}", array_keys(ldap_auth_settings_auth_fields()));
				$ldap_infos = ldap_auth_clean_group_name($ldap_infos);
				if ($ldap_infos && count($ldap_infos) == 1) {
					return ldap_auth_update_profile($user, $ldap_infos, $ldap_mail, ldap_auth_settings_auth_fields());
				}
			}
		}
	} else {
		error_log("LDAP_auth : cannot bind to LDAP server");
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
// @TODO : add a hook to let plugin write their own methods
function ldap_auth_update_profile(ElggUser $user, Array $ldap_infos, Array $ldap_mail, Array $fields) {
	
	// Hook : return anything but "continue" will stop and return hook result
	$hook_result = elgg_trigger_plugin_hook("ldap_auth:update_profile", "user", array("user" => $user, 'infos' => $ldap_infos, 'mail' => $ldap_mail, 'fields' => $fields), "continue");
	if ($hook_result != 'continue') return $hook_result;
	
	$mail_field_name = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'inriaMail');
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$mainpropchange = false;
	if (count($ldap_infos) == 1 && count($ldap_mail) == 1) {
		if ($user->email != $ldap_mail[0][$mail_field_name][0]) {
			$user->email = $ldap_mail[0][$mail_field_name][0];
			$mainpropchange = true;
		}
		foreach ($ldap_infos[0] as $key => $val) {
			if ($key == 'cn') {
				$fullname = $val[0];
			} else if ($key == 'sn') {
				$lastname = $val[0];
			} else if ($key == 'givenName') {
				$firstname = $val[0];
			} else {
				// No value is also a valid value (updated in LDAP to empty)
				//if (isset($val[0])) {
					$new = $val[0];
					$current = $user->$fields[$key];
					if ($current != $new) {
						if (!create_metadata($user->getGUID(), $fields[$key], $new, 'text', $user->getOwner(), ACCESS_LOGGED_IN)) {
							error_log("ldap_auth_update_profile : failed create_metadata for guid " . $user->getGUID() . " name=" . $fields[$key] . " val: " . $val[0]);
						}
					}
				/*
				} else {
					error_log("ldap_auth_update_profile : {$user->name} ldap_info {$key} corresponding to {$fields[$key]} is empty ");
				}
				*/
			}
			
			// Update name if asked, or empty name, or name is username (which means it was just created)
			$updatename = elgg_get_plugin_setting('updatename', 'ldap_auth', false);
			if (($updatename == 'yes') || empty($user->name) || ($user->name == $user->username)) {
				$mainpropchange = true;
				// MAJ du nom : NOM Prénom, ssi on dispose des 2 infos
				if (!empty($firstname) && !empty($lastname)) {
					$user->name = strtoupper($lastname) . ' ' . esope_uppercase_name($firstname);
				} else if (!empty($fullname)) {
					$user->name = $fullname;
				}
			}
		}
		if ($mainpropchange) $user->save();
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
// @TODO : add a hook to let plugin write their own methods
function ldap_auth_clean_group_name(array $infos) {
	
	// Hook : return anything but "continue" will stop and return hook result
	$hook_result = elgg_trigger_plugin_hook("ldap_auth:clean_group_name", "user", array("infos" => $infos), "continue");
	if ($hook_result != 'continue') return $hook_result;
	
	$res = $infos;
	$cn = explode(',',$infos[0]['inriagroupmemberof'][0],2);
	$group = explode('=',$cn[0]);
	$name = explode('-',$group[1]);
	$res[0]['inriagroupmemberof'][0] = $name[0];
	return $res;
}

