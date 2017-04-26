<?php

gatekeeper();

$url = elgg_get_site_url();
$dbprefix = elgg_get_config('dbprefix');
$own = elgg_get_logged_in_user_entity();
inria_check_and_update_user_status('login:before', 'user', $own);


// Actualités - Le Fil
$thewire = '<h2>' . elgg_echo('theme_inria:topbar:news') . '<a href="' . $url . 'thewire/all" title="' . elgg_echo('theme_inria:thewire:tooltip') . '" class="float-alt view-all">&#9654; tout voir</a></h2>';
$thewire .= '<div class="iris-box home-wire">';
$thewire .= elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
$thewire  .= '<div class="clearfloat"></div>';
$thewire .= '</div>';
$thewire .= '<div class="iris-box home-wire">';
elgg_push_context('listing');
// Exclusion des messages du Fil provenant des groupes
$thewire_params = array(
		'type' => 'object', 'subtype' => 'thewire', 
		// This is for container filtering only, can be removed if no filtering
		//"joins" => array("INNER JOIN " . $dbprefix . "entities AS ce ON e.container_guid = ce.guid"),
		//"wheres" => array("ce.type != 'group'"), // avoid messages where container is a group
		'limit' => 7, 'pagination' => true
	);
$thewire .= elgg_list_entities($thewire_params);
elgg_pop_context();
$thewire .= '<div class="clearfloat"></div>';
$thewire .= '</div>';



// Ca bouge sur iris - Activité du site
// Only for subtype filtering
$site_activity = '<h2>' . elgg_echo('theme_inria:site:activity') . '<a href="' . $url . 'activity" title="' . elgg_echo('theme_inria:site:activity:tooltip') . '" class="float-alt view-all">&#9654; tout voir</a></h2>';
$site_activity .= '<div class="iris-box home-activity">';
elgg_push_context('search'); // Permet de ne pas interprêter les shortcodes, mais afficher les menus...
//$site_activity .= elgg_list_river(array('limit' => 3, 'pagination' => false, 'types' => array('object', 'group', 'site')));
// Content only
//$site_activity .= elgg_list_river(array('limit' => 6, 'pagination' => false, 'types' => array('object')));
// Custom action types filter + exclude Wire
// Available action types on Iris (20150807) : comment, join, reply, create, update, edit, friend
$action_types = array('create', 'comment', 'reply', 'update', 'edit');
$thewire_subtype_id = get_subtype_id('object', 'thewire');
$all_groups_guid_sql = "SELECT `guid` FROM `{$dbprefix}groups_entity`";
$site_activity .= elgg_list_river(array(
		'action_types' => $action_types, 
		// This is for subtype filtering only, can be removed if no filtering
		"joins" => array("INNER JOIN " . $dbprefix . "entities AS e ON rv.object_guid = e.guid"),
		// @TODO n'enlever que les messages du Fil hors groupe (lister guid des groupes avant)
		//"wheres" => array("e.subtype != " . $thewire_subtype_id), // filter some subtypes
		// exclude thewire objects, except those in groups
		"wheres" => array("(e.subtype != " . $thewire_subtype_id . ") OR (e.container_guid IN ($all_groups_guid_sql))"),
		'limit' => 5, 
		'pagination' => true, 
));
elgg_pop_context();
$site_activity  .= '<div class="clearfloat"></div>';
$site_activity .= '</div>';



$groups = '';
$groups .= '<h2>' . elgg_echo('theme_inria:topbar:groups') . '<a href="' . $url . 'groups/all" class="float-alt view-all">&#9654; tout voir</a></h2>';
$groups .= '<div class="iris-box">';
$groups .= elgg_view('theme_inria/my_groups');
$groups .= '<div class="clearfloat"></div>';
$groups .= '<br /><br />';
$groups .= elgg_view('theme_inria/discover_groups');
$groups .= '<div class="clearfloat"></div>';
$groups .= '</div>';

// Composition de la page
$body .= '<div class="iris-cols">
		<div class="home-static-container iris-col">
			' . $thewire . '
		</div>
		<div class="home-static-container iris-col">
			' . $groups . '
			' . $site_activity . '
		</div>
	</div>
	<div class="clearfloat"></div>';

// Tableau de bord personnalisable
//$body .= '<h2 class="hidden">' . elgg_echo('theme_inria:home:widgets') . '</h2>' . $widget_body;


// Fil d'Ariane
// Supprime le lien "main" (inexistant) de l'accueil
elgg_pop_breadcrumb();
// Supprime le lien vers l'accueil
elgg_pop_breadcrumb();

// Note : sidebar is not used, as the whole layout is defined on content $body
//$params = array('content' => $body, 'sidebar' => $sidebar, 'filter' => false);
$params = array('content' => $body, 'title' => false);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

