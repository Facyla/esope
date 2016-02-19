<?php
/**
 * Elgg time_tracker personal edit and summary page
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
$summary = get_input('summary', false);

// Set the page owner
$username = get_input('username', $_SESSION['username']);
$member = get_user_by_username($username);
if ($member === false || is_null($member)) { $member = elgg_get_logged_in_user_entity(); }
$member_guid = $member->guid;
elgg_set_page_owner_guid($member_guid);


// Seuls les admins peuvent consulter ou faire les saisies pour une autre personne
if (($member->guid != $_SESSION['guid']) && !elgg_is_admin_logged_in()) { forward('time_tracker'); }

$project_guid = get_input('project_guid', 'none');

$content .= '<style type="text/css">' . elgg_view('project_manager/css') . '</style>';
$js = '<script type="text/javascript">' . elgg_view('project_manager/js') . '</script>';

// Ajax loader : Please wait while updating animation
$content .= '<div id="loading_overlay" style="display:none;"><div id="loading_fader">' . elgg_echo('project_manager:ajax:loading') . '</div></div>';


// Composition de la page
if ($summary) {
  
  $title = sprintf(elgg_echo('time_tracker:summary:owner'), $member->name);
  
  // Bloc dépliable : informations générales et mode d'emploi
  $info_doc = '<div class="infobox_quote">' . elgg_echo('time_tracker:summary:details') . '</div>';
  $content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
  $content .= '<br /><br />';
  
  // Projets renseignés
  $projects = time_tracker_get_projects($member->guid);
  
  // Saisies validées ou non
  $time_tracker_validated = unserialize($member->time_tracker_validated);
  
  // Collecte et affichage des données
  $total_time = 0; $total_prod_time = 0;
  
  // Entêtes du tableau
  for ($year = 2013; $year <= (date('Y')); $year++) {
    $yearly_sums = array();
    $content .= "<h4>$year</h4>";
    $content .= '<table class="project_manager" style="width:100%;">';
    $content .= '<tr>
      <th colspan="3">Date, nombre de jours et validation</th>
      <th colspan="2">Somme des Temps</th>
      <th colspan="4">Temps spéciaux</th>
      <th colspan="' . sizeof($projects). '">Projets</th>';
    $content .= '</tr>';
    $content .= '<tr>
      <th scope="col">Mois</th>
      <th scope="col">Nb Jours</th>
      <th scope="col">Validation</th>
      <th scope="col">Tps saisi</th>
      <th scope="col">Production</th>
      <th scope="col">Congé</th>
      <th scope="col">Gestion</th>
      <th scope="col">Avant-vente</th>
      <th scope="col">Travaux techniques</th>';
    foreach ($projects as $project) {
      //$project_code = $project->project_code;
      $project_code = $project->project_code;
      if (empty($project_code)) $project_code = substr($project->title, 0, 7) . '…';
      if (empty($project_code)) $project_code = elgg_echo('time_tracker:code:undefined');
      $content .= '<th scope="col">' . $project_code . '</th>';
    }
    $content .= '</tr>';
    $total_prod_year = 0;
    $total_time_year = 0;
    $total_time_validation = 0;
    $jours_ouvrables_year = 0;
    
    // Saisies et indicateurs Mois par mois..
    $max_month = 12;
    if ($y == date('Y')) $max_month = date('m');
    for ($month = 1; $month <= $max_month; $month++) {
      $month_projects = '';
      $total_prod_month = 0; // Tous les temps sur les projets (production)
      $total_time_month = 0; // Tous les temps saisis (pour comparaison avec jours ouvrables)
      foreach ($projects as $project) {
        $project_time = time_tracker_monthly_time($year, $month, $project->guid, $member_guid);
        $month_projects .= '<td>' . $project_time . '</td>';
        if (!isset($yearly_sums[$project->guid])) $yearly_sums[$project->guid] = $project_time;
        else $yearly_sums[$project->guid] += $project_time;
        $total_prod_month += $project_time;
        $total_time_month += $project_time;
      }
      $jours_ouvrables_month = time_tracker_nb_jours_ouvrable($year, $month);
      $jours_ouvrables_year += $jours_ouvrables_month;
      // Rapport d'activité validé ?
      $validated = '<span class="notvalidated">Non</span>';
      if ($time_tracker_validated[$year][$month] == 1) {
        $validated = '<span class="validated">Oui</span>';
        $total_time_validation++;
      }
      // Congés
      $c_time = time_tracker_monthly_time($year, $month, 'C', $member_guid);
      if (!isset($yearly_sums['C'])) $yearly_sums['C'] = $c_time; else $yearly_sums['C'] += $c_time;
      $total_time_month += $c_time; // Compté dans temps saisi
      // Gestion
      $g_time = time_tracker_monthly_time($year, $month, 'G', $member_guid);
      if (!isset($yearly_sums['G'])) $yearly_sums['G'] = $g_time; else $yearly_sums['G'] += $g_time;
      $total_time_month += $g_time; // Compté dans temps saisi
      // Avant-vente
      $a_time = time_tracker_monthly_time($year, $month, 'A', $member_guid);
      if (!isset($yearly_sums['A'])) $yearly_sums['A'] = $a_time; else $yearly_sums['A'] += $a_time;
      $total_time_month += $a_time; // Compté dans temps saisi
      // Travaux techniques
      $t_time = time_tracker_monthly_time($year, $month, 'T', $member_guid);
      if (!isset($yearly_sums['T'])) $yearly_sums['T'] = $t_time; else $yearly_sums['T'] += $t_time;
      $total_time_month += $t_time; // Compté dans temps saisi
      
      // Contenu de la ligne de tableau
      $content .= '<tr>';
      //$content .= '<td scope="row"><a href="">' . ((strlen($month) == 1) ? "0$month" : $month) . ' ' . $months[(int)$month] . ' ' . $year . '</a></td>';
      $content .= '<td scope="row"><a href="' . $CONFIG->url . 'time_tracker/' . $year . '/' . ((strlen($month) == 1) ? "0$month" : $month) . '">' . $months[$month] . ' ' . $year . '</a></td>';
      $content .= '<td class="reference_data">' . $jours_ouvrables_month . '</td>';
      $content .= '<td class="inner-result">' . $validated . '</td>';
      $content .= '<td class="inner-result">' . $total_time_month . '</td>';
      $content .= '<td class="inner-result">' . $total_prod_month . '</td>';
      $content .= '<td>' . $c_time . '</td>
        <td>' . $g_time . '</td>
        <td>' . $a_time . '</td>
        <td>' . $t_time . '</td>';
      $content .= $month_projects;
      $total_time_year += $total_time_month; // Temps saisi total annuel
      $total_prod_year += $total_prod_month; // Temps de production total annuel
      $content .= '</tr>';
    }
    
    // Contenu de la ligne des totaux
    $content .= '<tr><td scope="row" style="font-weight:bold;">Total</td>
      <td class="result">' . $jours_ouvrables_year . '</td>
      <td class="result">' . $total_time_validation . '</td>
      <td class="result">' . $total_time_year . '</td>
      <td class="result">' . $total_prod_year . '</td>
      <td class="result">' . $yearly_sums['C'] . '</td>
      <td class="result">' . $yearly_sums['G'] . '</td>
      <td class="result">' . $yearly_sums['A'] . '</td>
      <td class="result">' . $yearly_sums['T'] . '</td>';
    foreach ($projects as $project) { $content .= '<td class="result">' . $yearly_sums[$project->guid] . '</td>'; }
    $content .= '</tr>';
    $content .= '</table><br />';
    $total_time += $total_time_year;
    $total_prod_time += $total_prod_year;
  }
  
  $content .= '<strong>Total général : ' . $total_prod_time . ' jours produits (' . $total_time . ' jours saisis)</strong><br />';
  $content .= '<br />';
  
  
  /*
  // Affichage de toutes les saisies précédentes
  $content .= '<h3>Toutes mes feuilles de temps</h3>';
  $options = array(
      'types' => 'object', 'subtypes' => 'time_tracker', 'owner_guids' => $member_guid,
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
  
// Vue de saisie mensuelle
} else {
  
  // Date_stamp
  $date_stamp = get_input('date_stamp', false);
  if ($date_stamp) {
    $year = substr($date_stamp, 0, 4);
    $month = substr($date_stamp, 4, 2);
  } else {
    $year = get_input('year', date('Y'));
    if (strlen($year) == 6) {
      $month = substr($year, 4, 2);
      $year = substr($year, 0, 4);
    } else $month = get_input('month', date('m'));
    // Besoin de 2 caractères pour le date_stamp
    if (strlen($month) == 1) $month = "0$month";
    $date_stamp = (string)$year.$month;
  }
  // Previous month datestamp
  $m1_year = (int)$year;
  if ((int)$month > 1) { $m1_month = (int)$month - 1; } else { $m1_month = 12; $m1_year -= 1; }
  if (strlen($m1_month) == 1) $m1_month = "0$m1_month";
  $m1_date_stamp = (string)$m1_year.$m1_month;
  
  
  $title = sprintf(elgg_echo('time_tracker:owner'), $member->name);
  
  // Bloc dépliable : informations générales et mode d'emploi
  $info_doc = '<div class="infobox_quote">' . elgg_echo('time_tracker:details') . '</div>';
  $content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
  $content .= '<br /><br />';
  
  // Ajout nouvelle ligne projet-temps sur ce mois
  $content .= '<div style="">';
  $content .= '<em>Pour ajouter une colonne au tableau, cliquez sur "+ Projet" et validez.</em><br />';
  $content .= '<div id="time_tracker_newtime" style="display:none;">' . elgg_view('forms/time_tracker', array('time_tracker' => array('user_guid' => $member_guid, 'year' => $year, 'month' => $month), 'hide_projects' => $hide_projects)) . '</div>';
  $content .= '<div class="clearfloat"></div><em>Si votre projet ne figure pas dans la liste, <a href="' . $vars['url'] . 'project_manager/new">vous pouvez le créer</a> puis revenir le renseigner ici.</em><br />';
  $content .= '</div>';
  $content .= '<div class="clearfloat"></div>';
  
  $content .= '<br />';
  // Sélecteur pour changer de mois de saisie
  $content .= '<span style="float:right;">' . time_tracker_select_input_month($year, $month, "time_tracker/owner/$username", '/') . '</span>';
  
  // AFFICHAGE SAISIES DU MOIS DEMANDÉ
  $content .= '<h3>Rapport d\'activités du mois de '.$months[(int)$month].'</h3>';
  
  // Saisies validées ou non ?
  $time_tracker_validated = unserialize($member->time_tracker_validated);
  $validated = $time_tracker_validated[$year][$month];
  //$content .= "Saisies validées : " . print_r($time_tracker_validated, true) . '<br />';
  // Si saisies validées et pas admin => pas de modif possible
  if (($validated == 1) && !elgg_is_admin_logged_in()) {
    $content .= '<div style="border:2px solid red; margin:0 0 12px 0; padding:6px 12px; font-weight:bold">Le rapport a été validé et ne peut plus être modifié<br />Si vous souhaitez tout de même le modifier merci de vous adresser à un adminnistrateur.<br /><br />';
  } else {
    if ($validated == 1) $content .= '<div style="border:2px solid red; margin:0 0 12px 0; padding:6px 12px; font-weight:bold">Le rapport a été validé et ne devrait plus être modifié<br />En tant qu\'administrateur vous pouvez tout de même le changer.</div>';
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
    $total_time_month = 0;
    $total_prod_month = 0;
    $total_special_month = 0;
    $hide_projects = array(); // Sert à ne pas réafficher les projets déjà renseignés dans le nouveau formulaire
    $project_times = '';
    $content .= time_tracker_add_header_col($year, $month, $member_guid, $validated);
    
    // Si aucune saisie pour le moment, on tente de reprendre celles du mois précédent
    if (!$time_trackers) {
      $options['count'] = true;
      $options['metadata_values'] = $m1_date_stamp;
      $count_m1_time_trackers = elgg_get_entities_from_metadata($options);
      $options['count'] = false;
      $options['limit'] = $count_m1_time_trackers;
      $m1_time_trackers = elgg_get_entities_from_metadata($options);
      $m1_projects = array();
      if ($m1_time_trackers) foreach ($m1_time_trackers as $ent) {
        if (!in_array($ent->project_guid, $m1_projects) && !in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C'))) $m1_projects[] = $ent->project_guid;
      }
      if ($m1_projects) foreach ($m1_projects as $guid) {
        $content_projects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => $guid, 'year' => $year, 'month' => $month)));
      }
    }
    
    if ($time_trackers) foreach ($time_trackers as $ent) {
      $hide_projects[] = $ent->project_guid;
      //if (in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C'))) continue;
      //$content .= elgg_view('object/time_tracker', array('entity' => $ent));
      // Comptage des temps du mois
      $project_time = time_tracker_monthly_time($year, $month, $ent->project_guid, $member_guid);
      // Nom complet du projet
      $project_name = time_tracker_get_projectname($ent->project_guid);
      if ($project = get_entity($ent->project_guid)) {
        if ($project instanceof ElggObject) {
          $content_projects .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
          $project_times .= '<strong>' . $project_name . '&nbsp;:</strong>' . " : " . $project_time . ' jours<br />';
          $total_prod_month += $project_time;
          $total_time_month += $project_time;
        } else if ($project instanceof ElggUser) {
          // Note : cette saisie est supprimée au profit des saisies spéciales CATG
          $ent->delete();
          /*
          $content_otherprojects .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
          $project_times .= $project_name . " : " . $project_time . ' jours<br />';
          // Temps non compté en production si hors-projet
          $total_prod_month += $project_time;
          $total_time_month += $project_time;
          */
        }
      } else {
        $content_metaprojects .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
        $project_times .= '<strong>' . $project_name . '&nbsp;:</strong>' . $project_time . ' jours<br />';
        // Temps non compté en production si hors-projet
        //$total_prod_month += $project_time;
        $total_special_month += $project_time;
        $total_time_month += $project_time;
      }
    }

    // Ajout des colonnes hors-projet si pas déjà affichées
    // Congés
    if (!in_array('C', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'C', 'year' => $year, 'month' => $month)));
    // Avant-vente
    if (!in_array('A', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'A', 'year' => $year, 'month' => $month)));
    // Gestion
    if (!in_array('G', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'G', 'year' => $year, 'month' => $month)));
    // Travaux techniques
    if (!in_array('T', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'T', 'year' => $year, 'month' => $month)));

    // Autres, hors-projet - non affecté
    /*
    if (!in_array($member_guid, $hide_projects)) $content_otherprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => $member_guid, 'year' => $year, 'month' => $month)));
    */
    
    // Ajout dans l'ordre des différents types de saisies
    $content .= $content_metaprojects . $content_projects . $content_otherprojects;
    $content .= '<span class="elgg-button elgg-button-action" id="add_project_toggle"><a href="javascript:void(0);" onclick="$(\'#time_tracker_newtime\').show(); $(\'#add_project_toggle\').hide();">' . elgg_echo('time_tracker:add_new') . '</a></span>';
    $content .= '<div class="clearfloat"></div><br /><br />';
    
    // Lien vers notes de frais
    $content .= '<h3>Notes de frais</h3><a class="elgg-button elgg-button-action" href="' . $GLOBAL->url . 'project_manager/expenses/' . $member->username . '" target="_new" title="Saisir les notes de frais dans une nouvelle fenêtre">Saisir ';
    if ($member_guid == elgg_get_logged_in_user_guid()) $content .= 'mes notes de frais ';
    else $content .= 'les notes de frais de ' . $member->name;
    $content .= '</a><br /><br />';
    
    // Récap des saisies et posibilités de validation
    $jours_ouvrables_month = time_tracker_nb_jours_ouvrable($year, $month);
    $content .= '<div style="border:2px dashed red; margin:6px; padding:4px 12px; text-align:center; font-weight:bold;">';
    $content .= "Une fois votre saisie terminée, rechargez la page pour vérifier votre saisie et pouvoir valider votre rapport d'activité.<br />";
    $content .= '<a class="elgg-button elgg-button-action" href="' . full_url() . '">Recharger la page</a>';
    $content .= '</div><br />';
    
    // Indicateurs et synthèse mensuelle
    $content .= '<h4>Synthèse pour '.$months[(int)$month].'</h4>';
    $content .= '<div class="infobox_info" style="width:46%; float:left;">';
    $content .= "Nombre de jours ouvrables dans le mois : $jours_ouvrables_month jours<br />";
    $content .= "Nombre de jours renseignés (production ou congé) : $total_time_month jours<br />";
    $content .= "Total du temps de production : $total_prod_month jours<br />";
    $content .= "Total du temps hors-production (CTGA) : $total_special_month jours<br />";
    if ($total_time_month >= $jours_ouvrables_month) { $content .= '<strong style="color:darkgreen;">Validation possible.</strong>'; }
    else {
      $content .= '<strong style="color:red;">Certains jours ne sont pas renseignés : merci de les compléter.</strong>';
      /*
      // Calcul timestamp du dernier jour ouvré du mois
      $last_day_of_month = $count_days_in_month;
      while ( (time_tracker_jour_ouvrable($year, $month, $last_day_of_month) != 1) && ($last_day_of_month > 1)) { $last_day_of_month--; }
      $end_of_month = mktime(0, 0, 0, $month, $last_day_of_month, $year);
      if (time() >= $end_of_month) {
        $content .= '<strong style="color:red;">Vous pouvez tout de même valider une saisie incomplète.</strong>';
      }
      */
    }
    $content .= '<br /><div style="font-size:11px; margin-top:8px;"><strong>Détail par projet</strong>' . $project_times . '</div>';
    $content .= '</div>';
    
    $content .= '<div class="infobox_encart" style="width:46%; float:right;">';
    $content .= "Statut : " . elgg_echo('project_manager:items_status:'.$member->items_status) . "<br />";
    if ($member->items_status == 'salarie') {
      $content .= "Coût annuel brut : {$member->yearly_global_cost} €<br />";
      $content .= "Coût mensuel moyen : " . round(($member->yearly_global_cost / 12),2) . " €<br />";
      $content .= "Coût journalier moyen : " . round(($member->yearly_global_cost / 12 / 20),2) . " €<br />";
      $content .= "Part variable annuelle : {$member->yearly_variable_part} €<br />";
    } else if ($member->items_status == 'non-salarie') {
      $content .= "Coût de journée : " . $member->daily_cost . " € / jour<br />";
      // Note : varie selon les projets (et les profils ?)
    } else {}

    $content .= '</div>';
  }
  $content .= '<div class="clearfloat"></div><br />';
}


// Rendu de la page
$body = elgg_view_layout('one_column', array('content' => $content . $js, 'sidebar' => '', 'title' => $title));
echo elgg_view_page($title, $body);

