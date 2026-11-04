<?php
/**
 * Request a login URL/code by e-mail
 */

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('loginusername'),
	'name' => 'username',
	'autofocus' => true,
	'required' => true,
]);

if (isset($vars['returntoreferer'])) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'returntoreferer',
		'value' => 'true'
	]);
}

$footer = elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'elgg-justify-right',
	'fields' => [
		[
			'#type' => 'submit',
			'text' => elgg_echo('request'),
		],
	],
]);

elgg_set_form_footer($footer);
