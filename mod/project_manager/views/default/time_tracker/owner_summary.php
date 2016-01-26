<?php
$debugmode = false; // Activate debug mode..
if ($debugmode) {
	ini_set('max_execution_time', 120);
	$t0 = microtime(true);
	//error_log(" - start at $t0");
}

$member = $vars['member'];
$hide_info = $vars['hide_info'];
$member_guid = $member->guid;

$content = '';
$months = time_tracker_get_date_table('months');


// Bloc dépliable : informations générales et mode d'emploi
if (!$hide_info) {
	$info_doc = '<div class="infobox_quote">' . elgg_echo('time_tracker:summary:details') . '</div>';
	$content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
	$content .= '<br /><br />';
}

if ($debugmode) { error_log(' - avant projets => ' . 1000*(microtime(true) - $t0)); }

// Projets renseignés
$projects = time_tracker_get_projects($member->guid);

// Affichage des données, uniquement s'il y en a
if ($projects) {
	if ($debugmode) { error_log(' - avant saisies => ' . 1000*(microtime(true) - $t0)); }

	// Saisies validées ou non
	$time_tracker_validated = unserialize($member->time_tracker_validated);
	// $content .= print_r($time_tracker_validated, true); // @debug

	// Collecte et affichage des données
	$total_time = 0; $total_prod_time = 0;

	// Entêtes du tableau
	$max_year = (int)date('Y');
	for ($year = 2013; $year <= $max_year; $year++) {
		if ($debugmode) { error_log(' - ' . $year . ' => ' . 1000*(microtime(true) - $t0)); }
		$yearly_sums = array();
		$content .= "<h4>$year</h4>";
		$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/notes/' . $member->username . '/' . $year . '01-' . $year . '12" target="_blank" class="elgg-button elgg-button-action">Afficher toutes les notes pour cette année</a>';
		$content .= '<div class="time_tracker_innercontainer">';
		$table_content = '';
		$total_prod_year = 0;
		$total_frais_year = 0;
		$total_time_year = 0;
		$total_time_validation = 0;
		$jours_ouvrables_year = 0;
		
		// Check active projects
		$yearly_active_projects = array();
		$projects_table_head = '';
		foreach ($projects as $project) {
			// $yearly_sums[$project->guid]
			$yearly_sums[$project->guid] = time_tracker_yearly_time($year, $project->guid, $member_guid);
			if ($yearly_sums[$project->guid] > 0) {
				// Project yearly time
				$yearly_active_projects[$project->guid] = $project;
				// Table header cell
				$project_code = project_manager_get_project_code($project);
				$project_name = time_tracker_get_projectname($project);
				$projects_table_head .= '<th scope="col" title="Projet ' . $project_name . '"><a href="' . $project->getURL() . '">' . $project_code . '</a></th>';
			}
		}
		
		// Saisies et indicateurs Mois par mois..
		$max_month = 12;
		if ($year == date('Y')) $max_month = date('m');
		for ($month = 1; $month <= $max_month; $month++) {
			//if ($debugmode) { error_log(' - ' . $year . '/' . $month . ' => ' . 1000*(microtime(true) - $t0)); }
			$month_projects = '';
			$total_prod_month = 0; // Tous les temps sur les projets (production)
			$total_time_month = 0; // Tous les temps saisis (pour comparaison avec jours ouvrables)
			$total_frais_month = time_tracker_monthly_frais($year, $month, false, $member_guid, false, false, false);
			if ($yearly_active_projects) foreach ($yearly_active_projects as $project) {
				$project_time = time_tracker_monthly_time($year, $month, $project->guid, $member_guid);
				$month_projects .= '<td>' . $project_time . '</td>';
				$total_prod_month += $project_time;
				$total_time_month += $project_time;
			}
			$jours_ouvrables_month = time_tracker_nb_jours_ouvrable($year, $month);
			$jours_ouvrables_year += $jours_ouvrables_month;
			// Rapport d'activité validé ?
			$validated = '<span class="notvalidated" style="color:darkred; font-weight:bold;">Non</span>';
			$val_month = ((strlen($month) == 1) ? "0$month" : $month);
			if ($time_tracker_validated[$year][$val_month] == 1) {
				$validated = '<span class="validated" style="color:darkgreen; font-weight:bold;">Oui</span>';
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
			$table_content .= '<tr>';
			//$table_content .= '<td scope="row"><a href="">' . ((strlen($month) == 1) ? "0$month" : $month) . ' ' . $months[(int)$month] . ' ' . $year . '</a></td>';
			$table_content .= '<td scope="row"><a href="' . $CONFIG->url . 'time_tracker/' . $year . '/' . ((strlen($month) == 1) ? "0$month" : $month) . '">' . $months[$month] . ' ' . $year . '</a></td>';
			$table_content .= '<td class="reference_data">' . $jours_ouvrables_month . '</td>';
			$table_content .= '<td class="inner-result">' . $validated . '</td>';
			$table_content .= '<td class="inner-result">' . $total_time_month . '</td>';
			$table_content .= '<td class="inner-result">' . $total_prod_month . '</td>';
			$table_content .= '<td class="inner-result">' . $total_frais_month . '</td>';
			$table_content .= '<td>' . $c_time . '</td>
				<td>' . $g_time . '</td>
				<td>' . $a_time . '</td>
				<td>' . $t_time . '</td>';
			$table_content .= $month_projects;
			$total_time_year += $total_time_month; // Temps saisi total annuel
			$total_frais_year += $total_frais_month; // Frais mensuels
			$total_prod_year += $total_prod_month; // Temps de production total annuel
			$table_content .= '</tr>';
		}
	
		// Contenu de la ligne des totaux
		$table_content .= '<tr><td scope="row" style="font-weight:bold;">Total</td>
			<td class="result">' . $jours_ouvrables_year . '</td>
			<td class="result">' . $total_time_validation . '</td>
			<td class="result">' . $total_time_year . '</td>
			<td class="result">' . $total_prod_year . '</td>
			<td class="result">' . $total_frais_year . '</td>
			<td class="result">' . $yearly_sums['C'] . '</td>
			<td class="result">' . $yearly_sums['G'] . '</td>
			<td class="result">' . $yearly_sums['A'] . '</td>
			<td class="result">' . $yearly_sums['T'] . '</td>';
		if ($yearly_active_projects) foreach ($yearly_active_projects as $project) {
			// Project total cell
			$table_content .= '<td class="result">' . $yearly_sums[$project->guid] . '</td>';
		}
		$table_content .= '</tr>';
		
		
		// Création du tableau annuel
		// Ajout des headers (maintenant qu'on a les indicateurs permettant de savoir ce qu'on affiche ou non)
		$content .= '<table class="project_manager">';
		$content .= '<thead><tr>
			<th colspan="3">Date, nombre de jours et validation</th>
			<th colspan="2">Somme des Temps</th>
			<th>Frais</th>
			<th colspan="4">Temps spéciaux</th>
			<th colspan="' . count($yearly_active_projects) . '">Projets</th>';
		$content .= '</tr>';
		$content .= '<tr>
			<th scope="col">Mois</th>
			<th scope="col" title="Nombre de jours ouvrables dans le mois">Nb Jours</th>
			<th scope="col">Valid°</th>
			<th scope="col">Saisie</th>
			<th scope="col">Prod°</th>
			<th scope="col">en €</th>
			<th scope="col" title="Congés">C</th>
			<th scope="col" title="Gestion">G</th>
			<th scope="col" title="Avant-venter">AV</th>
			<th scope="col" title="Travaux techniques">T</th>';
		$content .= $projects_table_head;
		/*
		if ($projects) foreach ($projects as $project) {
			$project_code = project_manager_get_project_code($project);
			$project_name = time_tracker_get_projectname($project);
			$content .= '<th scope="col" title="Projet ' . $project_code . ' : ' . $project_name . '">' . $project_code . '</th>';
		}
		*/
		$content .= '</tr></thead>';
		
		$content .= '<tbody>' . $table_content . '</tbody>';
		
		$content .= '</table>';
		$content .= '</div>';
		$content .= '<br />';
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
} else {
	$content .= "<p><strong>Aucune saisie effectuée</strong></p><br />";
}

if ($debugmode) { error_log(' - total : ' . 1000*(microtime(true) - $t0)); }

echo $content;

