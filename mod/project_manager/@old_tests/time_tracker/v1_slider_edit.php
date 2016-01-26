<?php
$content = '';
if (!isset($vars['id'])) {
  global $unique_id; if ($unique_id > 0) $unique_id++; else $unique_id = 1;
}

if (isset($vars['entity'])) {
  $time_tracker = $vars['entity'];
  $time_tracker_guid = $time_tracker->guid;
  $user_guid = $time_tracker->owner_guid;
  $year = $time_tracker->year;
  $month = $time_tracker->month;
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


$content .= '<div style="border:1px solid #CCC; padding:6px 12px; margin:6px;">';

  if (isset($vars['entity'])) {
    $project = get_entity($project_guid);
    if ($project instanceof ElggObject) $project_name = $project->title;
    else $project_name = elgg_echo('time_tracker:otherproject');
    $content .= '<label>' . $project_name . elgg_view('input/hidden', array('name' => 'project_guid', 'id' => 'project_'.$unique_id, 'value' => $project_guid)) . '</label>';
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
      echo '<p style="font-weight:bold; color:darkred;">Tous les projets connus ont été renseignés : veuillez créer un nouveau projet ou modifier les saisies sur les projets existants.</p>';
      return;
    }
    $content .= '<label>Projet ' . elgg_view('input/dropdown', array('name' => 'project_guid', 'id' => 'project_'.$unique_id, 'options_values' => $projects_options, 'value' => $project_guid, 'js' => 'onChange="get_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',this.value,' . $unique_id . '); if(this.value == \'none\'){ $(\'#time_tracker_form_' . $unique_id . '\').hide(); } else { $(\'#time_tracker_form_' . $unique_id . '\').show(); }"')) . '</label>';
  }

  if (!empty($project_guid)) $content .= '<span id="time_tracker_form_' . $unique_id . '">';
  else $content .= '<span id="time_tracker_form_' . $unique_id . '" style="display:none;">';

    // Frais associés à ce projet
    $content .= '<label style="margin-left:20px; float:right;">Frais ' . elgg_view('input/text', array('name' => 'cost', 'id' => 'project_cost_'.$unique_id, 'value' => $cost, 'js' => 'style="width:16ex;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '&nbsp;€</label>';

    $content .= '<div class="clearfloat"></div>';
    
    // Nb de jours (note : si aucun projet défini, temps non enregistré)
    $content .= '<span style="float:left;">' . elgg_view('input/time_tracker_element', array('name' => 'days', 'id' => 'project_days_'.$unique_id, 'text' => "Jours", 'min' => 0, 'max' => 31, 'value' => $days, 'time_tracker' => $vars['time_tracker'])) . '</span>';

    // Nb d'heures (note : si aucun projet défini, temps non enregistré)
    $content .= '<span style="float:left;">' . elgg_view('input/time_tracker_element', array('name' => 'hours', 'id' => 'project_hours_'.$unique_id, 'text' => "+ Heures", 'min' => 0, 'max' => 23, 'value' => $hours, 'step' => '1', 'time_tracker' => $vars['time_tracker'])) . '</span>';

    $content .= '<div class="clearfloat"></div>';
    
    // Commentaires sur cette saisie (note : si aucun projet défini, temps non enregistré)
    $content .= '<p><label>Commentaire ' . elgg_view('input/text', array('name' => 'comment', 'id' => 'project_comment_'.$unique_id, 'value' => $comment, 'js' => 'style="width:90%;" onChange="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . ');"')) . '<label></p>';

  $content .= '</span>';
  
  if (!isset($vars['entity'])) {
    $content .= '<a class="elgg-button" href="javascript:void(0);" onclick="update_time_tracker(' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id . '); location.reload();">' . elgg_echo('time_tracker:add_new') . '</a>';
  }

$content .= '</div>';

echo $content;


