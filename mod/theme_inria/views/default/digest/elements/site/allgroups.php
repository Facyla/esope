<?php

/**
* Shows the publication activity of the member's groups in the Digest
*
*/

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

$dbprefix = elgg_get_config("dbprefix");

$content = '';
$limit = 3; // Content limit (not for groups, but for groups'' content ; should return all user's groups)
$offset = 0;

// Get all groups a user is member of, or has created
$groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
if ($groups) {
	foreach ($groups as $group) {
		$items = null;
	
		// retrieve latest group activity
		$sql = "SELECT r.*";
		$sql .= " FROM " . $dbprefix . "river r";
		$sql .= " INNER JOIN " . $dbprefix . "entities AS e ON r.object_guid = e.guid"; // river event -> object
		$sql .= " WHERE (e.container_guid = {$group->guid} OR r.object_guid = {$group->guid})"; // filter by group
		$sql .= " AND r.posted BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval
		$sql .= " AND e.owner_guid != " . $user->guid; // filter own content
		$sql .= " AND r.subject_guid != " . $user->guid; // filter own actions
		//$sql .= " AND " . get_access_sql_suffix("e"); // filter access
		$sql .= " AND " . _elgg_get_access_where_sql(array("table_alias" => "e")); // filter access
		$sql .= " ORDER BY posted DESC";
		$sql .= " LIMIT " . $offset . "," . $limit;
		$items = get_data($sql, "_elgg_row_to_elgg_river_item");

		if (!empty($items)) {
			$options = array(
				"list_class" => "elgg-list-river elgg-river",
				"items" => $items,
				"pagination" => false,
			);
			
			// Note : we need direct access so images can be generated and inlined into email (because of walled garden)
			// but this is not working for these images for some reason ?
			$icon = '<img src="' . $group->getIconURL('tiny') . '" />';
			//$icon = '<img src="' . elgg_get_site_url() . 'mod/groups/icon.php?group_guid=' . $group->guid . '&size=tiny" />';
			$content .= '<h4 class="group-title">' . elgg_view("output/url", array("text" => $icon . $group->name, "href" => $group->getURL())) . '</h4>';
			$content .= elgg_view("page/components/list", $options);
			$content .= '<br /><br />';
		}
		unset($items);
	}
}

if (!empty($content)) {
	$title = elgg_echo('esope:digest:groupactivity');
	echo elgg_view_module("digest", $title, $content);
}

