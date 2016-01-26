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

global $CONFIG;
$months = time_tracker_get_date_table('months', false);
$short_months = time_tracker_get_date_table('months', true);
$content = '';

// Set the current page's owner to the site
elgg_set_page_owner_guid(0);
elgg_set_context('project_manager');


// Compose the page
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';
$content .= '<script type="text/javascript">' . elgg_view('project_manager/js') . '</script>';

// Ajax loader : Please wait while updating animation
$content .= '<div id="loading_overlay" style="display:none;"><div id="loading_fader">' . elgg_echo('project_manager:ajax:loading') . '</div></div>';


// Infos diverses et mode d'emploi
$info_doc .= elgg_echo('project_manager:consultants:details') . '<br /><br />';
$info_doc .= '<h3>' . elgg_echo('project_manager:managers') . '</h3>';
$managers = explode(',', elgg_get_plugin_setting('managers', 'project_manager'));
foreach ($managers as $manager_guid) {
	$manager = get_entity($manager_guid);
	if (!isset($managers_list)) $managers_list = $manager->name;
	else $managers_list .= ', ' . $manager->name;
}
$info_doc .= '<p>' . $managers_list . '</p>';

// Données de base pour calculs consultants
$info_doc .= '<h3>' . elgg_echo('project_manager:settings:consultants:data') . '</h3>';
$info_doc .= elgg_echo('project_manager:consultants:data:details') . '<br /><br />';
$coef_salarial = elgg_get_plugin_setting('coefsalarie', 'project_manager'); // 1.8
$coef_pv = elgg_get_plugin_setting('coefpv', 'project_manager'); // 1.35
$days_per_month = elgg_get_plugin_setting('dayspermonth', 'project_manager'); // 20
$info_doc .= elgg_echo('project_manager:settings:coefsalarie') . ' : ' . $coef_salarial . '<br />';
$info_doc .= elgg_echo('project_manager:settings:coefpv') . ' : ' . $coef_pv . '<br />';
$info_doc .= elgg_echo('project_manager:settings:dayspermonth') . ' : ' . $days_per_month . '<br />';

// Bloc dépliable : informations générales et mode d'emploi
$content .= elgg_view('output/show_hide_block', array('title' => elgg_echo("project_manager:infos"), 'linktext' => elgg_echo('project_manager:showhide'), 'content' => $info_doc));
$content .= '<br /><br /><br />';


// Composition de la page : vue globale de tous les membres
$all_members_count = elgg_get_entities(array('types' => 'user', 'count' => true));
$all_members = elgg_get_entities(array('types' => 'user', 'count' => false, 'limit' => $all_members_count));
$content .= '<table class="project_manager" style="width:100%;">';
$content .= '<tr>
	<th scope="col">' . elgg_echo('project_manager:consultants:member'). '</th><th scope="col">' . elgg_echo('project_manager:consultants:statut'). '</th>
	<th scope="col" title="' . elgg_echo('project_manager:consultants:fixe:details'). '">' . elgg_echo('project_manager:consultants:fixe'). '</th>
	<th scope="col" title="' . elgg_echo('project_manager:consultants:variable:details'). '">' . elgg_echo('project_manager:consultants:variable'). '</th>
	<th scope="col" title="' . elgg_echo('project_manager:consultants:monthbrut:details'). '">' . elgg_echo('project_manager:consultants:monthbrut'). '</th>
	<th scope="col" title="' . elgg_echo('project_manager:consultants:monthcost:details'). '">' . elgg_echo('project_manager:consultants:monthcost'). '</th>
	<th scope="col" title="' . elgg_echo('project_manager:consultants:daycost:details'). '">' . elgg_echo('project_manager:consultants:daycost'). '</th>';
foreach ($months as $num => $month) { $content .= '<th scope="col">' . mb_substr($month, 0, 3) . '.</th>'; }
/*
	<th>Janvier</th><th>Février</th><th>Mars</th><th>Avril</th><th>Mai</th><th>Juin</th>';
$content .= '<th>Juillet</th><th>Août</th><th>Septembre</th><th>Octobre</th><th>Novembre</th><th>Décembre</th>';
*/
$content .= '</tr>';

