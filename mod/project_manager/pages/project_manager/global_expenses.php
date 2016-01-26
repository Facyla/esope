<?php
/**
 * Elgg time_tracker personal edit and summary page
 * 
 * @package Elggtime_tracker
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

global $CONFIG;
project_manager_gatekeeper();
// Seulement pour les managers
project_manager_manager_gatekeeper();
// project_manager_flexible_gatekeeper($ent, array('isexternal' => 'yes'), false);

// Give access to all users, data, etc.
$ia = elgg_set_ignore_access(true);

$content = '';
elgg_set_context('project_manager');

// Some useful vars
$months = time_tracker_get_date_table('months');
$current_ts = time();
$base_url = $CONFIG->url . 'project_manager/expenses/all';
$all_projects = time_tracker_get_projects();

// Set required vars - FILTERS
// Filter : everyone (no value or 'all'), or specific member
$member_guid = get_input('member_guid', false);
if ($member_guid) {
	if (empty($member_guid) || ($member_guid == "all")) $member = false;
	else $member = get_entity($member_guid);
} else {
	$username = get_input('username', false);
	if ($username) $member = get_user_by_username($username);
}
if ($member instanceof ElggUser) {
	$member_guid = $member->guid;
	$username = $member->username;
} else {
	$member = false;
	$member_guid = false;
	$username = false;
}

// Filter : all projects (no value or 'all'), or specific project
$member_guid = get_input('member_guid', false);
if ($project_guid) {
	if (empty($project_guid) || ($project_guid == "all")) $project = false;
	else $project = get_entity($project_guid);
}

// Filter : Validation or not, or both ('all')
$show_validated = get_input('validation', 'all'); // true/false/all

// Filter : Affectation or not, or both ('all')
$show_affectated = get_input('affectation', 'all'); // true/false/all

// Filter : year
$year = get_input('year', false);
if (empty($year) || ($year == 'all')) $year = false;
// Filter : month
$month = get_input('month', false);
if (empty($month) || ($month == 'all')) $month = false;
else if (strlen($month) == 1) $month = "0$month";



// Composition de la page
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';
$js = '<script type="text/javascript">' . elgg_view('time_tracker/js') . '</script>';

// TESTS - admin seulement
if (elgg_is_admin_logged_in()) {
	$content .= '<div style="float:right; width:45%; margin-left:5%; border:1px solid red; padding:10px;">';
	$ok = '<span style="color:green"> OK</span>';
	$ko = '<span style="color:red"> non</span>';
	//time_tracker_monthly_frais($year, $month, $project_guid = false, $user_guid = false, $exclude_meta = false, $exclude_other = false, $validated_only = false);
	$content .= "Tous les Frais : " 
		. time_tracker_monthly_frais() . "$ok<br />";
	$content .= "Tous les Frais validés : " 
		. time_tracker_monthly_frais(false, false, false, false, false, false, true) . "$ok<br />";
	$content .= "Frais de Florian : " 
		. time_tracker_monthly_frais(false, false, false, 2, false, false, false) . "$ok<br />";
	$content .= "Frais de Florian validés : " 
		. time_tracker_monthly_frais(false, false, false, 2, false, false, true) . "$ok<br />";
	$content .= "Frais de Florian sur le projet MARIE : " 
		. time_tracker_monthly_frais(false, false, 3598, 2, false, false, false) . "$ok<br />";
	$content .= "Frais de Florian validés sur le projet MARIE : " 
		. time_tracker_monthly_frais(false, false, 3598, 2, false, false, true) . "$ok<br />";
	$content .= "Frais de Florian en janvier : " 
		. time_tracker_monthly_frais(2013, 1, false, 2, false, false, false) . "$ok<br />";
	$content .= "Frais de Florian validés en janvier : " 
		. time_tracker_monthly_frais(2013, 1, false, 2, false, false, true) . "$ok<br />";
	$content .= "Frais de Florian en février : " 
		. time_tracker_monthly_frais(2013, 2, false, 2, false, false, false) . "$ok<br />";
	$content .= "Frais de Florian validés en février : " 
		. time_tracker_monthly_frais(2013, 2, false, 2, false, false, true) . "$ok<br />";
	$content .= "Frais de Florian en janvier sur le projet MARIE : " 
		. time_tracker_monthly_frais(2013, 1, 3598, 2, false, false, false) . "$ok<br />";
	$content .= "Frais de Florian validés en janvier sur le projet MARIE : " 
		. time_tracker_monthly_frais(2013, 1, 3598, 2, false, false, true) . "$ok<br />";
	$content .= "</div><br />";
}

// Composition du titre
$title = "Synthèse des Notes de frais";
if ($show_validated == 'all') {}
else if ($show_validated == 'true') { $title .= 'validées '; }
else if ($show_validated == 'false') { $title .= 'non validées '; }
if ($show_affectated == 'all') {}
else if ($show_affectated == 'true') { $title .= 'affectées sur des projets '; }
else if ($show_affectated == 'false') { $title .= 'non affectées sur des projets '; }
if ($member) { $title .= " de {$member->name}"; }
if ($project) { $title .= " sur le projet {$project->title}"; }
if ($year || $month) { $title .= " en "; }
if ($month) { $title .= $months[(int)$month] . ' '; }
if ($year) { $title .= $year; }


// Formulaire et données nécessaires
$form_id = 'project_manager_global_expenses_form';
$content .= '<form method="POST" id="' . $form_id . '" action="' . $CONFIG->url . 'action/project_manager/edit_all_expenses">';
$content .= elgg_view('input/securitytoken');
if ($show_validated) $content .= elgg_view('input/hidden', array('name' => 'validation', 'value' => $show_validated));
if ($show_affectated) $content .= elgg_view('input/hidden', array('name' => 'affectation', 'value' => $show_affectated));
if ($member) $content .= elgg_view('input/hidden', array('name' => 'user_guid', 'value' => $member->guid));
if ($project) $content .= elgg_view('input/hidden', array('name' => 'project_guid', 'value' => $project->guid));
if ($year) $content .= elgg_view('input/hidden', array('name' => 'year', 'value' => $year));
if ($month) $content .= elgg_view('input/hidden', array('name' => 'month', 'value' => $month));


// Filtres et liens
//$content .= '<div style="float:right; padding:6px 12px;">';
$content .= '<strong>Pour filtrer les notes de frais&nbsp;:</strong><br />';

// Links to toggle various parameters
// No change - permalink
$params_url = $base_url . "?validation=$show_validated&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";

$content .= " - validées / non-validées / toutes <strong>&validation=true/false/all</strong> ($show_validated)&nbsp;: ";
// Validated
$link = $base_url . "?validation=true&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">validées</a>, ';
// Not validated
$link = $base_url . "?validation=false&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">non validées</a>, ';
// Both validated & not
$link = $base_url . "?validation=all&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">toutes</a><br />';

$content .= " - affectées / non-affectées / toutes <strong>&affectation=true/false/all</strong> ($show_affectated)&nbsp;: ";
// Affectated
$link = $base_url . "?validation=$show_validated&affectation=true&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">affectées</a>, ';
// Not affectated
$link = $base_url . "?validation=$show_validated&affectation=false&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">non affectées</a>, ';
// Both affectated & not
$link = $base_url . "?validation=$show_validated&affectation=all&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">toutes</a><br />';

$content .= " - par consultant <strong>&member_guid=GUID</strong> ($member_guid)&nbsp;: ";
// All members
$link = $base_url . "?validation=$show_validated&affectation=$show_affectated&member_guid=all&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">tous</a><br />';

$content .= " - par projet <strong>&project_guid=GUID</strong> ($project_guid)&nbsp;: ";
// All projects
$link = $base_url . "?validation=$show_validated&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=$month";
$content .= '<a href="' . $link . '">tous</a><br />';

$content .= " - par année <strong>&year=YYYY</strong> ($year)&nbsp;: ";
// All years
$link = $base_url . "?validation=$show_validated&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=all&month=$month";
$content .= '<a href="' . $link . '">toutes</a><br />';

$content .= " - par mois : <strong>&month=MM</strong> ($month)&nbsp;: ";
// All months
$link = $base_url . "?validation=$show_validated&affectation=$show_affectated&member_guid=$member_guid&project_guid=$project_guid&year=$year&month=all";
$content .= '<a href="' . $link . '">toutes</a><br />';


// FILTRE PAR CONSULTANT
// Liste des projets sur lesquels un membre a effectué des saisies
// permet de construire liste des affectations aux projets (si non clos)
if ($member) {
	//$content .= "<br />Filtre par consultant&nbsp;: ";
	//$content .= $member->name;
	// Liste pour une personne
	$projects = time_tracker_get_projects($member->guid);
	$projects[] = $member;
} else {
	//$content .= "aucun (tous les consultants)";
	// Liste globale = tous les projets + tous les consultants
	$projects = $all_projects;
	$consultants = project_manager_get_consultants();
	foreach ($consultants as $guid => $ent) { $projects[] = $ent; }
}
//$content .= '<br />TEST projets = '; foreach ($projects as $ent) { $content .= $ent->title . $ent->name . ', '; }

// FILTRE PAR PROJET : on ne garde qu'un seul projet si c'est demandé
if ($project) {
	//$content .= "<br />Filtre par projet&nbsp;: ";
	//$content .= $project->title;
	$projects = array($project);
} else {
	//$content .= "aucun (tous les projets)";
}
//$content .= '<br />TEST projets = '; foreach ($projects as $ent) { $content .= $ent->title . $ent->name . ', '; }

// FILTRE PAR VALIDATION
/*
$content .= "<br />Filtre par validation&nbsp;: ";
// Saisies déjà effectuées : non-affecté ($member) + affectées sur projets
if ($show_validated == 'all') {
	$content .= "aucun<br /><em>Note : toutes les notes de frais sont affichées, y compris celles qui n'ont pas été validées par les consultants. Seules les saisies validées devraient être modifiées.<br />";
} else if ($show_validated == 'true') {
	$content .= "oui<br /><em>Note : seules les notes de frais NON-validées par les consultants apparaissent ici. Attention : seules les saisies validées devraient être modifiées.<br />";
} else if ($show_validated == 'false') {
	$content .= "non<br /><em>Note : seules les notes de frais validées par les consultants apparaissent ici ; les saisies en cours ne sont pas listées.<br />";
}
*/


