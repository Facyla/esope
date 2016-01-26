<?php
/**
 * Elgg project_manager browser
 * 
 * @package Elggproject_manager
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009 - 2009
 * @link http://elgg.com/
 */

project_manager_gatekeeper();
// project_manager_flexible_gatekeeper($ent, array('isexternal' => 'yes'), false);

// Accès réservé aux managers, et aux admins
project_manager_manager_gatekeeper();

// Give access to alll users, data, etc.
elgg_set_ignore_access(true);

global $CONFIG;
$months = time_tracker_get_date_table('months');
$short_months = time_tracker_get_date_table('months', true);
$content = '';

// Set required vars
// Set the page owner
$project_guid = get_input('project_guid', false);
if ($project_guid) $project = get_entity($project_guid);
// @TODO : Si project_guid est un code (CGAT), récupérer autrement le 'projet'
// pas un projet réellement, mais des infos attachées via le code_projet
$container_guid = get_input('container_guid', false);
if ($container_guid) $container = get_entity($container_guid);

// Get group and project, if exists
if ($project && ($project instanceof ElggObject)) {
  $container_guid = $project->container_guid;
  $container = get_entity($container_guid);
} else {
  $project = project_manager_get_project_for_container($container_guid);
  if ($project) $project_guid = $project->guid; else $project_guid = false;
}
if ($container) elgg_set_page_owner_guid($container_guid);

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

// Set the current page's owner to the site
elgg_set_page_owner_guid(0);
elgg_set_context('project_manager');



// Compose the page
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';
$content .= '<script type="text/javascript">' . elgg_view('project_manager/js') . '</script>';

$content .= elgg_view('project_manager/nav');

$content .= '<h3>' . elgg_echo('project_manager:managers') . '</h3>';
$managers = explode(',', elgg_get_plugin_setting('managers', 'project_manager'));
foreach ($managers as $manager_guid) {
  $manager = get_entity($manager_guid);
  if (!isset($managers_list)) $managers_list = $manager->name;
  else $managers_list .= ', ' . $manager->name;
}
$content .= '<p>' . $managers_list . '</p>';

$content .= '<div id="loading_fader" style="display:none; font-weight:bold; color:darkgreen;">' . elgg_echo('project_manager:edit:ok') . '</div>';

// Données de base pour calculs consultants
$coef_salarial = elgg_get_plugin_setting('coefsalarie', 'project_manager'); // 1.8
$coef_pv = elgg_get_plugin_setting('coefpv', 'project_manager'); // 1.35
$days_per_month = elgg_get_plugin_setting('dayspermonth', 'project_manager'); // 20
$content .= '<h3>' . elgg_echo('project_manager:settings:consultants:data') . '</h3>';
$content .= elgg_echo('project_manager:settings:coefsalarie') . ' : ' . $coef_salarial . '<br />';
$content .= elgg_echo('project_manager:settings:coefpv') . ' : ' . $coef_pv . '<br />';
$content .= elgg_echo('project_manager:settings:dayspermonth') . ' : ' . $days_per_month . '<br />';
$content .= '<br />';

// Formulaire pour changer de projet
$content .= time_tracker_select_input_project($project->guid);

// Formulaires pour changer de feuille de temps
$content .= '<span style="float:right;">' . time_tracker_select_input_month($year, $month, $base_url = 'project_manager/project/' . $project->guid, $name = 'date_stamp') . '</span>';


