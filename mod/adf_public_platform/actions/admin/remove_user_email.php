<?php
// Restrict action to admins
admin_gatekeeper();

// Get variables
$guid = get_input('guid');

$user = get_entity($guid);

// Remove emails only for other non-admin users
// so we don't end up with no email to reset password for key users
if (elgg_instanceof($user, 'user') && !($user->isAdmin()) && ($user->guid != elgg_get_logged_in_user_guid())) {
	$user->email = '';
	$user->save();
	system_message(elgg_echo("esope:user:removeemail:ok"));
} else {
	register_error(elgg_echo("esope:user:removeemail:error"));
}

forward(REFERER);

