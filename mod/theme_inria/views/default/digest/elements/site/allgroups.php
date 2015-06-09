<?php

/**
* Shows the activity of the member's groups in the Digest
*
*/

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

$dbprefix = get_config("dbprefix");

$all_content = '';

// Get all groups a user is member of, or has created
$groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => false));
foreach ($groups as $group) {
	$group_guid = $group->getGUID();

	$offset = 0;
	$limit = 3;

	// retrieve recent group activity
	$sql = "SELECT r.*";
	$sql .= " FROM " . $dbprefix . "river r";
	$sql .= " INNER JOIN " . $dbprefix . "entities AS e ON r.object_guid = e.guid"; // river event -> object
	$sql .= " WHERE (e.container_guid = $group_guid OR r.object_guid = $group_guid)"; // filter by group
	$sql .= " AND r.posted BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval
	$sql .= " AND e.owner_guid != " . $user->guid; // filter own content from entities
	$sql .= " AND r.subject_guid != " . $user->guid; // filter own actions
	$sql .= " AND " . get_access_sql_suffix("e"); // filter access
	$sql .= " ORDER BY posted DESC";
	$sql .= " LIMIT " . $offset . "," . $limit;

	$items = get_data($sql, "elgg_row_to_elgg_river_item");

	if (!empty($items)) {
		$title = elgg_view("output/url", array("text" => $group->name, "href" => $group->getURL()));

		$options = array(
			"list_class" => "elgg-list-river elgg-river",
			"items" => $items,
			"pagination" => false
		);

		$content = elgg_view("page/components/list", $options);

		$all_content .= '<h4>' . $title . '</h4>' . $content . '<br /><br />';
	}

	unset($items);
}

if (!empty($all_content)) {
	echo elgg_view_module("digest", elgg_echo('esope:digest:groupactivity'), $all_content);
}

