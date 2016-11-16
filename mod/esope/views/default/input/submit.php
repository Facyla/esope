<?php
/**
 * Create a submit input button
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['class'] CSS class that replaces elgg-button-submit
 */

// ESOPE : enable button submit instead of input <=> enables images and font-art in button text...

$vars['type'] = 'submit';
$vars['class'] = elgg_extract('class', $vars, 'elgg-button-submit');

// ESOPE : enable button submit <=> enables images and font-art in button text...
if (strip_tags($vars['value']) == $vars['value']) {
	echo elgg_view('input/button', $vars);
} else {
	$value = $vars['value'];
	unset($vars['value']);
	
	if (isset($vars['class'])) {
		$vars['class'] = "elgg-button {$vars['class']}";
	} else {
		$vars['class'] = "elgg-button";
	}

	// blank src if trying to access an offsite image. @todo why?
	if (isset($vars['src']) && strpos($vars['src'], elgg_get_site_url()) === false) {
		$vars['src'] = "";
	}
	
	echo '<button ' . elgg_format_attributes($vars) . '>' . $value . '</button>';
}


