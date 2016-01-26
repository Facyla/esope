<?php
/**
 * Save serialized project data
 *
 * @package ElggPages
 * 
 * Data structure : [$year][$month][]
 */
// Get vars
$project_guid = get_input('project_guid', false);
// Global save
$project_data = get_input('project_data', false);
$c_project_data = get_input('c_project_data', false);
// or Month save
$year = get_input('year', false);
$month = get_input('month', false);
$p_data = get_input('p_data', false);
$c_p_data = get_input('c_p_data', false);

if (!$project_guid) {
	register_error(elgg_echo('project_manager:error'));
	forward(REFERER);
} else $project = get_entity($project_guid);

project_manager_gatekeeper();
//project_manager_manager_gatekeeper();
project_manager_projectdata_gatekeeper($project, elgg_get_logged_in_user_guid(), true, true);
action_gatekeeper();
//admin_gatekeeper();

// Give access to all users, data, etc.
$ia = elgg_set_ignore_access(true);


if ($project) {
	if (!$project->canEdit()) {
		register_error(elgg_echo('project_manager:error:invaliduser'));
		forward(REFERER);
	}
	// Save project_data, or year/month data
	if ($project_data) {
		if (is_array($project_data)) $project_data = serialize($project_data);
		$project->project_data = $project_data;
	} else if ($year && $month && $p_data) {
		$project_data = unserialize($project->project_data);
		if (!is_array($p_data)) $p_data = unserialize($p_data);
		$project_data[$year][$month] = $p_data;
		$project_data = serialize($project_data);
		$project->project_data = $project_data;
	}
	// Save computed c_project_data, or year/month computed data
	if ($c_project_data) {
		if (is_array($c_project_data)) $c_project_data = serialize($c_project_data);
		$project->c_project_data = $c_project_data;
	} else if ($year && $month && $c_p_data) {
		$c_project_data = unserialize($project->c_project_data);
		if (!is_array($c_p_data)) $c_p_data = unserialize($c_p_data);
		$c_project_data[$year][$month] = $c_p_data;
		$c_project_data = serialize($c_project_data);
		$project->c_project_data = $c_project_data;
	}
	//$project->save();
	
	// Return (full) saved data
	echo json_encode(array(
			"result" => 'true', 
			"project_guid" => $project->guid, 
			"project_data" => $project_data, 
			"c_project_data" => $c_project_data, 
		));
	exit;
}

elgg_set_ignore_access($ia);
system_message(elgg_echo('project_manager:save:ok'));
forward(REFERER);

