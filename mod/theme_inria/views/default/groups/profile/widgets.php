<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 
	
$group = $vars['entity'];
if (!$group) { return true; }

// tools widget area
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';

// enable tools to extend this area
// Inria : disable widgets on group home
//echo elgg_view("groups/tool_latest", $vars);

// backward compatibility
$right = elgg_view('groups/right_column', $vars);
$left = elgg_view('groups/left_column', $vars);
if ($right || $left) {
	elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
	echo $left;
	echo $right;
}

echo "</ul>";


// Add RSS feed
if (elgg_is_active_plugin('simplepie')) {
	$rss_feed = elgg_view('simplepie/group_simplepie_feed', $vars);
}

// Add group activity
$all_link = elgg_view('output/url', array('href' => "groups/activity/$group->guid", 'text' => elgg_echo('groups:activity'), 'is_trusted' => true));

elgg_push_context('widgets');
$db_prefix = elgg_get_config('dbprefix');
$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$activity = elgg_list_river(array(
	'limit' => $limit, 'offset' => $offset, 'pagination' => true,
	'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
	'wheres' => array("(e1.container_guid = $group->guid)"),
));
elgg_pop_context();

if (!$activity) { $activity = '<p>' . elgg_echo('groups:activity:none') . '</p>'; }


// Use 2 columns if RSS feed enabled in this group
if (!empty($rss_feed)) {
	echo '<div style="width:48%; float:left;">';
	echo '<h3>' . $all_link . '</h3>' . $activity;
	echo '</div>';
	echo '<div style="width:48%; float:right;">';
	echo $rss_feed;
	echo '</div>';
} else {
	echo '<h3>' . $all_link . '</h3>' . $activity;
}

