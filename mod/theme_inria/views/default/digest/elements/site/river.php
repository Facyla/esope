<?php
/**
 * Shows the social activity of your friends in the Digest
 * 
 */

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

// Only for subtype filtering
$subtype_id = get_subtype_id('object', 'thewire');
$dbprefix = get_config("dbprefix");

$river_options = array(
	"relationship" => "friend",
	"relationship_guid" => $user->getGUID(),
	"limit" => 5,
	"posted_time_lower" => $ts_lower,
	"posted_time_upper" => $ts_upper,
	"pagination" => false,
	// This is for subtype filtering only, can be removed if no filtering
	"joins" => array("INNER JOIN " . $dbprefix . "entities AS e ON rv.object_guid = e.guid"),
	"wheres" => array("e.subtype != " . $subtype_id), // filter some subtypes
);

// Render river results
if ($river_items = elgg_list_river($river_options)) {
	$title = elgg_view("output/url", array("text" => elgg_echo("theme_inria:digest:friends"), "href" => "activity/friends/" . $user->username));
	
	echo elgg_view_module("digest", $title, $river_items);
}

