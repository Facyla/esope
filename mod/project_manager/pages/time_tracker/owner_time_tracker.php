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

// Set required vars
//$summary = get_input('summary', false);
$add_previous_projects = get_input('add_previous_projects', false);
if ($add_previous_projects) $add_previous_projects = true;

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
// Ajax loader : Please wait while updating animation
$content .= '<div id="loading_overlay" style="display:none;"><div id="loading_fader">' . elgg_echo('project_manager:ajax:loading') . '</div></div>';
$content .= '<br />';


// 2 blocs pour clarifier les actions possibles
$info_col = '';
$actions_col = '';

// Composition de la page
// Saisies validées du membre
$time_tracker_validated = unserialize($member->time_tracker_validated);

// Saisies précédentes :
$options = array('types' => 'object', 'subtypes' => 'time_tracker', 'limit' => 10, 'offset' => 0, 'order_by' => 'time_created asc');
$existing_time_trackers = elgg_get_entities($options);
 
// Page par défaut : dernier mois à saisir (non validé), sinon mois en cours, sinon 1er janvier 2013 si aucune saisie ?
// Ssi pas de date définie par ailleurs..
$datestamp = get_input('date_stamp', false);
$year = get_input('year', false);
$month = get_input('month', false);
// Dates par défaut seulement si aucune date spécifiée par ailleurs
if (!$datestamp && !($year && $month)) {
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
			$default_year = '2013';
			$default_month = '01';
			$default_year = substr($first_datestamp,0,4);
			$default_month = substr($first_datestamp,4,2);
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
	$year = substr($datestamp, 0, 4);
	$month = substr($datestamp, 4, 2);
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

// Bloc dépliable : informations générales et mode d'emploi
$info_doc = '<div class="infobox_quote">' . elgg_echo('time_tracker:details') . '</div>';
$info_col .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
$info_col .= '<br /><br />';

// Actions
$actions_col .= '<p><a href="' . full_url() . '?add_previous_projects=true" class="elgg-button elgg-button-action">Ajouter les projets du mois précédent</a></p>';
// Ajout nouvelle ligne projet-temps sur ce mois
//$actions_col .= '<span class="elgg-button elgg-button-action" id="add_project_toggle"><a href="javascript:void(0);" onclick="$(\'#time_tracker_newtime\').show(); $(\'#add_project_toggle\').hide();">' . elgg_echo('time_tracker:add_new') . '</a></span>';
//$actions_col .= '<div id="time_tracker_newtime" style="display:none;">' . elgg_view('forms/time_tracker', array('time_tracker' => array('user_guid' => $member_guid, 'year' => $year, 'month' => $month), 'hide_projects' => $hide_projects)) . '</div>';
$actions_col .= elgg_view('forms/time_tracker', array('time_tracker' => array('user_guid' => $member_guid, 'year' => $year, 'month' => $month), 'hide_projects' => $hide_projects));
$actions_col .= 'Pour ajouter un nouveau projet au tableau, choisissez le projet et validez.';
$actions_col .= '<br />';
$actions_col .= '<br />';
$actions_col .= '<p><a href="' . elgg_get_site_url() . 'project_manager/new" class="elgg-button elgg-button-action">Créer un nouveau projet</a></em><br />';
$actions_col .= '<div class="clearfloat"></div>';




// BLOC SUPERIEUR
$content .= '<div style="width:48%; float:right;">';
$content .= $actions_col;
$content .= '</div>';
$content .= '<div style="width:48%; float:left;">';
$content .= $info_col;
$content .= '</div>';
$content .= '<div class="clearfloat"></div>';
$content .= '<br />';



/* AFFICHAGE SAISIES DU MOIS COURANT / DEMANDE + NAVIGATION */

// Previous month and year
if ($year > 2013) {
	$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/owner/' . $username . '/' . ($datestamp - 100) . '" class="time_tracker_datenav" style="float:left;" title="Année précédente"><i class=" fa-angle-double-left"></i>&nbsp;' . ($year-1) . '</a>';
}
$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/owner/' . $username . '/' . $prev_datestamp . '" class="time_tracker_datenav" style="float:left;" title="Mois précédent"><i class="fa-angle-left"></i>&nbsp;' . $months[$prev_month] .'</a>';
// Next month and year
$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/owner/' . $username . '/' . ($datestamp + 100) . '" class="time_tracker_datenav" style="float:right;" title="Année suivante"><i class=" fa-angle-double-right"></i>&nbsp;' . ($year+1) . '</a>';
$content .= '<a href="' . elgg_get_site_url() . 'time_tracker/owner/' . $username . '/' . $next_datestamp . '" class="time_tracker_datenav" style="float:right;" title="Mois suivant"><i class="fa-angle-right"></i>&nbsp;' . $months[$next_month] . '</a>';
// Titre + Sélecteur pour changer de mois de saisie
$content .= '<h3 style="text-align:center;">Rapport d\'activités du mois de ' . time_tracker_select_input_month($year, $month, "time_tracker/owner/$username", '/', true, '') . '</h3>';
//$content .= '<span>' . time_tracker_select_input_month($year, $month, "time_tracker/owner/$username", '/', '') . '</span><br />';
$content .= '<div class="clearfloat"></div>';
$content .= '<br />';


$content .= '<div class="time_tracker_container"><div class="time_tracker_innercontainer">';

// Saisies du mois validées ou non ?
$is_month_validated = $time_tracker_validated[$year][$month];
//$content .= "Saisies validées : " . print_r($time_tracker_validated, true) . '<br />';
// Si saisies validées et pas admin => pas de modif possible
if (($is_month_validated == 1) && !elgg_is_admin_logged_in()) {
	$content .= '<div style="border:2px solid red; margin:0 0 12px 0; padding:6px 12px; font-weight:bold">Le rapport a été validé et ne peut plus être modifié<br />Si vous souhaitez tout de même le modifier merci de vous adresser à un adminnistrateur.<br /><br />';
} else {
	if ($is_month_validated == 1) $content .= '<div style="border:2px solid red; margin:0 0 12px 0; padding:6px 12px; font-weight:bold">Le rapport a été validé et ne devrait plus être modifié<br />En tant qu\'administrateur vous pouvez tout de même le changer.</div>';
	$options = array(
			'metadata_name_value_pairs' => array('name' => 'date_stamp', 'value' => $datestamp),
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
	$project_times = ''; $real_project_times = ''; $user_project_times = ''; $special_project_times = '';
	$content .= time_tracker_add_header_col($year, $month, $member_guid, $is_month_validated);
	
	// Si aucune saisie pour le moment, on tente de reprendre celles du mois précédent
	if (!$time_trackers) {
		$options['count'] = true;
		$options['metadata_values'] = $prev_datestamp;
		$count_m1_time_trackers = elgg_get_entities_from_metadata($options);
		$options['count'] = false;
		$options['limit'] = $count_m1_time_trackers;
		$m1_time_trackers = elgg_get_entities_from_metadata($options);
		$m1_projects = array();
		if ($m1_time_trackers) foreach ($m1_time_trackers as $ent) {
			if (!in_array($ent->project_guid, $m1_projects) && !in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C', 'NOTES'))) $m1_projects[] = $ent->project_guid;
		}
		if ($m1_projects) foreach ($m1_projects as $guid) {
			$content_projects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => $guid, 'year' => $year, 'month' => $month)));
		}
	}
	
	
	if ($time_trackers) foreach ($time_trackers as $ent) {
		$hide_projects[] = $ent->project_guid;
		//if (in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C', 'NOTES'))) continue;
		//$content .= elgg_view('object/time_tracker', array('entity' => $ent));
		// Comptage des temps du mois
		$project_time = time_tracker_monthly_time($year, $month, $ent->project_guid, $member_guid);
		// Nom complet du projet
		$project_name = time_tracker_get_projectname($ent->project_guid);
		if ($project = get_entity($ent->project_guid)) {
			if (elgg_instanceof($project, 'object')) {
				$content_projects .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
				$real_project_times .= '<strong>' . $project_name . '&nbsp;: </strong>' . " : " . $project_time . ' jours<br />';
				$total_prod_month += $project_time;
				$total_time_month += $project_time;
			} else if (elgg_instanceof($project, 'user')) {
				// Note : cette saisie est supprimée au profit des saisies spéciales CATG
				$ent->delete();
				/*
				$content_otherprojects .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
				$real_project_times .= $project_name . "&nbsp;: " . $project_time . ' jours<br />';
				// Temps non compté en production si hors-projet
				$total_prod_month += $project_time;
				$total_time_month += $project_time;
				*/
			}
		} else {
			if ($ent->project_guid != 'NOTES') {
				$content_metaprojects .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
				$special_project_times .= '<strong>' . $project_name . '&nbsp;:</strong> ' . $project_time . ' jours<br />';
				// Temps non compté en production si hors-projet
				//$total_prod_month += $project_time;
				$total_special_month += $project_time;
				$total_time_month += $project_time;
			} else {
				$content_notes .= elgg_view('forms/time_tracker', array('entity' => $ent, 'no_project_switch' => true));
			}
		}
	}
		
	// Si demandé, on tente de reprendre celles du mois précédent (mais sans doublon !)
	// Afficher après avoir dédoublonné
	if ($add_previous_projects) {
		$options['count'] = true;
		$options['metadata_name_value_pairs'] = array('name' => 'date_stamp', 'value' => $prev_datestamp);
		$count_m1_time_trackers = elgg_get_entities_from_metadata($options);
		$options['count'] = false;
		$options['limit'] = $count_m1_time_trackers;
		$m1_time_trackers = elgg_get_entities_from_metadata($options);
		$m1_projects = array();
		if ($m1_time_trackers) foreach ($m1_time_trackers as $ent) {
			if (!in_array($ent->project_guid, $m1_projects) && !in_array($ent->project_guid, $hide_projects) && !in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C', 'NOTES'))) $m1_projects[] = $ent->project_guid;
		}
		if ($m1_projects) foreach ($m1_projects as $guid) {
			$additional_project_times .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => $guid, 'year' => $year, 'month' => $month)));
		}
	}
	$project_times = $special_project_times . $real_project_times . $user_project_times;
	
	// Ajout des colonnes hors-projet si pas déjà affichées
	// Congés
	if (!in_array('C', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'C', 'year' => $year, 'month' => $month)));
	// Avant-vente
	if (!in_array('A', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'A', 'year' => $year, 'month' => $month)));
	// Gestion
	if (!in_array('G', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'G', 'year' => $year, 'month' => $month)));
	// Travaux techniques
	if (!in_array('T', $hide_projects)) $content_metaprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'T', 'year' => $year, 'month' => $month)));
	// Notes sur chacun des jours saisis
	if (!in_array('NOTES', $hide_projects)) $content_notes .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => 'NOTES', 'year' => $year, 'month' => $month)));

	// Autres, hors-projet - non affecté
	/*
	if (!in_array($member_guid, $hide_projects)) $content_otherprojects .= elgg_view('forms/time_tracker', array('no_project_switch' => true, 'time_tracker' => array('user_guid' => $member_guid, 'project_guid' => $member_guid, 'year' => $year, 'month' => $month)));
	*/
	
	// Ajout dans l'ordre des différents types de saisies
	$content .= $content_metaprojects . $content_projects . $content_otherprojects . $additional_project_times . $content_notes;
	//$content .= '<span class="elgg-button elgg-button-action" id="add_project_toggle"><a href="javascript:void(0);" onclick="$(\'#time_tracker_newtime\').show(); $(\'#add_project_toggle\').hide();">' . elgg_echo('time_tracker:add_new') . '</a></span>';
	$content .= '<div class="clearfloat"></div><br /><br />';
	$content .= '</div></div>';
	
	// Lien vers notes de frais
	$content .= '<h3>Notes de frais</h3><a class="elgg-button elgg-button-action" href="' . $GLOBAL->url . 'project_manager/expenses/' . $member->username . '" target="_new" title="Saisir les notes de frais dans une nouvelle fenêtre">Saisir ';
	if ($member_guid == elgg_get_logged_in_user_guid()) $content .= 'mes notes de frais ';
	else $content .= 'les notes de frais de ' . $member->name;
	$content .= '</a><br /><br />';
	
	
	// Validation du RA
	$jours_ouvrables_month = time_tracker_nb_jours_ouvrable($year, $month);
	$content .= '<div style="border:2px dashed red; margin:6px; padding:4px 12px; text-align:center; font-weight:bold;">';
	$content .= "Une fois votre saisie terminée, rechargez la page pour vérifier votre saisie et pouvoir valider votre rapport d'activité.<br />";
	$content .= '<a class="elgg-button elgg-button-action" href="' . full_url() . '">Recharger la page</a>';
	$content .= '</div><br />';
	
	
	// Récap des saisies : indicateurs et synthèse mensuelle
	$content .= '<h4>Synthèse pour '.$months[(int)$month].'</h4>';
	$content .= '<div class="infobox_info" style="width:46%; float:left;">';
	$content .= "Nombre de jours ouvrables dans le mois : $jours_ouvrables_month jours<br />";
	$content .= "Nombre de jours renseignés (production ou congé) : $total_time_month jours<br />";
	$content .= "Total du temps de production : $total_prod_month jours<br />";
	$content .= "Total du temps hors-production (CTGA) : $total_special_month jours<br />";
	$content .= '<br />Détail par projet&nbsp;:<br /><div style="font-size:12px; padding-left:12px;">' . $project_times . '</div><br />';
	if ($total_time_month >= $jours_ouvrables_month) {
		if ($is_month_validated) $content .= '<strong style="color:darkgreen;">Vous avez validé ce rapport d\'activité.</strong>';
		else $content .= '<strong style="color:darkgreen;">Validation possible.</strong>';
	} else {
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
	$content .= '</div>';
	
	$content .= '<div class="infobox_encart" style="width:46%; float:right;">';
	$content .= '<strong>Informations salariales</strong><br />';
	$content .= "Statut : " . elgg_echo('project_manager:items_status:'.$member->items_status) . "<br />";
	if ($member->items_status == 'salarie') {
		$content .= "Coût annuel brut : {$member->yearly_global_cost} €<br />";
		$content .= "Coût mensuel moyen : " . round(($member->yearly_global_cost / 12),2) . " €<br />";
		$content .= "Coût journalier moyen : " . round(($member->yearly_global_cost / 12 / 20),2) . " €<br />";
		$content .= "Part variable annuelle : {$member->yearly_variable_part} €<br />";
	} else if ($member->items_status == 'non-salarie') {
		$content .= "Coût de journée : " . $member->daily_cost . " € / jour<br />";
		// Note : varie selon les projets (et les profils ?)
	} else {
		$content .= '';
	}
	if (project_manager_manager_gatekeeper(false, true, false)) {
		$content .= '<br /><a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'project_manager/consultants">Modifier ces informations (Manager)</a><br />';
	}
	$content .= '</div>';
}
$content .= '<div class="clearfloat"></div><br />';
$content .= '<br />';



/* Synthèse globale des Rapports d'activités */
$content .= '<br /><br /><br /><hr />';
$content .= '<a name="summary"></a>';
$content .= elgg_view_title(elgg_echo('time_tracker:summary:owner', array($member->name)));
//$summary_hide = '<br />' . elgg_view('time_tracker/owner_summary', array('member' => $member));
//$content .= elgg_view('output/show_hide_block', array('title' => "Afficher la synthèse globale", 'linktext' => "cliquer pour afficher", 'content' => $summary_hide));
$content .= '<div style="overflow-x:auto; max-width:100%;">';
$content .= '<div class="time_tracker_container">';
$content .= '<br />' . elgg_view('time_tracker/owner_summary', array('member' => $member));
$content .= '</div>';
$content .= '</div>';



// Rendu de la page
$nav = elgg_view('project_manager/nav', array('selected' => $selected, 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $css . $content . $js, 'sidebar' => ''));
echo elgg_view_page($title, $body);

