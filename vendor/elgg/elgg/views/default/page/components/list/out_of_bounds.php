<?php
/**
 * This view provides a way back to other content in the list if a user reaches a listing page out of bounds (without items, but with a count)
 */

$items = elgg_extract('items', $vars);
$pagination = (bool) elgg_extract('pagination', $vars);
$count = (int) elgg_extract('count', $vars);

if (!empty($items) || !$pagination || empty($count)) {
	return;
}

$link = elgg_view('output/url', [
	'text' => elgg_echo('list:out_of_bounds:link'),
	'href' => elgg_http_add_url_query_elements(elgg_get_current_url(), ['offset' => null]),
]);

echo elgg_view_message('notice', elgg_echo('list:out_of_bounds'), ['link' => $link]);
