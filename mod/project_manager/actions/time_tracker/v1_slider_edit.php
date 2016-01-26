<?php
/**
 * Create or edit a time_tracker
 *
 * @package ElggPages
 */

// Note : si pas précisé, appel et réponse en AJAX donc on retourne la réponse appropriée..
/* Notes de conception
l'avantage des annotations et metadata serait de pouvoir se balader dans le temps sans "changer d'objet" : oui mais est-ce faisable ?
la limite est vite atteinte pour la recherche avec annotations et metadata, pour une recherche par projet, par période de temps ou par personne..
du coup, plutôt avoir un objet "feuille de temps mensuelle" qui permette de filtrer sur plusieurs propriétés ?

*/
gatekeeper();
action_gatekeeper();

// Get vars
$guid = get_input('guid', false);
$user_guid = get_input('user', false);
$year = get_input('year', false);
$month = get_input('month', false);
if ($month && (strlen($month) == 1)) $month = "0$month";
$date_stamp = (string) $year . $month;
// Affectation : Peut être un projet ou l'user (rien par défaut car info nécessaire pour enregistrer les saisies)
// Si non affecté, on n'enregistre pas (ou comme donnée temporaire hors affectation ?)
$project_guid = get_input('project', false);
if (empty($project_guid) || ($project_guid == 'none')) $project_guid = false;
$unique_id = get_input('unique_id', false);
$access_id = 0;

// @TODO changer cette façon de stocker en ->time_tracker = array($day_of_month => array('time', 'cost', 'comment', 'extra_hours'))
// Pour tableau multi-dimensionnel : name="time_tracker[day_of_month][hours]", etc.
$days = get_input('days', false);
$hours = get_input('hours', false);
$cost = get_input('cost', false);
$comment = get_input('comment', false);
// Si aucun projet précisé, on n'enregistre pas
if (!$project_guid) { exit(); }

//elgg_make_sticky_form('time_tracker');
//error_log("DEBUG TIME_TRACKER : $user_guid, $month/$year, $project_guid : $days - $hours - $cost - $comment");

if ($user_guid && $year && $month && $project_guid) {} else {
	register_error(elgg_echo('time_tracker:error:missingvalues'));
	forward(REFERER);
}
if ($user_guid) {
	$user = get_entity($user_guid);
	if (!$user || !$user->canEdit()) { register_error(elgg_echo('time_tracker:error:invaliduser')); forward(REFERER); }
}
if ($project_guid) {
	$project = get_entity($project_guid);
	if (!$project) { register_error(elgg_echo('time_tracker:error:invalidproject')); forward(REFERER); }
}


// 1 chercher si GUID existe pour critères (feuille de temps mensuelle d'un membre)
// Si on peut l'avoir quand il est dispo ça va plus vite...?
if ($time_tracker = get_entity($guid)) {
  if ($time_tracker->subtype == 'time_tracker') {} else {
    // Non valide : on va devoir chercher s'il y en a un bon
    $time_tracker = false;
  }
}
// YYYYMM pour classement naturel des dates et recherche par intervale..
$options = array(
    'metadata_names' => 'date_stamp', 'metadata_values' => $date_stamp, 'types' => 'object', 'subtypes' => 'time_tracker',
    'owner_guids' => $user_guid, 'limit' => 10, 'offset' => 0, 'order_by' => '', 'count' => true,
  );
$count_time_trackers = elgg_get_entities_from_metadata($options);
$options['count'] = false;
$options['limit'] = $count_time_trackers;
$time_trackers = elgg_get_entities_from_metadata($options);
//error_log('DEBUG TIME_TRACKER : ' . print_r($time_trackers, true));
// On ne modifie qu'une saisie affectée à un projet donné (ou explicitement non affecté)
//error_log('DEBUG : ' . sizeof($time_trackers) . ' - ' . $project_guid);
if (is_array($time_trackers)) 
foreach($time_trackers as $ent) {
  if ($ent->project_guid == $project_guid) $time_tracker = $ent;
}
// 2 si non on le crée..
if (!$time_tracker) {
  //error_log('DEBUG TIME_TRACKER : objet inexistant');
  $time_tracker = new ElggObject();
  $time_tracker->subtype = 'time_tracker';
  $time_tracker->owner_guid = $user_guid;
  $time_tracker->container_guid = $user_guid;
  $time_tracker->access_id = 0;
}

// @TODO : on doit pouvoir affecter les données sur chaque projet, donc la base mensuelle ne suffit pas : il faut le faire par projet, ou alors stocker des données sérialisées

$time_tracker->project_guid = $project_guid;
$time_tracker->year = $year;
$time_tracker->month = $month;
$time_tracker->date_stamp = $date_stamp;
if ($field) $time_tracker->$field = $field_value;
if ($days) $time_tracker->days = $days;
if ($hours) $time_tracker->hours = $hours;
if ($cost !== false) $time_tracker->cost = $cost;
if ($comment) $time_tracker->comment = $comment;
/*
$time_tracker->days = $days;
$time_tracker->hours = $hours;
$time_tracker->cost = $cost;
$time_tracker->comment = $comment;
*/
// Change data

//if ( $user->annotate('time_tracker', $value, $access_id, $user_guid, 'integer') ) {
/*
error_log('DEBUG TIME_TRACKER : action quasi aboutie');
echo "true"; // Réponse pour form AJAX
exit();
*/
if ($time_tracker->save()) {
  // @TODO : si choix d'un projet existant, on renvoie les valeurs pour mise à jour des champs de saisie : days, hours, cost, commment
  //echo "true"; // Réponse pour form AJAX
  echo json_encode(array(
      "result" => "true", 
      "project" => $time_tracker->project_guid, 
      "days" => $time_tracker->days, 
      "hours" => $time_tracker->hours, 
      "cost" => $time_tracker->cost, 
      "comment" => $time_tracker->comment, 
    ));
  
  //error_log('DEBUG TIME_TRACKER : objet CREE');
  //elgg_clear_sticky_form('time_tracker');
  //system_message(elgg_echo('time_trackers:saved'));
	//add_to_river('river/object/time_tracker/update', 'update', $user_guid);
/*
} else {
	register_error(elgg_echo('time_trackers:error:no_save'));
	forward(REFERER);
*/
}

exit();

