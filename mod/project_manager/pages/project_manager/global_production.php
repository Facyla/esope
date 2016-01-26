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

// Give access to all users, data, etc.
$ia = elgg_set_ignore_access(true);


$p_edit_url = elgg_get_site_url() . 'project_manager/production/project/';
$edit_url = elgg_get_site_url() . 'project_manager/edit/';
$months = time_tracker_get_date_table('months');
$short_months = time_tracker_get_date_table('months', true);
$content = '';
elgg_set_context('project_manager');

// Set required vars

$project_guid = get_input('project_guid', false);
if ($project_guid) $project = get_entity($project_guid);
// @TODO : Si project_guid est un code (CGAT), récupérer autrement le 'projet'
// pas un projet réellement, mais des infos attachées via le code_projet
$container_guid = get_input('container_guid', false);
if ($container_guid) $container = get_entity($container_guid);

// Get group and project, if exists
if ($project && elgg_instanceof($project, 'object', 'project_manager')) {
	$container_guid = $project->container_guid;
	$container = get_entity($container_guid);
} else {
	$project = project_manager_get_project_for_container($container_guid);
	if ($project) $project_guid = $project->guid; else $project_guid = false;
}

// Set the page owner to the container, if any, or to the site
if ($container) elgg_set_page_owner_guid($container_guid);
else elgg_set_page_owner_guid(0);

// Définition du date_stamp
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


// Compose the page
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';
$content .= '<script type="text/javascript">' . elgg_view('project_manager/js') . '</script>';

// Ajax loader : Please wait while updating animation
$content .= '<div id="loading_overlay" style="display:none;"><div id="loading_fader">' . elgg_echo('project_manager:ajax:loading') . '</div></div>';

$info_doc = elgg_echo('project_manager:globalproduction:details') . '<br /><br />';

// Infos : qui a accès à cette page
$info_doc .= '<h3>' . elgg_echo('project_manager:managers') . '</h3>';
$managers = explode(',', elgg_get_plugin_setting('managers', 'project_manager'));
foreach ($managers as $manager_guid) {
	$manager = get_entity($manager_guid);
	if (!isset($managers_list)) $managers_list = $manager->name;
	else $managers_list .= ', ' . $manager->name;
}
$info_doc .= '<p>' . $managers_list . '</p>';
$info_doc .= '<p>' . elgg_echo('project_manager:access:otheraccess') . '</p>';

// Données de base pour calculs consultants
$coef_salarial = elgg_get_plugin_setting('coefsalarie', 'project_manager'); // 1.8
$coef_pv = elgg_get_plugin_setting('coefpv', 'project_manager'); // 1.35
$days_per_month = elgg_get_plugin_setting('dayspermonth', 'project_manager'); // 20
$info_doc .= '<h3>' . elgg_echo('project_manager:settings:consultants:data') . '</h3>';
$info_doc .= elgg_echo('project_manager:consultants:data:details') . '<br /><br />';
$info_doc .= elgg_echo('project_manager:settings:coefsalarie') . ' : ' . $coef_salarial . '<br />';
$info_doc .= elgg_echo('project_manager:settings:coefpv') . ' : ' . $coef_pv . '<br />';
$info_doc .= elgg_echo('project_manager:settings:dayspermonth') . ' : ' . $days_per_month . '<br />';
// Bloc dépliable : informations générales et mode d'emploi
$content .= elgg_view('output/show_hide_block', array('title' => elgg_echo('project_manager:infos'), 'linktext' => elgg_echo('project_manager:showhide'), 'content' => $info_doc));
$content .= '<br /><br />';


// TABLEAUX ANNUELS DE PRODUCTION
// Formulaire pour changer d'année
$content .= '<span style="float:right;">' . time_tracker_select_input_year($year, 'project_manager/production/all/', '?year=') . '</span>';
$content .= '<h2>' . elgg_echo('project_manager:allprojects', array($year)) . '</h2>';

// 1. Collecte des données
$options = array(
		'types' => 'object', 'subtypes' => 'project_manager',
		'limit' => 10, 'offset' => 0, 'order_by' => 'time_created asc', 'count' => true,
	);
