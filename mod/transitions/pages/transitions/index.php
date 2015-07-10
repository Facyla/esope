<?php
/**
 * Transitions² public homepage
 *
 */

// no RSS feed with a "widget" front page
/*
global $autofeed;
$autofeed = FALSE;
*/


$content = '';
$title = elgg_echo('transitions:index');
$sidebar = '';

$category = get_input('category', '');
if ($category == 'all') $category = '';
$actor_type = get_input('actor_type', '');
if ($actor_type == 'all') $actor_type = '';
$query = get_input('q', '');


$quickform = '<div class="transitions-gallery-quickform">';
$quickform .= '<div class="transitions-gallery-item">';
$quickform .= '<p>Racontez-nous votre transition, partagez une ressource pour le catalogue !</p>';
if (elgg_is_logged_in()) {
	//$content .= '<a href="' . elgg_get_site_url() . 'transitions/add/' . elgg_get_logged_in_user_guid() . '" class="elgg-button elgg-button-action">Contribuez</a>';
	// Quick contribution form
	$quickform .= elgg_view_form('transitions/quickform');
} else {
	$quickform .= '<a href="' . elgg_get_site_url() . 'register" class="elgg-button elgg-button-action">Contribuez</a>';
}
$quickform .= '</div>';
$quickform .= '</div>';


// RECHERCHE
$search = elgg_view('theme_transitions2/search');
$content .= elgg_view_module('aside', 'Recherchez une ressource', $search);
$content .= '<div class="clearfloat"></div>';

$search_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'count' => true);

if (!empty($category)) {
	$search_options['metadata_name_value_pairs'][] = array('name' => 'category', 'value' => $category);
}
if (!empty($actor_type)) {
	$search_options['metadata_name_value_pairs'][] = array('name' => 'actor_type', 'value' => $actor_type);
}
if (!empty($query)) {
	$db_prefix = elgg_get_config('dbprefix');
	$search_options['joins'][] = "JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid";
	$search_options['wheres'][] = "(oe.title LIKE '%$query%') OR (oe.description LIKE '%$query%')";
}
echo print_r($search_options, true);
if (isset($search_options['metadata_name_value_pairs'])) {
	$count = elgg_get_entities_from_metadata($search_options);
	$catalogue = elgg_list_entities_from_metadata($search_options);
} else {
	$count = elgg_get_entities($search_options);
	$catalogue = elgg_list_entities($search_options);
}
$content .= '<div id="transitions">';
$content .= $quickform;
$content .= $catalogue;
$content .= '</div>';


$content = elgg_view_layout('one_column', array('content' => $content));

echo elgg_view_page($title, $content);