/* DEBUG accès réservés
foreach ($all_members as $ent) {
	$content .= $ent->name . ' : ';
	// ($user, $metadata_values = '', $allow = true, $is_equal = true, $required = true, $forward = true)
	if (project_manager_flexible_gatekeeper($ent, array('isexternal' => 'yes'), false, true, true, false, false)) $content .= 'OK';
	else $content .= 'NON';
	if (in_array($ent->guid, $managers)) $content .= " - Vous êtes manager, OK";
	else $content .= " - Accès interdit";
	$content .= '<br />';
}
*/
foreach ($all_members as $ent) {
	// MAJ des données utilisateur : NOM Prénom
	$new_name = strtoupper($ent->lastname) . ' ' . $ent->firstname;
	if (!empty($ent->lastname) && !empty($ent->firstname)) {
		if ($ent->name != $new_name) {
			$ent->name = $new_name;
			$ent->save();
		}
	}
	// On peut mettre à jour les infos Nom et Prénom si non renseigné ou différent du nom sur le site
	if (empty($ent->lastname) || empty($ent->firstname) || ($ent->name != $new_name)) {
		$edit_lastname = elgg_view('input/text', array('value' => $ent->lastname, 'js' => 'style="max-width:12ex;" onChange="project_manager_update_consultants('.$ent->guid.', \'lastname\', this.value);"'));
		$edit_firstname = elgg_view('input/text', array('value' => $ent->firstname, 'js' => 'style="max-width:12ex;" onChange="project_manager_update_consultants('.$ent->guid.', \'firstname\', this.value);"'));
		$edit_name = '<br />' . elgg_echo('project_manager:consultants:lastname') . '&nbsp;: ' . $edit_lastname . '<br />' . elgg_echo('project_manager:consultants:name') . '&nbsp;: ' . $edit_firstname;
	} else $edit_name = '';
	$edit_status = elgg_view('input/dropdown', array('value' => $ent->items_status, 'options_values' => array('' => elgg_echo('project_manager:items_status:'), "salarie" => elgg_echo('project_manager:items_status:salarie'), "non-salarie" => elgg_echo('project_manager:items_status:non-salarie')), 'js' => 'style="max-width:13ex;" onChange="project_manager_update_consultants('.$ent->guid.', \'items_status\', this.value);"'));
	$edit_yearly_global_cost = elgg_view('input/text', array('value' => $ent->yearly_global_cost, 'js' => 'style="width:10ex;" onChange="project_manager_update_consultants('.$ent->guid.', \'yearly_global_cost\', this.value);"'));
	$edit_yearly_variable_part = elgg_view('input/text', array('value' => $ent->yearly_variable_part, 'js' => 'style="width:10ex;" onChange="project_manager_update_consultants('.$ent->guid.', \'yearly_variable_part\', this.value);"'));
	$edit_daily_cost = elgg_view('input/text', array('value' => $ent->daily_cost, 'js' => 'style="max-width:10ex;" onChange="project_manager_update_consultants('.$ent->guid.', \'daily_cost\', this.value);"'));
	if ($ent->isBanned()) {
		// Non concerné
	} else if ($ent->items_status == 'salarie') {
		$content_salarie .= '<tr>';
		$monthly = $ent->yearly_global_cost / 12;
		$monthly_cost = ($monthly * $coef_salarial) + ($ent->yearly_variable_part * $coef_pv / 12);
		$content_salarie .= '<td scope="row">' . $ent->name . $edit_name . '</td>';
		$content_salarie .= '<td>' . $edit_status . '</td>';
		$content_salarie .= '<td>' . $edit_yearly_global_cost . '</td>';
		$content_salarie .= '<td>' . $edit_yearly_variable_part . '</td>';
		$content_salarie .= '<td>' . round($monthly, 2) . '</td>';
		$content_salarie .= '<td>' . round($monthly_cost, 2) . '</td>';
		$content_salarie .= '<td>' . round(($monthly_cost / $days_per_month), 2) . '</td>';
		foreach ($months as $num => $month) {
			// Voir si on compte temps hors-projet et temps méta (GATC)
			$content_salarie .= '<td>' . time_tracker_monthly_time(date('Y'), $num, null, $ent->guid, true, true, true) . '</td>';
		}
		$content_salarie .= '</tr>';
	} else if ($ent->items_status == 'non-salarie') {
		$content_non_salarie .= '<tr>';
		$content_non_salarie .= '<td scope="row">' . $ent->name . $edit_name . '</td>';
		$content_non_salarie .= '<td>' . $edit_status . '</td>';
		$content_non_salarie .= '<td>' . '</td>';
		$content_non_salarie .= '<td>' . '</td>';
		$content_non_salarie .= '<td>' . '</td>';
		$content_non_salarie .= '<td>' . '</td>';
		$content_non_salarie .= '<td>' . $edit_daily_cost . '</td>';
		foreach ($months as $num => $month) {
			// Voir si on compte temps hors-projet et temps méta (GATC)
			$content_non_salarie .= '<td>' . time_tracker_monthly_time(date('Y'), $num, null, $ent->guid, true, true) . '</td>';
		}
		$content_non_salarie .= '</tr>';
	} else {
		if (elgg_is_admin_logged_in()) {
			if ($ent->isexternal == 'yes') {
				$content_external .= '<tr>';
				$content_external .= '<td scope="row" colspan="19">' . $ent->name . ' (extranet)' . $edit_name . '</td>';
				$content_external .= '</tr>';
			} else {
				$content_undefined .= '<tr>';
				$content_undefined .= '<td scope="row">' . $ent->name . $edit_name . '</td>';
				$content_undefined .= '<td >' . $edit_status . '</td>';
				$content_undefined .= '<td colspan="18">' . '</td>';
				$content_undefined .= '</tr>';
			}
		}
	}
}
$content .= '<tr><th colspan="19" scope="colgroup">' . elgg_echo('project_manager:items_status:salarie') . '</th></tr>';
$content .= $content_salarie;
$content .= '<tr><th colspan="19" scope="colgroup">' . elgg_echo('project_manager:items_status:non-salarie') . '</th></tr>';
$content .= $content_non_salarie;
if (elgg_is_admin_logged_in()) {
	$content .= '<tr><th colspan="19" scope="colgroup">' . elgg_echo('project_manager:items_status:') . '</th></tr>';
	$content .= $content_undefined;
	$content .= '<tr><th colspan="19" scope="colgroup">' . elgg_echo('project_manager:items_status:extranet') . '</th></tr>';
	$content .= $content_external;
}
$content .= '</tr></table>';


elgg_set_context('project_manager');
elgg_push_context('consultants');

elgg_set_ignore_access($ia);
$nav = elgg_view('project_manager/nav', array('selected' => 'consultants', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content, 'sidebar' => $area1));

$title = elgg_echo("project_manager:consultants");

echo elgg_view_page($title, $body); // Finally draw the page

