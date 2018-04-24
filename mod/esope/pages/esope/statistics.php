<?php
/**
 * Statistics for everyone and for admins
 *
 */

gatekeeper();

// Liste manuelle.. ou metadata spécifique ?
//$allowed = false;
$allowed = true; // @TODO : add some real conditions...
if (elgg_is_admin_logged_in()) { $allowed = true; }
// @TODO need to define an intermediary role...
if (in_array($_SESSION['username'], explode(',', elgg_get_plugin_setting('editors', 'esope')))) { $allowed = true; }

if (!$allowed) { forward(); }

$url = elgg_get_site_url();

$content = '';
$sidebar = '';


// @TODO Error and access logs / basic stats ?
/*
if (elgg_is_admin_logged_in()) {
	$log_dir = '/var/log/apache2/';
	$access_log = $log_dir . 'access.log';
	$error_log = $log_dir . 'error.log';
	ini_set("open_basedir = /var/log/apache2");
	$content .= "Access log : $access_log" . '<pre>' . esope_tail($access_log, 20) . '</pre>';
	$content .= "Error log : $error_log" . '<pre>' . esope_tail($error_log, 20) . '</pre>';
}
*/



// Composition de la page

// SIDEBAR

// Accès autorisés pour tous
$sidebar .= '<p><a class="elgg-button elgg-button-action" href="' . $url . 'feedback">Afficher les feedbacks</a>' . "</p>";

// Accès autorisés pour certaines personnes choisies
if (elgg_is_admin_logged_in()) {
	// @TODO ajouter editors
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $url . 'cmspages">Gérer les pages CMS</a>';
	$sidebar .= ' et <a href="' . $url . 'admin/plugin_settings/cmspages">gérer les éditeurs autorisés</a>' . "</p>";
}

// Accès admin seulement
if (elgg_is_admin_logged_in()) {
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $url . 'groups/all">Gérer les groupes à la Une</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $url . 'admin/appearance/profile_fields">Gérer les champs du profil</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $url . 'admin/statistics/digest">Analyse des résumés (digest)</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $url . 'views_counter/list_entities">Statistiques du compteur de vues</a>' . "</p>";
	$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . $url . 'event_calendar/list">Gérer les événements du site</a>' . "</p>";
	$sidebar .= '<span class="anim-stats">' . elgg_view('admin/statistics/overview') . '</span>';
}

$sidebar .= '<div class="clearfloat"></div>';



// CONTENU DE LA PAGE PRINCIPALE

$content .= '<div id="esope-statistics">';
//$content .= "Cette page répertorie les principales actions d'un animateur et présente quelques infos générales utiles pour l'animation.";

if (elgg_is_active_plugin('advanced_statistics')) {
$content .= "<script>" . elgg_view('js/advanced_statistics/admin') . "</script>
	<h2>Statistiques d'activité</h2><div>" . elgg_view('admin/advanced_statistics/activity') . "</div>
	<h2>Statistiques des contenus</h2><div>" . elgg_view('admin/advanced_statistics/content') . "</div>
	<h2>Statistiques des groupes</h2><div>" . elgg_view('admin/advanced_statistics/groups') . "</div>
	<h2>Statistiques du système</h2><div>" . elgg_view('admin/advanced_statistics/system') . "</div>
	<h2>Statistiques des membres</h2><div>" . elgg_view('admin/advanced_statistics/users') . "</div>
	<h2>Statistiques des widgets</h2><div>" . elgg_view('admin/advanced_statistics/widgets') . "</div>
	<div class=\"clearfloat\"></div>";
}

$content .= '</div>';

/* Marche pas avec le chargement des graphiques...
$content .= '<script type="text/javascript">
//$(function() {
jQuery(window).load(function () {
	$(\'#esope-statistics\').accordion({ header: \'h2\', autoHeight: false, heightStyle: \'content\' });
});
</script>';
*/


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

