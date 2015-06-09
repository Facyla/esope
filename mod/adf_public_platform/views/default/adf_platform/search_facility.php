<?php
/**
 * Elgg search page
 *
 * @todo much of this code should be pulled out into a library of functions
 */

/* Note : let's go this way... This view should return only a list of matched entities
 * The rest of the search interface should go elsewhere so that the view can be called from various use contexts
 */
/* Params
	 search_type
	 q
	 tag
	 limit
	 offset
	 entity_type
	 entity_subtype
	 owner_guid
	 container_guid
	 friends
	 sort
	 order
	 wheres - added to support multi-criteria metadata search
*/

// Search supports RSS
//global $autofeed;
//$autofeed = true;
elgg_push_context('search');


// Important : We have to register the metadata we'd like to search on
// And optionnally set tag_names after that if we want to perform search on some metadata
// Of course tag_names should be added to searchable_metadata if needed
$searchable_metadata = elgg_extract('searchable_metadata', $vars, false);
$tag_names = elgg_extract('tag_names', $vars, false);
if ($searchable_metadata && !is_array($searchable_metadata)) $searchable_metadata = array($searchable_metadata);
if ($tag_names && !is_array($tag_names)) $tag_names = array($tag_names);
if ($searchable_metadata && $tag_names) $searchable_metadata = array_merge($searchable_metadata, $tag_names);
$searchable_metadata = array_unique($searchable_metadata);
if ($searchable_metadata) foreach ($searchable_metadata as $name) { 
	elgg_register_tag_metadata_name($name);
}
if ($tag_names) set_input('tag_names', $tag_names);
// 'cause sometimes not all of metadata got caught on time, and $tag_names are filtered by registered metadata
//$valid_tag_names = elgg_get_registered_tag_metadata_names();
//echo " ".implode('-', $valid_tag_names);



// Add this because it won't use the right view if not specified
$list = elgg_extract('list', $vars, 'search/list');

// $search_type == all || entities || trigger plugin hook
$search_type = elgg_extract('search_type', $vars, 'all');

// @todo there is a bug in elgg_extract that makes variables have slashes sometimes.
// @todo is there an example query to demonstrate ^
// XSS protection is more important that searching for HTML.
$tag = elgg_extract('tag', $vars, '');
$query = stripslashes(elgg_extract('q', $vars, $tag));

// @todo - create function for sanitization of strings for display in 1.8
// encode <,>,&, quotes and characters above 127
if (function_exists('mb_convert_encoding')) {
	$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
} else {
	// if no mbstring extension, we just strip characters
	$display_query = preg_replace("/[^\x01-\x7F]/", "", $query);
}
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);


// check that we have an actual query
if (!$query) {
	$title = sprintf(elgg_echo('search:results'), "\"$display_query\"");
	$body  = '<strong>' . elgg_echo('search:search_error') . '</strong>';
	$body .= elgg_echo('search:no_query');
	echo $body;
	return;
}


// get limit and offset.  override if on search dashboard, where only 2
// of each most recent entity types will be shown.
$limit = ($search_type == 'all') ? 2 : elgg_extract('limit', $vars, 10);
$offset = ($search_type == 'all') ? 0 : elgg_extract('offset', $vars, 0);

$entity_type = elgg_extract('entity_type', $vars, ELGG_ENTITIES_ANY_VALUE);
$entity_subtype = elgg_extract('entity_subtype', $vars, ELGG_ENTITIES_ANY_VALUE);
$owner_guid = elgg_extract('owner_guid', $vars, ELGG_ENTITIES_ANY_VALUE);
$container_guid = elgg_extract('container_guid', $vars, ELGG_ENTITIES_ANY_VALUE);
$friends = elgg_extract('friends', $vars, ELGG_ENTITIES_ANY_VALUE);
$sort = elgg_extract('sort', $vars);
$wheres = elgg_extract('wheres', $vars);
switch ($sort) {
	case 'relevance':
	case 'created':
	case 'updated':
	case 'action_on':
	case 'alpha':
		break;

	default:
		$sort = 'relevance';
		break;
}

