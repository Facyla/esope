<?php
$entity = elgg_extract('entity', $vars);

if (elgg_instanceof($entity)) {
	$title = $entity->name;
	if (empty($title)) $title = elgg_echo('untitled');
	echo elgg_view_title($title);
	echo elgg_view_entity($entity, false, false); // guid, full, bypass override
}