$count_project_managers = elgg_get_entities($options);
$options['count'] = false; $options['limit'] = $count_project_managers;
$all_project_managers = elgg_get_entities($options);
$projects_data = array(); // project_guid -> project_data, c_project_data
// Collecte : pour une année donnée
if (is_array($all_project_managers)) foreach($all_project_managers as $ent) {
	$data = unserialize($ent->project_data);
	$c_data = unserialize($ent->c_project_data);
	// Filtrer si données sur cette année ou non
	// si aucune, pas la peine de conserver le projet dans le tableau
	// @TODO : autres critères de sélection ?
	if ($c_data[$year]) {
		$projects_data[$ent->guid] = array('data' => $data, 'c_data' => $c_data);
		$project_managers[] = $ent;
	}
}

// Pour chaque année	 //for ($y = 2013; $y <= (date('Y')); $y++) {}

$ok_icon = '<br /><span class="elgg-icon elgg-icon-checkmark"></span>';
$ok_info = elgg_echo('project_manager:validated');
$ko_icon = '<br /><span class="elgg-icon elgg-icon-attention"></span>';
$ko_info = elgg_echo('project_manager:notvalidated');
//$nodata_icon = '<br /><span class="elgg-icon elgg-icon-attention"></span>';
$nodata_icon = '';
$nodata_info = elgg_echo('project_manager:nomonthdata');
// Nombre de projets actifs
$nb_projects = sizeof($project_managers);
// Nombre de mois actifs (pour lesquels on peut attendre des saisies)
$open_months = 12;
// Si année actuelle, on s'arrête au numéro du mois-1 (validable une fois le mois fini, pas avant)
if ($year == date('Y')) $open_months = 1 - (int)date('n');
else if ($year > date('Y')) $open_months = 0;

$sums = array();
$sums['total']['charges'] = 0;
$sums['total']['ca'] = 0;
$sums['total']['marge'] = 0;
for ($m = 1; $m <= 12; $m++) {
	if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
	$sums['total'][$mm]['charges'] = 0;
	$sums['total'][$mm]['ca'] = 0;
	$sums['total'][$mm]['marge'] = 0;
	$sums['total'][$mm]['validation'] = 0;
}

// 2. Tableau annuel
$content .= '<table class="project_manager" style="width:100%;">';
// Entête 1 : Global Projets, Liste des mois de janvier à décembre
$content .= '<tr><th rowspan="2">' . $year . '</th><th colspan="4">' . elgg_echo('project_manager:report:global') . '</th>';
for ($m = 1; $m <= 12; $m++) { $content .= '<th colspan="2">' . $months[$m] . '</th>'; }
$content .= '</tr>';
// Entête2 : pour chaque mois : Charges, CA et marge
$content .= '<tr style="font-size:10px;">
		<td scope="col">' . elgg_echo('project_manager:report:validation') . '</td>
		<td scope="col">' . elgg_echo('project_manager:report:charges') . '</td>
		<td scope="col">' . elgg_echo('project_manager:report:ca') . '</td>
		<td scope="col">' . elgg_echo('project_manager:report:marge') . '</td>';
for ($m = 1; $m <= 12; $m++) {
	$content .= '<td scope="col">' . elgg_echo('project_manager:report:charges') . '</td>
		<td scope="col"> ' . elgg_echo('project_manager:report:ca') . ' </td>';
}
$content .= '</tr>';

