<?php
/**
 * Elgg log browser admin page
 * ESOPE : add more filtering options
 *
 * @note The ElggObject this creates for each entry is temporary
 * 
 * @package ElggLogBrowser
 */

$limit = get_input('limit', 100);
$offset = get_input('offset');

$search_username = get_input('search_username');
if ($search_username) {
	$user = get_user_by_username($search_username);
	if ($user) {
		$user_guid = $user->guid;
	} else {
		$user_guid = null;
	}
} else {
	$user_guid = get_input('user_guid', null);
	if ($user_guid) {
		$user_guid = (int) $user_guid;
		$user = get_entity($user_guid);
		if ($user) {
			$search_username = $user->username;
		}
	} else {
		$user_guid = null;
	}
}

$timelower = get_input('timelower');
if ($timelower) {
	$timelower = strtotime($timelower);
}

$timeupper = get_input('timeupper');
if ($timeupper) {
	$timeupper = strtotime($timeupper);
}

$ip_address = get_input('ip_address');

// ESOPE additions
$entity_type = get_input('entity_type', '');
$entity_subtype = get_input('entity_subtype', '');
$object_guid = get_input('object_guid', 0);
$event = get_input('event', '');


// Search form
$refine = elgg_view('logbrowser/refine', array(
	'timeupper' => $timeupper,
	'timelower' => $timelower,
	'ip_address' => $ip_address,
	'username' => $search_username,
	'user_guid' => $user_guid,
	'entity_type' => $entity_type,
	'entity_subtype' => $entity_subtype,
	'object_guid' => $object_guid,
	'event' => $event,
));


// Get log entries
// get_system_log($by_user = "", $event = "", $class = "", $type = "", $subtype = "", $limit = null, $offset = 0, $count = false, $timebefore = 0, $timeafter = 0, $object_id = 0, $ip_address = "")
/*
$log = get_system_log($user_guid, "", "", "","", $limit, $offset, false, $timeupper, $timelower, 0, $ip_address);
$count = get_system_log($user_guid, "", "", "","", $limit, $offset, true, $timeupper, $timelower, 0, $ip_address);
*/
$log = get_system_log($user_guid, $event, "", $entity_type, $entity_subtype, $limit, $offset, false, $timeupper, $timelower, $object_guid, $ip_address);
$count = get_system_log($user_guid, $event, "", $entity_type, $entity_subtype, $limit, $offset, true, $timeupper, $timelower, $object_guid, $ip_address);

// if user does not exist, we have no results
if ($search_username && is_null($user_guid)) {
	$log = false;
	$count = 0;
}

$table = elgg_view('logbrowser/table', array('log_entries' => $log));

$nav = elgg_view('navigation/pagination',array(
	'offset' => $offset,
	'count' => $count,
	'limit' => $limit,
));

// display admin body
$body = <<<__HTML
$refine
$nav
$table
$nav
__HTML;

echo $body;

