<?php
global $CONFIG;

gatekeeper();

$url = elgg_get_site_url();
$dbprefix = elgg_get_config('dbprefix');

$own = elgg_get_logged_in_user_entity();
inria_check_and_update_user_status('login', 'user', $own);


// Slider
$slider_params = array('width' => '100%', 'height' => '300px');
$slider = elgg_view('slider/slider', $slider_params);


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
$site_activity .= elgg_list_river(array(
		'action_types' => $action_types, 
		// This is for subtype filtering only, can be removed if no filtering
		"joins" => array("INNER JOIN " . $dbprefix . "entities AS e ON rv.object_guid = e.guid"),
		"wheres" => array("e.subtype != " . $thewire_subtype_id), // filter some subtypes
		'limit' => 6, 
		'pagination' => false, 
));
elgg_pop_context();

// Le Fil
$thewire = '<h2><a href="' . $url . 'thewire/all" title="' . elgg_echo('theme_inria:thewire:tooltip') . '">' . elgg_echo('theme_inria:thewire:title') . '<span style="float:right;">&#9654;</span></a></h2>';
//$thewire .= '<em style="float:right;">' . elgg_echo('theme_inria:thewire:details') . '</em>';
$thewire .= elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
//elgg_push_context('widgets');
// Exclusion des messages du Fil provenant des groupes
$thewire_params = array(
		'type' => 'object', 'subtype' => 'thewire', 
		// This is for container filtering only, can be removed if no filtering
		"joins" => array("INNER JOIN " . $dbprefix . "entities AS ce ON e.container_guid = ce.guid"),
		"wheres" => array("ce.type != 'group'"), // avoid messages where container is a group
		'limit' => 5, 'pagination' => false
	);
$thewire .= elgg_list_entities($thewire_params);
//elgg_pop_context();

// Tableau de bord
// Note : il peut être intéressant de reprendre le layout des widgets si on veut séparer les colonnes et les intégrer dans l'interface
elgg_set_context('dashboard');
elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
// Pour afficher un bloc sur 2 colonnes, on utilise la partie content
$params = array( 'content' => '', 'num_columns' => 3, 'show_access' => false);
$widget_body = elgg_view_layout('widgets', $params);


// Composition de la page
// Slider et barre latérale droite : groupes et membres
$body = '
	<div style="width:76%; float:left;">
		<div style="padding: 0 26px 26px 13px;">
			<div style="width:100%;" class="iris-news">'
				//. '<h2 class="hidden">' . elgg_echo('theme_inria:home:edito') . '</h2>' . $intro . '<div class="clearfloat"></div>'
				. $slider . '
			</div>
		</div>
	</div>
	
	<div style="width:22%; float:right;">
		<h2 class="hidden">' . elgg_echo('theme_inria:home:information') . '</h2>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_inria/featured_groups') . '</div>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_inria/users/online', array('limit' => 30)) . '</div>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_inria/users/newest') . '</div>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_inria/newest_groups') . '</div>
	</div>
	<div class="clearfloat"></div>';

// Activité et Fil
$body .= '<div style="width:40%; float:left;">
		<div class="home-box home-activity">' . $site_activity . '</div>
	</div>
	<div style="width:57%; float:right;">
		<div class="home-box home-wire">' . $thewire . '</div>
	</div>
	<div class="clearfloat"></div>';

// Tableau de bord personnalisable
$body .= '<h2 class="hidden">' . elgg_echo('theme_inria:home:widgets') . '</h2>
	' . $widget_body;


// Fil d'Ariane
// Supprime le lien "main" (inexistant) de l'accueil
elgg_pop_breadcrumb();
// Supprime le lien vers l'accueil
elgg_pop_breadcrumb();


// Note : sidebar is not used, as the whole layout is defined on content $body
//$params = array('content' => $body, 'sidebar' => $sidebar, 'filter' => false);
$params = array('content' => $body);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

