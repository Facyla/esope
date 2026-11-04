<?php

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'params[custom_link][title]',
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'url',
	'#label' => elgg_echo('entity_attachments:href'),
	'name' => 'params[custom_link][href]',
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('entity_attachments:subtitle'),
	'name' => 'params[custom_link][subtitle]',
]);
