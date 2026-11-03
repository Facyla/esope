<?php
/**
 * Login form where a user needs to enter a code to login.
 * The code was sent to the e-mail address of the user
 */

echo elgg_view('output/longtext', [
	'value' => elgg_echo('login_by_email:code:description'),
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('login_by_email:code:code'),
	'name' => 'code',
	'placeholder' => '000000',
	'required' => true,
	'min' => 1,
	'max' => 999999,
]);

$footer = elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('user:persistent'),
			'#class' => 'elgg-field-stretch',
			'name' => 'persistent',
			'value' => 1,
		],
		[
			'#type' => 'submit',
			'text' => elgg_echo('login'),
		],
	],
]);
elgg_set_form_footer($footer);
