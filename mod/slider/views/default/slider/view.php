<?php
// Get slider
$slider = $vars['entity'];
// Alternate method (more friendly with cmspages)
if (!$slider) {
	$guid = $vars['guid'];
	$slider = get_entity($guid);
}
if (!elgg_instanceof($slider, 'object', 'slider')) return;

$slider_content = '<li>' . implode('</li><li>', $slider->slides) . '</li>'; // Content without enclosing <ul> (we need id)
$height = '100%';
$width = '100%';
if (!empty($slider->height)) $height = $slider->height;
if (!empty($slider->width)) $width = $slider->width;

$slider_params = array(
		'slidercontent' => $slider_content,
		'sliderparams' => $slider->config,
		'slidercss_main' => "",
		'slidercss_textslide' => "",
		'height' => $height,
		'width' => $width,
	);

echo '<div style="height:' . $height . '; width:' . $width . '; overflow:hidden;" id="slider-' . $slider->guid . '">
	<style>
	' . $slider->css . '
	</style>
	' . elgg_view('slider/slider', $slider_params) . '
</div>';

