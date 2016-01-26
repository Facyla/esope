<?php
/**
 * Elgg time_tracker global edit page
 * 
 * @package Elggtime_tracker
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
*/

$debugmode = false; // Activate debug mode..
$display_dates = get_input('display_dates', false);
$display_consultants = get_input('display_consultants', false);
$display_projects = get_input('display_projects', false);
$display_time_trackers = get_input('display_time_trackers', false);

// Affichage par défaut si rien n'est choisi = par projets
if (!$display_dates && !$display_consultants && !$display_projects && !$display_time_trackers) { !$display_projects = true; }

$t0 = microtime(true);
if ($debugmode) {
	ini_set('max_execution_time', 180);
	error_log("DEBUG MODE : start at $t0 on " . __FILE__);
}

global $CONFIG;
$content = '';

// Access and user rights
project_manager_gatekeeper();
project_manager_manager_gatekeeper();

// Give access to all users, data, etc.
$ia = elgg_set_ignore_access(true);

// Get and prepare useful vars
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

// JS & CSS
//$js = '<script type="text/javascript">' . elgg_view('time_tracker/js') . '</script>';
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';

// Set useful vars and context
$title = sprintf(elgg_echo('time_tracker:summary'));
$selected = 'time_tracker/summary'; // Vue synthétique par année
$months = time_tracker_get_date_table('months');
$back_to_top = '<span class="elgg-button back_to_top" style="float:right;"><a href="#top">Retour en haut de page</a></span>';
elgg_set_context('time_tracker');
elgg_set_page_owner_guid(0);



// PREPARE PAGE CONTENT

// $content .= '<span style="float:right;">' . time_tracker_select_input_month($year, $month, "time_tracker/owner/$username") . '</span>';
//$content .= '<span style="float:right; margin-right:10px; width: 300px; box-shadow: 1px 1px 10px 3px #999; padding: 6px 12px;"><a name="top"></a><strong>Vue globale des Rapports d\'Activités</strong><br />';
$content .= "Cliquez pour changer de vue : ";
$content .= '<a href="' . $vars['url'] . '/time_tracker/all/?display_dates=true" class="elgg-button elgg-button-action">..par date</a> &nbsp; ';
$content .= '<a href="' . $vars['url'] . '/time_tracker/all/?display_consultants=true" class="elgg-button elgg-button-action">...par consultant</a> &nbsp; ';
$content .= '<a href="' . $vars['url'] . '/time_tracker/all/?display_projects=true" class="elgg-button elgg-button-action">..par projet</a> &nbsp; ';
if (elgg_is_admin_logged_in()) $content .= '<a href="' . $vars['url'] . '/time_tracker/all/?display_time_trackers=true" class="elgg-button elgg-button-action">..toutes les saisies</a><br />';
$content .= '<br /><strong><em>Aide : pour rechercher un projet/consultant dans la page : Ctrl+F</em></strong><br />';
$content .= '<div class="clearfloat"></div>';


// SYNTHÈSE : PAR PÉRIODE DE TEMPS
if ($display_dates) {
	$content .= '<br /><a name="dates"></a><h2>Synthèse par dates</h2>';
	$content .= '<em>Les valeurs sont arrondies au jour près</em><br /><br />';
	if ($debugmode) { $t1 = microtime(true); }
	// Collecte des données mensuelles par date
	for ($y = 2013; $y <= (date('Y')); $y++) {
		$max_month = 12;
		if ($y == date('Y')) $max_month = date('m');
		for ($m = 1; $m <= $max_month; $m++) {
			if ($debugmode) { $t = microtime(true); }
		  $all_times[$y][$m] = time_tracker_monthly_time($y, $m);
			if ($debugmode) { error_log("$y/$m => " . 1000*(microtime(true) - $t)); }
		}
	}
	if ($debugmode) { $t2 = microtime(true); }
	$total_time = 0;
	// Synthèse des données annuelles (temps global par mois)
	if (is_array($all_times)) foreach ($all_times as $year => $year_member_times) {
		$content .= "<h4>Année $year</h4>";
		$total_year = 0;
		if (is_array($year_member_times)) foreach ($year_member_times as $month => $month_time) {
		  $content .= "<strong>" . $months[(int)$month] . " : " . $month_time . " jours</strong><br />";
		  $total_year += $month_time;
		}
		$content .= "<h5>Total annuel $year : " . $total_year . " jours</h5><br />";
		$total_time += $total_year;
	}
	$content .= '<br />';
	if ($debugmode) {
		set_time_limit(60);
		error_log('Initialisation => ' . 1000*($t1 - $t0)) . ' ms';
		error_log('Collecte des donnees par date => ' . 1000*($t2 - $t1)) . ' ms';
		error_log('Synthese annuelle => ' . 1000*(microtime(true) - $t2)) . ' ms';
	}
}


