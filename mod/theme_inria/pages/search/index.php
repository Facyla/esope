<?php
/**
 * Elgg search page
 *
 * @todo much of this code should be pulled out into a library of functions
 */

// Search supports RSS
global $autofeed;
$autofeed = true;

// Set to allow or disable search results on empty query
$allow_empty_query = true;


// $search_type == all || entities || trigger plugin hook
$search_type = get_input('search_type', 'all');
//$search_type = 'all';

// @todo there is a bug in get_input that makes variables have slashes sometimes.
// @todo is there an example query to demonstrate ^
// XSS protection is more important that searching for HTML.
$query = stripslashes(get_input('q', get_input('tag', '')));

$display_query = _elgg_get_display_query($query);
$results_count = 0;

// Min words : is that relevant ?
global $CONFIG;
$min_chars = $CONFIG->search_info['min_chars'];
/*
if (strlen($query) < $min_chars) {
	register_error(elgg_echo('esope:search:tooshort', array($min_chars)));
	//$query = '';
}
*/

$entity_type = get_input('entity_type', ELGG_ENTITIES_ANY_VALUE);
$entity_subtype = get_input('entity_subtype', ELGG_ENTITIES_ANY_VALUE);
if ($entity_subtype == 'search_type:tags') {
	$search_type = 'tags';
	//$entity_subtype = '';
}
if (empty($entity_type)) { $entity_type = ELGG_ENTITIES_ANY_VALUE; }
if (empty($entity_subtype)) { $entity_subtype = ELGG_ENTITIES_ANY_VALUE; }

// Cannot search for "all" if type selected
//if (!empty($entity_type)) { $search_type = 'entities'; }


$owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE);
$owner_username = get_input('owner_username', false);
if ($owner_username) {
	$owner = get_user_by_username($owner_username);
	if (elgg_instanceof($owner, 'user')) {
		$owner_guid = $owner->guid;
	}
}


$container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);
// Display results in appropriate layout for groups
if (!empty($container_guid)) {
	if ($container = get_entity($container_guid)) {
		if (elgg_instanceof($container, 'group')) {
			elgg_set_page_owner_guid($container_guid);
			elgg_extend_view('page/elements/owner_block', 'groups/search', 800);
		}
	}
}


$friends = get_input('friends', ELGG_ENTITIES_ANY_VALUE);

// @todo - create function for sanitization of strings for display in 1.8
// encode <,>,&, quotes and characters above 127
if (function_exists('mb_convert_encoding')) {
	$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
} else {
	// if no mbstring extension, we just strip characters
	$display_query = preg_replace("/[^\x01-\x7F]/", "", $query);
}
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);

// get limit and offset.  override if on search dashboard, where only 2
// of each most recent entity types will be shown.
//if (($search_type == 'all') && empty($entity_subtype)) {
if (($search_type == 'all') && (empty($entity_subtype) || ($entity_subtype == 'search_text:tags'))) {
	$limit = get_input('limit', 2);
	$offset = 0;
	$pagination = false;
} else {
	$limit = get_input('limit', elgg_get_config('default_limit'));
	$offset = get_input('offset', 0);
	$pagination = true;
}

// Sort
$sort = get_input('sort');
switch ($sort) {
	case 'relevance':
	case 'created':
	case 'updated':
	case 'action_on':
		break;

	case 'alpha':
		// @TODO is this useful ?
		break;

	case 'likes':
		// @TODO add where clause for likes orderings
		break;

	default:
		$sort = 'relevance';
		break;
}

// Order
$order = get_input('order', 'desc');
if ($order != 'asc' && $order != 'desc') {
	$order = 'desc';
}


// Dates filtering
$created_time_lower = get_input('created_time_lower', null);
$created_time_upper = get_input('created_time_upper', null);
$modified_time_lower = get_input('modified_time_lower', null);
$modified_time_upper = get_input('modified_time_upper', null);
// Convert time to timestamp if needed
if (!empty($created_time_lower) && strpos($created_time_lower, '-')) { $created_time_lower = strtotime($created_time_lower); }
if (!empty($created_time_upper) && strpos($created_time_upper, '-')) { $created_time_upper = strtotime($created_time_upper); }
if (!empty($modified_time_lower) && strpos($modified_time_lower, '-')) { $modified_time_lower = strtotime($modified_time_lower); }
if (!empty($modified_time_upper) && strpos($modified_time_upper, '-')) { $modified_time_upper = strtotime($modified_time_upper); }


// Get available types and subtypes filters + custom search types
$types = get_registered_entity_types();
$custom_types = elgg_trigger_plugin_hook('search_types', 'get_types', $params, array());

// Add advanced search & sorting tools - if enabled (don't break default behaviour/interface)
$advancedsearch = 'yes';
$advancedsearch_sidebar = 'yes';




// MAIN SEARCH PARAMS
$params = array(
//	'query' => $query,
	'offset' => $offset,
	'search_type' => $search_type,
	'type' => $entity_type,
	'subtype' => $entity_subtype,
//	'tag_type' => $tag_type,
//	'friends' => $friends
	'pagination' => $pagination,
	'advanced_pagination' => false, // Useless, as we display a limit select in form
//	'owner_guid' => $owner_guid,
//	'container_guid' => $container_guid,
	// Add date filtering
//	'created_time_lower' => $created_time_lower,
//	'created_time_upper' => $created_time_upper,
//	'modified_time_lower' => $modified_time_lower,
//	'modified_time_upper' => $modified_time_upper,
	'order' => $order,
	'sort' => $sort,
);


