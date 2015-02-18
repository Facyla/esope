<?php
/**
 * Elgg LDAP lib
 * @filesource lib/ldap_auth.php
 * @package Elgg.ldap_auth
 * @author Simon Bouland <simon.bouland@inria.fr>
 * @author Florian DANIEL <facyla@gmail.com>
 */

if (!include_once dirname(dirname(__FILE__)) . '/settings.php') {
	register_error(elgg_echo('ldap_auth:missingsettings'));
}

/* TODO
 * - make the plugin more generic (hooks + settings)
 * - add generic helper fonctions
 */

/**
 * ldap_auth helper functions
 *
 * @package Elgg.ldap_auth
 */


/** Login process using LDAP
 *
 * @param string $username the LDAP login.
 * @param string $password the coresponding LDAP password.
 * 
 * @return valid user/false
 * @throws LoginException
 * @access private
 */
/** Note : normalement les caractères spéciaux sont bien traités par cette fonction
 * Pour afficher le mot de passe en clair, utiliser htmlentities($password, ENT_QUOTES,'UTF-8');
 * Eviter d'utiliser stripslashes (supprime les antislashs si ceux-ci sont utilisés)
*/
function ldap_auth_login($username, $password) {
	$updateprofile = elgg_get_plugin_setting('updateprofile', 'ldap_auth');
	$allow_registration = elgg_get_plugin_setting('allow_registration', 'ldap_auth');
	
	// User can be logged in or created only if not closed
	if (ldap_auth_is_active($username)) {
		// Check valid LDAP login (username/pass)
		if (ldap_auth_is_valid($username, $password)) {
			if ($user = get_user_by_username($username)) {
				// Optionally update profile
				if ($updateprofile == 'yes') { ldap_auth_check_profile($user); }
				return login($user);
			}
			// Optionally create profile if one found (but valid LDAP)
			if ($allow_registration == 'yes') {
				if ($user = ldap_auth_create_profile($username, $password)) { return login($user); }
			}
		}
	}
	// Return nothing means we skip this handler (non-blocking)
}


/** Check if LDAP account exists
 *
 * @param string $username the LDAP login.
 * 
 * @return bool false / array RDN
 * @throws LoginException
 * @access private
 */
function ldap_user_exists($username) {
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth');
	$result = ldap_get_search_infos("$username_field_name=$username", ldap_auth_settings_auth(), array($username_field_name));
	if ($result) { return true; }
	// Error or not found : same as doesn't exist
	return false;
}


/* Return user email from username */
function ldap_get_email($username) {
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth');
	$mail_field_name = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'mail');
	// Check LDAP server data
	$result = ldap_get_search_infos("$username_field_name=$username", ldap_auth_settings_auth(), array($mail_field_name));
	if ($result) { return $result[0][$mail_field_name][0]; }
	// Error or not found : same as doesn't exist
	return false;
}


/* Return user data from ldap search, using data caching
 * $criteria : field=value or other valid ldap search cirteria
 * $ldap_server : LdapServer settings
 * $attributes : list of attributes to be returned
 */
function ldap_get_search_infos($criteria, $ldap_server, $attributes) {
	global $ldap_auth_search_data;
	
	// Use caching
	$data_key = implode(';', $criteria) . "+" . implode(';', $ldap_server) . "+" . implode(';', $attributes);
	$data_key = md5($data_key);
	if (isset($ldap_auth_search_data[$data_key])) {
		//error_log("LDAP : using cache $data_key = " . $ldap_auth_search_data[$data_key]);
		return $ldap_auth_search_data[$data_key];
	}
	
	// Check LDAP server data
	$ldap = new LdapServer($ldap_server);
	if ($ldap->bind()) {
		$results = $ldap->search($criteria, $attributes);
		if ($results) {
			// Cache results
			$ldap_auth_search_data[$data_key] = $results;
			return $results;
		}
	}
	// Error or not found
	return false;
}


/** Check if LDAP account exists and is not closed
 *
 * @param string $username the LDAP login.
 * 
 * @return bool
 * @throws LoginException
 * @access private
 */
function ldap_auth_is_active($username) {
	$status_field_name = elgg_get_plugin_setting('status_field_name', 'ldap_auth', 'inriaEntryStatus');
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	
	// No status field set means any account is considered as active
	if (empty($status_field_name)) { return true; }
	
	// Check status for user
	$result = ldap_get_search_infos("$username_field_name=$username", ldap_auth_settings_auth(), array($status_field_name));
	if ($result) {
		$status = $result[0][$status_field_name][0];
		// Not closed <=> active
		if ($status != 'closed') { return true; }
	}
	// Error or not found => not a valid ldap login (same as closed)
	return false;
}


