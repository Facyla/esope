<?php
/**
 * Elgg time_tracker saver
 * 
 * @package Elggtime_tracker
 * @author Facyla
 * @copyright Facyla 2010
 * @link http://id.facyla.net/
 */

gatekeeper();
global $CONFIG;

$content = '';

$month_table = array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');

// Set required vars
// Set the page owner
$member_guid = get_input('user_guid', $_SESSION['guid']);
$member = get_entity($member_guid);
if ($member === false || is_null($member)) {
	$member = elgg_get_logged_in_user_entity();
	$member_guid = $member->guid;
	elgg_set_page_owner_guid($member_guid);
}
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
$project_guid = get_input('project_guid', 'none');


$js = '<script type="text/javascript">
// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function update_time_tracker(user, year, month, unique_id) {
	// @TODO : afficher image de chargement
	$.post(
	  elgg.security.addToken(\'' . $CONFIG->url . 'action/time_tracker/edit\'), 
	  {
	    user: user,
      year: year,
      month: month,
      unique_id: unique_id,
      project: $("#project_" + unique_id).val(),
      days: $("#project_days_" + unique_id + "_val").val(),
      hours: $("#project_hours_" + unique_id + "_val").val(),
      cost: $("#project_cost_" + unique_id).val(),
      comment: $("#project_comment_" + unique_id).val(),
	  }, 
    function(data) {
		  if (data.result == \'true\') {
			  $("#project_days_" + unique_id).slider(\'value\', data.days);
			  $("#project_hours_" + unique_id).slider(\'value\', data.hours);
			  $("#project_cost_" + unique_id).val(data.cost);
			  $("#project_comment_" + unique_id).val(data.comment);
		  } else {
			  alert(elgg.echo("Erreur : les informations n\'ont pas pu être mises à jour, veuillez réessayer dans un instant."));
		  }
	  }, 
	  "json"
	);
}
</script>';


$js .= '<script type="text/javascript">
// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function get_time_tracker(user, year, month, project, unique_id) {
	$.post(
	  elgg.security.addToken(\'' . $CONFIG->url . 'action/time_tracker/edit\'), 
	  {
	    user: user,
      year: year,
      month: month,
      unique_id: unique_id,
      project: project,
	  }, 
    function(data) {
		  if (data.result == \'true\') {
			  $("#project_days_" + unique_id).slider(\'value\', data.days);
			  $("#project_hours_" + unique_id).slider(\'value\', data.hours);
			  $("#project_cost_" + unique_id).val(data.cost);
			  $("#project_comment_" + unique_id).val(data.comment);
		  } else {
			  alert(elgg.echo("Erreur : les informations n\'ont pas pu être mises à jour, veuillez recharger la page et réessayer."));
		  }
	  }, 
	  "json"
	);
}
</script>';

$content .= '<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
  ';

/* Process : on saisit sa feuille de temps quand on veut, avec un découpage par mois et par projet
On peut ajouter de nouveaux projets parmi la liste de ses projets, dont certains génériques (prospection, etc.)
On peut ajouter de nouveaux temps affectés à divers projets
Calendrier annuel avec vue sur mois en cours : 
 - une ligne de saisie par projet
 - possibilité d'ajouter des projets à la volée
 - possibilité de modifier les lignes déjà renseignées
 - Saisie : temps hors projets déjà en place par défaut, et temps projets à la suite
JANVIER
 Projet X : temps passé / commentaire
 Projet Y : temps passé / commentaire
 + saisir le temps sur un autre projet
 
*/

// Formulaires pour changer de feuille de temps
$content .= '<span style="float:right;"><label>pour le mois de <select name="date_stamp" onChange="javascript:document.location.href=this.value">';
for ($y = 2013; $y <= (date('Y')); $y++) {
  for ($m = 1; $m <= 12; $m++) {
    if (strlen($m) == 1) $ds = $y.'0'.$m; else $ds = $y.$m;
    if (($y == $year) && ($m == $month)) {
      $content .= '<option selected="selected" value="' . $vars['url'] . 'time_tracker?date_stamp=' . $ds . '">' . $month_table[$m] . ' ' . $y . '</option>';
    } else {
      $content .= '<option value="' . $vars['url'] . 'time_tracker?date_stamp=' . $ds . '">' . $month_table[$m] . ' ' . $y . '</option>';
    }
  }
}
$content .= '</select></label></span>';

$content .= '<h2>Feuilles de temps de ' . $member->name . '</h2>';


// Affichage saisies pour le mois demandé
$content .= '<br />';
$content .= '<h3>Feuille de temps du mois de '.$month_table[(int)$month].'</h3>';
$options = array(
    'metadata_names' => 'date_stamp', 'metadata_values' => $date_stamp, 
    'types' => 'object', 'subtypes' => 'time_tracker',
    'owner_guids' => $member_guid,
    'limit' => 10, 'offset' => 0, 'order_by' => '', 'count' => true,
  );
$count_time_trackers = elgg_get_entities_from_metadata($options);
$options['count'] = false;
$options['limit'] = $count_time_trackers;
$time_trackers = elgg_get_entities_from_metadata($options);
$total_days = 0;
$total_hours = 0;
$hide_projects = array(); // Sert à ne pas réafficher les projets déjà renseignés dans le nouveau formulaire
foreach ($time_trackers as $ent) {
  $hide_projects[] = $ent->project_guid;
  //$content .= elgg_view('object/time_tracker', array('entity' => $ent));
  $content .= elgg_view('forms/time_tracker/edit', array('entity' => $ent, 'no_project_switch' => true));
  //$ent->delete(); // /!\ Uniquement pour les dévs !!!
  $total_days += $ent->days;
  $total_hours += $ent->hours;
}
while ($total_hours >= 7) {
  $total_hours -= 7;
  $total_days++;
}

// Ajout nouvelle ligne projet-temps sur ce mois
$content .= '<span class="elgg-button"><a href="javascript:void(0);" onclick="$(\'#time_tracker_newtime\').toggle();">' . elgg_echo('time_tracker:add_new') . '</a></span>';
$time_tracker_params = array(
  'time_tracker_guid' => 0, // Toujours inconnu si on n'a pas choisi le projet
  'user_guid' => $member_guid, 
  'year' => $year, 
  'month' => $month, 
  'project_guid' => $project_guid, 
);
$content .= '<span id="time_tracker_newtime" style="display:none;">' . elgg_view('forms/time_tracker/edit', array('time_tracker' => $time_tracker_params, 'hide_projects' => $hide_projects)) . '</span>';
$content .= '<br /><em>Si votre projet ne figure pas dans la liste, <a href="' . $vars['url'] . 'project_manager/new">vous pouvez le créer</a> puis revenir le renseigner ici.</em><br />';
$content .= '<div class="clearfloat"></div><br />';

// Indicateurs et synthèse mensuelle
$content .= '<h4>Synthèse pour '.$month_table[(int)$month].'</h4>';
$content .= '<div style="border:1px solid red; padding:4px 8px; width:45%; float:left;">';
$content .= "Nombre de jours : $total_days et $total_hours heures<br />";
$content .= "Production mensuelle : " . (($total_days * 600) + ($total_hours * 100)) . " €<br />";
$content .= '</div>';
$content .= '<div style="border:1px solid blue; padding:4px 8px; width:45%; float:right;">';
$content .= "Statut : " . elgg_echo('project_manager:items_status:'.$member->items_status) . "<br />";
if ($member->items_status == 'salarie') {
  $content .= "Coût annuel brut : {$member->yearly_global_cost} €<br />";
  $content .= "Coût mensuel moyen : " . round(($member->yearly_global_cost / 12),2) . " €<br />";
  $content .= "Coût journalier moyen : " . round(($member->yearly_global_cost / 12 / 20),2) . " €<br />";
  $content .= "Part variable annuelle : {$member->yearly_variable_part} €<br />";
} else if ($member->items_status == 'salarie') {
  $content .= "Coût de journée : " . $member->daily_cost . " € / jour<br />";
  // Note : varie selon les projets (et les profils ?)
} else {}

$content .= '</div>';
$content .= '<div class="clearfloat"></div><br />';


// Affichage toutes les saisies précédentes
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


$body = elgg_view_layout('two_column_left_sidebar', array('content' => $content . $js, 'sidebar' => '', 'title' => $title));
echo elgg_view_page($title, $body);

