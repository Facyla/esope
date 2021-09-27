<?php
/**
 * Shows the activity of your friends in the Digest
 *
 */

$user = elgg_extract('user', $vars, elgg_get_logged_in_user_entity());
$ts_lower = (int) elgg_extract('ts_lower', $vars);
$ts_upper = (int) elgg_extract('ts_upper', $vars);
$subtypes = (array) elgg_extract("subtypes", $vars, false);

$river_options = array(
	'relationship' => "friend",
	'relationship_guid' => $user->getGUID(),
	'limit' => 6,
	'posted_time_lower' => $ts_lower,
	'posted_time_upper' => $ts_upper,
	'pagination' => false,
	'types' => ['group', 'user'],
);

// This is for subtype filtering only, useless if no filtering
if ($subtypes) {
	$subtype_ids = array();
	$dbprefix = elgg_get_config("dbprefix");
	/*
	foreach ($subtypes as $subtype) {
		$subtype_ids[] = get_subtype_id('object', $subtype);
	}
	$subtype_ids = implode(',', $subtype_ids);
	*/
	//$river_options['joins'] = array("INNER JOIN " . $dbprefix . "entities AS e ON rv.object_guid = e.guid");
	// Exclude some subtypes
	$river_options['wheres'] = array("subtype != 'thewire'"); // @todo rewrite for 3.3+
}


// Render river results, if any
$river_items = elgg_list_river($river_options);
if (!empty($river_items)) {
	$title = elgg_view('output/url', array(
		'text' => elgg_echo('river:friends'),
		'href' => 'activity/friends/' . $user->username,
		'is_trusted' => true
	));

	echo elgg_view_module('digest', $title, $river_items);
}
