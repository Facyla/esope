<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

gatekeeper();

// Liste manuelle.. ou metadata spécifique ?
if (elgg_is_admin_logged_in() || in_array($_SESSION['username'], explode(',', elgg_get_plugin_setting('animators', 'theme_inria'))) ) {
} else {
	forward();
}

$content = '';
$sidebar = '';

// Composition de la page
$content .= '<div id="inria-animation" class="">';
$content .= "Cette page répertorie les principales actions d'un animateur et présente quelques infos générales utiles pour l'animation.";


// Accès autorisés pour tous
$sidebar .= '<p><a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'feedback">Afficher les feedbacks</a>' . "</p>";

// Accès autorisés pour certaines personnes choisies
$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'cmspages">Gérer les pages CMS</a>';
if (elgg_is_admin_logged_in()) {
	$sidebar .= ' et <a href="' . $CONFIG->url . 'admin/plugin_settings/cmspages">gérer les éditeurs autorisés</a>' . "</p>";
}

// Accès admin seulement
if (elgg_is_admin_logged_in()) {
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'groups/all">Gérer les groupes à la Une</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'admin/appearance/profile_fields">Gérer les champs du profil</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'admin/statistics/digest">Analyse des résumés (digest)</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'views_counter/list_entities">Statistiques du compteur de vues</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'event_calendar/list">Gérer les événements du site</a>' . "</p>";
	$sidebar .= '<span class="anim-stats">' . elgg_view('admin/statistics/overview') . '</span>';
}

$sidebar .= '<div class="clearfloat"></div>';


$content .= "<script>" . elgg_view('js/advanced_statistics/admin') . "</script>
	<p><h2>Statistiques d'activité</h2>" . elgg_view('admin/advanced_statistics/activity') . "</p>
	<p><h2>Statistiques des contenus</h2>" . elgg_view('admin/advanced_statistics/content') . "</p>
	<p><h2>Statistiques des groupes</h2>" . elgg_view('admin/advanced_statistics/groups') . "</p>
	<p><h2>Statistiques du système</h2>" . elgg_view('admin/advanced_statistics/system') . "</p>
	<p><h2>Statistiques des membres</h2>" . elgg_view('admin/advanced_statistics/users') . "</p>
	<p><h2>Statistiques des widgets</h2>" . elgg_view('admin/advanced_statistics/widgets') . "</p>
	<div class=\"clearfloat\"></div>";


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

