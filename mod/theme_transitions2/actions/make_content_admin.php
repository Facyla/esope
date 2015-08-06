<?php
/**
 * Grants content admin privileges to a user.
 */

$guid = get_input('guid');
$user = get_entity($guid);

if (($user instanceof ElggUser) && ($user->canEdit())) {
	//if ($user->makeAdmin() && ($user->is_content_admin = 'yes')) {
	if ($user->is_content_admin = 'yes') {
		system_message(elgg_echo('admin:user:make_content_admin:yes'));
	} else {
		register_error(elgg_echo('admin:user:make_content_admin:no'));
	}
} else {
	register_error(elgg_echo('admin:user:make_content_admin:no'));
}

forward(REFERER);
