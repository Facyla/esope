<?php
/**
 * Pages sidebar
 */

echo elgg_view('task/elements/comments_block', array(
	'subtypes' => array('task', 'task_top'),
	'owner_guid' => elgg_get_page_owner_guid(),
));

echo elgg_view('task/elements/tagcloud_block', array(
	'subtypes' => array('task', 'task_top'),
	'owner_guid' => elgg_get_page_owner_guid(),
));