<?php

gatekeeper();

$url = elgg_get_site_url();
$dbprefix = elgg_get_config('dbprefix');
$own = elgg_get_logged_in_user_entity();
inria_check_and_update_user_status('login:before', 'user', $own);


// Slider
/*
$slider_params = array('width' => '100%', 'height' => '300px');
$slider = elgg_view('slider/slider', $slider_params);
*/
$slider_guid = elgg_get_plugin_setting('home_slider', 'theme_inria');
$slider = '';
if (elgg_is_admin_logged_in()) {
	$slider .= '<p><i class="fa fa-cogs"></i> &nbsp; ';
	$slider .= '<a href="' . $url . 'admin/plugin_settings/theme_inria" class="elgg-button elgg-button-action">' . elgg_echo('theme_inria:homeslider:select') . ' (' . $slider_guid . ')</a> &nbsp; ';
	if (!empty($slider_guid)) {
		$slider .= '<a href="' . $url . 'slider/edit/' . $slider_guid . '" class="elgg-button elgg-button-action">' . elgg_echo('theme_inria:homeslider:edit') . '</a>';
	}
	$slider .= '</p>';
}
$slider .= elgg_view('slider/view', array('guid' => $slider_guid));



// Activité du site
// Only for subtype filtering
$site_activity = '<h2><a href="' . $url . 'activity" title="' . elgg_echo('theme_inria:site:activity:tooltip') . '">' . elgg_echo('theme_inria:site:activity') . '<span style="float:right;">&#9654;</span></a></h2>';
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

// Le Fil
$thewire = '<h2><a href="' . $url . 'thewire/all" title="' . elgg_echo('theme_inria:thewire:tooltip') . '">' . elgg_echo('theme_inria:thewire:title') . '<span style="float:right;">&#9654;</span></a></h2>';
//$thewire .= '<em style="float:right;">' . elgg_echo('theme_inria:thewire:details') . '</em>';
$thewire .= elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
//elgg_push_context('widgets');
elgg_push_context('listing');
// Exclusion des messages du Fil provenant des groupes
$thewire_params = array(
		'type' => 'object', 'subtype' => 'thewire', 
		// This is for container filtering only, can be removed if no filtering
		"joins" => array("INNER JOIN " . $dbprefix . "entities AS ce ON e.container_guid = ce.guid"),
		"wheres" => array("ce.type != 'group'"), // avoid messages where container is a group
		'limit' => 7, 'pagination' => true
	);
$thewire .= elgg_list_entities($thewire_params);
elgg_pop_context();



// Composition de la page
// Activité et Fil
$body .= '<div style="display:flex; flex-direction:row; flex-wrap: wrap;">
		<div style="flex:1; padding: 0 2em; max-width: 420px; margin: 0 auto;" class="home-static-container">
			<h2>' . elgg_echo('theme_inria:topbar:news') . '</h2><div class="home-box home-wire">' . $thewire . '</div>
		</div>
		<div style="flex:1; padding: 0 2em; max-width: 420px; margin: 0 auto;" class="home-static-container">
			<h2>' . elgg_echo('theme_inria:topbar:groups') . '</h2><div class="home-box">' . elgg_view('theme_inria/newest_groups') . elgg_view('theme_inria/featured_groups') . '</div>
			<h2>' . elgg_echo('river:all') . '</h2><div class="home-box home-activity">' . $site_activity . '</div></div>
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