// Données calculées : $sums[$project_guid][month] array('ca', 'charges', 'marge', 'validation')
// Pour chaque projet : totaux annuels (par ligne) = Charges, CA et marge ; dans les colonnes des mois : résultats mensuels (données source)
foreach($project_managers as $ent) {
	// Données et calculs
	$project_name = mb_substr(time_tracker_get_projectname($ent), 0, 10);
	// Ssi on a que des valeurs à ajouter : array_sum
	$sums[$ent->guid]['total']['charges'] = 0;
	$sums[$ent->guid]['total']['ca'] = 0;
	$sums[$ent->guid]['total']['marge'] = 0;
	$sums[$ent->guid]['total']['validation'] = 0;
	// Données du projet pour chaque mois
	for ($m = 1; $m <= 12; $m++) {
		if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
		// Validation et somme seulement si les données existent
		if (isset($projects_data[$ent->guid]['data'][$year][$m])) {
			$sums[$ent->guid][$mm] = array(
					'charges' => $projects_data[$ent->guid]['c_data'][$year][$m]['charges'], 
					'ca' => $projects_data[$ent->guid]['c_data'][$year][$m]['ca'], 
					'marge' => $projects_data[$ent->guid]['c_data'][$year][$m]['marge'], 
				);
			// Données validées ou non ? Pas prise en compte si non validées
			if ($projects_data[$ent->guid]['data'][$year][$m]['validation'] == '1') {
				$sums[$ent->guid][$mm]['validation'] = true;
				// Ajout aux totaux du projet
				$sums[$ent->guid]['total']['charges'] += $sums[$ent->guid][$mm]['charges'];
				$sums[$ent->guid]['total']['ca'] += $sums[$ent->guid][$mm]['ca'];
				$sums[$ent->guid]['total']['marge'] += $sums[$ent->guid][$mm]['marge'];
				$sums[$ent->guid]['total']['validation'] += 1; // Si total = 12 l'année est validée
				// Ajouts aux totaux par mois
				$sums['total'][$mm]['charges'] += $sums[$ent->guid][$mm]['charges'];
				$sums['total'][$mm]['ca'] += $sums[$ent->guid][$mm]['ca'];
				$sums['total'][$mm]['marge'] += $sums[$ent->guid][$mm]['marge'];
				$sums['total'][$mm]['validation'] += 1; // Si total = nb_projets le mois est validé
			} else {
				$sums[$ent->guid][$mm]['validation'] = false;
			}
		}
	}
	
	// Ajouts aux totaux globaux
	$sums['total']['charges'] += $sums[$ent->guid]['total']['charges'];
	$sums['total']['ca'] += $sums[$ent->guid]['total']['ca'];
	$sums['total']['marge'] += $sums[$ent->guid]['total']['marge'];
	$sums['total']['validation'] += $sums[$ent->guid]['total']['validation'];
	
	if ($sums[$ent->guid]['total']['validation'] >= $open_months) {
		$validation = '<td class="inner-result project_manager_validated">' . elgg_echo('project_manager:ok') . '<br />(' . $sums[$ent->guid]['total']['validation'] . ' / ' . $open_months . ')</td>';
	} else if ($sums[$ent->guid]['total']['validation'] < $open_months) {
		$validation = '<td class="inner-result project_manager_notvalidated">' . elgg_echo('project_manager:no') . '<br />(' . $sums[$ent->guid]['total']['validation'] . ' / ' . $open_months . ')</td>';
	}
	// Affichage ligne du projet
	$content .= '<tr>
		<td scope="row"><a href="' . $p_edit_url . $ent->guid . '" target="_new">' . $project_name . '</a></td>
		' . $validation . '
		<td class="inner-result">' . round($sums[$ent->guid]['total']['charges'], 2) . '</td>
		<td class="inner-result">' . round($sums[$ent->guid]['total']['ca'], 2) . '</td>
		<td class="inner-result">' . round($sums[$ent->guid]['total']['marge'], 2) . '</td>';
	for ($m = 1; $m <= 12; $m++) {
		if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
		if ($sums[$ent->guid][$mm]['validation']) {
			$content .= '<td class="project_manager_validated" title="' . $ok_info . '">' . round($sums[$ent->guid][$mm]['charges'], 2) . $ok_icon . '</td><td class="project_manager_validated" title="' . $ok_info . '">' . round($sums[$ent->guid][$mm]['ca'], 2) . $ok_icon . '</td>';
		} else if (isset($sums[$ent->guid][$mm]['validation'])) {
			$content .= '<td class="project_manager_notvalidated" title="' . $ko_info . '">' . round($sums[$ent->guid][$mm]['charges'], 2) . $ko_icon . '</td><td class="project_manager_notvalidated" title="' . $ko_info . '">' . round($sums[$ent->guid][$mm]['ca'], 2) . $ko_icon . '</td>';
		} else {
			$content .= '<td class="project_manager_nodata" title="' . $nodata_info . '">' . round($sums[$ent->guid][$mm]['charges'], 2) . $nodata_icon . '</td><td class="project_manager_nodata" title="' . $nodata_info . '">' . round($sums[$ent->guid][$mm]['ca'], 2) . $nodata_icon . '</td>';
		}
	}
	$content .= '</tr>';
}

