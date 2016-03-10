<?php
/**
 * Shows the activity of your friends in the Digest
 *
 */

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);
$subtypes = (array) elgg_extract("subtypes", $vars, false);

// Only for subtype filtering
if ($subtypes) {
	$subtype_id = get_subtype_id('object', 'thewire');
	$dbprefix = elgg_get_config("dbprefix");
}

$river_options = array(
	"relationship" => "friend",
	"relationship_guid" => $user->getGUID(),
	"limit" => 6,
	"posted_time_lower" => $ts_lower,
	"posted_time_upper" => $ts_upper,
	"pagination" => false,
	'types' => array('group', 'user'),
);

// This is for subtype filtering only, useless if no filtering
if ($subtypes) {
	$river_options['joins'] = array("INNER JOIN " . $dbprefix . "entities AS e ON rv.object_guid = e.guid");
	$river_options['wheres'] = array("e.subtype != " . $subtype_id); // filter some subtypes
}


// Render river results, if any
$river_items = elgg_list_river($river_options);
if (!empty($river_items)) {
	$title = elgg_view("output/url", array(
		"text" => elgg_echo("river:friends"),
		"href" => "activity/friends/" . $user->username,
		"is_trusted" => true,
	));

	echo elgg_view_module("digest", $title, $river_items);
}
