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

$content = '';
elgg_set_context('time_tracker');

$months = time_tracker_get_date_table('months');

// Set the page owner
$username = get_input('username', $_SESSION['username']);
$member = get_user_by_username($username);
if ($member === false || is_null($member)) {
	$member = elgg_get_logged_in_user_entity();
	$username = $member->username;
}
$member_guid = $member->guid;
elgg_set_page_owner_guid($member_guid);

$project_guid = get_input('project_guid', 'none');

// Seuls les managers (et les admins) peuvent consulter ou faire les saisies pour une autre personne
$is_manager = false;
if (project_manager_manager_gatekeeper(false, true, false)) {
	$is_manager = true;
	$content .= '<a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'time_tracker/all">Afficher la synthèse des rapports d\'activités (Manager)</a><br /><br />';
}
if (($member->guid != elgg_get_logged_in_user_guid()) && !$is_manager) { forward('time_tracker'); }


$content .= '<style type="text/css">' . elgg_view('project_manager/css') . '</style>';
$js = '<script type="text/javascript">' . elgg_view('project_manager/js') . '</script>';
$content .= '<br />';


// Composition de la page
// Saisies validées du membre
$time_tracker_validated = unserialize($member->time_tracker_validated);


// Page par défaut : dernier mois à saisir (non validé), sinon mois en cours, sinon 1er janvier 2013 si aucune saisie ?
// Ssi pas de date définie par ailleurs..
$datestamp = get_input('date_stamp', false);
$year = get_input('year', false);
$month = get_input('month', false);

// Dates par défaut seulement si aucune date spécifiée par ailleurs
if (!$datestamp && !($year && $month)) {
	// Saisies précédentes :
	$options = array(
			'metadata_name_value_pairs' => array(
					array('name' => 'project_guid', 'value' => 'NOTES'),
				),
			'types' => 'object', 'subtypes' => 'time_tracker', 'owner_guids' => $member_guid,
			'limit' => 0
		);
	$existing_time_trackers = elgg_get_entities_from_metadata($options);
	
	if ($existing_time_trackers) {
		// Si saisie existante => début à la 1ère saisie non validée
		$first_time_tracker = $existing_time_trackers[0];
		$first_datestamp = $first_time_tracker->date_stamp;
		
		// S'il y a des saisies validées : on commence à la première saisie non validée
		if (!empty($time_tracker_validated)) {
			// On teste toutes les saisies à partir de la première saisie faite pour déterminer la 1ère saisie manquante
			for ($y = (int)substr($first_datestamp,0,4); $y <= (date('Y')); $y++) {
				// Pour la première année, on commence au premier mois
				if ($y == (int)substr($first_datestamp,0,4)) {
					for ($m = (int)substr($first_datestamp,4,2); $m <= 12; $m++) {
						if (strlen($m) < 2) $mm = "0$m"; else $mm = $m;
						if ($time_tracker_validated[$y][$mm] != 1) {
							$default_year = $y;
							$default_month = $m;
							$info_col .= '<p class="time_tracker_alert">Vous avez déjà effectué plusieurs saisies. La date par défaut est celle de votre première saisie non validée ('.$m.'/'.$y.'). Vous pouvez changer de mois via le sélecteur ci-dessous.</p>';
							break 2;
						}
					}
				} else {
					// Années suivantes : on commence en janvier
					for ($m = 1; $m <= 12; $m++) {
						if (strlen($m) < 2) $mm = "0$m"; else $mm = $m;
						if ($time_tracker_validated[$y][$mm] != 1) {
							$default_year = $y;
							$default_month = $m;
							$info_col .= '<p class="time_tracker_alert">Vous avez déjà effectué plusieurs saisies. La date par défaut est celle de votre première saisie non validée ('.$m.'/'.$y.'). Vous pouvez changer de mois via le sélecteur ci-dessous.</p>';
							break 2;
						}
					}
				}
			}
		// Si aucune saisie validée : on commence à la première date de saisie
		} else {
			$info_col .= '<p class="time_tracker_alert">Aucune saisie validée pour le moment. Vous pouvez commencer à renseigner vos rapports d\'activité à partir de la date de mise en place de cet outil. Pour commencer à une date ultérieure, changez de mois (ou d\'année) via le sélecteur ci-dessous.</p>';
			//$default_year = substr($first_datestamp,0,4);
			//$default_month = substr($first_datestamp,4,2);
			$default_year = '2013';
			$default_month = '01';
		}
	} else {
		$info_col .= '<p class="time_tracker_alert">Aucune saisie pour le moment. La date par défaut est celle de la mise en place de cet outil. Vous pouvez changer de mois via le sélecteur ci-dessous.</p>';
		// Si aucune saisie => début au 1er janvier 2013
		$default_year = '2013';
		$default_month = '01';
	}
}
$info_col .= '<p class="time_tracker_info">Vous pouvez accéder au <a href="#summary">tableau récapitulatif de vos saisies situé en bas de page</a>.</p>';