//$content .= '<tr><th scope="colgroup" colspan="3">' . $year . '</th></tr>';

// Validation : OK si = nb de projets et que le mois est passée, NON si < nb_projets, et vide si mois en cours ou à venir
$content .= '<tr><th colspan="5">' . elgg_echo('project_manager:report:monthvalidation') . '</th>';
for ($m = 1; $m <= 12; $m++) {
	if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
	// Si année future ou année courante et mois actuel ou à venir, inutile de calculer
	if (($year > date('Y')) || ($year == date('Y') && ($m >= (int)date('n')))) {
		$content .= '<td colspan="2" class="result project_manager_nodata">-</td>';
	} else {
		if ($sums['total'][$mm]['validation'] >= $nb_projects) {
			$content .= '<td colspan="2" class="result project_manager_validated">' . elgg_echo('project_manager:ok') . ' (' . $sums['total'][$mm]['validation'] . ' / ' . $nb_projects . ')</td>';
		} else {
			$content .= '<td colspan="2" class="result project_manager_notvalidated">' . elgg_echo('project_manager:no') . ' (' . $sums['total'][$mm]['validation'] . ' / ' . $nb_projects . ')</td>';
		}
	}
}
$content .= '</tr>';
// Totaux 1 : Somme des Marges, pour chaque mois
$content .= '<tr><th colspan="5">' . elgg_echo('project_manager:report:monthmarge') . '</th>';
for ($m = 1; $m <= 12; $m++) {
	if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
	$content .= '<td colspan="2" class="result">' . round($sums['total'][$mm]['marge'], 2) . '</td>';
}
$content .= '</tr>';
// Totaux 2 : Résultat global et Somme des Charges et des CA, pour chaque mois
$content .= '<tr>
	<th colspan="2">Résultat</th>
	<td class="result">' . round($sums['total']['charges'], 2) . '</td>
	<td class="result">' . round($sums['total']['ca'], 2) . '</td>
	<td class="result">' . round($sums['total']['marge'], 2) . '</td>';
for ($m = 1; $m <= 12; $m++) {
	if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
	$content .= '<td class="result">' . round($sums['total'][$mm]['charges'], 2) . '</td>
		<td class="result">' . round($sums['total'][$mm]['ca'], 2) . '</td>';
}
$content .= '</tr>';

// Totaux 2 : Test croisé = (revoir formule ; ratio erreur < 0.01)
$content .= '<tr><th colspan="5">' . elgg_echo('project_manager:report:crosstest') . '</th>';
$content .= '<td colspan="24">&nbsp;</td>';
//for ($m = 1; $m <= 12; $m++) { $content .= '<td>&nbsp;</td><td>&nbsp;</td>'; }
$content .= '</tr>';
$content .= '</table>';



