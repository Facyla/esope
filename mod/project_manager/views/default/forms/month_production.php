<?php

$container = $vars['container'];
$project = $vars['project'];
$project_guid = $project->guid;
$year = $vars['year'];
$month = $vars['month'];

$content = '';
$p_url = elgg_get_site_url() . 'project_manager/production/project/';
$edit_url = elgg_get_site_url() . 'project_manager/edit/';
$months = time_tracker_get_date_table('months');
$short_months = time_tracker_get_date_table('months', true);
// Données de base pour calculs consultants
$coef_salarial = elgg_get_plugin_setting('coefsalarie', 'project_manager'); // 1.8
$coef_pv = elgg_get_plugin_setting('coefpv', 'project_manager'); // 1.35
$days_per_month = elgg_get_plugin_setting('dayspermonth', 'project_manager'); // 20

$pm_meta = project_manager_get_user_metadata();

// Project view, if required data
if ((elgg_instanceof($container, 'group') || elgg_instanceof($container, 'user')) && elgg_instanceof($project, 'object')) {
	
	//$content .= "Groupe : $container_guid	- Projet : $project_guid";
	
	/* Toutes les données saisies/ajustées du projet sont stockées dans une variable $project->project_data
	 * celle-ci contient, sous une forme sérialisée, les données selon la structure suivante :
	 * $project_data[$year][$month][$c_p_data] = $c_p_data;
	 * avec $c_p_data[$p_type]['marge'][$id] = $value;
	 * On re-calcule dynamiquement tout ce qui est variable (infos, indicateurs), et on peut alors initialiser les données avec des valeurs par défaut, et les conserver pour toute date de saisie.
	*/
	// Project data (manual inputs)
	$project_data = unserialize($project->project_data);
	// Project data for current month
	$p_data = $project_data[(int)$year][(int)$month];
	
	// Computed project data (used for information, reference, default values, previous month values, etc.)
	$c_project_data = unserialize($project->c_project_data);
	// Computed project data for *this* month
	$c_p_data = array();
	/*
	// Note : data should be updated at the end of the page, and used only for next month
	$c_p_data = $c_project_data[$year][$month];
	*/
	
	// Dates du mois précédent : 1 mois de moins, ou 12e mois et 1 année de moins
	$m1_year = (int)$year;
	if ((int)$month > 1) { $m1_month = (int)$month - 1; } else { $m1_month = 12; $m1_year -= 1; }
	// Previous month p_data
	$m1_p_data = $project_data[(int)$m1_year][(int)$m1_month];
	// Previous month computed data
	$m1_c_p_data = $c_project_data[(int)$m1_year][$m1_month];
	
	
	// Formulaire et données nécessaires
	$form_id = 'project_manager_' . $project_guid . '_' . $year . '_' . $month;
	$content .= '<form method="POST" id="' . $form_id . '" action="' . elgg_get_site_url() . 'action/project_manager/edit_project_production">';
	$content .= elgg_view('input/securitytoken');
	$content .= elgg_view('input/hidden', array('name' => 'project_guid', 'value' => $project_guid));
	$content .= elgg_view('input/hidden', array('name' => 'year', 'value' => $year));
	$content .= elgg_view('input/hidden', array('name' => 'month', 'value' => (int)$month));
	
	
	// Pour enregistrer les données en JS : on a besoin de name sur chacun des champs à enregistrer
	// 1. En faire un form (global ou par mois)
	// 'name' => 'project_data[$year][$month][$p_type]['var_name'][$id]'
	// pas sur chaque champ, mais plutôt un bouton Save&Refresh : project_manager_save_project_production(form_id)
	
	// Fiche mensuelle par projet
	$p_types = array('salarie' => "Production salariée", 'non-salarie' => "Production non salariée", 'otherhuman' => "Autres humains", 'other' => "Autres");
	$salarie_vars = array('cjm', 'days', 'cost1', 'frais', 'cost2', 'tjm', 'days2', 'ca1', 'fraisf', 'ca2', 'marge');
	$nonsalarie_vars = $salarie_vars;
	$otherhuman_vars = $salarie_vars;
	$other_vars = array('costinfo', 'cost1', 'frais', 'cost2', 'costinfo2', 'ca1', 'fraisf', 'ca2', 'marge');
	
	//$content .= "<h2>Projet {$project->project_code}, pour le mois de " . $months[(int)$month] . " $year</h2>";
	// ($project_guid, $include_specials = true, $base_url = 'project_manager/production', $name = '/project/', $forward = true, $label = 'Changer de projet ')
	$content .= '<h2>Projet ' . time_tracker_select_input_project($project->guid, false, 'project_manager/production', '/project/', true, '') . ' pour le mois de ' . time_tracker_select_input_month($year, $month, 'project_manager/production/project/' . $project->guid, '/', true, '') . '</h2>';
	
	$content .= '<strong><a href="' . $edit_url . $project_guid . '">&raquo;&nbsp;modifier les informations du Projet</a></strong><br /><br />';
	
	// Si projet non signé => big alerte
	if ($project->project_managertype == 'unsigned') {
		register_error("ATTENTION : projet démarré mais NON SIGNÉ => à signer rapidement !!");
		$content .= '<div style="border:3px solid red; padding:6px 12px;">Projet démarré mais NON SIGNÉ => à signer rapidement !!</div>';
	}
	
	// @TODO Ajout des membres ayant effectué des saisies sur ce projet
	$content .= '<h3>Consultants ayant effectué des saisies sur ce projet</h3>';
	$unlisted_consultants = project_manager_get_consultants($project_guid);
	foreach($unlisted_consultants as $guid => $ent) { $involved_people[] = $guid; }
	$content .= elgg_view('output/members_list', array('value' => $involved_people));
	$content .= '<br />';
	
	$project_manager = get_entity($project->projectmanager);
	$project_owner = get_entity($project->owner_guid);
	$content .= '<table class="project_manager" style="width:100%;">';
	
	// Pour chaque type de poste (salariés, etc.)
	foreach ($p_types as $p_type => $p_type_title) {
		
		// Entête du type de poste
		$content .= '<tr><th colspan="13">' . $p_type_title . '</th></tr>';
		
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
					$postes = str_replace("\r", '\n', $project->otherhuman);
					$postes = str_replace('\n\n', '\n', $postes);
					$postes = explode('\n', $postes);
				}
				break;
			case 'other' :
				if (!empty($project->other)) {
					$postes = str_replace("\r", '\n', $project->other);
					$postes = str_replace('\n\n', '\n', $postes);
					$postes = explode('\n', $postes);
				}
				break;
		}
		if (!is_array($postes)) $postes = array($postes);
		// Ajout des autres membres impliqués dans le projet, selon leur statut, et s'ils ne l'ont pas déjà été..
		if (($project_manager->{$pm_meta} == $p_type) && !in_array($project_manager->guid, $postes)) { $postes[] = $project_manager->guid; }
		if (($project_owner->{$pm_meta} == $p_type) && !in_array($project_owner->guid, $postes)) { $postes[] = $project_owner->guid; }
		// Ajout des membres ayant effectué des saisies sur ce projet
		foreach($unlisted_consultants as $guid => $ent) {
			if (($ent->{$pm_meta} == $p_type) && !in_array($guid, $postes)) { $postes[] = $guid; }
		}
		
		$no_data_add_edit_link = elgg_echo('project_manager:novalue') 
			. " Pour définir d'autres postes de charges ou de CA, merci de les indiquer en 
			<a href=\"" . $edit_url . $project->guid . "\" target=\"_new\">mettant à jour les informations du projet (nouvelle fenêtre)</a>.";
		
		if (!is_array($postes)) {
			$content .= '<tr><td colspan="13">' . $no_data_add_edit_link . '</td></tr>';
		} else {
			// Entêtes pour chaque type de profils/postes
			$content .= '<tr>';
			$content .= '<th rowspan="2" scope="col">Nom</th>';
			$content .= '<th colspan="6" scope="col">Informations consultants (ajustables par chef de projet)</th>';
			$content .= '<th colspan="5" scope="col">Gestion par le chef de projet (saisies et calculs)</th>';
			$content .= '<th rowspan="2" scope="col">Marge</th>';
			$content .= '</tr>';
			$content .= '<tr>';
			//$content .= '<th scope="col">Nom</th>';
			$content .= '<th scope="col">Validé</th>';
			if ($p_type == 'other') $content .= '<th scope="col" colspan="2">Infos autres charges</th>';
			else $content .= '<th scope="col">CJM</th><th scope="col">J. produits</th>';
			$content .= '<th scope="col">Coût1</th><th scope="col">Frais</th><th scope="col">Coût2</th>';
			if ($p_type == 'other') $content .= '<th scope="col" colspan="2">Infos autres CA</th>';
			else {
				if (in_array($p_type, array('salarie', 'non-salarie'))) $content .= '<th scope="col">TJM ' . time_tracker_select_tjm($project, '', null) . '</th>';
				else $content .= '<th scope="col">TJM</th>';
				$content .= '<th scope="col">J. consommés</th>';
			}
			$content .= '<th scope="col">CA1</th><th scope="col">FraisF</th><th scope="col">CA2</th>';
			//$content .= '<th scope="col">Marge</th>';
			$content .= '</tr>';
			foreach ($postes as $id) {
				$id = trim($id);
				// Pour sauter les lignes vides et autres blagues
				if (empty($id)) continue;
				
				// DONNÉES ET CALCULS
				
				// Poste concerné : consultant ou autre info du projet
				if ($ent = get_entity($id)) $line_name = $ent->name; else $line_name = $id;
				
				// Champs différenciés pour 'Autres' :
				// CJM et Jours remplacés par 1 seule colonne 'Infos autres charges'
				// TJM et Jours remplacés par 1 seule colonne 'Infos autre CA'
				if ($p_type == 'other') {
					$c_p_data[$p_type]['costinfo'][$id] = ''; // à saisir
					$c_p_data[$p_type]['cost1'][$id] = ''; // à saisir
					$c_p_data[$p_type]['costinfo2'][$id] = ''; // à saisir
					$c_p_data[$p_type]['ca1'][$id] = ''; // à saisir
				} else {
					$c_p_data[$p_type]['cjm'][$id] = time_tracker_get_user_daily_cost($ent);
					if ($ent instanceof ElggUser) $c_p_data[$p_type]['days'][$id] = time_tracker_monthly_time($year, $month, $project_guid, $id);
					else $c_p_data[$p_type]['days'][$id] = 0; // à saisir
					$c_p_data[$p_type]['cost1'][$id] = $c_p_data[$p_type]['cjm'][$id] * $p_data[$p_type]['days'][$id];
					$c_p_data[$p_type]['tjm'][$id] = 0; // à saisir : taux journalier moyen, sur *ce* projet
					// Par défaut, jours consommés = jours saisis
					if (strlen($c_p_data[$p_type]['days2'][$id]) == 0) $c_p_data[$p_type]['days'][$id]; else $c_p_data[$p_type]['days2'][$id] = 0; // @TODO
					$c_p_data[$p_type]['ca1'][$id] = $p_data[$p_type]['tjm'][$id] * $p_data[$p_type]['days2'][$id];
				}
				// Données calculées ou saisies
				$c_p_data[$p_type]['frais'][$id] = time_tracker_monthly_frais($year, $month, $project_guid, $id); // saisie du consultant
				// Par défaut, Frais facturés = 0, mais pourrait être aussi frais saisis ?
				$c_p_data[$p_type]['fraisf'][$id] = $c_p_data[$p_type]['frais'][$id]; // Info pour FraisF = frais (mais pas valeur par défaut)
				// Données calculées à partir des précédentes
				$c_p_data[$p_type]['cost2'][$id] = $c_p_data[$p_type]['cost1'][$id] + $c_p_data[$p_type]['frais'][$id];
				$c_p_data[$p_type]['ca2'][$id] = $p_data[$p_type]['ca1'][$id] + $p_data[$p_type]['fraisf'][$id]; // Sur base données saisies
				$c_p_data[$p_type]['marge'][$id] = $c_p_data[$p_type]['ca2'][$id] - $c_p_data[$p_type]['cost2'][$id];
				
				// Valeurs par défaut des saisies
				if ($p_type == 'other') {
					if (strlen($p_data[$p_type]['costinfo'][$id]) == 0) $p_data[$p_type]['costinfo'][$id] = $c_p_data[$p_type]['costinfo'][$id];
					if (strlen($p_data[$p_type]['cost1'][$id]) == 0) $p_data[$p_type]['cost1'][$id] = $c_p_data[$p_type]['cost1'][$id];
					if (strlen($p_data[$p_type]['costinfo2'][$id]) == 0) $p_data[$p_type]['costinfo2'][$id] = $c_p_data[$p_type]['costinfo2'][$id];
					if (strlen($p_data[$p_type]['ca1'][$id]) == 0) $p_data[$p_type]['ca1'][$id] = $c_p_data[$p_type]['ca1'][$id];
				} else {
					if (strlen($p_data[$p_type]['days'][$id]) == 0) $p_data[$p_type]['days'][$id] = $c_p_data[$p_type]['days'][$id];
					if (strlen($p_data[$p_type]['tjm'][$id]) == 0) $p_data[$p_type]['tjm'][$id] = $c_p_data[$p_type]['tjm'][$id];
					if (strlen($p_data[$p_type]['days2'][$id]) == 0) $p_data[$p_type]['days2'][$id] = $c_p_data[$p_type]['days2'][$id];
				}
				if (strlen($p_data[$p_type]['frais'][$id]) == 0) $p_data[$p_type]['frais'][$id] = $c_p_data[$p_type]['frais'][$id];
				// FraisF pas calculés depuis Frais car c'est généralement inclus dans le prix global de la prestation
				//if (strlen($p_data[$p_type]['fraisf'][$id]) == 0) $p_data[$p_type]['fraisf'][$id] = $c_p_data[$p_type]['fraisf'][$id];
				
				
				// Composition du contenu
				$content .= '<tr>';
				$content .= '<td scope="row">' . $line_name . '</h3></td>';
				// Saisies validées ou non ?
				if (in_array($p_type, array('salarie', 'non-salarie'))) {
					// @TODO : mettre dans un array au début, pour éviter de récupérer les infos plusieurs fois
					$time_tracker_validated = unserialize($ent->time_tracker_validated);
					$val_month = ((strlen($month) == 1) ? "0$month" : $month);
					if ($time_tracker_validated[$year][$val_month] == 1) $content .= '<td style="color:darkgreen; font-weight:bold;">OK</td>';
					else $content .= '<td style="color:darkred; font-weight:bold;">NON</td>';
				} else $content .= '<td>&nbsp;</td>'; // Sans objet car pas de saisie..
				if ($p_type == 'other') {
					// Infos autres charges : saisie manuelle
					$content .= '<td colspan="2">' . $c_p_data[$p_type]['costinfo'][$id] . ' ' . elgg_view('input/text', array('name' => "p_data[$p_type][costinfo][$id]", 'value' => $p_data[$p_type]['costinfo'][$id], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
					// Coût 1 : saisie manuelle
					$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][cost1][$id]", 'value' => $p_data[$p_type]['cost1'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>défaut = ' . round($c_p_data[$p_type]['cost1'][$id], 2) . '</em></td>'; // @TODO
				} else {
					// CJM : donnée auto
					$content .= '<td>' . round($c_p_data[$p_type]['cjm'][$id], 2) . '</td>';
					// Jours produits : indication et valeur par défaut + ajustement manuel
					$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][days][$id]", 'value' => $p_data[$p_type]['days'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>saisie = ' . $c_p_data[$p_type]['days'][$id] . '</em></td>';
					// Coût 1 : calcul auto
					$content .= '<td>' . round($c_p_data[$p_type]['cost1'][$id], 2) . '</td>';
				}
				// Frais : indication et valeur par défaut + ajustement manuel
				$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][frais][$id]", 'value' => $p_data[$p_type]['frais'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>saisie = ' . $c_p_data[$p_type]['frais'][$id] . '</em></td>';
				// Coût 2 : calcul auto
				$content .= '<td>' . round($c_p_data[$p_type]['cost2'][$id], 2) . '</td>';
				
				if ($p_type == 'other') {
					// Infos autres CA
					$content .= '<td colspan="2">' . $c_p_data[$p_type]['costinfo2'][$id] . ' ' . elgg_view('input/text', array('name' => "p_data[$p_type][costinfo2][$id]", 'value' => $p_data[$p_type]['costinfo2'][$id], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
					// CA1
					$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][ca1][$id]", 'value' => $p_data[$p_type]['ca1'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>défaut = ' . round($c_p_data[$p_type]['ca1'][$id], 2) . '</em></td>'; // @TODO
				} else {
					// TJM
					// @TODO : si dispo, indiquer valeur taux mois précédent
					$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][tjm][$id]", 'value' => $p_data[$p_type]['tjm'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>Tx M-1 = ' . $m1_p_data[$p_type]['tjm'][$id] . '</em></td>';
					// Jours consommés
					$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][days2][$id]", 'value' => $p_data[$p_type]['days2'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>produits = ' . $c_p_data[$p_type]['days'][$id] . '</em></td>';
					// CA1
					$content .= '<td>' . round($c_p_data[$p_type]['ca1'][$id], 2) . '</td>';
				}
				// FraisF
				$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[$p_type][fraisf][$id]", 'value' => $p_data[$p_type]['fraisf'][$id], 'js' => 'style="width:10ex;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>Frais = ' . $c_p_data[$p_type]['fraisf'][$id] . '</em></td>';
				// CA2
				$content .= '<td>' . round($c_p_data[$p_type]['ca2'][$id], 2) . '</td>';
				// Marge calculée
				$content .= '<td>' . round($c_p_data[$p_type]['marge'][$id], 2) . '</td>';
				$content .= '</tr>';
			}
		}
		
		// Totaux = somme pour chacune des colonnes
		if (is_array($c_p_data[$p_type])) {
			$content .= '<tr>';
			$content .= '<th scope=row"">Total</th>';
			// Pour avoir toutes les variables, dans le bon ordre, et pour chaque type de production
			if ($p_type == 'other') { $var_names = $other_vars; } else { $var_names = $salarie_vars; }
			$content .= '<td>&nbsp;</td>'; // Total validation
			//foreach ($c_p_data[$p_type] as $key => $values) {
			foreach ($var_names as $key) {
				// Dans certains cas, on utilise les saisies et non les données calculées
				if (in_array($key, array('days2', 'fraisf'))) {
					if (is_array($p_data[$p_type][$key])) $key_total = array_sum($p_data[$p_type][$key]); else $key_total = 0;
				} else {
					if (is_array($c_p_data[$p_type][$key])) $key_total = array_sum($c_p_data[$p_type][$key]); else $key_total = 0;
				}
				$c_p_data[$p_type][$key]['total'] = $key_total;
				// Pas de somme pour les taux, seulement pour les valeurs
				if (in_array($key, array('cjm', 'tjm'))) { $content .= '<td>&nbsp;</td>'; continue; }
				// Exception pour 'Autres' : fusion de 2 colonnes en 1 seule
				if (($key == 'costinfo') || ($key == 'costinfo2')) {
					//$content .= '<td colspan="2">' . $key_total . '</td>';
					$content .= '<td class="result" colspan="2"></td>';
				} else {
					$content .= '<td class="result">' . round($key_total, 2) . '</td>';
				}
			}
			$content .= '</tr>';
		}
		
	}
	$content .= '</table>';
	$content .= '<br />';
	
	
	// Données et calculs
	$project_total = $project->budget;
	$project_total = (float)str_replace(array(',', ' '), array('.', ''), $project_total);
	
	// Données calculées automatiquement (donc p_data = c_p_data)
	$c_p_data['charges'] = 0; // somme des (4) COUTS2
	foreach ($p_types as $p_type => $p_type_title) { $c_p_data['charges'] += $c_p_data[$p_type]['cost2']['total']; }
	$c_p_data['ca'] = 0; // somme des (4) CA2
	foreach ($p_types as $p_type => $p_type_title) { $c_p_data['ca'] += $c_p_data[$p_type]['ca2']['total']; }
	$c_p_data['fraisf'] = 0; // somme des (4) FRAISF
	foreach ($p_types as $p_type => $p_type_title) { $c_p_data['fraisf'] += $p_data[$p_type]['fraisf']['total']; }
	
	// RAP et RAF issus saisie précédente, ou si aucune : calculé = budget total
	if (isset($m1_c_p_data['rap'])) $c_p_data['rap_m1'] = $m1_c_p_data['rap']; else $c_p_data['rap_m1'] = $project_total;
	// @TODO issu saisie précédente, ou si aucune : calculé = budget total
	if (isset($m1_c_p_data['raf'])) $c_p_data['raf_m1'] = $m1_c_p_data['raf']; else $c_p_data['raf_m1'] = $project_total;
	// @TODO calculé à partir des données du form = somme des CA2
	if (strlen($c_p_data['facture']) == 0) { $c_p_data['facture'] = $c_p_data['ca']; } else $c_p_data['facture'] = 0;
	
	// Valeurs par défaut des saisies
	if (strlen($p_data['rap_m1']) == 0) $p_data['rap_m1'] = $c_p_data['rap_m1'];
	if (strlen($p_data['raf_m1']) == 0) $p_data['raf_m1'] = $c_p_data['raf_m1'];
	
	// Infos et rappels pour saisies : issu saisie précédente ou calculé
	$c_p_data['marge'] = $c_p_data['ca'] - $c_p_data['charges']; // CA - CHARGES
	$c_p_data['rap'] = $p_data['rap_m1'] - $c_p_data['ca'] + $c_p_data['fraisf']; // (Reste à produire M-1) - CA + FraisF
	$c_p_data['raf'] = $p_data['raf_m1'] - $p_data['facture']; // (Reste à produire M-1) - (Facture à émettre)
	
	// Facture = info mais pas automatiquement renseigné
	//if (strlen($p_data['facture']) == 0) $p_data['facture'] = $c_p_data['facture'];
	// $p_data['comment'] = ''; // Aucune valeur par défaut pour les commentaires
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th colspan="4">Indicateurs mensuels</th></tr>';
	$content .= '<tr>';
	$content .= '<th scope="row">CHARGES</th>';
	$content .= '<th scope="row">CA</th>';
	$content .= '<th scope="row">FraisF</th>';
	$content .= '<th scope="row">Marge</th>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td class="result">' . round($c_p_data['charges'], 2) . '</td>';
	$content .= '<td class="result">' . $c_p_data['ca'] . '</td>';
	$content .= '<td class="result">' . $c_p_data['fraisf'] . '</td>';
	$content .= '<td class="result">' . round($c_p_data['marge'], 2) . '</td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th colspan="3">Récap mois précédent</th></tr>';
	$content .= '<tr>';
	$content .= '<th scope="row">Total contrat</th>';
	$content .= '<th scope="row">Reste à produire M-1 : ' . $c_p_data['rap_m1'] . '</th>';
	$content .= '<th scope="row">Reste à facturer M-1 : ' . $c_p_data['raf_m1'] . '</th>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td class="result">' . $project_total . '</td>';
	$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[rap_m1]", 'value' => $p_data['rap_m1'], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
	$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[raf_m1]", 'value' => $p_data['raf_m1'], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th colspan="4">Facturation et synthèse</th></tr>';
	$content .= '<tr>';
	$content .= '<th scope="row">Facture à émettre : ' . $c_p_data['facture'] . '</th>';
	$content .= '<th scope="row">Reste à produire</th>';
	$content .= '<th scope="row">Reste à facturer</th>';
	$content .= '<th scope="row">Validation de la feuille mensuelle (vide = non validé)</th>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[facture]", 'value' => $p_data['facture'], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
	$content .= '<td class="result">' . $c_p_data['rap'] . '</td>';
	$content .= '<td class="result">' . $c_p_data['raf'] . '</td>';
	$content .= '<td>' . elgg_view('input/pulldown', array('name' => "p_data[validation]", 'value' => $p_data['validation'], 'options_values' => array(0 => 'Non validé', 1 => 'Validation OK'), 'js' => 'onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>Les feuilles mensuelles doivent être validées par le chef de projet ou un manager.</em></td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th>Notes / Remarques</th></tr>';
	$content .= '<tr><td>' . elgg_view('input/plaintext', array('name' => "p_data[comment]", 'value' => $p_data['comment'], 'js' => 'style="width:100%; height:60px;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td></tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<br />';
	
	/* DEBUG
	$print_p_data .= print_r($p_data, true);
	$content .= str_replace(array('\n', "\r", ' '), array('<br />', '<br />', '&nbsp;'), $print_p_data);
	*/
	
	// Sauvegarder les données du projet => fait via le form, et en AJAX entretemps
	// Project data
	//$project_data[$year][$month] = $p_data;
	//$project->project_data = serialize($project_data);
	
	// Computed data - saved for faster retrieval of information, reference, default values (volatile), and previous month values
	$c_project_data[(int)$year][(int)$month] = $c_p_data;
	$project->c_project_data = serialize($c_project_data);
	
	// Save default or modified data
	//$content .= '<a class="elgg-button" href="javascript:void(0);" onClick="project_manager_save_project_production(\'' . $form_id . '\');">Enregistrer les données sans recharger la page</a> ou ';
	$content .= '<input type="submit" value="Enregistrer les données et re-calculer" />';
	$content .= '</form>';
	
	// Débuggage
	if (elgg_is_admin_logged_in()) {
		$content .= "C_P_DATA : $m1_year $m1_month : " . print_r($c_p_data, true) . '<br /><br />P_DATA : ' . print_r($p_data, true);
		$content .= "<hr />M-1 C_P_DATA : $m1_year $m1_month : " . print_r($m1_c_p_data, true) . '<br /><br />M-1 P_DATA : ' . print_r($m1_p_data, true);
	}
	
	
	/*
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
	*/
	
}

echo $content;

