<?php
/**
 * Unbans a user.
 *
 * @package Elgg.Core
 * @subpackage Administration.User
 */

if (elgg_is_admin_logged_in()) {
	$guid = get_input('guid');
	$user = get_entity($guid);
	if (reset_login_failure_count($user->guid)) {
		system_message(elgg_echo('admin:user:unban:yes'));
	} else {
		register_error(elgg_echo('admin:user:unban:no'));
	}
}

forward(REFERER);
