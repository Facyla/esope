<?php
/**
 * Elgg groups plugin everyone page
 *
 * @package ElggBookmarks
 */

elgg_set_context('groups');
elgg_push_context('search');

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb($owner->name);
*/
elgg_push_breadcrumb(elgg_echo('search'));


$title = '';
$content = '';
$sidebar = '';


$hide_directory = elgg_get_plugin_setting('hide_directory', 'esope');
if ($hide_directory == 'yes') { gatekeeper(); }

//elgg_require_js('elgg/spinner'); // @TODO make spinner work...

$sidebar .= elgg_view('esope/groups/search', $vars);


$content .= '<div class="iris-search-sort">';
	$num_groups = elgg_get_entities(array('type' => 'group', 'count' => true));
	$content .= '<span class="iris-search-count">' . $num_groups . ' ' . elgg_echo('groups') . '</span>';
	$order_opt = array(
			'alpha' => "Ordre alphabétique",
			'desc' => "Groupes les + récents",
			'asc' => "Groupes les + anciens",
			'popular' => "Avec le plus de membres",
		);
	$content .= '<span class="iris-search-order">' . 'Trier par ' . elgg_view('input/select', array('name' => 'iris_groups_search_order', 'options_values' => $order_opt)) . '</span>';
$content .= '</div>';

$content .= '<div id="esope-search-results">' . elgg_echo('esope:search:nosearch') . '</div>';



$body = elgg_view_layout('iris_search', array(
	'title' => false,
	'content' => $content,
	'sidebar' => $sidebar,
	'q' => get_input('q'),
	//'filter_context' => 'all',
	'filter' => false,
));

echo elgg_view_page($title, $body);

