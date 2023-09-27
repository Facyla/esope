<?php
/**
 * Site settings, i18n section.
 */

$result = elgg_view_field([
	'#type' => 'select',
	'name' => 'language',
	'#label' => elgg_echo('installation:language'),
	'value' => elgg_get_config('language'),
	'options_values' => elgg()->translator->getInstalledTranslations(true),
]);

$language_options = elgg()->translator->getInstalledTranslations();

// lock site language and English, these can't be disabled
$config_language = elgg_get_config('language');
if ($config_language !== 'en') {
	$language_options[$config_language] = [
		'text' => $language_options[$config_language],
		'value' => $config_language,
		'disabled' => true,
	];
}

$language_options['en'] = [
	'text' => $language_options['en'],
	'value' => 'en',
	'disabled' => true,
];

$result .= elgg_view_field([
	'#type' => 'checkboxes',
	'#label' => elgg_echo('config:i18n:allowed_languages'),
	'#help' => elgg_echo('config:i18n:allowed_languages:help'),
	'name' => 'allowed_languages',
	'value' => elgg()->translator->getAllowedLanguages(),
	'options_values' => $language_options,
	'align' => 'horizontal',
]);

$result .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('config:i18n:who_can_change_language'),
	'name' => 'who_can_change_language',
	'value' => elgg_get_config('who_can_change_language'),
	'options_values' => [
		'everyone' => elgg_echo('config:i18n:who_can_change_language:everyone'),
		'admin_only' => elgg_echo('config:i18n:who_can_change_language:admin_only'),
		'nobody' => elgg_echo('config:i18n:who_can_change_language:nobody'),
	],
]);

echo elgg_view_module('info', elgg_echo('admin:settings:i18n'), $result);
