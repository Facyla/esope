<?php
/* Helpers and other Inria specific functions
 * 
 */


// Temporary LOGIN / LOGOUT to enable viewing content as someone else (only a part of a page)
/*
// @TODO : requires new method to work using Elgg 1.12 API - see login as for possible hints

// These functions are used for temporary changing the current user 
// This lets view one's page as someone else
function theme_inria_temp_login($user) {
#	$_SESSION['user'] = $user;
#	$_SESSION['guid'] = $user->guid;
#	$_SESSION['id'] = $user->guid;
#	$_SESSION['username'] = $user->username;
#	$_SESSION['name'] = $user->name;
#	$_SESSION['code'] = $user->code;
#	$_SESSION['user']->save();

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

#	$_SESSION['user']->code = "";
#	$_SESSION['user']->save();
#	unset($_SESSION['user']);
#	unset($_SESSION['guid']);
#	unset($_SESSION['id']);
#	unset($_SESSION['username']);
#	unset($_SESSION['name']);
#	unset($_SESSION['code']);

	session_destroy();
	_elgg_session_boot(NULL, NULL, NULL);
	return true;
}
*/


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


// Détermine le niveau d'accès par défaut dans un groupe
function theme_inria_group_default_access($group) {
	if (!elgg_instanceof($group, 'group')) { return false; }
	
	// Determine default access
	// Define default group content access method
	if ($group->membership == 2) {
		$defaultaccess = elgg_get_plugin_setting('opengroups_defaultaccess', 'esope');
		if (empty($defaultaccess)) { $defaultaccess = 'groupvis'; }
	} else {
		$defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'esope');
		if (empty($defaultaccess)) { $defaultaccess = 'group'; }
	}
	// If access policy says group only, always default to group acl (or whatever esope settings says)
	if ($group->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY) {
		$defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'esope');
		if (empty($defaultaccess)) { $defaultaccess = 'group'; }
	}
	
	return $defaultaccess;
}

// Détermine la valeur du niveau d'accès par défaut dans un groupe
function theme_inria_group_default_access_value($group) {
	if (!elgg_instanceof($group, 'group')) { return false; }
	
	// Determine default access
	$defaultaccess = theme_inria_group_default_access($group);
	switch($defaultaccess) {
		case 'group': $default_access_value = $group->group_acl; break;
		case 'groupvis': $default_access_value = $group->access_id; break;
		case 'members': $default_access_value = 1; break;
		case 'public': $default_access_value = 2; break;
		case 'default':
			// Do not set (let original check do it) $vars['value'] = get_default_access();
			break;
		default: $default_access_value = $group->group_acl;
	}
	return $default_access_value;
}



