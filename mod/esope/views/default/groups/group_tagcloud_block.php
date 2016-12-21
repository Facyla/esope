<?php
/**
 * Display tags for groups
 *
 * Generally used in a sidebar. Version for groups (all groups or a specific group).
 *
 * @uses $vars['subtypes']   Object subtype string or array of subtypes
 * @uses $vars['owner_guid'] The owner of the content being tagged
 * @uses $vars['limit']      The maximum number of tags to display
 * @uses $vars['tag_name']   The group tags metadata name
 */

$owner_guid = elgg_extract('owner_guid', $vars, ELGG_ENTITIES_ANY_VALUE);
if (!$owner_guid) { $owner_guid = ELGG_ENTITIES_ANY_VALUE; }

$options = array(
	'type' => 'group',
	'subtype' => elgg_extract('subtypes', $vars, ELGG_ENTITIES_ANY_VALUE),
	'threshold' => 0,
	'owner_guid' => $owner_guid,
	'limit' => elgg_extract('limit', $vars, 50),
	'tag_name' => elgg_extract('tag_name', $vars, 'interests'), // This is for groups
);

$title = elgg_echo('tagcloud');
$cloud = elgg_view_tagcloud($options);

if (!$cloud) { return true; }

echo elgg_view_module('aside', $title, $cloud);

