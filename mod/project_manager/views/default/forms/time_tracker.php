<?php
/* Notes de conception
 Ce form, par projet, doit pouvoir s'afficher sous forme d'une colonne d'un tableau : la sauvegarde s'effectue par projet <=> par colonne, mais on doit donc avoir les entêtes dans le form global
*/

$content = '';

// Date d'aujourd'hui
$now_year = date('Y', time());
$now_month = date('m', time());
$now_day = date('d', time());

$fr_days = time_tracker_get_date_table('days');
$fr_shortdays = time_tracker_get_date_table('days', true);

if (!isset($vars['id'])) {
	global $unique_id; if ($unique_id > 0) $unique_id++; else $unique_id = 1;
}

// Valeur initiales
if (isset($vars['entity'])) {
	$time_tracker = $vars['entity'];
	$time_tracker_guid = $time_tracker->guid;
	$user_guid = $time_tracker->owner_guid;
	$year = (int) $time_tracker->year;
	$month = $time_tracker->month;
	//$time_inputs = $time_tracker->time_tracker;
	$days = $time_tracker->days;
	$hours = $time_tracker->hours;
	$cost = $time_tracker->cost;
	$validation = $time_tracker->validation;
	$comment = $time_tracker->comment;
	$project_guid = $time_tracker->project_guid;
	$vars['time_tracker'] = array(
			'time_tracker_guid' => $time_tracker_guid,
			'user_guid' => $user_guid, 
			'year' => $year, 
			'month' => $month, 
			'project_guid' => $project_guid, 
			'unique_id' => $unique_id,
		);
} else if (isset($vars['time_tracker'])) {
	//$content .= implode(', ', $vars['time_tracker']) . '<br />';
	$time_tracker_guid = $vars['time_tracker']['guid'];
	if (empty($time_tracker_guid)) $time_tracker_guid = '0';
	$user_guid = $vars['time_tracker']['user_guid'];
	$year = (int) $vars['time_tracker']['year'];
	$month = $vars['time_tracker']['month'];
	$project_guid = $vars['time_tracker']['project_guid'];
	// Permet de regrouper les valeurs d'un même formulaire
	$vars['time_tracker']['unique_id'] = $unique_id;
}


// Nom du projet : permet d'identifier le projet, qu'il existe ou non
$project_name = false;
if (!empty($project_guid)) {
	if ($project = get_entity($project_guid)) {
		if ($project instanceof ElggObject) {
			// Note : un projet terminé ne peut plus faire l'objet de saisie de temps
			if (in_array($projecttype, array('closed', 'rejected'))) {
				register_error('project_manager:error:closedproject');
				return;
			}
			$project_name = '<a href="' . $project->getURL() . '" title="' . $project->title . '">';
			$project_name .= (!empty($project->project_code)) ? $project->project_code : elgg_echo('time_tracker:code:undefined');
			$project_name .= '</a>';
			$time_tracker_type = 'time_tracker_project';
		} else if ($project instanceof ElggUser) {
			$project_name = elgg_echo('time_tracker:otherproject');
			$time_tracker_type = 'time_tracker_other';
		}
	} else {
		switch($project_guid) {
			//case 'P': $project_name = elgg_echo('time_tracker:production'); break;
			case 'A': $project_name = elgg_echo('time_tracker:avantvente'); break;
			case 'T': $project_name = elgg_echo('time_tracker:travauxtechniques'); break;
			case 'G': $project_name = elgg_echo('time_tracker:gestion'); break;
			case 'C': $project_name = elgg_echo('time_tracker:conge'); break;
			case 'NOTES': $project_name = elgg_echo('time_tracker:notes'); break;
		}
		if ($project_guid != "NOTES") $project_name = '<span>' . $project_name . '</span>';
		$time_tracker_type = 'time_tracker_special';
		// Cas particulier : les notes et remarques
		if ($project_guid == 'NOTES') $time_tracker_type = 'time_tracker_notes';
	}
}

