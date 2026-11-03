<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggEntity) {
	return;
}

$defaults = [
	'icon' => false,
	'access' => false,
	'byline' => false,
	'time' => false,
	'show_social_menu' => false,
	'subtitle' => $entity->subtitle,
];

$vars = array_merge($defaults, $vars);

if (!isset($vars['title']) && empty($entity->getDisplayName())) {
	$vars['title'] = get_class($entity);
}

echo elgg_view('object/elements/summary', $vars);
