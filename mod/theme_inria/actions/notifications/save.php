<?php

/**
 * Elgg notifications
 *
 * @package ElggNotifications
 */

// Iris v2 : force site notifications (setting is not visible)

$current_user = elgg_get_logged_in_user_entity();

$guid = (int) get_input('guid', 0);
if (!$guid || !($user = get_entity($guid))) {
	forward();
}
if (($user->guid != $current_user->guid) && !$current_user->isAdmin()) {
	forward();
}

$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();
$subscriptions = array();
foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
	// Iris v2 : force site notifications - personal
	if ($method == 'site') {
		set_user_notification_setting($user->guid, 'site', true);
	} else {
		$personal[$method] = get_input($method.'personal');
		set_user_notification_setting($user->guid, $method, ($personal[$method] == '1') ? true : false);
	}

	// Iris v2 : force site notifications - per collection
	if ($method == 'site') {
		if ($collections = get_user_access_collections($user->guid)) {
			$collections_ids[] = -1;
			foreach ($collections as $collection) { $collections_ids[] = $collection->id; }
			$user->collections_notifications_preferences_site = $collections_ids;
		}
	} else {
		$collections[$method] = get_input($method.'collections');
		$metaname = 'collections_notifications_preferences_' . $method;
		$user->$metaname = $collections[$method];
	}

	// Iris v2 : force site notifications - per contact/user
	if ($method == 'site') {
		// Get friends and subscriptions
		$friends = $user->getFriends(array('limit' => 0));
		foreach($friends as $friend) { elgg_add_subscription($user->guid, 'site', $friend->guid); }
	} else {
		$subscriptions[$method] = get_input($method.'subscriptions');
		remove_entity_relationships($user->guid, 'notify' . $method, false, 'user');
	}
}

// Add new friends subscription
foreach ($subscriptions as $method => $subscription) {
	if (is_array($subscription) && !empty($subscription)) {
		foreach ($subscription as $subscriptionperson) {
			elgg_add_subscription($user->guid, $method, $subscriptionperson);
		}
	}
}

// Pour les contenus commentés (réglage global)
if (elgg_is_active_plugin('comment_tracker')) {
	$site = elgg_get_site_entity();
	remove_entity_relationship($user->guid, 'block_comment_notifysite', $site->guid);
	set_input('sitecommentsubscriptions', true);
}

system_message(elgg_echo('notifications:subscriptions:success'));

forward(REFERER);

