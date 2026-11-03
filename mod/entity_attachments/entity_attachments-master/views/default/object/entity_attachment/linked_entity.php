<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggEntity) {
	return;
}

$linked_entity = get_entity((int) $entity->entity_guid);
if (!$linked_entity instanceof \ElggEntity) {
	return;
}

$icon = 'link';
if ($linked_entity instanceof \ElggUser) {
	$icon = 'user';
} elseif ($linked_entity instanceof \ElggGroup) {
	$icon = 'users';
}

$vars['icon'] = elgg_view_icon($icon);
$vars['title'] = elgg_view_entity_url($linked_entity);

echo elgg_view('object/entity_attachment/default', $vars);
