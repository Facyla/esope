<?php
// Displays inline help on hovering + enables to toggle a popup helper
// Accepts translation short 'key' : translation key, without prefix 'elgg_menus:' and suffix ':details'
$content = elgg_extract('content', $vars, '');
if (!$content) {
	$key = elgg_extract('key', $vars, '');
	if ($key) {
		$key = "elgg_menus:$key:details";
		$content = elgg_echo($key);
		// Do not display if undefined translation
		if ($key == $content) $content = false;
	}
}
$style = elgg_extract('style', $vars, '');

if ($content) {
	$uniqid = 'elgg-menus-help-' . mt_rand();
	
	// Popup content
	echo elgg_view_module('popup', false, $content, array(
			'id' => $uniqid,
			'class' => 'hidden clearfix developers-content-thin elgg-menus-popup',
		));
	
	// Build toggle link
	$content = strip_tags(str_replace('"', "'", $content));
	echo elgg_view('output/url', array(
			'text' => '<span class="fa fa-question-circle fa-fw" title="' . $content . '">',
			'href' => '#' . $uniqid,
			'rel' => 'popup',
			'style' => $style,
		));
}


