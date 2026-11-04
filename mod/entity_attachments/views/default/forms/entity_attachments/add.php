<?php

use Elgg\Exceptions\Http\BadRequestException;

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggObject || !$entity->canEdit()) {
	throw new BadRequestException();
}

$body = elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity->guid,
]);

$options_values = [
	'linked_entity' => elgg_echo('entity_attachments:forms:add:type:linked_entity'),
	'linked_group' => elgg_echo('entity_attachments:forms:add:type:linked_group'),
	'linked_user' => elgg_echo('entity_attachments:forms:add:type:linked_user'),
	'custom_link' => elgg_echo('entity_attachments:forms:add:type:custom_link'),
	'download_link' => elgg_echo('entity_attachments:forms:add:type:download_link'),
];

if (!elgg_is_active_plugin('groups')) {
	unset($options_values['linked_group']);
}

$body .= elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('entity_attachments:forms:add:type'),
	'name' => 'type',
	'options_values' => $options_values,
]);

foreach ($options_values as $key => $label) {
	$menu = '';
	
	$view_contents = elgg_view('forms/entity_attachments/types/' . $key, $vars);
	$view_contents .= elgg_view_field([
		'#type' => 'submit',
		'text' => elgg_echo('save'),
	]);
	
	if ($key === 'linked_entity') {
		$menu .= elgg_view('output/url', [
			'icon' => 'filter',
			'text' => elgg_echo('filter'),
			'href' => false,
			'class' => 'elgg-toggle',
			'data-toggle-selector' => '.entity-attachments-type-linked_entity .elgg-field:has(#entity-attachments-linked-entity-filter)',
		]);
	}
	
	$body .= elgg_view_module('inline', $label, $view_contents, [
		'class' => [
			'hidden',
			'entity-attachments-type',
			'entity-attachments-type-' . $key,
		],
		'menu' => $menu,
	]);
}

echo elgg_view_module('info', elgg_echo('item:object:entity_attachment:add'), $body);