/*
$total_project = 0;
if (is_array($project_times)) {
	$content .= '<table class="project_manager" style="width:100%;">';
	// Pour chaque année
	foreach ($project_times as $year => $year_project_times) {
		//$content .= "<h4>$year</h4>";
		$content .= '<tr><th scope="colgroup" colspan="3">' . $year . '</th></tr>';
		$total_year = 0;
		if (is_array($year_project_times)) {
			// Pour chaque mois de l'année
			foreach ($year_project_times as $month => $month_project_times) {
				//$content .= "<h5>" . $months[(int)$month] . "</h5>";
				$content .= '<tr>';
				$content .= '<th rowspan="' . (1+sizeof($month_project_times)) . '" scope="rowgroup">' . $months[(int)$month] . '</th>';
				$total_month = 0;
				if (is_array($month_project_times)) {
					// Pour chaque saisie du mois
					foreach ($month_project_times as $user_guid => $days) {
						$content .= '<td scope="row">' . get_entity($user_guid)->name . '</td><td>' . $days . '</td></tr><tr>';
						$total_month += (float)$days;
					}
					//$content .= "<strong>" . elgg_echo('time_tracker:total:permonth') . " " . $months[(int)$month] . ": " . round($total_month, 2) . "</strong><br /><br />";
					$content .= '<th>' . elgg_echo('time_tracker:total:permonth') . ' ' . $months[(int)$month] . '</th><td class="inner-result">' . round($total_month, 2) . '</td></tr>';
				} else $content .= '<tr><td colspan="3">' . elgg_echo('time_tracker:noinput') . '</td></tr>';
				$content .= '</tr>';
				$total_year += $total_month;
			}
		} else $content .= '<tr><td colspan="3">' . elgg_echo('time_tracker:noinput') . '</td></tr>';
		$content .= '<tr><th scope="row" colspan="2">' . elgg_echo('time_tracker:total:peryear') . ' ' . $year . '</th><td class="result">' . round($total_year, 2) . '</td></tr>';
		$content .= '<tr><td colspan="3">&nbsp;</td></tr>';
		$total_project += $total_year;
	}
	$content .= '<tr><th scope="row" colspan="2">' . elgg_echo('time_tracker:total:perproject') . '</th><td class="result">' . round($total_project, 2) . '</td></tr>';
	$content .= '</table>';
} else {
	$content .= '<p>' . elgg_echo('time_tracker:noinput') . '</p>';
}
*/



$content .= "<br /><br /><h2>Tableau annuel de synthèse</h2>";

$content .= '<table class="project_manager" style="width:auto;">';
// Entête 1 : titre des colonnes
$content .= '<tr>';
$content .= '<th>' . elgg_echo('project_manager:report:month') . '</th><th>' . elgg_echo('project_manager:report:validation') . '</th><th>' . elgg_echo('project_manager:report:opendays') . '</th><th>' . elgg_echo('project_manager:report:chargestotal') . '</th><th>' . elgg_echo('project_manager:report:catotal') . '</th><th>' . elgg_echo('project_manager:report:result') . '</th>';
$content .= '</tr>';


// Pour chaque mois :
for ($m = 1; $m <= 12; $m++) {
	if (strlen($m) == 1) $mm = "0$m"; else $mm = "$m";
	// Validation des données du mois : OK si autant de validations que de projets
	// Validation : OK si = nb de projets et que le mois est passée, NON si < nb_projets, et vide si mois en cours ou à venir
	// Si année future ou année courante et mois actuel ou à venir, inutile de calculer
	if (($year > date('Y')) || ($year == date('Y') && ($m >= (int)date('n')))) {
		$validation = '<td class="project_manager_nodata">' . elgg_echo('project_manager:na') . '</td>';
	} else {
		if ($sums['total'][$mm]['validation'] >= $nb_projects) {
			$validation = '<td class="project_manager_validated">' . elgg_echo('project_manager:ok') . ' (' . $sums['total'][$mm]['validation'] . ' / ' . $nb_projects . ')</td>';
		} else {
			$validation = '<td class="project_manager_notvalidated">' . elgg_echo('project_manager:no') . ' (' . $sums['total'][$mm]['validation'] . ' / ' . $nb_projects . ')</td>';
		}
	}
	$content .= '<tr>';
	$content .= '<th>' . $months[$m] . '</th>
	' . $validation . '
	<td>' . time_tracker_nb_jours_ouvrable($year, $m) . '</td>
	<td class="result">' . round($sums['total'][$mm]['charges'], 2) . '</td>
	<td class="result">' . round($sums['total'][$mm]['ca'], 2) . '</td>
	<td class="result">' . round($sums['total'][$mm]['marge'], 2) . '</td>
	';
	$content .= '</tr>';
}

// Synthèse année
$content .= '<tr>';
$content .= '<th>' . $year . '</th><th>&nbsp;</th><th>' . time_tracker_nb_jours_ouvrable($year) . '</th><th>' . round($sums['total']['charges'], 2) . '</th><th>' . round($sums['total']['ca'], 2) . '</th><th>' . round($sums['total']['marge'], 2) . '</th>';
$content .= '</tr>';
$content .= '</table>';


