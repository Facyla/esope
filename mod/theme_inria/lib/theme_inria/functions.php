<?php
/* Helpers and other Inria specific functions
 * 
 */


// LOGIN / LOGOUT

// These functions are used for temporary changing the current user 
// This lets view one's page as someone else
function theme_inria_temp_login($user) {
	$_SESSION['user'] = $user;
	$_SESSION['guid'] = $user->guid;
	$_SESSION['id'] = $user->guid;
	$_SESSION['username'] = $user->username;
	$_SESSION['name'] = $user->name;
	$_SESSION['code'] = $user->code;
	$_SESSION['user']->save();
	session_regenerate_id();
	return true;
}
function theme_inria_temp_logout() {
	$_SESSION['user']->code = "";
	$_SESSION['user']->save();
	unset($_SESSION['user']);
	unset($_SESSION['guid']);
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['name']);
	unset($_SESSION['code']);
	session_destroy();
	_elgg_session_boot(NULL, NULL, NULL);
	return true;
}


// LDAP
// Conversion des codes de localisation en un nom compréhensible
function theme_inria_ldap_convert_locality($codes) {
	$result = ldap_get_search_infos('objectClass=locality', ldap_auth_settings_info(), array('*'));
	if ($result) {
		// Create localities map
		foreach($result as $num => $locality) {
			$code = $locality['l'][0];
			$locality_table[$code] = $locality['description'][0];
		}
		// Find human-readable localities
		foreach($codes as $code) { $localities[] = $locality_table[strtoupper($code)]; }
		return $localities;
	} else return false;
}



