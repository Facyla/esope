<?php
$entity = elgg_extract('entity', $vars);

echo elgg_view('output/url', array(
		'name' => 'preview',
		'text' => elgg_echo('preview'),
		'href' => 'newsletter/preview/' . $entity->guid,
		'class' => 'elgg-button elgg-button-action float-alt',
	));