// Validation
// Nombre de jours ouvrés
// Total Charges
// Total CA
// Totaux : Résultat
// Total Charges cumulées
// Total CA cumulés
// Cumul (= résultat si validation OK)

// Synthèse Année
// Nombre de jours ouvrés
// Total Charges
// Total Charges cumulées
// Total CA
// Total CA cumulés
// Totaux : Résultat
// Cumul (= résultat si validation OK)




// Project view, if required data
if ((elgg_instanceof($container, 'group') || elgg_instanceof($container, 'user')) && elgg_instanceof($project, 'object', 'project_manager')) {
	
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
	$content .= '<form method="POST" id="' . $form_id . '">';
	$content .= elgg_view('input/hidden', array('name' => 'project_guid', 'value' => $project_guid));
	$content .= elgg_view('input/hidden', array('name' => 'year', 'value' => $year));
	$content .= elgg_view('input/hidden', array('name' => 'month', 'value' => (int)$month));
	
	
	// Pour enregistrer les données en JS : on a besoin de name sur chacun des champs à enregistrer
	// 1. En faire un form (global ou par mois)
	// 'name' => 'project_data[$year][$month][$p_type]['var_name'][$id]'
	// pas sur chaque champ, mais plutôt un bouton Save&Refresh : project_manager_save_project_production(form_id)
	
	// Fiche mensuelle par projet
	$p_types = array('salarie' => elgg_echo('project_manager:report:prodsalarie'), 'non-salarie' => elgg_echo('project_manager:report:prodnonsalarie'), 'otherhuman' => elgg_echo('project_manager:report:otherhuman'), 'other' => elgg_echo('project_manager:report:prodother'));
	$salarie_vars = array('cjm', 'days', 'cost1', 'frais', 'cost2', 'tjm', 'days2', 'ca1', 'fraisf', 'ca2', 'marge');
	$nonsalarie_vars = $salarie_vars;
	$otherhuman_vars = $salarie_vars;
	$other_vars = array('costinfo', 'cost1', 'frais', 'cost2', 'costinfo2', 'ca1', 'fraisf', 'ca2', 'marge');
	
	$content .= '<h2>' . elgg_echo('project_manager:report:projectmonth', array($project->project_code, $months[(int)$month], $year)) . '</h2>';
	$content .= '<strong><a href="' . $edit_url . $project_guid . '">' . elgg_echo('project_manager:editproject') . '</a></strong><br /><br />';
	
	// Si projet non signé => big alerte
	if ($project->project_managertype == 'unsigned') {
		$msg = elgg_echo('project_manager:warning:unsigned');
		register_error($msg);
		$content .= '<div style="border:3px solid red; padding:6px 12px;">' . $msg . '</div>';
	}
	
	// @TODO Ajout des membres ayant effectué des saisies sur ce projet
	$content .= '<h3>' . elgg_echo('project_manager:report:consultants') . '</h3>';
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
		$content .= '<tr><th colspan="12">' . $p_type_title . '</th></tr>';
		
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
		if (!is_array($postes)) $postes = array($postes);
		// Ajout des autres membres impliqués dans le projet, selon leur statut, et s'ils ne l'ont pas déjà été..
		if (($project_manager->items_status == $p_type) && !in_array($project_manager->guid, $postes)) { $postes[] = $project_manager->guid; }
		if (($project_owner->items_status == $p_type) && !in_array($project_owner->guid, $postes)) { $postes[] = $project_owner->guid; }
		// Ajout des membres ayant effectué des saisies sur ce projet
		foreach($unlisted_consultants as $guid => $ent) {
			if (($ent->items_status == $p_type) && !in_array($guid, $postes)) { $postes[] = $guid; }
		}
		
		$no_data_add_edit_link = elgg_echo('project_manager:novalue') . '. ' . elgg_echo('project_manager:report:othercacharges') . '<a href="' . $edit_url . $project->guid . '" target="_new">' . elgg_echo('project_manager:report:updateproject') . '</a>.';
		
		if (!is_array($postes)) {
			$content .= '<tr><td colspan="12">' . $no_data_add_edit_link . '</td></tr>';
		} else {
			// Entêtes pour chaque type de profils/postes
			$content .= '<tr>';
			$content .= '<th rowspan="2" scope="col">' . elgg_echo('project_manager:report:nom') . '</th>';
			$content .= '<th colspan="5" scope="col">' . elgg_echo('project_manager:report:infoconsultant') . '</th>';
			$content .= '<th colspan="5" scope="col">' . elgg_echo('project_manager:report:gestioncdp') . '</th>';
			$content .= '<th rowspan="2" scope="col">' . elgg_echo('project_manager:report:marge') . '</th>';
			$content .= '</tr>';
			$content .= '<tr>';
			//$content .= '<th scope="col">Nom</th>';
			if ($p_type == 'other') $content .= '<th scope="col" colspan="2">' . elgg_echo('project_manager:report:otherchargeinfo') . '</th>';
			else $content .= '<th scope="col">' . elgg_echo('project_manager:report:cjm') . '</th><th scope="col">' . elgg_echo('project_manager:report:daysprod') . '</th>';
			$content .= '<th scope="col">' . elgg_echo('project_manager:report:cout1') . '</th><th scope="col">' . elgg_echo('project_manager:report:frais') . '</th><th scope="col">' . elgg_echo('project_manager:report:cout2') . '</th>';
			if ($p_type == 'other') $content .= '<th scope="col" colspan="2">' . elgg_echo('project_manager:report:othercainfo') . '</th>';
			else {
				if (in_array($p_type, array('salarie', 'non-salarie'))) $content .= '<th scope="col">' . elgg_echo('project_manager:report:tjm') . ' ' . time_tracker_select_tjm($project, '', null) . '</th>';
				else $content .= '<th scope="col">' . elgg_echo('project_manager:report:tjm') . '</th>';
				$content .= '<th scope="col">' . elgg_echo('project_manager:report:daysconso') . '</th>';
			}
			$content .= '<th scope="col">' . elgg_echo('project_manager:report:ca1') . '</th><th scope="col">' . elgg_echo('project_manager:report:fraisf') . '</th><th scope="col">' . elgg_echo('project_manager:report:ca2') . '</th>';
			//$content .= '<th scope="col">Marge</th>';
			$content .= '</tr>';
			foreach ($postes as $id) {
				$id = trim($id);
				// Pour sauter les lignes vides et autres blagues
				if (empty($id)) continue;
				
				// Données et calculs
				
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
					$c_p_data[$p_type]['cost1'][$id] = $c_p_data[$p_type]['cjm'][$id] * $c_p_data[$p_type]['days'][$id];
					$c_p_data[$p_type]['tjm'][$id] = 0; // à saisir : taux journalier moyen, sur *ce* projet
					// Par défaut, jours consommés = jours saisis
					if (strlen($c_p_data[$p_type]['days2'][$id]) == 0) $c_p_data[$p_type]['days'][$id]; else $c_p_data[$p_type]['days2'][$id] = 0; // @TODO
					$p_data[$p_type]['ca1'][$id] = $p_data[$p_type]['tjm'][$id] * $p_data[$p_type]['days2'][$id];
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
			$content .= '<th scope=row"">' . elgg_echo('project_manager:total') . '</th>';
			// Pour avoir toutes les variables, dans le bon ordre, et pour chaque type de production
			if ($p_type == 'other') { $var_names = $other_vars; } else { $var_names = $salarie_vars; }
			//foreach ($c_p_data[$p_type] as $key => $values) {
			foreach ($var_names as $key) {
				if (is_array($c_p_data[$p_type][$key])) $key_total = array_sum($c_p_data[$p_type][$key]); else $key_total = 0;
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
	
	// Données calculées automatiquement (donc p_data = c_p_data)
	$c_p_data['charges'] = 0; // somme des (4) COUTS2
	foreach ($p_types as $p_type => $p_type_title) { $c_p_data['charges'] += $c_p_data[$p_type]['cost2']['total']; }
	$c_p_data['ca'] = 0; // somme des (4) CA2
	foreach ($p_types as $p_type => $p_type_title) { $c_p_data['ca'] += $c_p_data[$p_type]['ca2']['total']; }
	$c_p_data['fraisf'] = 0; // somme des (4) FRAISF
	foreach ($p_types as $p_type => $p_type_title) { $c_p_data['fraisf'] += $c_p_data[$p_type]['fraisf']['total']; }
	
	// Issu saisie précédente, ou si aucune : calculé = budget total
	if ($m1_c_p_data['rap']) $c_p_data['rap_m1'] = $m1_c_p_data['rap']; else $c_p_data['rap_m1'] = $project_total;
	// @TODO issu saisie précédente, ou si aucune : calculé = budget total
	if ($m1_c_p_data['raf']) $c_p_data['raf_m1'] = $m1_c_p_data['raf']; else $c_p_data['raf_m1'] = $project_total;
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
	$content .= '<tr><th colspan="4">' . elgg_echo('project_manager:report:monthstats') . '</th></tr>';
	$content .= '<tr>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:chargesmaj') . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:ca') . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:fraisf') . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:marge') . '</th>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td class="result">' . round($c_p_data['charges'], 2) . '</td>';
	$content .= '<td class="result">' . round($c_p_data['ca'], 2) . '</td>';
	$content .= '<td class="result">' . $c_p_data['fraisf'] . '</td>';
	$content .= '<td class="result">' . round($c_p_data['marge'], 2) . '</td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th colspan="3">' . elgg_echo('project_manager:report:prevmonthreport') . '</th></tr>';
	$content .= '<tr>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:totalcontrat') . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:rapm1') . ' : ' . $c_p_data['rap_m1'] . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:rafm1') . ' : ' . $c_p_data['raf_m1'] . '</th>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td class="result">' . $project_total . '</td>';
	$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[rap_m1]", 'value' => $p_data['rap_m1'], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
	$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[raf_m1]", 'value' => $p_data['raf_m1'], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th colspan="4">' . elgg_echo('project_manager:report:facturesummary') . '</th></tr>';
	$content .= '<tr>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:todofacture') . ' : ' . $c_p_data['facture'] . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:rap') . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:raf') . '</th>';
	$content .= '<th scope="row">' . elgg_echo('project_manager:report:monthvalidationsheet') . '</th>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td>' . elgg_view('input/text', array('name' => "p_data[facture]", 'value' => $p_data['facture'], 'js' => 'style="width:100%;" onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '</td>';
	$content .= '<td class="result">' . $c_p_data['rap'] . '</td>';
	$content .= '<td class="result">' . $c_p_data['raf'] . '</td>';
	$content .= '<td>' . elgg_view('input/pulldown', array('name' => "p_data[raf_m1]", 'value' => $p_data['validation'], 'options_values' => array(0 => elgg_echo('project_manager:report:notvalidated') . '', 1 => elgg_echo('project_manager:report:validated') . ''), 'js' => 'onChange="project_manager_save_project_production(\'' . $form_id . '\');"')) . '<br /><em>' . elgg_echo('project_manager:report:validationnotice') . '</em></td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '<br />';
	
	$content .= '<table class="project_manager" style="width:100%;">';
	$content .= '<tr><th>' . elgg_echo('project_manager:notesrmq') . '</th></tr>';
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
	$content .= '<input type="submit" value="' . elgg_echo('project_manager:saveandrecompute') . '" />';
	$content .= '</form>';
	
	// Débuggage
	if (elgg_is_admin_logged_in()) {
		$content .= "DEBUG C_P_DATA : $m1_year $m1_month : " . print_r($c_p_data, true) . '<br /><br />P_DATA : ' . print_r($p_data, true);
		$content .= "<hr />DEBUG M-1 C_P_DATA : $m1_year $m1_month : " . print_r($m1_c_p_data, true) . '<br /><br />M-1 P_DATA : ' . print_r($m1_p_data, true);
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


elgg_set_ignore_access($ia);

// Render page
elgg_set_context('project_manager');
$title = elgg_echo("project_manager:production");
$nav = elgg_view('project_manager/nav', array('selected' => 'production', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content, 'sidebar' => $area1));

echo elgg_view_page($title, $body); // Finally draw the page