$lock_open = '<span class="elgg-icon elgg-icon-lock-open"></span> ';
$lock_closed = '<span class="elgg-icon elgg-icon-lock-closed"></span> ';
if ($validation == 1) {
	$validation_status = '<span class="project_manager_notvalidated" style="display:none;">' . $lock_open . elgg_echo('time_tracker:novalidation') . '</span>';
	$validation_status .= '<span class="project_manager_validated">' . $lock_closed . elgg_echo('time_tracker:validation') . '</span>';
} else {
	$validation_status = '<span class="project_manager_notvalidated">' . $lock_open . elgg_echo('time_tracker:novalidation') . '</span>';
	$validation_status .= '<span class="project_manager_validated" style="display:none;">' . $lock_closed . elgg_echo('time_tracker:validation') . '</span>';
}

// Une saisie validée ne peut plus être modifiée, sauf par un admin
// @TODO : reste affiché sans formulaire ni update en JS, et en mode disabled ?
//if ($validation == 1) {
if (($validation == 1) && !elgg_is_admin_logged_in()) {
	register_error('time_tracker:error:validated');
	return;
}


// Composition de la colonne de saisie
if (!empty($project_guid) && ($project_guid != 'none') && ($project_guid != 'NOTES')) $content .= '<div class="time_tracker_project_form">';
else if ($project_guid == 'NOTES') $content .= '<div class="time_tracker_project_form_notes">';
else $content .= '<div class="time_tracker_project_newform">';

// Lien pour retirer le projets
if (isset($vars['entity']) && !in_array($project_guid, array('P', 'C', 'G', 'A', 'T', 'NOTES'))) {
	$delete_text = '<span class="elgg-icon elgg-icon-delete" alt="' . elgg_echo('time_tracker:project:remove') . '" style="float:right;"></span>';
	$content .= '<div class="time_tracker_remove_project">' . elgg_view('output/confirmlink', array('href' => $vars['url'] . 'action/time_tracker/delete?time_tracker=' . $time_tracker->guid, 'text' => $delete_text, 'title' => elgg_echo('time_tracker:project:removetitle'), 'confirm' => elgg_echo('time_tracker:project:removeconfirm'))) . '</div>';
} else if (in_array($project_guid, array('P', 'C', 'G', 'A', 'T', 'NOTES'))) {
	$content .= '<div class="time_tracker_remove_project">&nbsp;</div>';
} else {
	$content .= '<div class="time_tracker_remove_project">&nbsp;</div>';
}


// Composition du formulaire
$form_id = 'time_tracker_form_' . $unique_id;
$content .= '<form action="/" class="time_tracker_month_form '.$time_tracker_type.'" id="time_tracker_form_' . $unique_id . '">';

// Si projet choisi, on l'affiche et saisie directe
if (isset($vars['entity']) || $project_name) {
	$content .= '<div class="time-tracker-header">' . $project_name . elgg_view('input/hidden', array('name' => 'project_guid', 'id' => 'project_'.$unique_id, 'value' => $project_guid)) . '</div>';
	
// sinon on le choisit et on enregistre + reload dans la foulée
} else {
	// 1. Choix du projet pour affectation des temps saisis
	$projects_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'count' => true));
	$projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'limit' => $projects_count));
	$projects_options['none'] = elgg_echo('time_tracker:chooseproject');
	// Hors-projet (personnel) : enlevé car remplacé par les CATG
	//if (!is_array($vars['hide_projects']) || !in_array($user_guid, $vars['hide_projects'])) $projects_options[$user_guid] = elgg_echo('time_tracker:otherproject');
	foreach ($projects as $ent) {
		// Affiché si aucun filtre ou pas dans le filtre
		if (!is_array($vars['hide_projects']) || !in_array($ent->guid, $vars['hide_projects'])) {
			if ($ent->project_managertype != 'closed') $projects_options[$ent->guid] = $ent->title;
		}
	}
	if (sizeof($projects_options) == 1) {
		$content .= '<p class="project_manager_notvalidated>' . elgg_echo('time_tracker:error:nomoreproject') . '</p>';
		return;
	}
	$content .= '<label>Projet ' . elgg_view('input/dropdown', array('name' => 'project_guid', 'id' => 'project_'.$unique_id, 'options_values' => $projects_options, 'value' => $project_guid, 'js' => 'onChange="save_time_tracker(\'' . $form_id . '\');"')) . '</label>';
}