// Search filters : add them only if applicable ; will be passed to all searches params and will be used to build URLs
$add_if_nonempty = array('query', 'owner_guid', 'container_guid', 'limit', 'sort', 'order', 'created_time_lower', 'created_time_upper', 'modified_time_lower', 'modified_time_upper');
$filter_params = array();
foreach ($add_if_nonempty as $field) {
	if (!empty($$field)) { $filter_params[$field] = $$field; }
}
// Add filter params
$params = array_merge($params, $filter_params);
// Remove subtype filter if performing a tags search
if ($entity_subtype == 'search_type:tags') { $params['subtype'] = ELGG_ENTITIES_ANY_VALUE; }


// SEARCH - start the actual search
// Esope note : we allow empty query searches - enable to query using other filters
$results_html = '';
$custom_results_html = '';



// check that we have an actual query
//if (strlen($query) >= $min_chars) {
//if (empty($query)) {
//if (!empty($query) && in_array($search_type, array('all', 'entities'))) {
if (in_array($search_type, array('all', 'entities'))) {
	// to pass the correct current search type to the views
	$current_params = $params;
	$current_params['search_type'] = 'entities';

	// foreach through types.
	// if a plugin returns FALSE for subtype ignore it.
	// if a plugin returns NULL or '' for subtype, pass to generic type search function.
	// if still NULL or '' or empty(array()) no results found. (== don't show??)
	foreach ($types as $type => $subtypes) {
		if ($type != 'object') { continue; }
		$subtypes = array_unique($subtypes);
		if (is_array($subtypes) && count($subtypes)) {
			foreach ($subtypes as $subtype) {
				// no need to search if we're not interested in these results
				// @todo when using index table, allow search to get full count.
				if (($entity_subtype != 'search_type:tags') && !empty($entity_subtype) && ($entity_subtype != $subtype)) { continue; }
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
						$results_html .= elgg_view($view, array('results' => $results, 'params' => $current_params));
						$results_count += $results['count'];
					}
				}
			}
		}
	}
}




// Custom searches : always apply (eg. tags search should be triggered even for entities search)
//if ($search_type != 'entities' || $search_type == 'all') {
if (!empty($query) || $allow_empty_query) {
	if (is_array($custom_types)) {
		foreach ($custom_types as $type) {
			//if (($search_type != 'all') && ($search_type != $type)) { continue; }
			$current_params = $params;
			$current_params['search_type'] = $type;
			$current_params['type'] = null;
			$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());

			// someone is saying not to display these types in searches.
			if ($results === FALSE) { continue; }

			if (is_array($results['entities']) && $results['count'] > 0) {
				if ($view = search_get_search_view($current_params, 'list')) {
					$custom_results_html .= elgg_view($view, array('results' => $results, 'params' => $current_params));
					$results_count += $results['count'];
				}
			}
		}
	}
}
//}



// COMPOSE SEARCH RESULTS PAGE
$content = '';

// highlight search terms
if ($search_type == 'tags') {
	$searched_words = array($display_query);
} else {
	$searched_words = search_remove_ignored_words($display_query, 'array');
}


if (!empty($query) || $allow_empty_query) {
	$content .= '<div class="iris-search-sort">';
		// if ($results_count > 1) {} else {}
		// Total results count
		$content .= '<span class="iris-search-count">' . $results_count . ' ' . elgg_echo('theme_inria:objects') . '</span>';
		$order_opt = array(
				/*
				'relevance' => "Pertinence",
				'created' => "Date de création",
				'updated' => "Date de mise à jour",
				'action_on' => "Dernière action",
				'likes' => "Popularité",
				*/
				'relevance' => elgg_echo('search:sort:relevance'),
				'created' => elgg_echo('search:sort:created'),
				'updated' => elgg_echo('search:sort:updated'),
				'action_on' => elgg_echo('search:sort:action_on'),
				'likes' => elgg_echo('search:sort:likes') ." (@TODO)",
			);
			$order = 
		$content .= '<span class="iris-search-order">' . 'Trier par ' . elgg_view('input/select', array('name' => 'iris_objects_search_order', 'options_values' => $order_opt, 'value' => get_input('sort'))) . '</span>';
	$content .= '</div>';

	// Highlight search terms : only on plain text (strips tags)
	//$custom_results_html = search_get_highlighted_relevant_substrings($custom_results_html, $display_query);
	
	// Add results - If no result, say it !
	if (!empty($custom_results_html)) {
		$content .= '<div class="iris-search-tags">' . $custom_results_html . '</div>';
	}
	$content .= $results_html;
	if (!$results_html && !$custom_results_html) { $content .= elgg_view('search/no_results'); }

} else {
	/*
	// Too short ? is that relevant ?  we do perform some searches on less than that...
	if (strlen($query) < $min_chars) {
		$content .= '<p><em>' . elgg_echo('esope:search:tooshort:details', array($min_chars)) . '</em></p>';
	}
	*/
	$content .= '<p><em>' . elgg_echo('theme_inria:search:empty') . '</em></p>';
}




// Sidebar : add advanced search & sorting tools - if enabled (don't break default behaviour/interface)
// Add back subtype filter if performing a tags search
if ($entity_subtype == 'search_type:tags') { $params['subtype'] = 'search_type:tags'; }

$sidebar = elgg_view('search/advanced_search_filter', array(
		'search_params' => $params, 
		'types_list' => $types, 
		'custom_types_list' => $custom_types, 
	));



elgg_push_context('objects');
$layout = elgg_view_layout('iris_search', array(
		'filter' => 'search', 
		'title' => false,
		'q' => $query, 
		'params' => $params, 
		'content' => $content, 
		'sidebar' => $sidebar, 
	));

$title = elgg_echo('search:results', array("\"$display_query\""));
if (empty($query)) { $title = elgg_echo('esope:search'); }

echo elgg_view_page($title, $layout);

