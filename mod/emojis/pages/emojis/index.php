<?php
/**
 * Emojis index page
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('emojis'));

$objects = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => '10',
));

$title = elgg_echo('emojis:index');

$body = elgg_view_layout('one_column', array(
	'title' => $title,
	'content' => $content,
	//'sidebar' => elgg_view('emojis/sidebar'),
	//'filter_context' => 'all',
));

echo elgg_view_page($title, $body);