// Project view, if required data
if ((($container instanceof ElggGroup) || ($container instanceof ElggUser)) && ($project instanceof ElggObject)) {
  //$content .= "Groupe : $container_guid  - Projet : $project_guid";
  
  $js = '<script type="text/javascript">' . elgg_view('time_tracker/js') . '</script>';
  $content .= '<style>' . elgg_view('project_manager/css') . '</style>';
  
  // Project data
  $project_data = $project->project_data;
  $month_p_data = $project_data[$year][$month];
  // Project data for current month
  
  // Fiche mensuelle par projet
  $p_types = array('salarie' => "Production salariée", 'non-salarie' => "Production non salariée", 'otherhuman' => "Autres humains", 'other' => "Autres");
  $content .= '<div class="clearfloat"></div>';
  $content .= "EN COURS : Infos collectées et à rendre éditables (non sauvegardées pour le moment)<br /><br />";
  $content .= "<h2>Projet {$project->project_code}, pour le mois de " . $months[(int)$month] . " $year</h2>";
  
  /* Toutes les données saisies/ajustées du projet sont stockées dans une variable $project->project_data
   * celle-ci contient, sous une forme sérialisée, les données selon la structure suivante :
   * $project_data[$year][$month][$p_data] = $p_data;
   * avec $p_data[$p_type]['marge'][$id] = $value;
   * On re-calcule dynamiquement tout ce qui est variable (infos, indicateurs), et on peut alors initialiser les données avec des valeurs par défaut, et les conserver pour toute date de saisie.
  */
  $p_data = array();
  // $project_data[$p_type][$var_name][$id] = $value
  
  $project_manager = get_entity($project->projectmanager);
  $project_owner = get_entity($project->owner_guid);
  $content .= '<table style="width:100%;">';
  foreach ($p_types as $p_type => $p_type_title) {
    $content .= '<tr><th colspan="12">' . $p_type_title . '</th></tr>';
    // Entêtes pour chaque type de profils/postes
    $content .= '<tr>';
    $content .= '<td scope="col">Nom</td>';
    if ($p_type == 'other') $content .= '<td scope="col" colspan="2">Infos autres charges</td>';
    else $content .= '<td scope="col">CJM</td><td scope="col">Jours produits</td>';
    $content .= '<td scope="col">Coût1</td><td scope="col">Frais</td><td scope="col">Coût2</td>';
    if ($p_type == 'other') $content .= '<td scope="col" colspan="2">Infos autres CA</td>';
    else $content .= '<td scope="col">TJM</td><td scope="col">Jours consommés</td>';
    $content .= '<td scope="col">CA1</td><td scope="col">FraisF</td><td scope="col">CA2</td>';
    $content .= '<td scope="col">Marge</td>';
    $content .= '</tr>';

    // @TODO : liste des consultants de type $p_type intervenant sur le projet
    // à partir des données du projet et des saisies effectuées
    // Note : liste peut être éditée manuellement, via les params du projet !
    $postes = false;
    switch($p_type) {
      case 'salarie' :
        if (!empty($project->team)) $postes = $project->team;
        break;
      case 'non-salarie' :
        if (!empty($project->fullteam)) $postes = $project->fullteam;
        break;
      case 'otherhuman' :
        if (!empty($project->otherhuman)) {
          $postes = str_replace('\r', '\n', $project->otherhuman);
          $postes = str_replace('\n\n', '\n', $postes);
          $postes = explode('\n', $postes);
        }
        break;
      case 'other' :
        if (!empty($project->other)) {
          $postes = str_replace('\r', '\n', $project->other);
          $postes = str_replace('\n\n', '\n', $postes);
          $postes = explode('\n', $postes);
        }
        break;
    }
    // Ajout des autres membres impliqués dans le projet, selon leur statut, et s'ils ne l'ont pas déjà été..
    if (($project_manager->items_status == $p_type) && !in_array($project_manager->guid, $postes)) { $postes[] = $project_manager->guid; }
    if (($project_owner->items_status == $p_type) && !in_array($project_owner->guid, $postes)) { $postes[] = $project_owner->guid; }
    
    if (!is_array($postes)) $content .= '<tr><td colspan="12">' . elgg_echo('project_manager:novalue') . '</td></tr>';
    else foreach ($postes as $id) {
      $id = trim($id);
      // Pour sauter les lignes vides et autres blagues
      if (empty($id)) continue;
      
      // Infos et calculs
      // Données modifiable : on indique la valeur calculée automatiquement, et on permet de modifier avec :
      // elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project(PARAMS);"'));
      // JS : project_manager_update_project(year, month, project_guid, p_type, 'FIELD', id, this.value);
      
      // Poste concerné : consultant ou autre info du projet
      if ($ent = get_entity($id)) $line_name = $ent->name; else $line_name = $id;
      
      // Exception pour 'Autres' : CJM et Jours remplacé par 1 seule colonne 'Infos autres charges'
      if ($p_type == 'other') {
        $p_data[$p_type]['costinfo'][$id] = ''; // @TODO
        $p_data[$p_type]['cost1'][$id] = ''; // @TODO
      } else {
        $p_data[$p_type]['cjm'][$id] = time_tracker_get_user_daily_cost($ent);
        if ($ent instanceof ElggUser) $p_data[$p_type]['days'][$id] = time_tracker_monthly_time($year, $month, $project_guid, $id);
        else $p_data[$p_type]['days'][$id] = 0; // @TODO
        $p_data[$p_type]['cost1'][$id] = $p_data[$p_type]['cjm'][$id] * $p_data[$p_type]['days'][$id];
      }
      $p_data[$p_type]['frais'][$id] = 0; // @TODO
      $p_data[$p_type]['cost2'][$id] = $p_data[$p_type]['cost1'][$id] + $p_data[$p_type]['frais'][$id];
      
      if ($p_type == 'other') {
        // Exception pour 'Autres' : TJM et Jours remplacé par 1 seule colonne 'Infos autre CA'
        $p_data[$p_type]['costinfo2'][$id] = ''; // @TODO
        $p_data[$p_type]['ca1'][$id] = ''; // @TODO
      } else {
        $p_data[$p_type]['tjm'][$id] = 0; // @TODO : taux journalier moyen, sur *ce* projet
        $p_data[$p_type]['days2'][$id] = 0; // @TODO
        $p_data[$p_type]['ca1'][$id] = $p_data[$p_type]['tjm'][$id] * $p_data[$p_type]['days2'][$id];
      }
      $p_data[$p_type]['fraisf'][$id] = 0; // @TODO
      $p_data[$p_type]['ca2'][$id] = $p_data[$p_type]['ca1'][$id] + $p_data[$p_type]['fraisf'][$id];
      
      $p_data[$p_type]['marge'][$id] = $p_data[$p_type]['ca2'][$id] - $p_data[$p_type]['cost2'][$id];
      
      // Composition du contenu
      $content .= '<tr>';
      $content .= '<td scope="row">' . $line_name . '</h3></td>';
      if ($p_type == 'other') {
        $content .= '<td colspan="2">' . $p_data[$p_type]['costinfo'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:100%;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'costinfo\', '.$id.', this.value);"')) . '</td>';
        $content .= '<td>' . $p_data[$p_type]['cost1'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'cost1\', '.$id.', this.value);"')) . '</td>'; // @TODO
      } else {
        $content .= '<td>' . $p_data[$p_type]['cjm'][$id] . '</td>';
        $content .= '<td>' . $p_data[$p_type]['days'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'days\', '.$id.', this.value);"')) . '</td>';
        $content .= '<td>' . $p_data[$p_type]['cost1'][$id] . '</td>';
      }
      $content .= '<td>' . $p_data[$p_type]['frais'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'frais\', '.$id.', this.value);"')) . '</td>';
      $content .= '<td>' . $p_data[$p_type]['cost2'][$id] . '</td>';
      
      if ($p_type == 'other') {
        $content .= '<td colspan="2">' . $p_data[$p_type]['costinfo2'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:100%;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'costinfo2\', '.$id.', this.value);"')) . '</td>';
        $content .= '<td>' . $p_data[$p_type]['ca1'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'ca1\', '.$id.', this.value);"')) . '</td>'; // @TODO
      } else {
        $content .= '<td>' . $p_data[$p_type]['tjm'][$id] . ' ' . time_tracker_select_tjm($project, '', null) . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'tjm\', '.$id.', this.value);"')) . '</td>';
        $content .= '<td>' . $p_data[$p_type]['days2'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'days2\', '.$id.', this.value);"')) . '</td>';
        $content .= '<td>' . $p_data[$p_type]['ca1'][$id] . '</td>';
      }
      $content .= '<td>' . $p_data[$p_type]['fraisf'][$id] . ' ' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:10ex;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', '.$p_type.', \'fraisf\', '.$id.', this.value);"')) . '</td>';
      $content .= '<td>' . $p_data[$p_type]['ca2'][$id] . '</td>';
      
      $content .= '<td>' . $p_data[$p_type]['marge'][$id] . '</td>';
      $content .= '</tr>';
    }
    
    // Totaux = somme pour chacune des colonnes
    if (is_array($p_data[$p_type])) {
      $content .= '<tr>';
      $content .= '<th scope=row"">Total</th>';
      foreach ($p_data[$p_type] as $key => $values) {
        $key_total = array_sum($values);
        if (in_array($key, array('cjm', 'tjm'))) { $content .= '<td></td>'; continue; }
        // Exception pour 'Autres' : fusion de 2 colonnes en 1 seule
        if (($key == 'costinfo') || ($key == 'costinfo2')) {
          //$content .= '<td colspan="2">' . $key_total . '</td>';
          $content .= '<td class="result" colspan="2"></td>';
        } else {
          $content .= '<td class="result">' . $key_total . '</td>';
        }
      }
      $content .= '</tr>';
    }
    
  }
  $content .= '</table>';
  $content .= '<br />';

  // Données et calculs
  $project_total = $project->budget;
  $project_rap_m1 = 0; // @todo à éditer, ou issu saisie précédente ou calculé
  $project_raf_m1 = 0; // @todo à éditer, ou issu saisie précédente ou calculé
  $project_facture = 0; // @todo à éditer

  $project_charges = 0; // somme des (4) COUTS2
  if (is_array($p_data[$p_type]['cost2'])) foreach ($p_data[$p_type]['cost2'] as $id => $value) { $project_charges += $value; }
  $project_ca = 0; // somme des (4) CA2
  if (is_array($p_data[$p_type]['ca'])) foreach ($p_data[$p_type]['ca'] as $id => $value) { $project_ca += $value; }
  $project_fraisf = 0; // somme des (4) FRAISF
  if (is_array($p_data[$p_type]['fraisf'])) foreach ($p_data[$p_type]['fraisf'] as $id => $value) { $project_fraisf += $value; }
  $project_marge = $project_ca - $project_charges; // CA - CHARGES
  $project_rap = $project_rap_m1 - $project_ca + $project_fraisf; // (Reste à produire M-1) - CA + FraisF
  $project_raf = $project_rap_m1 - $project_facture; // (Reste à produire M-1) - (Facture à émettre)

  $content .= '<table style="width:100%;">';
  $content .= '<tr><td colspan="8">Infos générales du projet pour ce mois et synthèse</td></tr>';
  $content .= '<tr>';
  $content .= '<th colspan="2">Indicateurs mensuels</th>';
  $content .= '<th colspan="2">Récap mois précédent</th>';
  $content .= '<th colspan="2">Facturation et synthèse</th>';
  $content .= '<th>Notes / Remarques</th>';
  $content .= '</tr>';

  $content .= '<tr>';
  $content .= '<td scope="row">CHARGES</td><td class="result">' . $project_charges . '</td>';
  $content .= '<td scope="row">Total contrat</td><td class="result">' . $project_total . '</td>';
  $content .= '<td scope="row">Facture à émettre : ' . $project_facture . '</td><td>' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:100%;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', null, \'facture\', null, this.value);"')) . '</td>';
  $content .= '<td rowspan="4">' . elgg_view('input/plaintext', array('value' => '', 'js' => 'style="width:100%; height:80px;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', null, \'comment\', null, this.value);"')) . '</td>';
  $content .= '</tr>';
  $content .= '<tr>';
  $content .= '<td scope="row">CA</td><td class="result">' . $project_ca . '</td>';
  $content .= '<td scope="row">Reste à produire M-1 : ' . $project_rap_m1 . '</td><td>' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:100%;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', null, \'rap_m1\', null, this.value);"')) . '</td>';
  $content .= '<td scope="row">Reste à produire</td><td>' . $project_rap . '</td>';
  $content .= '</tr>';
  $content .= '<tr>';
  $content .= '<td scope="row">FraisF</td><td class="result">' . $project_fraisf . '</td>';
  $content .= '<td scope="row">Reste à facturer M-1 : ' . $project_raf_m1 . '</td><td>' . elgg_view('input/text', array('value' => '', 'js' => 'style="width:100%;" onChange="project_manager_update_project('.$year.', '.(int)$month.', '.$project_guid.', null, \'raf_m1\', null, this.value);"')) . '</td>';
  $content .= '<td scope="row">Reste à facturer</td><td>' . $project_raf . '</td>';
  $content .= '</tr>';
  $content .= '<tr>';
  $content .= '<td scope="row">Marge</td><td class="result">' . $project_marge . '</td>';
  $content .= '<td scope="row">FIN</td><td>' . $months[(int)$month]. '</td>';
  $content .= '<td colspan="2"></td>';
  $content .= '</tr>';

  $content .= '</table>';
  $content .= '<br /><br />';
  
  
  
  // Synthèse du temps passé sur le projet
  $content .= '<h2>Synthèse pour le projet ' . $project->project_code . '&nbsp;: ' . $project->title . '</h2>';
  $content .= time_tracker_project_times($project->guid);
  
  
  // Indicateurs et synthèse globale pour le projet
  $total_hours = time_tracker_project_total_time($project_guid);
  $content .= '<br /><h4>TODO : indicateurs à définir et construire, au niveau du projet</h4>';
  $content .= '<h4>Synthèse pour le projet</h4>';
  $content .= '<strong><a href="' . full_url() . '">Recharger la page pour actualiser les données ci-dessous</a></strong><br />';
  $content .= '<div style="border:1px solid red; padding:4px 8px; width:45%; float:left;">';
    $content .= "Temps total passé : " . $total_hours . " jours<br />";
    $content .= "Production mensuelle : " . (($total_hours * 600) + ($total_extra_hours * 100)) . " €<br />";
  $content .= '</div>';
  $content .= '<div class="clearfloat"></div><br />';
  
}


// Render page
elgg_set_context('project_manager');

$body = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => $area1, 'title' => $title));

$title = elgg_echo("project_manager:consultants");

echo elgg_view_page($title, $body); // Finally draw the page

