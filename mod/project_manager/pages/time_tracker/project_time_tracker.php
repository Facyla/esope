<?php
/**
 * Elgg time_tracker personal edit page
 * 
 * @package Elggtime_tracker
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
*/

project_manager_gatekeeper();
global $CONFIG;

$content = '';

$months = time_tracker_get_date_table('months');

// Set required vars
// Set the page owner
$project_guid = get_input('project_guid', false);
if ($project_guid) $project = get_entity($project_guid);
$container_guid = get_input('container_guid', false);
if ($container_guid) $container = get_entity($container_guid);

if (!(($container instanceof ElggGroup) || ($container instanceof ElggUser)) && !($project instanceof ElggObject)) {
  register_error('project_manager:missingrequireddata');
  forward(REFERER);
}

// Get group and project, if exists
if ($project && ($project instanceof ElggObject)) {
  $container_guid = $project->container_guid;
  $container = get_entity($container_guid);
} else {
  $project = project_manager_get_project_for_container($container_guid);
  if ($project) $project_guid = $project->guid; else $project_guid = false;
}
elgg_set_page_owner_guid($container_guid);

//$content .= "Groupe : $container_guid  - Projet : $project_guid";

// Définition du date_stamp
$date_stamp = get_input('date_stamp', false);
if ($date_stamp) {
  $year = substr($date_stamp, 0, 4);
  $month = substr($date_stamp, 4, 2);
} else {
  $year = get_input('year', date('Y'));
  $month = get_input('month', date('m'));
  $date_stamp = (string)$year.$month;
}
if (strlen($month) == 1) $month = "0$month";


$js = '<script type="text/javascript">' . elgg_view('time_tracker/js') . '</script>';
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';

// Composition de la page

// Synthèse du temps passé sur le projet
$content .= '<h2>' . elgg_echo('project_manager:menu:project:time_tracker:summary') . '<br /><a href="' . $project->getURL() . '">' . $project->project_code . '&nbsp;: ' . $project->title . '</a></h2><br />';
$content .= time_tracker_project_times($project->guid);
$content .= '<br />';


/*
// Formulaires pour changer de feuille de temps
$content .= '<span style="float:right;">' . time_tracker_select_input_month($year, $month, 'time_tracker/project/'.$project_guid, '?date_stamp=') . '</span>';

// Indicateurs et synthèse pour le projet
$total_hours = time_tracker_project_total_time($project_guid);

$content .= '<h4>TODO : indicateurs à définir et construire, au niveau du projet</h4>';
$content .= '<h4>Synthèse pour le projet</h4>';
$content .= '<strong><a class="elgg-button" href="' . full_url() . '">Recharger la page pour actualiser les données ci-dessous</a></strong><br />';
$content .= '<div style="border:1px solid red; padding:4px 8px; width:45%; float:left;">';
$content .= "Temps total passé en {$months[$month]}&nbsp;: " . $total_hours . " jours<br />";
//$content .= "Production mensuelle : " . (($total_hours * 600) + ($total_extra_hours * 100)) . " €<br />";
$content .= '</div>';
$content .= '<div class="clearfloat"></div><br />';
*/


// Affichage toutes les saisies précédentes
/*
$content .= '<br />';
$content .= '<h3>Toutes mes feuilles de temps</h3>';
$options = array(
    'types' => 'object', 'subtypes' => 'time_tracker',
    'owner_guids' => $member_guid,
    'limit' => 10, 'offset' => 0, 'order_by' => '', 'count' => true,
  );
$count_time_trackers = elgg_get_entities($options);
$options['count'] = false;
$options['limit'] = $count_time_trackers;
$time_trackers = elgg_get_entities($options);
$content .= '<strong>' . $count_time_trackers . ' feuilles de temps</strong><br />';
foreach ($time_trackers as $ent) {
  $content .= elgg_view('object/time_tracker', array('entity' => $ent));
  //$ent->delete(); // /!\ Uniquement pour les dévs !!!
}
*/


$body = elgg_view_layout('one_sidebar', array('content' => $content . $js, 'sidebar' => '', 'title' => $title));
echo elgg_view_page($title, $body);

