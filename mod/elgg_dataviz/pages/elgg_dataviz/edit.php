<?php
/**
 * Add dataviz page
 *
 * @package Elggdataviz
 */

$library = get_input('library');

$dataviz_guid = get_input('guid');
$dataviz = get_entity($dataviz_guid);

if (!elgg_instanceof($dataviz, 'object', 'dataviz') || !$dataviz->canEdit()) {
	register_error(elgg_echo('dataviz:unknown_dataviz'));
	forward(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('dataviz:edit');
elgg_push_breadcrumb($title);

$content = elgg_view_form('dataviz/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);

