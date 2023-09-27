<?php
/**
 * Groups plugin settings
 */

/* @var ElggPlugin $plugin */
$plugin = elgg_extract('entity', $vars);

$fields = [
	[
		'#type' => 'checkbox',
		'#label' => elgg_echo('groups:allowhiddengroups'),
		'name' => 'params[hidden_groups]',
		'default' => 'no',
		'switch' => true,
		'value' => 'yes',
		'checked' => ($plugin->hidden_groups === 'yes'),
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('groups:whocancreate'),
		'name' => 'params[limited_groups]',
		'options_values' => [
			'no' => elgg_echo('access:label:logged_in'),
			'yes' => elgg_echo('admin')
		],
		'value' => $plugin->limited_groups,
	],
];

foreach ($fields as $field) {
	echo elgg_view_field($field);
}