// Vue de saisie mensuelle
$selected = 'time_tracker';
// Date_stamp
$datestamp = get_input('date_stamp', false);
if ($datestamp) {
	// Période ?
	if (strpos($datestamp, '-')) {
		$datestamps = explode('-', $datestamp);
		if (strlen($datestamps[0]) == 4) $datestamps[0] = $datestamps[0] . '01';
		if (strlen($datestamps[1]) == 4) $datestamps[1] = $datestamps[1] . '12';
		$datestamp = $datestamps[0];
	}
	$year = substr($datestamp, 0, 4);
	$month = '01';
	if (strlen($datestamp) > 4) $month = substr($datestamp, 4, 2);
} else {
	$year = get_input('year', $default_year);
	if (strlen($year) == 6) {
		$month = substr($year, 4, 2);
		$year = substr($year, 0, 4);
	} else $month = get_input('month', $default_month);
	// Besoin de 2 caractères pour le date_stamp
	if (strlen($month) == 1) $month = "0$month";
	$datestamp = (string)$year.$month;
}
// Previous month datestamp
/*
$m1_year = (int)$year;
if ((int)$month > 1) { $m1_month = (int)$month - 1; } else { $m1_month = 12; $m1_year -= 1; }
if (strlen($m1_month) == 1) $m1_month = "0$m1_month";
$prev_datestamp = (string)$m1_year.$m1_month;
*/
// Previous month datestamp : take 1 month, or -1 year and +11 months (<=> -100+11=-89)
if ((int)$month > 1) {
	$prev_datestamp = $datestamp - 1;
	$prev_month = $month - 1;
} else {
	$prev_datestamp = $datestamp - 89;
	$prev_month = 12;
}
// Next month datestamp : add 1 month, or +1 year and -11 months (<=> +100-11=+89)
if ((int)$month < 12) {
	$next_datestamp = $datestamp + 1;
	$next_month = $month + 1;
} else {
	$next_datestamp = $datestamp + 89;
	$next_month =1;
}


$title = elgg_echo('time_tracker:owner', array($member->name));




// BLOC SUPERIEUR
// Bloc dépliable : informations générales et mode d'emploi
/*
$info_doc = '<div class="infobox_quote">' . elgg_echo('time_tracker:details') . '</div>';
$content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
$content .= '<br /><br />';
*/


/* AFFICHAGE SAISIES DU MOIS COURANT / DEMANDE + NAVIGATION */

// Previous month and year
if ($year > 2013) {
	$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/notes/' . $username . '/' . ($datestamp - 100) . '" class="time_tracker_datenav" style="float:left;" title="Année précédente"><i class=" fa-angle-double-left"></i>&nbsp;' . ($year-1) . '</a>';
}
$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/notes/' . $username . '/' . $prev_datestamp . '" class="time_tracker_datenav" style="float:left;" title="Mois précédent"><i class="fa-angle-left"></i>&nbsp;' . $months[$prev_month] .'</a>';
// Next month and year
$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/notes/' . $username . '/' . ($datestamp + 100) . '" class="time_tracker_datenav" style="float:right;" title="Année suivante"><i class=" fa-angle-double-right"></i>&nbsp;' . ($year+1) . '</a>';
$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/notes/' . $username . '/' . $next_datestamp . '" class="time_tracker_datenav" style="float:right;" title="Mois suivant"><i class="fa-angle-right"></i>&nbsp;' . $months[$next_month] . '</a>';
// Titre + Sélecteur pour changer de mois de saisie
$content .= '<h3 style="text-align:center;">Rapport d\'activités du mois de ' . time_tracker_select_input_month($year, $month, "time_tracker/notes/$username", '/', true, '') . '</h3>';
//$content .= '<span>' . time_tracker_select_input_month($year, $month, "time_tracker/notes/$username", '/', '') . '</span><br />';
$content .= '<div class="clearfloat"></div>';
$content .= '<br />';


