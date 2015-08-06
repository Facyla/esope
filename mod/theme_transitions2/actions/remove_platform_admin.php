<?php
/**
 * Revokes platform admin privileges from a user.
 */

$guid = get_input('guid');
$user = get_entity($guid);

if ($guid == elgg_get_logged_in_user_guid()) {
	register_error(elgg_echo('admin:user:self:removeadmin:no'));
	forward(REFERER);
}

if (($user instanceof ElggUser) && ($user->canEdit())) {
	$user->is_platform_admin = '';
	if (empty($user->is_platform_admin)) {
		system_message(elgg_echo('admin:user:remove_platform_admin:yes'));
	} else {
		register_error(elgg_echo('admin:user:remove_platform_admin:no'));
	}
} else {
	register_error(elgg_echo('admin:user:remove_platform_admin:no'));
}

forward(REFERER);
