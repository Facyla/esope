<?php
/**
 * Grants platform admin privileges to a user.
 */

$guid = get_input('guid');
$user = get_entity($guid);

if (elgg_instanceof($user, 'user') && elgg_is_admin_logged_in()) {
	if ($user->is_platform_admin = 'yes') {
		system_message(elgg_echo('admin:user:make_platform_admin:yes'));
	} else {
		register_error(elgg_echo('admin:user:make_platform_admin:no'));
	}
} else {
	register_error(elgg_echo('admin:user:make_platform_admin:no'));
}

forward(REFERER);
