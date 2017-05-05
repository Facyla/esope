<?php

//elgg_require_js('elgg.esope');
elgg_load_js('elgg.esope');

$sort_options = array(
		'relevance' => elgg_echo('search:sort:relevance'),
		'created' => elgg_echo('search:sort:created'),
		'updated' => elgg_echo('search:sort:updated'),
		'alpha' => elgg_echo('search:sort:alpha'),
		'action_on' => elgg_echo('search:sort:action_on'),
		'likes' => elgg_echo('search:sort:likes'),
	);

$order_options = array(
		'desc' => elgg_echo('search:order:desc'),
		'asc' => elgg_echo('search:order:asc'),
	);

// Type & subtype filters
$subtype_options[ELGG_ENTITIES_ANY_VALUE] = elgg_echo('esope:option:nofilter');

$types_list = elgg_extract('types_list', $vars, false);
if ($types_list) {
	foreach ($types_list as $type => $subtypes) {
		if ($type == 'object') {
			if (is_array($subtypes) && sizeof($subtypes) > 0) {
				foreach ($subtypes as $subtype) {
					$subtype_options[$subtype] = elgg_echo("item:$type:$subtype");
				}
			}
		}
	}
}

// Extract all search params
$params = elgg_extract('search_params', $vars);
//echo '<pre>' . print_r($params, true) . '</pre>';


// Convert time to timestamp if needed
if (!empty($params['created_time_lower']) && strpos('-', $params['created_time_lower'])) { $params['created_time_lower'] = strtotime($params['created_time_lower']); }
if (!empty($params['created_time_upper']) && strpos('-', $params['created_time_upper'])) { $params['created_time_upper'] = strtotime($params['created_time_upper']); }
if (!empty($params['modified_time_lower']) && strpos('-', $params['modified_time_lower'])) { $params['modified_time_lower'] = strtotime($params['modified_time_lower']); }
if (!empty($params['modified_time_upper']) && strpos('-', $params['modified_time_upper'])) { $params['modified_time_upper'] = strtotime($params['modified_time_upper']); }


/*
// ADVANCED SEARCH LINK MODE
// Build base URL
$base_search_url = elgg_get_site_url().'search?' . htmlspecialchars(http_build_query(array(
	'q' => $params['query'],
	'offset' => $params['offset'],
	'limit' => $params['limit'],
	'sort' => $params['sort'],
	'order' => $params['order'],
	'search_type' => $params['search_type'],
	'type' => $params['type'],
	'subtype' => $params['subtype'],
	'owner_guid' => $params['owner_guid'],
	'container_guid' => $params['container_guid'],
	'created_time_lower' => $params['created_time_lower'],
	'created_time_upper' => $params['created_time_upper'],
	'modified_time_lower' => $params['modified_time_lower'],
	'modified_time_upper' => $params['modified_time_upper'],
)));

echo '<div class="search-filter-menu">';
foreach($sort_options as $sort_opt => $sort_name) {
	foreach($order_options as $order_opt => $order_name) {
		$class = '';
		if (($sort_opt == $params['sort']) && ($order_opt == $params['order'])) $class = ' selected';
		echo '<a href="' . $params['base_url'] . '&sort=' . $sort_opt . '&order=' . $order_opt . '"  class="' . $class . '"">' . $sort_opt . ' ' . $order_opt . '</a>';
	}
}
echo '</div>';
*/

//echo '<pre>' . print_r($params, true) . '</pre>'; // debug

// ADVANCED SEARCH FORM INTERFACE
// Advanced search interface usable through a GET form
echo '<form method="GET" action="' . elgg_get_site_url() . 'search" id="advanced-search-form">';
echo '<fieldset>';
echo '<legend>' . elgg_echo('esope:advancedsearch'). '</legend>';
echo elgg_view('input/securitytokens');

// Fulltext search
//echo '<p><label>' . elgg_echo('search:field:fulltext') . ' ' . elgg_view('input/text', array('name' => 'q', 'value' => $params['query'])) . '</label>';
echo elgg_view('input/hidden', array('name' => 'q', 'value' => $params['query']));
echo elgg_view('input/submit', array('value' => elgg_echo('search'), 'class' => "elgg-button elgg-button-submit advanced-search-submit-top")) . '</p>';