// Par consultant
if ($display_consultants) {
	$content .= '<br /><a name="consultants"></a>' . $back_to_top . '<h2>Synthèse par consultant</h2>';
	$members = project_manager_get_consultants();
	foreach ($members as $ent) {
		if ($debugmode) { $t = microtime(true); }
		$content .= '<a target="_new" href="' . $ent->getURL() . '"><h3>' . $ent->name . '</h3></a>';
		$content .= elgg_view('time_tracker/owner_summary', array('member' => $ent, 'hide_info' => true));
		if ($debugmode) { error_log('Membre ' . $ent->name . " => " . 1000*(microtime(true) - $t)); }
	}
	$content .= '<br />';
}


// Par projet
if ($display_projects) {
	$content .= '<br /><a name="projects"></a>' . $back_to_top . '<h2>Synthèse par projet</h2>';
	$count_projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'count' => true));
	$projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'limit' => $count_projects));
	$max_col = 4;
	$col = 0;
	if ($projects) foreach ($projects as $project) {
		$col++;
		if ($col < $max_col) {
			if ($col == 1) $content .= '<div class="clearfloat"></div><br />';
			$content .= '<div style="float:left; width:24%; margin-right:1%;">';
		} else {
			$content .= '<div style="float:right; width:24%;">';
			$col = 0;
		}
		if ($debugmode) { $t = microtime(true); }
		$content .= '<a target="_new" href="' . $project->getURL() . '"><h3>' . time_tracker_get_projectname($project->guid) . '</h3></a>';
		$content .= time_tracker_project_times($project->guid, $return_array = false);
		$content .= '<br />';
		if ($debugmode) { error_log('Projet ' . substr($project->title, 0, 12) . " => " . 1000*(microtime(true) - $t)); }
		$content .= '</div>';
	}
	$content .= '<br />';
}


// Affichage exhaustif de toutes les saisies
if ($display_time_trackers && elgg_is_admin_logged_in) {
  $content .= '<br /><a name="all_time_trackers"></a>' . $back_to_top . '<h2>Toutes les feuilles de temps</h2>';
  $options = array(
      'types' => 'object', 'subtypes' => 'time_tracker',
      'limit' => false, 'offset' => 0, 'order_by' => '', 'count' => false,
    );
  $time_trackers = elgg_get_entities($options);
  $count_time_trackers = count($time_trackers);
  $content .= '<strong>' . $count_time_trackers . ' feuilles de temps</strong><br />';
  foreach ($time_trackers as $ent) {
    $content .= elgg_view('object/time_tracker', array('entity' => $ent));
    /*
    //$ent->time_tracker = null; // Suppression des données inutiles (ancien datamodel)
    // //$ent->delete(); // /!\ Uniquement pour les dévs !!! Efface TOUTES les données
    */
  }
}

$content .= '<div class="clearfloat"></div><br />';

if ($debugmode) {
	//global $project_manager_projects;
	error_log('Global => ' . 1000*(microtime(true) - $t0));
	//$content .= print_r($project_manager_projects, true);
}

elgg_set_ignore_access($ia);
$nav = elgg_view('project_manager/nav', array('selected' => $selected, 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content . $js, 'sidebar' => ''));
echo elgg_view_page($title, $body);

