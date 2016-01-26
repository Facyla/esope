<?php
/**
 * Elgg project_manager saver
 * 
 * @package Elggproject_manager
 * @author Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
*/

project_manager_gatekeeper();


$container_guid = (int) get_input('container_guid', false);
$project_guid = (int) get_input('guid', false);
if ($project_guid) $project = get_entity($project_guid);

if (elgg_instanceof($project, 'object', 'project_manager')) {
	$container_guid = $project->container_guid;
	$container = get_entity($container_guid);
} else {
	if ($container_guid && ($container = get_entity($container_guid))) {
		$project = project_manager_get_project_for_container($container_guid);
	}
}
elgg_set_page_owner_guid($container_guid);
if (elgg_instanceof($container, 'group')) elgg_push_context('groups');



// MENU LATERAL
$sidebar = elgg_view('project_manager/sidebar', array('tags' => $tagstring));


// CONTENU
$content = '';
$content .= '<style>' . elgg_view('project_manager/css') . '</style>';

// Render the project_manager page
if (elgg_instanceof($project, 'object', 'project_manager')) {
	//$title = $project->title;
	$title = false;
	$content .= elgg_view("object/project_manager", array('entity' => $project));
} else {
	$site_url = elgg_get_site_url();
	if ($container_guid) {
		$title = elgg_echo('project_manager:error:nogroupproject');
		$content .= elgg_echo('project_manager:error:nogroupproject:details', array($site_url, $container_guid));
	} else {
		$title = elgg_echo('project_manager:error:noproject');
		$content .= elgg_echo('project_manager:error:noproject:details', array($site_url));
	}
}



elgg_push_context('project_manager');

$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);