// Search types, type & subtypes : use explicit select or hidden inputs (not both !)
// @TODO add some coherence checks, ie force search_types to entities if type and/or subtype is selected
//echo '<p><label>' . elgg_echo('search:field:searchtype') . ' ' . elgg_view('input/select', array('name' => 'search_type', 'options_values' => $searchtype_options, 'value' => $params['search_type'])) . '</label> &nbsp; &nbsp; ';
echo elgg_view('input/hidden', array('name' => 'search_type', 'value' => 'all'));
//echo '<label>' . elgg_echo('search:field:type') . ' ' . elgg_view('input/select', array('name' => 'entity_type', 'options_values' => $type_options, 'value' => $params['type'])) . '</label> &nbsp; &nbsp; ';
echo elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'object'));
//echo '<label>' . elgg_echo('search:field:subtype') . ' ' . elgg_view('input/select', array('name' => 'entity_subtype', 'options_values' => $subtype_options, 'value' => $params['subtype'])) . '</label></p>';
echo '<label>' . elgg_echo('search:field:subtype') . ' ' . elgg_view('input/radio', array('name' => 'entity_subtype', 'options' => array_flip($subtype_options), 'value' => $params['subtype'], 'onChange' => "$('#advanced-search-form').submit();")) . '</label></p>';



// Date filters
/*
echo '<p><strong>' . elgg_echo('search:field:createdtime') . '</strong> <label><i class="fa fa-calendar"></i> ' . elgg_view('input/date', array('name' => 'created_time_lower', 'value' => $params['created_time_lower'], 'timestamp' => true)) . ' ' . elgg_echo('search:field:date:lower') . ' </label> &nbsp; &nbsp; ';
echo '<label><i class="fa fa-calendar"></i> ' . elgg_view('event_calendar/input/date_local', array('name' => 'created_time_upper', 'value' => $params['created_time_upper'], 'timestamp' => true)) . ' ' . elgg_echo('search:field:date:upper') . '</label>';
//echo ' &nbsp; &nbsp; ';
echo '</p><p>';
echo '<strong>' . elgg_echo('search:field:modifiedtime') . '</strong> <label><i class="fa fa-calendar"></i> ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_lower', 'value' => $params['modified_time_lower'], 'timestamp' => true)) . ' ' . elgg_echo('search:field:date:lower') . '</label> &nbsp; &nbsp; ';
echo '<label><i class="fa fa-calendar"></i> ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_upper', 'value' => $params['modified_time_upper'], 'timestamp' => true)) . ' ' . elgg_echo('search:field:date:upper') . '</label></p>';
*/


// Extra fields, displayed only if not empty
// @TODO : filtre avec sélecteur ? ou autocomplete ? ou valeur libre ?

// Owner search : site, group, user
if (!empty($params['owner_guid'])) {
	$owner = get_entity($params['owner_guid']);
	echo '<p><label>' . elgg_echo('search:field:owner_guid') . ' ' . elgg_view('input/select', array('name' => 'owner_guid', 'value' => $params['owner_guid'], 'options_values' => array('' => elgg_echo('option:none'), $params['owner_guid'] => $owner->name))) . '</label>';
} else {
	//echo elgg_view('input/hidden', array('name' => 'owner_guid', 'value' => $params['owner_guid']));
}

// Container search : site, group, user
if (!empty($params['container_guid'])) {
	$container = get_entity($params['container_guid']);
	echo '<p><label>' . elgg_echo('search:field:container_guid') . ' ' . elgg_view('input/select', array('name' => 'container_guid', 'value' => $params['container_guid'], 'options_values' => array('' => elgg_echo('option:none'), $params['container_guid'] => $container->name))) . '</label>';
} else {
	//echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $params['container_guid']));
}

// Limit, sort, and order
echo '<p>';
$limit_opt = array(2, 10, 30, 100);
if (!in_array($params['limit'], $limit_opt)) { $limit_opt[] = $params['limit']; }
$default_limit = elgg_get_config('default_limit');
if (!in_array($default_limit, $limit_opt)) { $limit_opt[] = $default_limit; }
sort($limit_opt);
//echo elgg_view('input/hidden', array('name' => 'limit', 'value' => $params['limit']));
//echo '<label>' . elgg_echo('search:field:limit') . ' ' . elgg_view('input/select', array('name' => 'limit', 'value' => $params['limit'], 'options' => $limit_opt)) . '</label> &nbsp; ';
//echo '<label>' . elgg_echo('search:field:sort') . ' ' . elgg_view('input/select', array('name' => 'sort', 'options_values' => $sort_options, 'value' => $params['sort'])) . '</label> &nbsp; ';
echo elgg_view('input/hidden', array('name' => 'sort', 'value' => $params['sort']));
echo elgg_view('input/hidden', array('name' => 'order', 'value' => $params['order']));
//echo '<label>' . elgg_echo('search:field:order') . ' ' . elgg_view('input/select', array('name' => 'order', 'options_values' => $order_options, 'value' => $params['order'])) . '</label> &nbsp; ';
echo '</p>';
// Offset (keep hidden as we have pagination)
echo elgg_view('input/hidden', array('name' => 'offset', 'value' => $params['offset']));

echo elgg_view('input/submit', array('value' => elgg_echo('search'), 'class' => "elgg-button elgg-button-submit advanced-search-submit-bottom")) . '</p>';

echo '</fieldset>';
echo '</form>';

