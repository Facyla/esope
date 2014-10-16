<?php
/**
 * List liked content, using various sort criteria and filtering options
 *
 */

elgg_push_breadcrumb(elgg_echo('likes'), "likes");

$limit = get_input('limit', 20);

$title = elgg_echo('likes');

$content = '';
$content .= elgg_view('likes/liked_content', array('limit' => $limit, 'pagination' => true));

$sidebar = '';


// @TODO : use content layout + filter options in tabs...
$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
	));

echo elgg_view_page($title, $body);

