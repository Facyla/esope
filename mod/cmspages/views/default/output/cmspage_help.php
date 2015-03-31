<?php
// Displays inline help on hovering + enables to toggle a popup helper

$content = elgg_extract('content', $vars, '');

if ($content) {
	$uniqid = 'cmspages-help-' . mt_rand();
	
	// Popup content
	echo elgg_view_module('popup', false, $content, array(
			'id' => $uniqid,
			'class' => 'hidden clearfix developers-content-thin cmspages-popup',
		));
	
	// Build toggle link
	$content = strip_tags(str_replace('"', "'", $content));
	echo elgg_view('output/url', array(
			'text' => '<span class="fa fa-question-circle fa-fw" title="' . $content . '">',
			'href' => '#' . $uniqid,
			'rel' => 'popup',
			'style' => "float:left;",
		));
}