// Autres infos utiles du formulaire de saisie pour le projet
$content .= elgg_view('input/hidden', array('name' => 'user', 'value' => $user_guid));
$content .= elgg_view('input/hidden', array('name' => 'year', 'value' => $year));
$content .= elgg_view('input/hidden', array('name' => 'month', 'value' => (int)$month));
$content .= elgg_view('input/hidden', array('name' => 'unique_id', 'value' => $unique_id));

// Suite du formulaire ssi projet choisi
if (!empty($project_guid) && ($project_guid != 'none')) {
	
	$content .= '<div class="clearfloat"></div>';
	
	// On a besoin de savoir pour quel mois de quelle année on saisit les données
	$date_timestamp = mktime(0, 0, 0, (int)$month, 1, $year); // timestamp au 1er du mois
	$count_days_in_month = date('t', $date_timestamp);
	// Weekend ou pas : w 	Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
	
	// Pour chaque jour du mois : saisie par projet
	for ($i = 1; $i <= $count_days_in_month; $i++) {
		$day_class = ''; // Pour différencier selon les jours
		$date_timestamp = mktime(0, 0, 0, (int)$month, $i, (int)$year); // timestamp à 00:00 du jour donné
		// Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
		$day_of_week = date('w', $date_timestamp);
		// Jour ouvré ou pas : w 	Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
		$is_workableday = time_tracker_jour_ouvrable($year, $month, $i);
		if ($is_workableday == 0) { $day_class .= 'time_tracker_notworkable '; }
		// Date d'aujourd'hui ?
		if ($i == $now_day) {
			if (($month == $now_month) && ($year == $now_year)) { $day_class .= 'time_tracker_today '; }
		}
		$content .= '<div class="time_tracker_day_cell">';
		
		// Nb d'heures : modes de sélection variés selon le type de saisie
		switch($project_guid) {
			//case 'P': break; // cas particulier : somme d'une ligne
			case 'NOTES':
				$content .= elgg_view('input/plaintext', array('name' => 'time_tracker[' . $i . '][hours]', 'class' => $day_class . 'time_tracker_'.$project_guid.' time_tracker_noday time_tracker_day'.$i. ' time_tracker_input_notes', 'id' => 'project_notes_'.$i.'_'.$unique_id, 'value' => $time_tracker->{'day'.$i.'_hours'}, 'js' => 'style="width:100%; height:24px;" onChange="save_time_tracker(\'' . $form_id . '\', '.$i.');"'));
					break;
			case 'C':
				if ($is_workableday == 0) {
					$content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][hours]', 'class' => $day_class . 'time_tracker_'.$project_guid, 'id' => 'project_hours_'.$i.'_'.$unique_id, 'value' => $time_tracker->{'day'.$i.'_hours'}, 'js' => 'style="width:100%;" disabled="disabled"'));
				} else {
					$content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][hours]', 'class' => $day_class . 'time_tracker_'.$project_guid.' time_tracker_noday time_tracker_day'.$i, 'id' => 'project_hours_'.$i.'_'.$unique_id, 'value' => $time_tracker->{'day'.$i.'_hours'}, 'js' => 'style="width:100%;" onChange="save_time_tracker(\'' . $form_id . '\', '.$i.');" onClick="time_tracker_toggle_conge(\'project_hours_'.$i.'_'.$unique_id.'\', \'' . $form_id . '\', '.$i.');"'));
				}
					break;
			case 'A':
			case 'T':
			case 'G':
			case $user_guid:
				$content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][hours]', 'class' => $day_class . 'time_tracker_'.$project_guid.' time_tracker_noday time_tracker_day'.$i, 'id' => 'project_hours_'.$i.'_'.$unique_id, 'value' => $time_tracker->{'day'.$i.'_hours'}, 'js' => 'style="width:100%;" onChange="save_time_tracker(\'' . $form_id . '\', '.$i.');"'));
				break;
			default:
				$content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][hours]', 'class' => $day_class . 'time_tracker_'.$project_guid.' time_tracker_day'.$i, 'id' => 'project_hours_'.$i.'_'.$unique_id, 'value' => $time_tracker->{'day'.$i.'_hours'}, 'js' => 'style="width:100%;" onChange="save_time_tracker(\'' . $form_id . '\', '.$i.');"'));
		}

		// Nb d'heures supp
		//$content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][extra_hours]', 'id' => 'project_extra_hours_'.$i.'_'.$unique_id, 'min' => 0, 'max' => 17, 'value' => $time_tracker->{'day'.$i.'_extra_hours'}, 'js' => 'style="max-width:4ex;" onChange="save_time_tracker(\'' . $form_id . '\');"'));
		
		$content .= '<br />';
		
		$content .= '</div>';
	}
	// Fin saisie jour par jour
	
	$content .= '<div class="clearfloat"></div>';
	
	// Frais associés à ce projet : gérés indépendament dans outil plus complet..
	/*
	$content .= '<p><label>' . elgg_echo('time_tracker:frais'). '<br />' . elgg_view('input/text', array('name' => 'cost', 'id' => 'project_cost_'.$unique_id, 'value' => $cost, 'js' => 'style="width:100%;" onChange="save_time_tracker(\'' . $form_id . '\');"')) . '</label></p>';
	*/
	
	// Frais associés à ce projet : gérés indépendament dans outil plus complet..
	/*
	$content .= '<p><label>' . elgg_echo('time_tracker:frais'). '<br />' . elgg_view('input/text', array('name' => 'cost', 'id' => 'project_cost_'.$unique_id, 'value' => $cost, 'js' => 'style="width:100%;" onChange="save_time_tracker(\'' . $form_id . '\');"')) . '</label></p>';
	*/
	
	
	if ($project_guid != 'NOTES') {
		$content .= '<br />';
		
		// Commentaires sur la saisie sur CE projet (pas contradictoire avec les notes par date)
		$content .= '<p><label>' . elgg_echo('time_tracker:comment'). '<br />' . elgg_view('input/plaintext', array('name' => 'comment', 'class' => 'time_tracker_input_comment', 'id' => 'project_comment_'.$unique_id, 'value' => $comment, 'js' => 'style="width:100%; height:4ex;" onChange="save_time_tracker(\'' . $form_id . '\');"', 'title' => "Cliquez pour agrandir la zone de saisie")) . '</label></p>';
		
		// Validation de la feuille de saisie => plus éditable sauf par admin qui peut la "rouvrir"
		$content .= '<p class="time_tracker_validation_status">' . elgg_view('input/hidden', array('name' => 'validation', 'class' => 'time_tracker_validation', 'id' => 'project_validation_'.$unique_id, 'value' => $validation, 'js' => 'style="width:100%;" onChange="save_time_tracker(\'' . $form_id . '\');"')) . $validation_status . '</p>';
	}
	
}


if (!isset($vars['entity']) && !$project_name) {
	$content .= '<a class="elgg-button elgg-button-action" href="javascript:void(0);" onclick="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . '); location.reload();">' . elgg_echo('time_tracker:save_new') . '</a>';
}

$content .= '</form></div>';

echo $content;
?>

