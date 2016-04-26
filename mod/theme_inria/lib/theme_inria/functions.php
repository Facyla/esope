<?php
/* Helpers and other Inria specific functions
 * 
 */


// LOGIN / LOGOUT
// @TODO : requires new method to work using Elgg 1.12 API - see login as for possible hints

// These functions are used for temporary changing the current user 
// This lets view one's page as someone else
function theme_inria_temp_login($user) {
	/*
	$_SESSION['user'] = $user;
	$_SESSION['guid'] = $user->guid;
	$_SESSION['id'] = $user->guid;
	$_SESSION['username'] = $user->username;
	$_SESSION['name'] = $user->name;
	$_SESSION['code'] = $user->code;
	$_SESSION['user']->save();
	*/
	$session = elgg_get_session();
	$session->set('user', $user);
	$session->set('guid', $user->guid);
	$session->set('id', $user->id);
	$session->set('username', $user->username);
	$session->set('name', $user->name);
	$session->set('code', $user->code);
	$session->save();
	session_regenerate_id();
	return true;
}
function theme_inria_temp_logout() {
	$session = elgg_get_session();
	$session->set('code', '');
	$session->save();
	$session->remove('user');
	$session->remove('guid');
	$session->remove('id');
	$session->remove('username');
	$session->remove('name');
	$session->remove('code');
	/*
	$_SESSION['user']->code = "";
	$_SESSION['user']->save();
	unset($_SESSION['user']);
	unset($_SESSION['guid']);
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['name']);
	unset($_SESSION['code']);
	*/
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
	} else { return false; }
}



