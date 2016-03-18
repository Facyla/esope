<?php
/**
 * Elgg project_manager edit project
 * 
 * @package Elggproject_manager
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

project_manager_gatekeeper();

$project_manager_guid = (int) get_input('guid', false);
$group_guid = (int) get_input('group_guid', false);

// Check group validity
if ($group_guid && ($group = get_entity($group_guid))) {
}

$is_manager = project_manager_manager_gatekeeper(false, true, false);

// Check input object validity
if ($project_manager_guid && ($project_manager = get_entity($project_manager_guid))) {
	$title = elgg_echo('project_manager:edit');
	if ($project_manager->canEdit() || $is_manager) {
		// Note : un projet terminé ne peut plus être réouvert ni supprimé, sauf par un admin ou manager
		if (!in_array($projecttype, array('closed', 'rejected')) || isadminloggedin() || $is_manager) {
			$page_title = elgg_echo("project_manager:edit");
			$area2 = elgg_view("forms/project_manager/edit",array('entity' => $project_manager));
		} else {
			register_error('project_manager:error:closed');
			forward('project_manager/view/' . $project_manager->guid);
		}
	}
} else {
	$title = elgg_echo('project_manager:new');
	$page_title = elgg_echo("project_manager:new");
	$area2 = elgg_view("forms/project_manager/edit",array());
}

// Set the page owner
$page_owner = elgg_get_page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$container_guid = $project_manager->container_guid;
	if (!empty($container_guid))
		if ($page_owner = get_entity($container_guid)) { elgg_set_page_owner_guid($container_guid->guid); }
	if (empty($page_owner)) {
		$page_owner = $_SESSION['user'];
		elgg_set_page_owner_guid($_SESSION['guid']);
	}
}

$body = elgg_view_layout('one_sidebar', array('content' => $area2, 'sidebar' => '', 'title' => $title));
echo elgg_view_page($title, $body);

