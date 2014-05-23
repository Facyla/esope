<?php
global $CONFIG;

gatekeeper();

$own = elgg_get_logged_in_user_entity();
$urlimg = $CONFIG->url;
$urlimg = $url . 'mod/theme_cocon/graphics/';
$urlpictos = $urlimg . 'pictos/';

// Premiers pas : s'affiche au début, peut être désactivé
/* Pas utilisé car remplacé par un menu configurable
$firststeps = '';
// Masqué ou réaffiché sur demande
$hide_firststeps = get_input('firststeps', false);
if ($hide_firststeps == 'hide') { $own->hide_firststeps = 'yes'; } 
else if ($hide_firststeps == 'show') { $own->hide_firststeps = 'no'; }
// Affiché jusqu'à ce qu'on demande à le masquer
if ($own->hide_firststeps != 'yes') {
	$firststeps = elgg_view('cmspages/view', array('pagetype' => 'premiers-pas'));
	if (!empty($firststeps)) {
		$firststeps = '<header><div class="cocon-firststeps">
				<div class="firststeps">
					' . $firststeps . '
					<a href="?firststeps=hide" class="firststeps-disable">' . elgg_echo('theme_cocon:firststeps:hide') . '</a>
				</div>
			</div></header>
			<div class="clearfloat"></div>';
	}
}
*/


// Slider
/*
$slider_params = array(
		//'sliderparams' => "theme:'cs-portfolio', buildStartStop:false, resizeContents:false, ", 
		//'slidercss_main' => "width:100%; height:400px;", 
		'width' => '100%',
		'height' => '300px', 
	);
$slider = elgg_view('slider/slider', $slider_params);
*/

// Texte intro configurable
//$intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');
//$intro = '<div class="home-news">' . elgg_view('cmspages/view', array('pagetype' => 'home-loggedin-news')) . '</div>';


// Le Fil
$thewire = '<span class="viewall" style="float:right;"><a href="' . $CONFIG->url . 'thewire/all">' . elgg_echo('link:view:all') . '</a></span><h2><img src="' . $urlpictos . 'thewire_45.png" />' . elgg_echo('theme_cocon:thewire:title') . '</h2>' . elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
//elgg_push_context('widgets');
$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 3, 'pagination' => false));
$thewire .= '<div class="clearfloat"></div>';
//elgg_pop_context();

// Activité du site
$site_activity = '<span class="viewall" style="float:right;"><a href="' . $CONFIG->url . 'activity">' . elgg_echo('link:view:all') . '</a></span><h2><img src="' . $urlpictos . 'activity.png" />' . elgg_echo('theme_cocon:site:activity') . '</h2>';
elgg_push_context('search'); // Permet de ne pas interprêter les shortcodes, mais afficher les menus...
$db_prefix = elgg_get_config('dbprefix');
//$site_activity .= elgg_list_river(array('limit' => 3, 'pagination' => false, 'types' => array('object', 'group', 'site')));
$site_activity .= elgg_list_river(array('limit' => 3, 'pagination' => false, 'types' => array('object')));
elgg_pop_context();

// Tableau de bord
// Note : il peut être intéressant de reprendre le layout des widgets si on veut séparer les colonnes et les intégrer dans l'interface
elgg_set_context('dashboard');
elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
// Pour afficher un bloc sur 2 colonnes, on utilise la partie content
$params = array( 'content' => '', 'num_columns' => 3, 'show_access' => false);
$widget_body = elgg_view_layout('widgets', $params);


// Composition de la page
//$body = $firststeps . '
$body = '
	<div style="width:76%; float:left;">
		<div style="padding: 0 26px 26px 13px;">
			
			<div style="width:47%; float:left;">
				<div class="home-box home-activity">' . $site_activity . '</div>
			</div>
			<div style="width:50%; float:right;">
				<div class="home-box home-wire">' . $thewire . '</div>
			</div>
	
		</div>
	</div>
	
	<div style="width:22%; float:right;">
		<h2 class="hidden">' . elgg_echo('theme_cocon:home:information') . '</h2>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_cocon/sidebar_groups') . '</div>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_cocon/users/online', array('limit' => 30)) . '</div>
		<div class="clearfloat"></div>
		<div class="home-box">' . elgg_view('theme_cocon/users/newest') . '</div>
	</div>
	
	<div class="clearfloat"></div>
	<h2 class="hidden">' . elgg_echo('theme_cocon:home:widgets') . '</h2>
	' . $widget_body;

// Note : si on utilise la sidebar, il faut impérativement y placer un bloc de widgets
// sinon on déséquilibre trop la page
/*
$sidebar = elgg_view('theme_cocon/sidebar_groups') . '
		<div class="clearfloat"></div><br />
		' . elgg_view('theme_cocon/users/online') . '
		<div class="clearfloat"></div><br />
		' . elgg_view('theme_cocon/users/newest');
*/

// Supprime le lien "main" (inexistant) de l'accueil
elgg_pop_breadcrumb();
// Supprime le lien vers l'accueil
elgg_pop_breadcrumb();

// Note : sidebar is not used, as the whole layout is defined on content $body
$params = array( 'content' => $body, 'sidebar' => $sidebar, 'filter' => false);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

