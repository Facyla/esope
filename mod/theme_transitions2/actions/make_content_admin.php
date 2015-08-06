<?php
/**
 * Grants content admin privileges to a user.
 */

$guid = get_input('guid');
$user = get_entity($guid);

if (elgg_instanceof($user, 'user') && theme_transitions2_user_is_platform_admin()) {
	if ($user->is_content_admin = 'yes') {
		system_message(elgg_echo('admin:user:make_content_admin:yes'));
	} else {
		register_error(elgg_echo('admin:user:make_content_admin:no'));
	}
} else {
	register_error(elgg_echo('admin:user:make_content_admin:no'));
}

forward(REFERER);
