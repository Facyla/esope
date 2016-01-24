<?php

elgg_load_library('elgg:recommendations');

$user = $vars['entity'];
$limit = $vars['limit'];
$list_style = $vars['list_style'];


// GROUPES

// User groups (to be excluded)
$user_groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
$user_groups_guids = array();
foreach($user_groups as $ent) {
	$user_groups_guids[] = $ent->guid;
}
if (!empty($user_groups_guids)) $exclude_usergroups = "NOT IN (" . implode(',', $user_groups_guids) . ")";
echo $user_groups_guids;

// Featured groups
$featured_groups = elgg_get_entities_from_metadata(array('type' => 'group', 'limit' => 0, 'metadata_name_value_pairs' => array('name' => 'featured_group', 'value' => 'yes'), 'wheres' => array($exclude_usergroups)));

// Popular groups
$name_metastring_id = elgg_get_metastring_id('featured_group');
$value_metastring_id = elgg_get_metastring_id('yes');
$dbprefix = elgg_get_config('dbprefix');
$exclude_featured = "NOT EXISTS (SELECT 1 FROM {$dbprefix}metadata md WHERE md.entity_guid = e.guid AND md.name_id = $name_metastring_id AND md.value_id = $value_metastring_id)";
$popular_groups = elgg_get_entities_from_relationship_count(array('type' => 'group', 'relationship' => 'member', 'inverse_relationship' => false, 'wheres' => array($exclude_featured, $exclude_usergroups), 'limit' => 6));


// RENDER RECOMMENDED GROUPS
if ($featured_groups) foreach($featured_groups as $ent) {
	/*
	$icon = '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('small') . '" /></a>';
	$info = '<p><strong>' . $ent->name . '</strong>';
	$info .= '<p>' . $ent->getMembers(null, null, true) . ' membres</p>';
	$content .= elgg_view_listing($icon, $info);
	*/
	$content .= '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('small') . '" /></a>';
}
if ($popular_groups) foreach($popular_groups as $ent) {
	/*
	$icon = '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('small') . '" /></a>';
	$info = '<p><strong>' . $ent->name . '</strong>';
	$info .= '<p>' . $ent->getMembers(null, null, true) . ' membres</p>';
	$content .= elgg_view_listing($icon, $info);
	*/
	$content .= '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('small') . '" /></a>';
}
$content .= '<div class="clearfloat"></div>';


echo $content;

