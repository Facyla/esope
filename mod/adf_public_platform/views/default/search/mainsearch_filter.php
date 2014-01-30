<?php
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


$sort_options = array('relevance', 'created', 'updated', 'alpha', 'action_on');
$order_options = array('desc', 'asc');

echo '<div class="search-filter-menu">';
foreach($sort_options as $sort_opt) {
	foreach($order_options as $order_opt) {
		$class = '';
		if (($sort_opt == $vars['sort']) && ($order_opt == $vars['order'])) $class = ' selected';
		echo '<a href="' . $vars['base_url'] . '&sort=' . $sort_opt . '&order=' . $order_opt . '"  class="' . $class . '"">' . $sort_opt . ' ' . $order_opt . '</a>';
	}
}
echo '</div>';


// @TODO build an advanced seearch interface through a GET form


