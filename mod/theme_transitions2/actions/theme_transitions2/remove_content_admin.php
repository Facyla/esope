<?php
/**
 * Revokes content admin privileges from a user.
 */

$guid = get_input('guid');
$user = get_entity($guid);

if ($guid == elgg_get_logged_in_user_guid()) {
	register_error(elgg_echo('admin:user:self:removeadmin:no'));
	forward(REFERER);
}

if (elgg_instanceof($user, 'user') && theme_transitions2_user_is_platform_admin()) {
	$user->is_content_admin = '';
	if (empty($user->is_content_admin)) {
		system_message(elgg_echo('admin:user:remove_content_admin:yes'));
	} else {
		register_error(elgg_echo('admin:user:remove_content_admin:no'));
	}
} else {
	register_error(elgg_echo('admin:user:remove_content_admin:no'));
}

forward(REFERER);
