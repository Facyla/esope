<?php
$group = elgg_extract('group', $vars);

$content = '';

$content .= '<h3>' . elgg_echo('groups:activity') . '</h3>';
$db_prefix = elgg_get_config('dbprefix');
elgg_push_context('widgets');
$content .= elgg_list_river(array(
	'pagination' => true,
	'limit' => 5,
	'joins' => array(
		"JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid",
		"LEFT JOIN {$db_prefix}entities e2 ON e2.guid = rv.target_guid",
	),
	'wheres' => array(
		"(e1.container_guid = $group->guid OR e2.container_guid = $group->guid)",
	),
	'action_types' => array('join', 'vote', 'tag'),
	//'action_types' => array('join'),
	//'types' => array('group', 'user'),
));
elgg_pop_context();


echo '<div class="group-workspace-activity" id="group-workspace-activity-' . $group->guid . '">' . $content . '</div>';

