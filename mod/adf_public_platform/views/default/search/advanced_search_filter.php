<?php
$sort_options = array(
		'relevance' => 'search:sort:relevance', 
		'created' => 'search:sort:created', 
		'updated' => 'search:sort:updated', 
		'alpha' => 'search:sort:alpha', 
		'action_on' => 'search:sort:action_on',
	);
$order_options = array(
		'desc' => 'search:order:desc', 
		'asc' => 'search:order:asc', 
	);


/*
// ADVANCED SEARCH LINK MODE
// Build base URL
$base_search_url = elgg_get_site_url().'search?' . htmlspecialchars(http_build_query(array(
	'q' => $vars['query'],
	'offset' => $vars['offset'],
	'limit' => $vars['limit'],
	'sort' => $vars['sort'],
	'order' => $vars['order'],
	'search_type' => $vars['search_type'],
	'type' => $vars['type'],
	'subtype' => $vars['subtype'],
	'owner_guid' => $vars['owner_guid'],
	'container_guid' => $vars['container_guid'],
	'created_time_lower' => $vars['created_time_lower'],
	'created_time_upper' => $vars['created_time_upper'],
	'modified_time_lower' => $vars['modified_time_lower'],
	'modified_time_upper' => $vars['modified_time_upper'],
)));

echo '<div class="search-filter-menu">';
foreach($sort_options as $sort_opt => $sort_name) {
	foreach($order_options as $order_opt => $order_name) {
		$class = '';
		if (($sort_opt == $vars['sort']) && ($order_opt == $vars['order'])) $class = ' selected';
		echo '<a href="' . $vars['base_url'] . '&sort=' . $sort_opt . '&order=' . $order_opt . '"  class="' . $class . '"">' . $sort_opt . ' ' . $order_opt . '</a>';
	}
}
echo '</div>';
*/



// ADVANCED SEARCH FORM INTERFACE
// @TODO build an advanced seearch interface through a GET form
echo '<form method="GET" action="' . $vars['url'] . 'search" id="advanced-search-form">';
echo '<fieldset>';
echo '<legend>Advanced search</legend>';
echo elgg_view('input/securitytokens');
echo elgg_view('input/hidden', array('name' => 'offset', 'value' => $vars['offset']));
echo elgg_view('input/hidden', array('name' => 'limit', 'value' => $vars['limit']));

if (!empty($vars['type'])) echo elgg_view('input/hidden', array('name' => 'type', 'value' => $vars['type']));
if (!empty($vars['subtype'])) echo elgg_view('input/hidden', array('name' => 'subtype', 'value' => $vars['subtype']));
if (!empty($vars['owner_guid'])) echo elgg_view('input/hidden', array('name' => 'owner_guid', 'value' => $vars['owner_guid']));
if (!empty($vars['container_guid'])) echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $vars['container_guid']));
if (!empty($vars['search_type'])) echo elgg_view('input/hidden', array('name' => 'search_type', 'value' => $vars['search_type']));

echo '<p><label>Sort type : ' . elgg_view('input/dropdown', array('name' => 'sort', 'options_values' => $sort_options, 'value' => $vars['sort'])) . '</label> &nbsp; &nbsp; ';
echo '<label>Order results : ' . elgg_view('input/dropdown', array('name' => 'order', 'options_values' => $order_options, 'value' => $vars['order'])) . '</label></p>';

echo '<p><label>Creation date (after) : ' . elgg_view('event_calendar/input/date_local', array('name' => 'created_time_lower', 'value' => $vars['created_time_lower'])) . '</label> &nbsp; &nbsp; ';
echo '<label>Creation date (before) : ' . elgg_view('event_calendar/input/date_local', array('name' => 'created_time_upper', 'value' => $vars['created_time_upper'])) . '</label></p>';
echo '<p><label>Modification date (after) : ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_lower', 'value' => $vars['modified_time_lower'])) . '</label> &nbsp; &nbsp; ';
echo '<label>Modification date (after) : ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_upper', 'value' => $vars['modified_time_upper'])) . '</label></p>';

echo '<p><label>Search text : ' . elgg_view('input/text', array('name' => 'q', 'value' => $vars['query'])) . '</label></p>';

echo '<p><label>' . elgg_view('input/submit', array('value' => elgg_echo('search'))) . '</label></p>';

echo '</fieldset>';
echo '</form>';

