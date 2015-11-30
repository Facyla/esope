<?php
$entity = elgg_extract('entity', $vars);

if (elgg_instanceof($entity, 'object')) {
	$title = $entity->title;
	if (empty($title)) $title = $entity->name;
	if (empty($title)) $title = elgg_echo('untitled');
	
	echo elgg_view_title($title);
	if ($entity->icontime) { echo elgg_view_entity_icon($entity, 'master', array()); }
	echo elgg_view('output/longtext', array('value' => $entity->description));
}

