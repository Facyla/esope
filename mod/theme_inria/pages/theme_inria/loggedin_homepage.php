<?php
global $CONFIG;

gatekeeper();

// Premiers pas (si configuré)
$firststeps_guid = elgg_get_plugin_setting('firststeps_guid', 'adf_public_platform');
$firststeps_page = get_entity($firststeps_guid);
if ($firststeps_page instanceof ElggObject) {
	$firststeps = '<div class="firststeps">
			<a href="javascript:void(0);" onClick="$(\'#firsteps_toggle\').toggle(); $(\'#firststeps_show\').toggle(); $(\'#firststeps_hide\').toggle();">Premiers pas (cliquer pour afficher / masquer)
				<span id="firststeps_show" style="float:right;">&#x25BC;</span>
				<span id="firststeps_hide" style="float:right; display:none;">&#x25B2;</span>
			</a>'
		. '<div id="firsteps_toggle" style="padding:10px; border:0 !important;">'
			. $firststeps_page->description
		. '</div>' 
	. '</div>';
	// Masqué par défaut après les 2 premiers passages
	// @todo : on pourrait le faire si pas connecté depuis X temps..
	if (($_SESSION['user']->last_login >= 0) && ($_SESSION['user']->prev_last_login >= 0)) {
		$first_time = '<script type="text/javascript">
		$(document).ready(function() {
			$(\'#firsteps_toggle\').hide();
		})
		</script>';
		$firststeps .= $first_time;
	}
}

// Texte intro configurable
$intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');

// Le Fil
$thewire = '<h3><a href="' . $CONFIG->url . 'thewire/all">Inria, le Fil</a></h3>' . elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
elgg_push_context('widgets');
$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 4, 'pagination' => false));
elgg_pop_context('widgets');

// Activité du site
//if ($homesite_index == 'yes') {
	$site_activity = '<h3><a href="' . $CONFIG->url . 'activity">' . elgg_echo('adf_platform:site:activity') . '</a></h3>';
	// Activité du site
	elgg_push_context('widgets');
	$db_prefix = elgg_get_config('dbprefix');
	$site_activity .= elgg_list_river(array('limit' => 4, 'pagination' => false));
	elgg_pop_context();
//}

// Tableau de bord
// Note : il peut être intéressant de reprendre le layout des widgets si on veut séparer les colonnes et les intégrer dans l'interface
elgg_set_context('dashboard');
elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
// Pour afficher un bloc sur 2 colonnes, on utilise la partie content
$params = array( 'content' => '', 'num_columns' => 3, 'show_access' => false);
$widget_body = elgg_view_layout('widgets', $params);


// Composition de la page
$body = '
	<header><div class="intro">' . $firststeps . '</div></header>
	<div class="clearfloat"></div>
	
	<div style="width:78%; float:left;">
		' . $thewire . '
		<div class="clearfloat"></div>
		' . $site_activity . '
	</div>
	
	<div style="width:20%; float:right;">
		' . $intro . '
		<div class="clearfloat"></div>
		' . elgg_view('theme_inria/sidebar_groups') . '
		<div class="clearfloat"></div><br />
		' . elgg_view('theme_inria/users/online') . '
		<div class="clearfloat"></div><br />
		' . elgg_view('theme_inria/users/newest') . '
	</div>
	
	<div class="clearfloat"></div><br />
	' . $widget_body;

// Note : si on utilise la sidebar, il faut impérativement y placer un bloc de widgets
// sinon on déséquilibre trop la page
/*
$sidebar = elgg_view('theme_inria/sidebar_groups') . '
		<div class="clearfloat"></div><br />
		' . elgg_view('theme_inria/users/online') . '
		<div class="clearfloat"></div><br />
		' . elgg_view('theme_inria/users/newest');
*/

// Supprime le lien "main" (inexistant) de l'accueil
elgg_pop_breadcrumb();

$params = array( 'content' => $body, 'sidebar' => $sidebar, 'filter' => false);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

