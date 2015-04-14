<?php
$slider = $vars['entity'];
if (!elgg_instanceof($slider, 'object', 'slider')) return;

$slider_content = '<li>' . implode('</li><li>', $slider->slides) . '</li>'; // Content without enclosing <ul> (we need id)
$height = 'auto';
$width = 'auto';
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

echo '<div style="height:' . $height . '; width:' . $width . '; overflow:hidden;">' . elgg_view('slider/slider', $slider_params) . '</div>';

