<?php

$icons = fontawesome_get_icon_array();
if (empty($icons)) {
	return;
}

$options = array(
	'' => elgg_echo('fontawesome:input:select')
);
foreach ($icons as $hex_code => $icon_class) {
	$options[$icon_class] = json_decode('"\u' . ltrim($hex_code, '\\') . '"') . " $icon_class";
}

$vars['options_values'] = $options;
$vars['class'] = 'elgg-input-fa';
echo elgg_view('input/dropdown', $vars);
