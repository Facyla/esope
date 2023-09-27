<?php
/**
 * List all user files
 *
 * Note: this view has a corresponding view in the default view type, changes should be reflected
 *
 * @uses $vars['entity'] the user or group to list for
 */

$owner = elgg_extract('entity', $vars);

// List files
echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'file',
	'owner_guid' => $owner->guid,
	'no_results' => elgg_echo('file:none'),
	'distinct' => false,
	'pagination' => false,
]);