/** Check if LDAP credentials are valid
 *
 * @param string $username the LDAP login.
 * @param string $password the coresponding LDAP password.
 *
 * @return bool Return true on success, false on invalid credentials
 * @throws LoginException
 * @access private
 */
function ldap_auth_is_valid($username, $password) {
	// Search for rdn - we need to bind anonymously to do search for rdn
	// Le RDN de toto est rdn:uid=toto, son DN est dn:uid=toto,ou=people,dc=example,dc=org.
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	
	$result = ldap_get_search_infos("$username_field_name=$username", ldap_auth_settings_auth(), array());
	if ($result && count($result) == 1) {
		// Check if credentials are valid
		$auth = new LdapServer(ldap_auth_settings_auth());
		if ($auth->bind($result[0], $password)) { return true; }
		//throw new LoginException(elgg_echo('LoginException:PasswordFailure'));
	}
	//throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
	
	/*
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ($auth->bind()) {
		// We need the rdn to perform a bind with password
		$result = $auth->search("$username_field_name=$username");
		if ($result && count($result) == 1) {
			// Check if credentials are valid
			if ($auth->bind($result[0], $password)) { return true; }
			//throw new LoginException(elgg_echo('LoginException:PasswordFailure'));
		}
		//throw new LoginException(elgg_echo('LoginException:UsernameFailure'));
	}
	*/
	return false;
}


/** Create user by username - requires active LDAP access
 *
 * @param string $username The user's username
 *
 * @return ElggUser|false Depending on success
 */
function ldap_auth_create_profile($username, $password) {
	global $CONFIG;
	// Registration is allowed only if set in plugin
	$allow_registration = elgg_get_plugin_setting('allow_registration', 'ldap_auth', true);
	if ($allow_registration != 'no') {
		$register_email = elgg_get_plugin_setting('generic_register_email', 'ldap_auth', "noreply@inria.fr");
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
		$user_email = ldap_get_email($username);
		if (is_email_address($user_email)) {
			$existing_user = get_user_by_email($user_email);
			if ($existing_user) {
				register_error("User(s) already exist, registered with your email $user_email : please contact site administrator at {$CONFIG->site->email} so your site login matches LDAP login");
				return false;
			} else {
				$register_email = $user_email;
			}
		}
		
		if ($user_guid = register_user($new_username, $password, $username, $register_email, true)) {
			$user = get_user($user_guid);
			login($user);
			//update profile with ldap infos
			$user->ldap_username = $username;
			if (!ldap_auth_check_profile($user)) {
				error_log("LDAP_auth : cannot update profile $user_guid on registration");
			}
			// Success, credentials valid and account has been created
			return $user;
		} else {
			error_log("LDAP_auth : cannot automatically create user $new_username");
		}
	}
	return false;
}


/** Search for user info in LDAP directories and update Elgg profile
 *
 * @param ElggUser $user The user
 *
 * @return bool Return true on success
 */
function ldap_auth_check_profile(ElggUser $user) {
	if (!$user || !elgg_instanceof($user, 'user')) { return false; }
	
	// Hook : return "keepgoing" to skip hook result
	$hook_result = elgg_trigger_plugin_hook("check_profile", "ldap_auth", array("user" => $user), "keepgoing");
	if ($hook_result !== "keepgoing") return $hook_result;
	
	$mail_field_name = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'mail');
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$user_mail = ldap_get_email($user->username);
	
	// Check user exists in auth branch (always required)
	$auth_result = ldap_get_search_infos("$username_field_name={$user->username}", ldap_auth_settings_auth(), array_keys(ldap_auth_settings_auth_fields()));
	if (!$auth_result) {
		error_log("LDAP_auth : cannot bind to LDAP auth server on $username_field_name={$user->username}");
		return false;
	}
	// Check we have a single result
	if (count($auth_result) > 1) {
		//$auth_result = array(end($auth_result));
		error_log("LDAP_auth : username matches multiple users, so cannot update user data");
		return false;
	}
	
	// Use info branch first (optional branch, but useful)
	// Fallback on auth only
	$ldap_infos = ldap_get_search_infos("$mail_field_name=$user_mail", ldap_auth_settings_info(), array_keys(ldap_auth_settings_info_fields()));
	if ($ldap_infos) {
		// Note : more than 1 result usually means info has been updated ! so keep the latest only
		if (count($ldap_infos) > 1) { $ldap_infos = array(end($ldap_infos)); }
		return ldap_auth_update_profile($user, $auth_result, $ldap_infos, ldap_auth_settings_info_fields());
	} else {
		// Fallback branch : use only auth (source + fields)
		$auth_result = ldap_auth_clean_group_name($auth_result);
		if (count($auth_result) > 1) { $auth_result = array(end($auth_result)); }
		return ldap_auth_update_profile($user, $auth_result, $auth_result, ldap_auth_settings_auth_fields());
	}
	// Could not update data
	return false;
}


