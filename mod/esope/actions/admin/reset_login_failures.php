<?php
/**
 * Resets login failures count for a blocked user.
 *
 * @package Elgg.Core
 * @subpackage Administration.User
 */

if (elgg_is_admin_logged_in()) {
	$guid = get_input('guid');
	if (reset_login_failure_count($guid)) {
		system_message(elgg_echo('admin:user:unban:yes'));
	} else {
		register_error(elgg_echo('admin:user:unban:no'));
	}
}

forward(REFERER);
