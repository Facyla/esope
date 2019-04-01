<?php
/**
 * Groups search
 *
 */

$title = elgg_echo('groups');

$content = '';

elgg_pop_breadcrumb();

elgg_register_title_button();

$content .= elgg_view('esearch/esearch_groups');

$sidebar = '';
$sidebar .= elgg_view('groups/group_tagcloud_block');
$sidebar .= elgg_view('groups/sidebar/featured');

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
	'filter_override' => elgg_view('groups/group_sort_menu', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

