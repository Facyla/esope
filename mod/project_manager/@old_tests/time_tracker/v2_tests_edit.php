<?php
/* Notes de conception
 Ce form, par projet, doit pouvoir s'afficher sous forme d'une colonne d'un tableau : la sauvegarde s'effectue par projet <=> par colonne, mais on doit donc avoir les entêtes dans le form global
*/

$content = '';

global $time_tracker_displayed_datelabel;

$fr_days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
$fr_shortdays = array('D', 'L', 'M', 'M', 'J', 'V', 'S');

if (!isset($vars['id'])) {
  global $unique_id; if ($unique_id > 0) $unique_id++; else $unique_id = 1;
}

if (isset($vars['entity'])) {
  $time_tracker = $vars['entity'];
  $time_tracker_guid = $time_tracker->guid;
  $user_guid = $time_tracker->owner_guid;
  $year = $time_tracker->year;
  $month = $time_tracker->month;
  $time_inputs = $time_tracker->time_tracker;
  $days = $time_tracker->days;
  $hours = $time_tracker->hours;
  $cost = $time_tracker->cost;
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
  $year = $vars['time_tracker']['year'];
  $month = $vars['time_tracker']['month'];
  $project_guid = $vars['time_tracker']['project_guid'];
  // Permet de regrouper les valeurs d'un même formulaire
  $vars['time_tracker']['unique_id'] = $unique_id;
}

$content .= '<form id="time_tracker_form_' . $unique_id . '" style="border-right:1px solid #000; padding:0px 0px 12px 2px; margin:0px 4px 0px 0px; float:left; ';
if ($time_tracker_displayed_datelabel) $content .= 'max-width:8ex;'; else $content .= 'max-width:12ex;>';
$content .= '">';
  
  // Si projet non choisi, on le choisit et on enregistre + reload dans la foulée, sinon saisie directe
  if (isset($vars['entity'])) {
    $project = get_entity($project_guid);
    if ($project instanceof ElggObject) $project_name = $project->title;
    else $project_name = elgg_echo('time_tracker:otherproject');
    $content .= '<label style="display:block; max-width:20ex; height:16ex;">' . $project_name . elgg_view('input/hidden', array('name' => 'project_guid', 'id' => 'project_'.$unique_id, 'value' => $project_guid)) . '</label>';
  } else {
    // 1. Choix du projet pour affectation des temps saisis
    $projects_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'count' => true));
    $projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'limit' => $projects_count));
    $projects_options['none'] = "  -- Choisir un projet -- ";
    if (!is_array($vars['hide_projects']) || !in_array($user_guid, $vars['hide_projects'])) $projects_options[$user_guid] = elgg_echo('time_tracker:otherproject');
    foreach ($projects as $ent) {
      // Affiché si pas de filtre ou pas dans le filtre
      if (!is_array($vars['hide_projects']) || !in_array($ent->guid, $vars['hide_projects'])) $projects_options[$ent->guid] = $ent->title;
    }
    if (sizeof($projects_options) == 1) {
      echo '<p style="font-weight:bold; color:darkred;">Tous les projets connus ont été renseignés : veuillez créer un nouveau projet, ou modifier les saisies sur les projets existants.</p>';
      return;
    }
    $content .= '<label>Projet ' . elgg_view('input/dropdown', array('name' => 'project_guid', 'id' => 'project_'.$unique_id, 'options_values' => $projects_options, 'value' => $project_guid, 'js' => 'onChange="get_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',this.value,' . $unique_id . '); if(this.value == \'none\'){ $(\'#time_tracker_form_' . $unique_id . '\').hide(); } else { $(\'#time_tracker_form_' . $unique_id . '\').show(); }"')) . '</label>';
  }
  
  // Autres infos utiles du formulaire de saisie pour le projet
  $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id
  $content .= '<label>' . elgg_view('input/hidden', array('name' => 'user', 'value' => $user_guid)) . '</label>';
  $content .= elgg_view('input/hidden', array('name' => 'year', 'value' => $year));
  $content .= elgg_view('input/hidden', array('name' => 'year', 'value' => $year));
  $content .= elgg_view('input/hidden', array('name' => 'month', 'value' => (int)$month));
  $content .= elgg_view('input/hidden', array('name' => 'unique_id', 'value' => $unique_id));
  
  // Suite du formulaire ssi projet choisi
  
  if (!empty($project_guid)) $content .= '<span id="time_tracker_hideform_' . $unique_id . '">';
  else $content .= '<span id="time_tracker_hideform_' . $unique_id . '" style="display:none;">';