$order = elgg_extract('order', $vars, 'desc');
if ($order != 'asc' && $order != 'desc') { $order = 'desc'; }

// set up search params
$params = array(
	'query' => $query,
	'offset' => $offset,
	'limit' => $limit,
	'sort' => $sort,
	'order' => $order,
	'search_type' => $search_type,
	'type' => $entity_type,
	'subtype' => $entity_subtype,
//	'tag_type' => $tag_type,
	'owner_guid' => $owner_guid,
	'container_guid' => $container_guid,
//	'friends' => $friends
	'pagination' => ($search_type == 'all') ? FALSE : TRUE,
	'list' => $list,
	'wheres' => $wheres,
);

$types = get_registered_entity_types();
$custom_types = elgg_trigger_plugin_hook('search_types', 'get_types', $params, array());


// start the actual search
$results_html = '';

if ($search_type == 'all' || $search_type == 'entities') {
	// to pass the correct current search type to the views
	$current_params = $params;
	$current_params['search_type'] = 'entities';

	// foreach through types.
	// if a plugin returns FALSE for subtype ignore it.
	// if a plugin returns NULL or '' for subtype, pass to generic type search function.
	// if still NULL or '' or empty(array()) no results found. (== don't show??)
	foreach ($types as $type => $subtypes) {
		if ($search_type != 'all' && $entity_type != $type) { continue; }

		if (is_array($subtypes) && count($subtypes)) {
			foreach ($subtypes as $subtype) {
				// no need to search if we're not interested in these results
				// @todo when using index table, allow search to get full count.
				if ($search_type != 'all' && $entity_subtype != $subtype) { continue; }
				$current_params['subtype'] = $subtype;
				$current_params['type'] = $type;

				$results = elgg_trigger_plugin_hook('search', "$type:$subtype", $current_params, NULL);
				if ($results === FALSE) {
					// someone is saying not to display these types in searches.
					continue;
				} elseif (is_array($results) && !count($results)) {
					// no results, but results searched in hook.
				} elseif (!$results) {
					// no results and not hooked.  use default type search.
					// don't change the params here, since it's really a different subtype.
					// Will be passed to elgg_get_entities().
					$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
				}

				if (is_array($results['entities']) && $results['count']) {
					if ($view = search_get_search_view($current_params, 'list')) {
						$results_html .= elgg_view('search/esope_list', array(
							'results' => $results,
							'params' => $current_params,
						));
					}
				}
			}
		}

		// pull in default type entities with no subtypes
		$current_params['type'] = $type;
		$current_params['subtype'] = ELGG_ENTITIES_NO_VALUE;

		$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
		// someone is saying not to display these types in searches.
		if ($results === FALSE) { continue; }

		if (is_array($results['entities']) && $results['count']) {
			if ($view = search_get_search_view($current_params, 'list')) {
				$results_html .= elgg_view('search/esope_list', array(
					'results' => $results,
					'params' => $current_params,
				));
			}
		}
	}
}

// call custom searches
if ($search_type != 'entities' || $search_type == 'all') {
	if (is_array($custom_types)) {
		foreach ($custom_types as $type) {
			if ($search_type != 'all' && $search_type != $type) { continue; }
			$current_params = $params;
			$current_params['search_type'] = $type;
			$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
			// someone is saying not to display these types in searches.
			if ($results === FALSE) { continue; }
			if (is_array($results['entities']) && $results['count']) {
				if ($view = search_get_search_view($current_params, 'list')) {
					$results_html .= elgg_view('search/esope_list', array('results' => $results, 'params' => $current_params));
				}
			}
		}
	}
}

// highlight search terms
if ($search_type == 'tags') {
	$searched_words = array($display_query);
} else {
	$searched_words = search_remove_ignored_words($display_query, 'array');
}
$highlighted_query = search_highlight_words($searched_words, $display_query);

$body = '<strong>' . elgg_echo('search:results', array("\"$highlighted_query\"")) . '</strong>';

if (!$results_html) { $body .= elgg_view('search/no_results'); } 
else { $body .= $results_html; }

echo $body;

