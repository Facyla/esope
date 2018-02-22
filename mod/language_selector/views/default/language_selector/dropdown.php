<?php

$allowed = language_selector_get_allowed_translations();
$current_lang_id = get_current_language();

if (count($allowed) <= 1) {
	return;
}

elgg_require_js('language_selector/default');

// show text or flags
$show_flags = false;
if (elgg_get_plugin_setting("show_images", "language_selector") != "no") {
	$show_flags = true;
}

$options = [];

$toggle_text = elgg_echo('language_selector:change');

foreach ($allowed as $lang_id) {
	$lang_name = elgg_echo($lang_id);

	$text = elgg_format_element('span', [
		'language-selector-label'
			], $lang_name);

	if ($show_flags) {
		$flag_view = false;
		foreach (['svg', 'jpg', 'png', 'gif'] as $ext) {
			$flag_icon = "language_selector/flags/$lang_id.$ext";
			if (elgg_view_exists($flag_icon)) {
				$flag_view = $flag_icon;
				break;
			}
		}
		if ($flag_view) {
			$icon = elgg_view('output/img', [
				'src' => elgg_get_simplecache_url($flag_view),
				'alt' => $lang_name,
				'class' => 'language-selector-flag-icon',
			]);
			$text = $icon . $text;
		}
	}

	$class = ['language-selector-language-option'];
	if ($current_lang_id == $lang_id) {
		$class[] = 'elgg-state-selected';
		$toggle_text = $text;
	}

	$options[] = elgg_view('output/url', [
		'text' => $text,
		'href' => "action/language_selector/change?lang_id=$lang_id",
		'class' => $class,
		'title' => $lang_name,
		'is_action' => true,
		'data-language' => $lang_id,
	]);
}


$selector = elgg_view('output/url', [
	'text' => $toggle_text,
	'href' => '#language-selector-popup',
	'title' => elgg_echo('language_selector:change'),
	'rel' => 'popup',
	'class' => 'language-selector-language-option language-selector-popup-trigger',
]);

$selector .= elgg_format_element('div', [
	'id' => 'language-selector-popup',
	'class' => 'language-selector-dropdown elgg-module-dropdown hidden',
		], implode('', $options));

echo elgg_format_element('div', [
	'class' => 'language_selector',
], $selector);
