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
if (empty($entity_type)) { $entity_type = ELGG_ENTITIES_ANY_VALUE; }
if (empty($entity_subtype)) { $entity_subtype = ELGG_ENTITIES_ANY_VALUE; }

// Cannot search for "all" if type selected
if (!empty($entity_type)) { $search_type = 'entities'; }


$friends = get_input('friends', ELGG_ENTITIES_ANY_VALUE);

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

$owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE);
$owner_username = get_input('owner_username', false);
if ($owner_username) {
	$owner = get_user_by_username($owner_username);
	if (elgg_instanceof($owner, 'user')) {
		$owner_guid = $owner->guid;
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

// get limit and offset.  override if on search dashboard, where only 2
// of each most recent entity types will be shown.
if ($search_type == 'all') {
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
	case 'alpha':
		break;

	default:
		$sort = 'relevance';
		break;
}

// Order
$order = get_input('order', 'desc');
if (!in_array($order, array('asc', 'desc'))) { $order = 'desc'; }

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
$advancedsearch = elgg_get_plugin_setting('advancedsearch', 'esope');
$advancedsearch_sidebar = elgg_get_plugin_setting('advancedsearch_sidebar', 'esope');




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
);

// Search filters : add them only if applicable ; will be passed to all searches params and will be used to build URLs
$add_if_nonempty = array('query', 'owner_guid', 'container_guid', 'limit', 'sort', 'order', 'created_time_lower', 'created_time_upper', 'modified_time_lower', 'modified_time_upper');
$filter_params = array();
foreach ($add_if_nonempty as $field) {
	if (!empty($$field)) { $filter_params[$field] = $$field; }
}
// Add filter params
$params = array_merge($params, $filter_params);



/* SIDEBAR : SEARCH FILTERS */
// Remove sidebar if using advanced search
if (($advancedsearch != 'yes') || (($advancedsearch == 'yes') && ($advancedsearch_sidebar != 'yes'))) {
	
	// All results filter (no type and subtype filter)
	$search_params = array(
			'q' => $query,
			'entity_subtype' => ELGG_ENTITIES_NO_VALUE,
			'entity_type' => ELGG_ENTITIES_NO_VALUE,
			'search_type' => 'all',
			'friends' => $friends
		);
	// Add filter params
	$search_params = array_merge($search_params, $filter_params);
	// add sidebar items for all and native types
	// @todo should these maintain any existing type / subtype filters or reset?
	$data = htmlspecialchars(http_build_query($search_params));
	$url = elgg_get_site_url() . "search?$data";
	$menu_item = new ElggMenuItem('all', elgg_echo('all'), $url);
	// Facyla - set "All" selected if no filter set
	if ($search_type == 'all') { $menu_item->setSelected(); }
	elgg_register_menu_item('page', $menu_item);

	// List types and subtypes filters
	$search_params = array(
			'q' => $query,
			'entity_type' => ELGG_ENTITIES_ANY_VALUE,
			'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
			'search_type' => 'entities',
			'friends' => $friends
		);
	// Add filter params
	$search_params = array_merge($search_params, $filter_params);
	foreach ($types as $type => $subtypes) {
		// Type filter menu first
		$label = "item:$type";
		$current_params = $search_params;
		$current_params['entity_type'] = $type;
		$current_params['entity_subtype'] = ELGG_ENTITIES_ANY_VALUE;
		$data = htmlspecialchars(http_build_query($current_params));
		$url = elgg_get_site_url() . "search?$data";
		$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
		elgg_register_menu_item('page', $menu_item);
	
		// Subtype filters
		// @todo when using index table, can include result counts on each of these.
		if (is_array($subtypes) && count($subtypes)) {
			foreach ($subtypes as $subtype) {
				$label = "item:$type:$subtype";
				$current_params['entity_subtype'] = $subtype;
				$data = htmlspecialchars(http_build_query($current_params));
				$url = elgg_get_site_url()."search?$data";
				$menu_item = new ElggMenuItem($label, " &nbsp; &nbsp; " . elgg_echo($label), $url);
				elgg_register_menu_item('page', $menu_item);
			}
		}
	}

	// Custom search filters
	foreach ($custom_types as $type) {
		$label = "search_types:$type";
		$custom_params = array(
				'q' => $query,
				'search_type' => $type,
			);
		// Add filter params
		$custom_params = array_merge($custom_params, $filter_params);
		$data = htmlspecialchars(http_build_query($custom_params));
		$url = elgg_get_site_url()."search?$data";
		$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
		elgg_register_menu_item('page', $menu_item);
	}
	
}




// SEARCH - start the actual search
// Note : we allow empty query searches - enable to query using other filters
$results_html = '';

// check that we have an actual query
//if (strlen($query) >= $min_chars) {
//if (empty($query)) {
if ($search_type == 'all' || $search_type == 'entities') {
	// to pass the correct current search type to the views
	$current_params = $params;
	$current_params['search_type'] = 'entities';

	// foreach through types.
	// if a plugin returns FALSE for subtype ignore it.
	// if a plugin returns NULL or '' for subtype, pass to generic type search function.
	// if still NULL or '' or empty(array()) no results found. (== don't show??)
	foreach ($types as $type => $subtypes) {
		if (($search_type == 'entities') && ($entity_type != $type)) { continue; }
		
		if (is_array($subtypes) && count($subtypes)) {
			foreach ($subtypes as $subtype) {
				// no need to search if we're not interested in these results
				// @todo when using index table, allow search to get full count.
				if (($search_type == 'entities') && !empty($entity_subtype) && ($entity_subtype != $subtype)) { continue; }
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
					}
				}
			}
		}
	
		// Add default type entities with NO subtypes if any subtype is set (eg. "none"), 
		// or ANY subtype if no subtype filter specified
		if (empty($entity_subtype) && ($type != 'object')) {
			$current_params['type'] = $type;
			$current_params['subtype'] = ELGG_ENTITIES_NO_VALUE;
			if (empty($entity_subtype)) { $current_params['subtype'] = ELGG_ENTITIES_ANY_VALUE; }
			$results = false;
			// Do not search groups inside a group container
			if (!(elgg_instanceof($container, 'group') && ($type == 'group'))) {
				$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
			}
			// someone is saying not to display these types in searches.
			if ($results === FALSE) { continue; }
			if (is_array($results['entities']) && $results['count']) {
				if ($view = search_get_search_view($current_params, 'list')) {
					$results_html .= elgg_view($view, array('results' => $results, 'params' => $current_params));
				}
			}
		}
		
	}
}

