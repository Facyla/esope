<?php

$plugin = elgg_extract('entity', $vars);
if (!$plugin instanceof ElggPlugin) {
	return;
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'flush_cache',
	'value' => 1,
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('icon_cropper:settings:min_width'),
	'#help' => elgg_echo('icon_cropper:settings:min_width:help'),
	'name' => 'params[min_width]',
	'value' => $plugin->min_width,
	'min' => 0,
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('icon_cropper:settings:min_height'),
	'#help' => elgg_echo('icon_cropper:settings:min_height:help'),
	'name' => 'params[min_height]',
	'value' => $plugin->min_height,
	'min' => 0,
]);
