<?php
/**
* Shows the publication activity of the member's groups in the Digest
*
*/

use Elgg\Activity\GroupRiverFilter;
use Elgg\Database\QueryBuilder;

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

$dbprefix = elgg_get_config("dbprefix");

$content = '';
$limit = 3; // Content limit (not for groups, but for groups'' content ; should return all user's groups)
$offset = 0;

// Get all groups a user is member of, or has created
$groups = elgg_get_entities(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
if ($groups) {
	foreach ($groups as $group) {
		$items = null;
	
		// retrieve latest group activity
		/*
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
			
			// Note: we need direct access so images can be generated and inlined into email (because of walled garden)
			// @TODO use timestamped URLs so images inliner car work properly
			//$icon_url = $group->getIconURL(['size' => 'tiny']);
			//if (strpos($icon_url, 'default_icons') === false) {
			//	$icon_url = elgg_get_site_url() . 'SOMEURL/' . $group->guid . '/tiny/' . $group->icontime;
			//}
			//$icon = '<img src="' . $icon_url . '" />';
			$icon = '<img src="' . $group->getIconURL('tiny') . '" />&nbsp;';
			$content .= '<h4 class="group-title">' . elgg_view("output/url", array("text" => $icon . $group->name, "href" => $group->getURL())) . '</h4>';
			$content .= elgg_view("page/components/list", $options);
			$content .= '<br /><br />';
		}
		unset($items);
		*/
		
		$content .= elgg_list_river([
			'limit' => 4,
			'pagination' => false,
			'wheres' => [
				 new GroupRiverFilter($group),
			],
			'no_results' => elgg_echo('river:none'),
		]);
	}
}

if (!empty($content)) {
	$title = elgg_echo('theme_adf:digest:groupactivity');
	echo elgg_view_module("digest", $title, $content);
}

