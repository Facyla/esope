<?php

$action = get_input("do");
$user_guids = get_input("user_guids");

// we need to see all users
access_show_hidden_entities(true);

if (!empty($user_guids)) {
	switch ($action) {
		case "validate":
			// validate all selected users
			foreach ($user_guids as $user_guid) {
				$user = get_user($user_guid);
				if (!empty($user)) {
					// validate user
					$user->admin_validated = true;
					
					// do we also need to enable the user
					if (!$user->isEnabled()) {
						$user->enable();
					}
					
					if ($user->save()) {
						// notify the user about the validation
						uservalidationbyadmin_notify_validate_user($user);
					}
				}
			}
			
			// report success
			system_message(elgg_echo("uservalidationbyadmin:actions:bulk_action:success:validate"));
			break;
		case "delete":
			// delete all selected users
			foreach ($user_guids as $user_guid) {
				$user = get_user($user_guid);
				if (!empty($user)) {
					$user->delete();
				}
			}
			
			system_message(elgg_echo("uservalidationbyadmin:actions:bulk_action:success:delete"));
			break;
		default:
			register_error(elgg_echo("uservalidationbyadmin:actions:bulk_action:error:invalid_action"));
			break;
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);
