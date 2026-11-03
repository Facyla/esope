<?php
/**
 * Livesearch endpoint to search for linked entities
 *
 * Can't use default objects endpoint because of added filters
 *
 * @see /views/json/livesearch/objects.php
 */

elgg_gatekeeper();

$limit = (int) elgg_extract('limit', $vars, elgg_get_config('default_limit'));
$query = elgg_extract('term', $vars, elgg_extract('q', $vars));
$input_name = elgg_extract('name', $vars);

$searchable_subtypes = elgg_extract('object', elgg_entity_types_with_capability('searchable'), []);
$subtypes = (array) elgg_extract('subtype', $vars, $searchable_subtypes, false);
$subtypes = array_intersect($subtypes, $searchable_subtypes);

$body = elgg_list_entities([
	'query' => $query,
	'type' => 'object',
	'subtypes' => $subtypes,
	'container_guid' => (array) elgg_extract('container_guid', $vars, null, false),
	'limit' => $limit,
	'sort_by' => [
		'property_type' => 'metadata',
		'property' => 'title',
		'direction' => 'ASC',
	],
	'fields' => ['metadata' => ['title']],
	'item_view' => 'search/entity',
	'input_name' => $input_name,
], 'elgg_search');

echo elgg_view_page('', $body);
