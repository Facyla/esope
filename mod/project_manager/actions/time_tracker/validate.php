<?php
/**
 * Validate time_trackers for a given user/year/month
 *
 */

// Note : si pas précisé, appel et réponse en AJAX donc on retourne la réponse appropriée..

gatekeeper();
action_gatekeeper();
//error_log("DEBUG TIME_TRACKER : debut");

// Get vars
$user_guid = get_input('user', false);
$year = get_input('year', false);
$month = get_input('month', false);
if ($month && (strlen($month) == 1)) $month = "0$month";
$date_stamp = (string) $year . $month;
$access_id = 0;

$validation = get_input('validation', false);

if ($user_guid && $year && $month) {} else {
	error_log(elgg_echo('time_tracker:error:missingvalues'));
	register_error(elgg_echo('time_tracker:error:missingvalues'));
	forward(REFERER);
}
if ($user_guid) {
	$user = get_entity($user_guid);
	if (!$user || !$user->canEdit()) {
		error_log(elgg_echo('time_tracker:error:invaliduser'));
		register_error(elgg_echo('time_tracker:error:invaliduser'));
		forward(REFERER);
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
$success = 0; $error = 0;
if (is_array($time_trackers)) 
foreach($time_trackers as $ent) {
	// Validation de chacune des saisies effectuées
	if ($ent->canEdit()) {
		//error_log("DEBUG time tracker validation action : {$ent->guid} {$ent->title} = $validation");
		$ent->validation = (bool)$validation;
		$success++;
	} else $error++;
}


if ($error == 0) {
	// On mémorise les données validées de manière plus synthétique pour les mieux les récupérer sans tout parcourir
	$validated = unserialize($user->time_tracker_validated);
	$validated[$year][$month] = $validation;
	$user->time_tracker_validated = serialize($validated);
	echo "true"; // Réponse pour form AJAX
} else {
	echo 'error';
	/*
	register_error(elgg_echo('time_trackers:error:no_save'));
	forward(REFERER);
	*/
}

exit();

