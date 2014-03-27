<?php
admin_gatekeeper();

// Get variables
$guid = get_input('guid');

$user = get_entity($guid);

// Archive only valid users who don't have a valid LDAP and are not admins
if (elgg_instanceof($user, 'user') && !($user->isAdmin()) && ($user->membertype != 'inria')) {
	$user->memberstatus = 'closed';
	$user->memberreason = 'admin';
	system_message(elgg_echo("theme_inria:archiveuser:ok"));
} else {
	register_error(elgg_echo("theme_inria:archiveuser:error"));
}

forward(REFERER);

