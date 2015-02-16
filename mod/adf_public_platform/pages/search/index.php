<?php
/**
 * Elgg search page
 *
 * @todo much of this code should be pulled out into a library of functions
 */

// Search supports RSS
global $autofeed;
$autofeed = true;

// $search_type == all || entities || trigger plugin hook
$search_type = get_input('search_type', 'all');

// @todo there is a bug in get_input that makes variables have slashes sometimes.
// @todo is there an example query to demonstrate ^
// XSS protection is more important that searching for HTML.
$query = stripslashes(get_input('q', get_input('tag', '')));
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
	
	$body  = elgg_view_title(elgg_echo('search:search_error'));
	$body .= elgg_echo('search:no_query');
	$layout = elgg_view_layout('one_sidebar', array('content' => $body));
	echo elgg_view_page($title, $layout);

	return;
}

// get limit and offset.  override if on search dashboard, where only 2
// of each most recent entity types will be shown.
$offset = get_input('offset', 0);
if ($search_type == 'all') {
	$limit = get_input('limit', 2);
} else {
	$limit = get_input('limit', 10);
}

$entity_type = get_input('entity_type', ELGG_ENTITIES_ANY_VALUE);
$entity_subtype = get_input('entity_subtype', ELGG_ENTITIES_ANY_VALUE);
$owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE);
//$container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);
$friends = get_input('friends', ELGG_ENTITIES_ANY_VALUE);

// Sort
$sort = get_input('sort');
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
if (strpos('-', $created_time_lower)) { $created_time_lower = strtotime($created_time_lower); }
if (strpos('-', $created_time_upper)) { $created_time_upper = strtotime($created_time_upper); }
if (strpos('-', $modified_time_lower)) { $modified_time_lower = strtotime($modified_time_lower); }
if (strpos('-', $modified_time_lower)) { $modified_time_upper = strtotime($modified_time_upper); }


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
	// Add date filtering
	'created_time_lower' => $created_time_lower,
	'created_time_upper' => $created_time_upper,
	'modified_time_lower' => $modified_time_lower,
	'modified_time_upper' => $modified_time_upper,
);



/* SIDEBAR */
$types = get_registered_entity_types();
$custom_types = elgg_trigger_plugin_hook('search_types', 'get_types', $params, array());

// add sidebar items for all and native types
// @todo should these maintain any existing type / subtype filters or reset?
$data = htmlspecialchars(http_build_query(array(
	'q' => $query,
	'entity_subtype' => $entity_subtype,
	'entity_type' => $entity_type,
	'owner_guid' => $owner_guid,
	'container_guid' => $container_guid,
	'search_type' => 'all',
	//'friends' => $friends
)));
$url = elgg_get_site_url() . "search?$data";
$menu_item = new ElggMenuItem('all', elgg_echo('all'), $url);
if ($search_type == 'all') $menu_item->setSelected(); // Facyla - set selected if no filter set
elgg_register_menu_item('page', $menu_item);

foreach ($types as $type => $subtypes) {
	// @todo when using index table, can include result counts on each of these.
	if (is_array($subtypes) && count($subtypes)) {
		foreach ($subtypes as $subtype) {
			$label = "item:$type:$subtype";

			$data = htmlspecialchars(http_build_query(array(
				'q' => $query,
				'entity_subtype' => $subtype,
				'entity_type' => $type,
				'owner_guid' => $owner_guid,
				'container_guid' => $container_guid,
				'search_type' => 'entities',
				'friends' => $friends
			)));

			$url = elgg_get_site_url()."search?$data";
			$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
			elgg_register_menu_item('page', $menu_item);
		}
	} else {
		$label = "item:$type";

		$data = htmlspecialchars(http_build_query(array(
			'q' => $query,
			'entity_type' => $type,
			'owner_guid' => $owner_guid,
			'container_guid' => $container_guid,
			'search_type' => 'entities',
			'friends' => $friends
		)));

		$url = elgg_get_site_url() . "search?$data";

		$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
		elgg_register_menu_item('page', $menu_item);
	}
}

// add sidebar for custom searches
foreach ($custom_types as $type) {
	$label = "search_types:$type";

	$data = htmlspecialchars(http_build_query(array(
		'q' => $query,
		'search_type' => $type,
		// Esope : Add owner and container filtering
		'owner_guid' => $owner_guid,
		'container_guid' => $container_guid,
		'friends' => $friends
	)));

	$url = elgg_get_site_url()."search?$data";

	$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
	elgg_register_menu_item('page', $menu_item);
}



/* SEARCH */
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
		if ($search_type != 'all' && $entity_type != $type) {
			continue;
		}

		if (is_array($subtypes) && count($subtypes)) {
			foreach ($subtypes as $subtype) {
				// no need to search if we're not interested in these results
				// @todo when using index table, allow search to get full count.
				if ($search_type != 'all' && $entity_subtype != $subtype) {
					continue;
				}
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
						$results_html .= elgg_view($view, array(
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
		if ($results === FALSE) {
			// someone is saying not to display these types in searches.
			continue;
		}

		if (is_array($results['entities']) && $results['count']) {
			if ($view = search_get_search_view($current_params, 'list')) {
				$results_html .= elgg_view($view, array(
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
			if ($search_type != 'all' && $search_type != $type) {
				continue;
			}

			$current_params = $params;
			$current_params['search_type'] = $type;

			$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());

			if ($results === FALSE) {
				// someone is saying not to display these types in searches.
				continue;
			}

			if (is_array($results['entities']) && $results['count']) {
				if ($view = search_get_search_view($current_params, 'list')) {
					$results_html .= elgg_view($view, array(
						'results' => $results,
						'params' => $current_params,
					));
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

$body = elgg_view_title(elgg_echo('search:results', array("\"$highlighted_query\"")));


// Add advanced search & sorting tools - if enabled (don't break default behaviour/interface)
$advancedsearch = elgg_get_plugin_setting('advancedsearch', 'adf_public_platform');
$params['types_list'] = $types;
$params['custom_types_list'] = $custom_types;
if ($advancedsearch == 'yes') {
	$body .= elgg_view('search/advanced_search_filter', $params);
}


// No result : say it !
if (!$results_html) {
	$body .= elgg_view('search/no_results');
} else {
	$body .= $results_html;
}


// this is passed the original params because we don't care what actually
// matched (which is out of date now anyway).
// we want to know what search type it is.
$layout_view = search_get_search_view($params, 'layout');
$layout = elgg_view($layout_view, array('params' => $params, 'body' => $body));

$title = elgg_echo('search:results', array("\"$display_query\""));

echo elgg_view_page($title, $layout);