/** Update Elgg profile based on information from LDAP
 *
 * @param ElggUser 	$user 		The user to update
 * @param array 	$ldap_infos Search result from $ldap_infos
 * @param array 	$ldap_auth 	Search result from $ldap_auth (used only for user email)
 * @param array 	$fields		mapping fields = ldap_auth_settings_info_fields() or ldap_auth_settings_auth_fields()
 *
 * @return bool Return true on success
 */
function ldap_auth_update_profile(ElggUser $user, Array $ldap_auth, Array $ldap_infos, Array $fields) {
	// Hook : return keepgoing" to skip hook result
	$hook_result = elgg_trigger_plugin_hook("update_profile", "ldap_auth", array("user" => $user, 'infos' => $ldap_infos, 'auth' => $ldap_auth, 'fields' => $fields), "keepgoing");
	if ($hook_result !== "keepgoing") return $hook_result;
	
	$mail_field_name = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'mail');
	$username_field_name = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$updatename = elgg_get_plugin_setting('updatename', 'ldap_auth', false);
	$mainpropchange = false;
	
	if (count($ldap_infos) == 1 && count($ldap_auth) == 1) {
		// Update email - requires saving entity
		if ($user->email != $ldap_auth[0][$mail_field_name][0]) {
			$user->email = $ldap_auth[0][$mail_field_name][0];
			$mainpropchange = true;
		}
		// Process other fields
		// Process fields defined in settings
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
						if (!create_metadata($user->guid, $fields[$key], $new, 'text', $user->getOwner(), ACCESS_LOGGED_IN)) {
							error_log("ldap_auth_update_profile : failed create_metadata for guid " . $user->getGUID() . " name=" . $fields[$key] . " val: " . $val[0]);
						}
					}
				/*
				} else {
					error_log("ldap_auth_update_profile : {$user->name} ldap_info {$key} corresponding to {$fields[$key]} is empty ");
				}
				*/
			}
			
			// Update name if asked, but also if empty name, or if name is username (which means account was just created)
			if (($updatename == 'yes') || empty($user->name) || ($user->name == $user->username)) {
				// MAJ du nom : NOM Prénom, ssi on dispose des 2 infos
				if (!empty($firstname) && !empty($lastname)) {
					if (function_exists('esope_uppercase_name')) {
						$user->name = strtoupper($lastname) . ' ' . esope_uppercase_name($firstname);
					} else {
						$user->name = strtoupper($lastname) . ' ' . $firstname;
					}
					$mainpropchange = true;
				} else if (!empty($fullname)) {
					$user->name = $fullname;
					$mainpropchange = true;
				}
			}
			
		}
		
		// Save entity if email and/or name have been updated
		if ($mainpropchange) $user->save();
		return true;
	}
	return false;
}


/** Return group names from LDAP
 * inriagroupmemberof fields are different in LDAP auth and info directories
 * 
 * @param array $infos Search result to clean
 * @return array $infos Well Formated
 */
function ldap_auth_clean_group_name(array $infos) {
	// Hook : return anything, except "keepgoing" which will stop hook
	$hook_result = elgg_trigger_plugin_hook("clean_group_name", "ldap_auth", array("infos" => $infos), "keepgoing");
	if ($hook_result !== "keepgoing") return $hook_result;
	
	$res = $infos;
	$cn = explode(',',$infos[0]['inriagroupmemberof'][0],2);
	$group = explode('=',$cn[0]);
	$name = explode('-',$group[1]);
	$res[0]['inriagroupmemberof'][0] = $name[0];
	return $res;
}


