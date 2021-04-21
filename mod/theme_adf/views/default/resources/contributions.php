<?php
// Contributions : recherche avancée et mise en avant de contenus

elgg_gatekeeper();

$user = elgg_get_logged_in_user_entity();


$title = 'Contributions';
$sidebar = null;
$content = '';

$content .= "<h1 style=\"color:#e57b5f;\">Contributions</h1>";

// Filtres de recherche avancés : dates, conteneur, auteur...
$subtypes = ['discussion', 'file', 'bookmark'];
$content .= elgg_list_entities([
	'type' => 'object', 
	'subtypes' => $subtypes, 
	'limit' => max(20, elgg_get_config('default_limit')),
	//'order_by' => ['e.time_created', 'desc'],
	//'container_guids' => $user_groups_guids_list,
	]);




echo elgg_view_page(null, [
	'title' => $title,
	'header' => false,
	'content' => $content,
	//'filter_value' => $page_filter,
	'sidebar' => $sidebar,
]);

