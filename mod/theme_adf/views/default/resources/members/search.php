<?php
/**
 * Members search page
 */

$query = get_input('member_query');

if (empty($query)) {
	forward('members');
}

$display_query = _elgg_get_display_query($query);
$title = elgg_echo('members:title:search', ["&laquo;&nbsp;$display_query&nbsp;&raquo;"]);

$content = elgg_list_entities([
	'query' => $query,
	'type' => 'user',
	'list_type_toggle' => false,
	'no_results' => true,
	'partial_match' => true, // default true
	'tokenize' => true, // default true
], 'elgg_search');

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'filter_id' => 'members',
	'filter_value' => 'search',
]);
