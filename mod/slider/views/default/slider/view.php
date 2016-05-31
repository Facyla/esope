<?php
// View slider entity

// Get slider
$slider = elgg_extract('entity', $vars);
// Alternate method (more friendly with cmspages)
if (!$slider) {
	$guid = elgg_extract('guid', $vars);
	$slider = get_entity($guid);
}
if (!$slider) { $slider = slider_get_entity_by_name($guid); }
if (!elgg_instanceof($slider, 'object', 'slider')) { return; }

// Add entity to $vars, so other views do not have to compute it again
$vars['entity'] = $slider;
// No menu by default
$add_menu = elgg_extract('add_menu', $vars, false);

$slides = (array) $slider->slides;
$slider_content = '<li>' . implode('</li><li>', $slides) . '</li>'; // Content without enclosing <ul> (we need id)
$height = '100%';
$width = '100%';
if (!empty($slider->height)) { $height = $slider->height; }
if (!empty($slider->width)) { $width = $slider->width; }

$slider_params = array(
		'slidercontent' => $slider_content,
		'sliderparams' => $slider->config,
		'slidercss_main' => "",
		'slidercss_textslide' => "",
		'height' => $height,
		'width' => $width,
	);


// Add listing block (for menu & actions)

if ($add_menu) { echo elgg_view('object/slider', $vars); }

/*
if ($slider->canEdit()) {
	echo elgg_view('output/url', array('href' => elgg_get_site_url() . "slider/edit/" . $slider->guid, 'class' => "elgg-button elgg-button-action", 'style' => "float:right;", 'text' => elgg_echo('edit')));
	echo elgg_view('output/url', array('href' => elgg_get_site_url() . "action/slider/delete/" . $slider->guid, 'confirm' => true, 'is_action' => true, 'class' => "elgg-button elgg-button-delete", 'style' => "float:right;", 'text' => elgg_echo('delete')));
}
*/


echo '<div style="height:' . $height . '; width:' . $width . '; overflow:hidden;" id="slider-' . $slider->guid . '" class="slider-' . $slider->name . '">
	<style>
	' . $slider->css . '
	</style>
	' . elgg_view('slider/slider', $slider_params) . '
</div>';

