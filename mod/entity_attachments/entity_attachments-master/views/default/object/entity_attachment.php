<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggEntity) {
	return;
}

$type = $entity->attachment_type;

$view = 'object/entity_attachment/default';
if (!empty($type) && elgg_view_exists("object/entity_attachment/{$type}")) {
	$view = "object/entity_attachment/{$type}";
}

echo elgg_view($view, $vars);
