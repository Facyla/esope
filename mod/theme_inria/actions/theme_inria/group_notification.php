<?php

/**
 * Elgg notifications group save
 *
 * @package ElggNotifications
 */

$current_user = elgg_get_logged_in_user_entity();

$guid = (int) get_input('guid', 0);
$group_guid = (int) get_input('group_guid', 0);
if (!$guid || !($user = get_entity($guid))) {
	forward();
}
if (!$group_guid || !($group = get_entity($group_guid)) || !elgg_instanceof($group, 'group')) {
	forward();
}
if (($user->guid != $current_user->guid) && !$current_user->isAdmin()) {
	forward();
}



$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();
foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
	$subscription = (bool) get_input($method, false);
	if ($subscription) {
		elgg_add_subscription($user->guid, $method, $group->guid);
	} else {
		elgg_remove_subscription($user->guid, $method, $group->guid);
	}
}


system_message(elgg_echo('notifications:subscriptions:success'));

forward(REFERER);
