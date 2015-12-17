<?php
	
$user_guid = (int) get_input("user_guid");

// we need to see all users
access_show_hidden_entities(true);

if (!empty($user_guid)) {
	$user = get_user($user_guid);
	if (!empty($user)) {
		if ($user->delete()) {
			system_message(elgg_echo("admin:user:delete:yes", array($user->name)));
		} else {
			register_error(elgg_echo("admin:user:delete:no"));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($user_guid)));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);