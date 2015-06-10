<?php
/* Renders an Impress.js presentation
 * param 'content' : the HTML content of the presentation
 * param 'slides' : alternate content, using slides description as array('content' => $html, 'properties' => array('id' => 'div_id', 'class' => 'some_class', 'data-x' => "3000", 'data-y' => "1500", 'data-scale' => "10", 'data-rotate-x' => "-40", 'data-rotate-y' => "10"))
 param 'css' : the presentation CSS
 param 'transition-duration' : the transition duration, in milliseconds
 */

global $CONFIG;

elgg_load_js('impress.js');
elgg_load_js('impress-audio');

$impress_css = elgg_extract('css', $vars, '');
$transition_duration = elgg_extract('transition-duration', $vars, '200');
$impress_content = elgg_extract('content', $vars, '');
if (empty($impress_content)) {
	$impress_slides = elgg_extract('content', $vars, '');
	$impress_content = '';
	foreach ($impress_slides as $slide) {
		$properties = '';
		foreach ($slide['properties'] as $key => $val) { $properties .= " $key=\"$val\""; }
		$impress_content .= '<div' . $properties . '>' . $slide['content'] . '</div>';
	}
}

// Note : id has to be 'impress'
$content .= '<div id="impress" data-transition-duration="' . $transition_duration . '">';

$content .= $impress_content;

$content .= '<div class="hint"><p>Use a spacebar or arrow keys to navigate</p></div>';

$content .= '</div>';


// JS scripts
$content .= '<script>
if ("ontouchstart" in document.documentElement) { 
	document.querySelector(".hint").innerHTML = "<p>Tap on the left or right to navigate</p>";
}
</script>';
$content .= '<script>$(document).ready(function() { impress().init(); });</script>';

echo $content;

