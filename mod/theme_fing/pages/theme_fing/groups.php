<?php
/**
 * Create a new page
 *
 * @package ElggPages
 */

$theme = strtolower(get_input('theme'));

$title = elgg_echo('theme_fing:' . $theme);
$content = '';
$sidebar = '';

elgg_pop_breadcrumb();
elgg_push_breadcrumb($title);


// Add custom intro block
$content .= elgg_view('cmspages/view', array('pagetype' => "group-theme-$theme"));

// Get and list groups
$params = array(
	'type' => 'group', 'limit' => 0,
	'metadata_name_value_pairs' => array('name' => 'theme', 'value' => $theme, 'case_sensitive' => false),
);

$groups = elgg_get_entities_from_metadata($params);
foreach ($groups as $ent) { $group_guids[] = $ent->guid; }

$params['full_view'] = false;
$content .= elgg_list_entities_from_metadata($params);


// Add recent activity in these groups in sidebar
$offset = get_input('offset', 0); 
$limit = get_input('limit', 10); 
$dbprefix = get_config("dbprefix");
$group_guids_in = implode(',', $group_guids);
$sql = "SELECT r.* FROM " . $dbprefix . "river r";
$sql .= " INNER JOIN " . $dbprefix . "entities AS e ON r.object_guid = e.guid"; // river event -> object
$sql .= " WHERE (e.container_guid IN ($group_guids_in) OR r.object_guid IN ($group_guids_in))"; // filter by all groups at once
$sql .= " AND " . get_access_sql_suffix("e"); // filter access
$sql .= " ORDER BY posted DESC LIMIT " . $offset . "," . $limit;
$items = get_data($sql, "elgg_row_to_elgg_river_item");
if (!empty($items)) {
	$options = array(
		"list_class" => "elgg-list-river elgg-river",
		"items" => $items,
		"pagination" => false
	);
	$sidebar .= elgg_view("page/components/list", $options);
}


$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
));

echo elgg_view_page($title, $body);