/*
	    user: user,
      year: year,
      month: month,
      unique_id: unique_id,
      project: $("#project_" + unique_id).val(),
*/

    $content .= '<div class="clearfloat"></div>';
    
    // @TODO : on a besoin de savoir pour quel mois de quelle année on saisit les données
    // Doc : http://php.net/manual/fr/function.date.php
    // mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
    // $date_timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date_timestamp = mktime(0, 0, 0, $month, 1, $year); // timestamp au 1er du mois
    $count_days_in_month = date('t', $date_timestamp);
    // Weekend ou pas : w 	Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
    
    
    // Pour chaque jour du mois : saisie par projet
    // $time_inputs = $time_tracker->time_tracker;
    // @TODO changer cette façon de stocker en ->time_tracker = array($day_of_month => array('time', 'cost', 'comment', 'extra_hours'))
    // Pour tableau multi-dimensionnel : name="time_tracker[day_of_month][hours]", etc.
    for ($i = 1; $i <= $count_days_in_month; $i++) {
      $content .= '<div style="border-top:1px solid #000;">';
      $date_timestamp = mktime(0, 0, 0, $month, $i, $year); // timestamp à 00:00 du jour donné
      $day_of_week = date('w', $date_timestamp); // Weekend ou pas : w 	Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
      $is_weekend = false;
      if (($day_of_week < 1) || ($day_of_week == 6)) $is_weekend = true;
      
      if (!$time_tracker_displayed_datelabel) {
        $add_month_label = $fr_shortdays[$day_of_week] . ' ';
        $content .= '<div style="float:left; font-size:10px; width:30px;">';
        if (strlen($i) == 1) $content .= $add_month_label . '0' . $i;
        else $content .= $add_month_label . $i;
        $content .= '</div>';
      }
      
      // Nb d'heures
      $content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][hours]', 'id' => 'project_hours_'.$i.'_'.$unique_id, 'min' => 0, 'max' => 7, 'value' => $time_inputs[$i]['hours'], 'step' => '1', 'js' => 'style="max-width:4ex;"'));

      // Nb d'heures supp
      $content .= elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][extra_hours]', 'id' => 'project_extra_hours_'.$i.'_'.$unique_id, 'min' => 0, 'max' => 17, 'value' => $time_inputs[$i]['extra_hours'], 'step' => '1', 'js' => 'style="max-width:4ex;"'));
      
      /*
      // Frais associés à ce projet
      $content .= '<label style="margin-left:20px; float:right;">Frais ' . elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][cost]', 'id' => 'project_cost_'.$unique_id, 'value' => $cost, 'js' => 'style="width:16ex;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '&nbsp;€</label>';
      
      // Commentaire sur cette saisie
      $content .= '<p><label>Commentaire ' . elgg_view('input/text', array('name' => 'time_tracker[' . $i . '][comment]', 'id' => 'project_comment_'.$unique_id, 'value' => $comment, 'js' => 'style="width:90%;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '<label></p>';
      */
      
      $content .= '<br />';
      
      /*
      // Nb de jours (note : si aucun projet défini, temps non enregistré)
      $content .= '<span style="float:left;">' . elgg_view('input/time_tracker_month', array('name' => 'days', 'id' => 'project_days_'.$unique_id, 'text' => "Jours", 'min' => 0, 'max' => 31, 'value' => $days, 'time_tracker' => $vars['time_tracker'])) . '</span>';

      // Nb d'heures (note : si aucun projet défini, temps non enregistré)
      $content .= '<span style="float:left;">' . elgg_view('input/time_tracker_month', array('name' => 'hours', 'id' => 'project_hours_'.$unique_id, 'text' => "+ Heures", 'min' => 0, 'max' => 23, 'value' => $hours, 'step' => '1', 'time_tracker' => $vars['time_tracker'])) . '</span>';

      $content .= '<div class="clearfloat"></div>';
      
      // Commentaires sur cette saisie (note : si aucun projet défini, temps non enregistré)
      $content .= '<p><label>Commentaire ' . elgg_view('input/text', array('name' => 'comment', 'id' => 'project_comment_'.$unique_id, 'value' => $comment, 'js' => 'style="width:90%;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '<label></p>';
      */
      $content .= '</div>';
    }
    
    $content .= '<div class="clearfloat"></div><br />';
    
    // Frais associés à ce projet
    $content .= '<p><label>Frais<br />' . elgg_view('input/text', array('name' => 'cost', 'id' => 'project_cost_'.$unique_id, 'value' => $cost, 'js' => 'style="width:8ex;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '€</label></p>';
    
    // Commentaires sur cette saisie ?
    $content .= '<p><label>Notes<br />' . elgg_view('input/plaintext', array('name' => 'comment', 'id' => 'project_comment_'.$unique_id, 'value' => $comment, 'js' => 'style="width:8ex; height:4ex;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '<label></p>';
    
  $content .= '</span>';
  
  // Ne plus afficher le menu
  $time_tracker_displayed_datelabel = true;
  
  if (!isset($vars['entity'])) {
    $content .= '<a class="elgg-button" href="javascript:void(0);" onclick="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . '); location.reload();">' . elgg_echo('time_tracker:add_new') . '</a>';
  }

$content .= '</form>';

echo $content;


