<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

gatekeeper();

// Liste manuelle.. ou metadata spécifique ?
if (elgg_is_admin_logged_in() || in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('animators', 'theme_inria'))) ) {
	
} else {
	forward();
}

$content = '';

// Composition de la page
$content .= '<div id="inria-animation" class="">';
$content .= "Cette page répertorie les principales actions d'un animateur et présente quelques infos générales utiles pour l'animation.
<ul>
	<li>Consulter les feedbacks : " . '<a href="' . $CONFIG->url . 'feedback">Afficher les feedbacks</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'cmspages">Gérer les pages CMS</a> et <a href="' . $CONFIG->url . 'admin/plugin_settings/cmspages">gérer les éditeurs autorisés (admin)</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'groups/all">Gérer les groupes à la Une</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'groups/all">Gérer les groupes à la Une</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'admin/appearance/profile_fields">Gérer les champs du profil</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'admin/statistics/digest">Analyse des résumés (digest)</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'views_counter/list_entities">Statistiques du compteur de vues</a>' . "</li>
	
	<li>" . '<a href="' . $CONFIG->url . 'event_calendar/list">Gérer les événements du site</a>' . "</li>
	
	<li>Consulter les statistiques globales : " . elgg_view('admin/statistics/overview') . "</li>
	
	<script>" . elgg_view('js/advanced_statistics/admin') . "</script>
	<li>Consulter les statistiques d'activité : " . elgg_view('admin/advanced_statistics/activity') . "</li>
	<li>Consulter les statistiques des contenus : " . elgg_view('admin/advanced_statistics/content') . "</li>
	<li>Consulter les statistiques des groupes : " . elgg_view('admin/advanced_statistics/groups') . "</li>
	<li>Consulter les statistiques du système : " . elgg_view('admin/advanced_statistics/system') . "</li>
	<li>Consulter les statistiques des membres : " . elgg_view('admin/advanced_statistics/users') . "</li>
	<li>Consulter les statistiques des widgets : " . elgg_view('admin/advanced_statistics/widgets') . "</li>
</ul>";

$content .= '<div style="width:46%; float:left;">';
	$content .= '';
	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

$content .= '<div style="width:50%; float:right;">';
	$content .= '';
	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = $content;


// Affichage
echo elgg_view_page($title, $body);

