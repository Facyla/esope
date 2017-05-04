<?php 
/**
 * Group entity view
 * 
 * @package ElggGroups
 */

$group = $vars['entity'];

//$icon = elgg_view_entity_icon($group, 'tiny');
// Iris : bigger images
$size = 'tiny';
if (elgg_in_context('search')) { $size = 'large'; }

//$icon = elgg_view_entity_icon($entity, $size, $vars);
$icon = '<a href="' . $group->getURL() . '"><img src="' . $group->getIconUrl(array('size' => $size)) . '" alt="' . $group->name . '"></a>';


$metadata = elgg_view_menu('entity', array(
	'entity' => $group,
	'handler' => 'groups',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// Group tools support adds one condition - but won't block if plugin disabled
//if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
if ((elgg_in_context('owner_block') || elgg_in_context('widgets')) && !elgg_in_context("widgets_groups_show_members")) {
	$metadata = '';
}


if ($vars['full_view']) {
	echo elgg_view('groups/profile/summary', $vars);
} else {
	// brief view
	$params = array(
		'entity' => $group,
		'metadata' => $metadata,
		'subtitle' => $group->briefdescription,
	);
	$params = $params + $vars;
	$list_body = elgg_view('group/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body, $vars);
}
