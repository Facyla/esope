<?php
/**
 * Elgg log browser admin page
 */

use Elgg\SystemLog\SystemLog;

$limit = get_input('limit', 20);
$offset = get_input('offset');

$search_username = (string) get_input('search_username');
if (!empty($search_username)) {
	$user_guid = elgg_get_user_by_username($search_username)?->guid;
} else {
	$user_guid = get_input('user_guid');
	if ($user_guid) {
		$user_guid = (int) $user_guid;
		$search_username = get_user($user_guid)?->username;
	} else {
		$user_guid = null;
	}
}

$timelower = (string) get_input('timelower');
if ($timelower) {
	$timelower = strtotime($timelower);
}

$timeupper = (string) get_input('timeupper');
if ($timeupper) {
	$timeupper = strtotime($timeupper);
}

$ip_address = get_input('ip_address');
$object_id = get_input('object_id');
$event = get_input('event');

$refine = elgg_view('logbrowser/refine', [
	'timeupper' => $timeupper,
	'timelower' => $timelower,
	'ip_address' => $ip_address,
	'username' => $search_username,
	'object_id' => $object_id,
	'event' => $event,
]);

// Get log entries
$options = [
	'performed_by_guid' => $user_guid,
	'limit' => $limit,
	'offset' => $offset,
	'count' => false,
	'created_before' => $timeupper,
	'created_after' => $timelower,
	'ip_address' => $ip_address,
	'object_id' => $object_id,
	'event' => $event,
];
$log = SystemLog::instance()->getAll($options);

$options['count'] = true;
$count = SystemLog::instance()->getAll($options);

// if user does not exist, we have no results
if ($search_username && is_null($user_guid)) {
	$log = false;
	$count = 0;
}

$table = elgg_view('logbrowser/table', ['log_entries' => $log]);

$nav = elgg_view('navigation/pagination', [
	'offset' => $offset,
	'count' => $count,
	'limit' => $limit,
]);

// display admin body
echo $refine . $nav . $table . $nav;