/* Renvoie un sélecteur de projet
$project_selector = '<label>' . $label . '<select name="' . $name . '">';
$projects = time_tracker_get_projects($member->guid);
if (!$project_guid) $project_selector .= '<option selected="selected" value="">Aucun</option>';
$project_selector .= '<option value="">Aucun</option>';
// Projets "normaux" (production)
foreach ($projects as $ent) {
	if ($ent->guid == $project_guid) {
		$project_selector .= '<option selected="selected" value="' . $base_url . $ent->guid . '">' . time_tracker_get_projectname($ent) . '</option>';
	} else {
		$project_selector .= '<option value="' . $base_url . $ent->guid . '">' . time_tracker_get_projectname($ent) . '</option>';
	}
}
$project_selector .= '</select></label>';
*/


// AFFICHAGE DES DONNEES
// Saisies peuvent être éditées en partie : TVA déductible, affectation aux projets, refacturation
$content .= '<br /><br />';
$affectated_projects = '';
$notaffectated_projects = '';
foreach ($projects as $ent) {
	$params = array(
			'entity' => $ent,
			'show_validated' => $show_validated,
			'show_affectated' => $show_affectated,
			'year' => $year,
			'month' => $month,
			'projects' => $all_projects,
		);
	if ($show_affectated == 'all') {
		if ($ent instanceof ElggUser) $notaffectated_projects .= elgg_view('project_manager/project_expenses', $params);
		else $affectated_projects .= elgg_view('project_manager/project_expenses', $params);
	} else if ($show_affectated == 'true') {
		if ($ent instanceof ElggUser) continue;
		$affectated_projects .= elgg_view('project_manager/project_expenses', $params);
	} else if ($show_affectated == 'false') {
		if ($ent instanceof ElggObject) continue;
		$notaffectated_projects .= elgg_view('project_manager/project_expenses', $params);
	}
}
if ($show_affectated == 'all') {
	$content .= '<h3>Frais affectés à des projets</h3>';
	$content .= $affectated_projects;
	$content .= '<h3>Frais non-affectés</h3>';
	$content .= $notaffectated_projects;
} else {
	$content .= $affectated_projects . $notaffectated_projects;
}

$content .= elgg_view('input/submit', array());
$content .= '</form>';
$content .= '<br /><br /><br />';


// INFOS & AIDE A LA SAISIE
$content .= elgg_echo('project_manager:expenses:details');
// Bloc dépliable : informations générales et mode d'emploi
//$content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
$content .= '<br /><br />';


elgg_set_ignore_access($ia);

// Rendu de la page
$nav = elgg_view('project_manager/nav', array('selected' => 'expenses', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content . $js, 'sidebar' => ''));
echo elgg_view_page($title, $body);

