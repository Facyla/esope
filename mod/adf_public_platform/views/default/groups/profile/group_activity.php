<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 

$group = $vars['entity'];


// Add group activity or group content
// ESOPE : add activity if asked
if (elgg_get_plugin_setting('groups_add_activity', 'adf_public_platform') == 'yes') {
	elgg_push_context('widgets');
	$db_prefix = elgg_get_config('dbprefix');
	$activity = elgg_list_river(array(
		'pagination' => true,
		'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
		'wheres' => array("(e1.container_guid = $group->guid)"),
	));
	elgg_pop_context();
	if (!$activity) { $activity = '<p>' . elgg_echo('groups:activity:none') . '</p>'; }
	$all_link = elgg_view('output/url', array('href' => "groups/activity/$group->guid", 'text' => elgg_echo('groups:activity'), 'is_trusted' => true));
	echo '<h3>' . $all_link . '</h3>' . $activity;
}


