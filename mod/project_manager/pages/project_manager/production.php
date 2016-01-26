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

$p_url = elgg_get_site_url() . 'project_manager/production/project/';
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
$content .= '<br />';

if (project_manager_manager_gatekeeper(false, true, false)) {
	$content .= '<a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'project_manager/production/all">' . elgg_echo('project_manager:manager:summary') . '</a><br /><br />';
}


// Infos : qui a accès à cette page
$info_doc = elgg_echo('project_manager:production:details') . '<br /><br />';
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



// Project view, if required data
if ((elgg_instanceof($container, 'group') || elgg_instanceof($container, 'user')) && elgg_instanceof($project, 'object', 'project_manager')) {
	
	// Accès réservé au responsable de ce projet (owner ou manager), aux managers, et aux admins
	project_manager_projectdata_gatekeeper($project, elgg_get_logged_in_user_guid(), true, true);
	// Give access to all users, data, etc.
	$ia = elgg_set_ignore_access(true);
	
	$content .= elgg_view('forms/month_production', array(
			'container' => $container, 'project' => $project, 
			'year' => $year, 'month' => $month, 
		));
	
	/* Toutes les données saisies/ajustées du projet sont stockées dans une variable $project->project_data
	 * celle-ci contient, sous une forme sérialisée, les données selon la structure suivante :
	 * $project_data[$year][$month][$c_p_data] = $c_p_data;
	 * avec $c_p_data[$p_type]['marge'][$id] = $value;
	 * On re-calcule dynamiquement tout ce qui est variable (infos, indicateurs), et on peut alors initialiser les données avec des valeurs par défaut, et les conserver pour toute date de saisie.
	*/
	
	elgg_set_ignore_access($ia);
	
} else {
	// Formulaires de sélection
	$content .= '<div style="background:#DEDEDE; padding:6px 12px;">';
	// Formulaire pour changer de projet
	// @TODO : ne lister que ceux dont on est owner
	$content .= time_tracker_select_input_project($project->guid, false);
	// Formulaires pour changer de feuille de temps : seulement si projet défini ?
	$content .= '<span style="float:right;">' . time_tracker_select_input_month($year, $month, 'project_manager/production/project/' . $project->guid, '/') . '</span>';
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div><br />';
}


// Render page
elgg_set_context('project_manager');
$title = elgg_echo("project_manager:production");

$nav = elgg_view('project_manager/nav', array('selected' => 'production', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content, 'sidebar' => $area1));

echo elgg_view_page($title, $body); // Finally draw the page

