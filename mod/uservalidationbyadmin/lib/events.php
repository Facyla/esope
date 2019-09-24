<?php
/**
 * All event handlers are bundled here
 */

/**
 * Listen to the login event to make sure the user is validated
 *
 * @param string   $event the name of the event
 * @param string   $type  the type of the event
 * @param ElggUser $user  supplied user
 *
 * @return bool
 */
function uservalidationbyadmin_login_event($event, $type, $user) {
	$result = false;
	
	// make sure we can see all users
	$hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	
	// do we actualy have a user
	if (!empty($user) && elgg_instanceof($user, "user")) {
		// is the user enabled
		if ($user->isEnabled()) {
			if ($user->isAdmin()) {
				// admins are always allowed
				$result = true;
			} elseif (isset($user->admin_validated)) {
				// check if the user is validated
				if ($user->admin_validated) {
					// user is validated and can login
					$result = true;
				}
			} else {
				// user has register before this plugin was activated
				$result = true;
			}
		}
	}
	
	// check if the user can login
	if (empty($result)) {
		// register error
		register_error(elgg_echo("uservalidationbyadmin:login:error"));
	}
	
	// restore access setting
	access_show_hidden_entities($hidden);
	
	return $result;
}
