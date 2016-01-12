<?php

$user_guid = (int) get_input("user_guid");

// we need to see all users
access_show_hidden_entities(true);

if (!empty($user_guid)) {
	$user = get_user($user_guid);
	if (!empty($user)) {
		// we got a user, so validate him/her
		$user->admin_validated = true;
		
		// do we also need to enable the user
		if (!$user->isEnabled()) {
			$user->enable();
		}
		// Remove stored registration IP
		$user->register_ip = null;
		
		if ($user->save()) {
			// notify the user about the validation
			uservalidationbyadmin_notify_validate_user($user);
			
			system_message(elgg_echo("uservalidationbyadmin:actions:validate:success", array($user->name)));
		} else {
			register_error(elgg_echo("uservalidationbyadmin:actions:validate:error:save", array($user->name)));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($user_guid)));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);