// Custom searches
if ($search_type != 'entities' || $search_type == 'all') {
	if (is_array($custom_types)) {
		foreach ($custom_types as $type) {
			if (($search_type != 'all') && ($search_type != $type)) { continue; }
			$current_params = $params;
			$current_params['search_type'] = $type;
			$results = elgg_trigger_plugin_hook('search', $type, $current_params, array());

			// someone is saying not to display these types in searches.
			if ($results === FALSE) { continue; }

			if (is_array($results['entities']) && $results['count']) {
				if ($view = search_get_search_view($current_params, 'list')) {
					$results_html .= elgg_view($view, array('results' => $results, 'params' => $current_params));
				}
			}
		}
	}
}




// COMPOSE SEARCH RESULTS PAGE

// highlight search terms
if ($search_type == 'tags') {
	$searched_words = array($display_query);
} else {
	$searched_words = search_remove_ignored_words($display_query, 'array');
}

// Page title
if (!empty($query)) {
	$highlighted_query = search_highlight_words($searched_words, $display_query);
	$body = elgg_view_title(elgg_echo('search:results', array("\"$highlighted_query\"")));
} else {
	$body  .= elgg_view_title(elgg_echo('search:results:no_query'));
}
// Too short ? is that relevant ?  we do perform some searches on less than that...
/*
if (strlen($query) < $min_chars) {
	$body .= '<p><em>' . elgg_echo('esope:search:tooshort:details', array($min_chars)) . '</em></p>';
}
*/

// Add advanced search & sorting tools - if enabled (don't break default behaviour/interface)
if ($advancedsearch == 'yes') {
	$as_params['search_params'] = $params;
	$as_params['types_list'] = $types;
	$as_params['custom_types_list'] = $custom_types;
	$advanced_search = elgg_view('search/advanced_search_filter', $as_params);
	if ($advancedsearch_sidebar != 'yes') { $body .= $advanced_search; }
}

// Add results - If no result, say it !
$body .= $results_html;
if (!$results_html) { $body .= elgg_view('search/no_results'); }


// this is passed the original params because we don't care what actually
// matched (which is out of date now anyway).
// we want to know what search type it is.
$layout_view = search_get_search_view($params, 'layout');
if (($advancedsearch == 'yes') && ($advancedsearch_sidebar == 'yes')) {
	$layout = elgg_view_layout('one_sidebar', array('params' => $params, 'content' => $body, 'sidebar' => $advanced_search));
} else {
	$layout = elgg_view($layout_view, array('params' => $params, 'body' => $body));
}


$title = elgg_echo('search:results', array("\"$display_query\""));
if (empty($query)) { $title = elgg_echo('esope:search'); }

echo elgg_view_page($title, $layout);

