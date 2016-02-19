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
// project_manager_flexible_gatekeeper($ent, array('isexternal' => 'yes'), false);

global $CONFIG;
$months = time_tracker_get_date_table('months');
$content = '';
elgg_set_context('project_manager');

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

// Date_stamp
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
$project_guid = get_input('project_guid', 'none');

$current_ts = time();

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


// Composition de la page
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';
$js = '<script type="text/javascript">' . elgg_view('time_tracker/js') . '</script>';
$content .= '<br />';

//foreach ($projects as $ent) { $content .= "{$ent->guid} {$ent->title} <br />"; }

if (project_manager_manager_gatekeeper(false, true, false)) {
	$content .= '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'project_manager/expenses/all">' . elgg_echo('project_manager:expenses:managerlink') . '</a><br /><br />';
	// Liste de tous les projets : permet de construire liste des affectations aux projets (si non clos)
	$projects = time_tracker_get_projects();
} else {
	// Liste des projets sur lesquels un membre a effectué des saisies
	$projects = time_tracker_get_projects($member->guid);
	$projects[] = $member;
}


// NOUVELLES NOTES DE FRAIS
$content .= '<h2>' . elgg_echo('project_manager:expenses:addnew') . '</h2>';

// Formulaire et données nécessaires
$form_id = 'project_manager_expenses_' . $member_guid;
$content .= '<form method="POST" id="' . $form_id . '" action="' . $CONFIG->url . 'action/project_manager/edit_project_expenses">';
$content .= elgg_view('input/securitytoken');
$content .= elgg_view('input/hidden', array('name' => 'user_guid', 'value' => $member_guid));

$content .= '<table class="project_manager" style="width:auto;">';
// Entête : titre des colonnes
$content .= '<tr>';
$content .= '<th>' . elgg_echo('project_manager:expenses:date') . '</th>
	<th>' . elgg_echo('project_manager:expenses:objet') . '</th>
	<th>' . elgg_echo('project_manager:expenses:montant') . '</th>
	<th>' . elgg_echo('project_manager:expenses:devise') . '</th>
	<th>' . elgg_echo('project_manager:expenses:tva') . '</th>
	<th colspan="">' . elgg_echo('project_manager:expenses:affconsult') . '</th>
	<th colspan="">' . elgg_echo('project_manager:expenses:affprojs') . '</th>';
$content .= '</tr>';

// Par mois de l'année

// Par saisie
// @TODO Saisies => sérialisées par projet (ou membre si aucun projet affecté)
for ($i = 1; $i <= 6; $i++) {
	// id : doit être unique : timestamp + user_guid + ordre de saisie
	$id = $current_ts . '_' . $member_guid . '_' . $i;
	$content .= elgg_view('forms/expenses', array('expenses' => $expenses, 'id' => $id, 'projects' => $projects, 'action' => 'create'));
}
$content .= '</table>';
$content .= '<br />';



// SAISIES DÉJÀ EFFECTUÉES : non-affecté ($member) + affectées sur projets
$content .= '<h2>' . elgg_echo('project_manager:expenses:prevexpenses') . '</h2>';

// Entête : titre des colonnes
$col_title = '<tr>';
$col_title .= '<td scope="col">' . elgg_echo('project_manager:expenses:date') . '</td>
	<td scope="col">' . elgg_echo('project_manager:expenses:objet') . '</td>
	<td scope="col">' . elgg_echo('project_manager:expenses:montantloc') . '</td>
	<td scope="col">' . elgg_echo('project_manager:expenses:devise') . '</td>
	<td scope="col">' . elgg_echo('project_manager:expenses:rate') . '</td>
	<td scope="col">' . elgg_echo('project_manager:expenses:montanteur') . 'Montant €</td>
	<td scope="col" title="' . elgg_echo('project_manager:expenses:tvaded:details') . '">' . elgg_echo('project_manager:expenses:tvaded') . '</td>
	<td scope="col">' . elgg_echo('project_manager:expenses:affconsult') . '</th>
	<td scope="col">' . elgg_echo('project_manager:expenses:affproj') . '</td>
	<td scope="col">' . elgg_echo('project_manager:validation') . '</td>';
$col_title .= '</tr>';

$content .= '<table class="project_manager" style="width:100%;">';

// Peuvent être éditées : date, objet, montant, devise, TVA déductible, affectation aux projets
// @TODO : une fois les frais validés, on ne peut plus les modifer
foreach ($projects as $ent) {
	$project_guid = $ent->guid;
	
	// Données source récupérées via les données des projets
	$project_expenses = unserialize($ent->project_expenses);
	// Pour chacun des frais du projet de ce membre
	if (is_array($project_expenses[$member_guid]) && (sizeof($project_expenses[$member_guid]) > 0)) {
		ksort($project_expenses[$member_guid]); // Tri par date croissante
		//krsort($project_expenses[$member_guid]); // Tri par date décroissante
		// Entête : titre des colonnes
		if (elgg_instanceof($ent, 'object')) $content .= '<tr><th scope="colgroup" colspan="10">' . $ent->title . '</th></tr>';
		else if (elgg_instanceof($ent, 'user')) $content .= '<tr><th scope="colgroup" colspan="10">' . elgg_echo('project_manager:expenses:noproject') . '</th></tr>';
		$content .= $col_title;
		foreach ($project_expenses[$member_guid] as $id => $expenses) {
			$expenses['project_guid'] = $project_guid;
			// @TODO : on saute les saisies validées ?
			//if ($expenses['status'] == 'validated') continue;
			$content .= elgg_view('forms/expenses', array('expenses' => $expenses, 'id' => $id, 'projects' => $projects, 'action' => 'update'));
		}
	} else {
		//$content .= '<tr><td colspan="9">' . elgg_echo('project_manager:nodata') . '</td></tr>';
	}
}
$content .= '</table>';



$content .= '<br /><br />';
$content .= elgg_view('input/submit', array());
$content .= '</form>';
$content .= '<br /><br />';

$content .= elgg_echo('project_manager:expenses:details');
// Bloc dépliable : informations générales et mode d'emploi
//$content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
$content .= '<br /><br />';




// Rendu de la page
$nav = elgg_view('project_manager/nav', array('selected' => 'expenses', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content . $js, 'sidebar' => '', 'title' => $title));
echo elgg_view_page($title, $body);

