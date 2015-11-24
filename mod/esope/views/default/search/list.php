<?php
/**
 * List a section of search results corresponding in a particular type/subtype
 * or search type (comments for example)
 *
 * @uses $vars['results'] Array of data related to search results including:
 *                          - 'entities' Array of entities to be displayed
 *                          - 'count'    Total number of results
 * @uses $vars['params']  Array of parameters including:
 *                          - 'type'        Entity type
 *                          - 'subtype'     Entity subtype
 *                          - 'search_type' Type of search: 'entities', 'comments', 'tags'
 *                          - 'offset'      Offset in search results
 *                          - 'limit'       Number of results per page
 *                          - 'pagination'  Display pagination?
 */

$entities = $vars['results']['entities'];
$count = $vars['results']['count'] - count($entities);

if (!is_array($entities) || !count($entities)) {
	return FALSE;
}

$query = http_build_query(
	array(
		'q' => $vars['params']['query'],
		'entity_type' => $vars['params']['type'],
		'entity_subtype' => $vars['params']['subtype'],
		'limit' => $vars['params']['limit'],
		'offset' => $vars['params']['offset'],
		'search_type' => $vars['params']['search_type'],
	//@todo include vars for sorting, order, and friend-only.
		'owner_guid' => $vars['params']['owner_guid'],
		'container_guid' => $vars['params']['container_guid'],
	)
);

$url = elgg_get_site_url() . "search?$query";

// get pagination
if (array_key_exists('pagination', $vars['params']) && $vars['params']['pagination']) {
	$nav = elgg_view('navigation/pagination',array(
		'base_url' => $url,
		'offset' => $vars['params']['offset'],
		'count' => $vars['results']['count'],
		'limit' => $vars['params']['limit'],
	));
} else {
	$nav = '';
}

// figure out what we're dealing with.
$type_str = NULL;

if (array_key_exists('type', $vars['params']) && array_key_exists('subtype', $vars['params'])) {
	$type_str_tmp = "item:{$vars['params']['type']}:{$vars['params']['subtype']}";
	$type_str_echoed = elgg_echo($type_str_tmp);
	if ($type_str_echoed != $type_str_tmp) {
		$type_str = $type_str_echoed;
	}
}

if (!$type_str && array_key_exists('type', $vars['params'])) {
	$type_str = elgg_echo("item:{$vars['params']['type']}");
}

if (!$type_str) {
	$type_str = elgg_echo('search:unknown_entity');
}

// allow overrides for titles
$search_type_str = elgg_echo("search_types:{$vars['params']['search_type']}");
if (array_key_exists('search_type', $vars['params'])
	&& $search_type_str != "search_types:{$vars['params']['search_type']}") {

	$type_str = $search_type_str;
}

// get any more links.
$more_check = $vars['results']['count'] - ($vars['params']['offset'] + $vars['params']['limit']);
$more = ($more_check > 0) ? $more_check : 0;
// No need to add link to more results if we already have paginated results
if ($vars['params']['pagination']) { $more = 0; }
//$more_url = elgg_http_add_url_query_elements($more_url, array('offset' => $vars['params']['offset'] + $vars['params']['limit'])); // increment offset

// Add link to see more results (and remove limit, that is why we do not increment the offset)
if ($more) {
	$title_key = ($more == 1) ? 'comment' : 'comments';
	$more_str = elgg_echo('search:more', array($count, $type_str));
	$more_url = elgg_http_remove_url_query_element($url, 'limit');
	$more_link = "<li class='elgg-item'><a href=\"$more_url\">$more_str</a></li>";
} else {
	$more_link = '';
}

// @todo once elgg_view_title() supports passing a $vars array use it
$body = '<h3 class="search-heading-category">' . $type_str . '</h3>';

$view = search_get_search_view($vars['params'], 'entity');
if ($view) {
	$body .= '<ul class="elgg-list search-list">';
	foreach ($entities as $entity) {
		$id = "elgg-{$entity->getType()}-{$entity->getGUID()}";
		$body .= "<li id=\"$id\" class=\"elgg-item\">";
		$body .= elgg_view($view, array(
			'entity' => $entity,
			'params' => $vars['params'],
			'results' => $vars['results']
		));
		$body .= '</li>';
	}
	$body .= $more_link;
	$body .= '</ul>';
}

echo $body;
echo $nav;
