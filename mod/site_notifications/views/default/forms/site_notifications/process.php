<?php

elgg_require_js('forms/site_notifications/process');

// footer
$fields = [
	[
		'#type' => 'button',
		'text' => elgg_echo('site_notifications:toggle_all'),
		'class' => 'elgg-button elgg-button-cancel',
		'id' => 'site-notifications-toggle',
	],
	[
		'#type' => 'submit',
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button-delete',
		'data-confirm' => elgg_echo('site_notifications:delete:confirm'),
		'disabled' => true,
	],
];
if ((bool) elgg_extract('mark_read', $vars, true)) {
	$fields[] = [
		'#type' => 'submit',
		'text' => elgg_echo('site_notifications:mark_read'),
		'data-confirm' => elgg_echo('site_notifications:mark_read:confirm'),
		'formaction' => elgg_generate_action_url('site_notifications/mark_read', [], false),
		'disabled' => true,
	];
}

echo elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'mvs',
	'fields' => $fields,
	'align' => 'horizontal',
	'class' => 'elgg-level',
]);

echo elgg_format_element('div', ['class' => 'site-notifications-container'], (string) elgg_extract('list', $vars));
