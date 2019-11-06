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

foreach ($allowed as $lang_id) {
	$lang_name = elgg_echo($lang_id);
	$text = $lang_id;

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
			$text = elgg_view('output/img', [
				'src' => elgg_get_simplecache_url($flag_view),
				'alt' => $lang_name,
				'class' => 'language-selector-flag-icon',
			]);
		}
	}

	$class = ['language-selector-toggle'];
	if ($current_lang_id == $lang_id) {
		$class[] = 'elgg-state-selected';
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

echo elgg_format_element('div', [
	'class' => 'language_selector',
		], implode(' | ', $options));
