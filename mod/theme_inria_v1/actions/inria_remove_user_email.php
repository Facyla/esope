<?php
admin_gatekeeper();

// Get variables
$guid = get_input('guid');

$user = get_entity($guid);

// Archive only valid users who don't have a valid LDAP and are not admins
if (elgg_instanceof($user, 'user') && !($user->isAdmin()) && ($user->membertype != 'inria')) {
	$user->email = '';
	$user->save();
	system_message(elgg_echo("theme_inria:removeemail:ok"));
} else {
	register_error(elgg_echo("theme_inria:removeemail:error"));
}

forward(REFERER);