$content .= '<div class="time_tracker_container"><div class="time_tracker_innercontainer">';

// Saisies du mois validées ou non ?
//$content .= "Saisies validées : " . print_r($time_tracker_validated, true) . '<br />';
// Si saisies validées et pas admin => pas de modif possible

$options = array(
		'metadata_name_value_pairs' => array(
				array('name' => 'project_guid', 'value' => 'NOTES'),
			),
		'types' => 'object', 'subtypes' => 'time_tracker', 'owner_guids' => $member_guid,
		'limit' => 0, 'order_by_metadata' => array('name' => 'date_stamp', 'direction' => 'ASC'),
	);
if ($datestamp) {
	if ($datestamps) {
		$options['metadata_name_value_pairs'][] = array('name' => 'date_stamp', 'value' => $datestamps[0], 'operand' => '>=');
		$options['metadata_name_value_pairs'][] = array('name' => 'date_stamp', 'value' => $datestamps[1], 'operand' => '<=');
		$content .= '<h3>De ' . $datestamps[0] . ' à ' . $datestamps[1] . '</h3>';
	} else {
		$options['metadata_name_value_pairs'][] = array('name' => 'date_stamp', 'value' => $datestamp);
		$content .= '<h3>' . $months[(int)$month] . ' ' . $year . '</h3>';
	}
}
$time_trackers = elgg_get_entities_from_metadata($options);


// Display notes
if ($time_trackers) foreach ($time_trackers as $time_tracker) {
		// On a besoin de savoir pour quel mois de quelle année on saisit les données
	$date_timestamp = mktime(0, 0, 0, (int)$month, 1, $year); // timestamp au 1er du mois
	$count_days_in_month = date('t', $date_timestamp);
	// Weekend ou pas : w 	Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
	
	$content .= '<table style="width:100%; border:1px solid;">';
	$content .= '<thead>
			<tr><th colspan="2" style="padding:2px 4px; text-align:center;"><a href="' . elgg_get_site_url() . 'time_tracker/owner/' . $member->username . '/' . $time_tracker->year . $time_tracker->month . '" target="_blank" title="Afficher la feuille de temps">' . $months[(int)$time_tracker->month] . ' ' . $time_tracker->year . '</a></th></tr>
			<tr><th style="padding:2px 4px;">Date</th><th style="padding:2px 4px;">Notes</th></tr>
		</thead>';
	$content .= '<tbody>';
	// Pour chaque jour du mois : saisie par projet
	for ($i = 1; $i <= $count_days_in_month; $i++) {
		$notes = $time_tracker->{'day'.$i.'_hours'};
		if (empty(trim($notes))) continue;
		$day_class = ''; // Pour différencier selon les jours
		$date_timestamp = mktime(0, 0, 0, (int)$month, $i, (int)$year); // timestamp à 00:00 du jour donné
		// Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
		$day_of_week = date('w', $date_timestamp);
		$content .= '<tr style="border-bottom:1px solid lightgrey;">';
		$content .= "<td style=\"padding:2px 4px;\">$time_tracker->year/$time_tracker->month/$i</td>";
		$content .= '<td style="padding:2px 4px;">' . str_replace("\n", '<br />', $notes) . '</td>';
		$content .= '</tr>';
	}
	$content .= '</tbody>';
	$content .= '</table>';
	
	$content .= '<div class="clearfloat"></div><br />';
	
}

$content .= '<br />';


// Rendu de la page
$nav = elgg_view('project_manager/nav', array('selected' => $selected, 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $css . $content . $js, 'sidebar' => ''));
echo elgg_view_page($title, $body);

