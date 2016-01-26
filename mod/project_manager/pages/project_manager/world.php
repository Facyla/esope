<?php
/**
 * Elgg project_manager browser
 * 
 * @package Elggproject_manager
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009 - 2009
 * @link http://elgg.com/
 */

//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

project_manager_gatekeeper();

$limit = get_input("limit", 30);
$offset = get_input("offset", 0);
$tags = get_input("tags");

// Get the current page's owner
$page_owner = elgg_get_page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	elgg_set_page_owner_guid($_SESSION['user']->guid);
}
$own = elgg_get_logged_in_user_entity();
$ownguid = $own->guid;
// Tag search ?
if ($tags != "") {
	if(is_array($tags)) $tagstring = implode(", ", $tags); else $tagstring = $tags;
	$title = "Les projets \"$tagstring\"";
} else { $title = elgg_echo('project_manager:all'); }



// SIDEBAR
$sidebar = elgg_view('project_manager/search');
$sidebar .= '<br />';
$sidebar .= '<p><a href="' . elgg_get_site_url() . 'project_manager/new" class="elgg-button elgg-button-action">' . elgg_echo('project_manager:new') . '</a></p>';



// CONTENT
$content = '';
elgg_set_context('search');

$add_style = '.elgg-image-block { box-shadow: 0 1px 5px #777777; margin: 10px 0; padding: 2px; } ';
$content .= '<style>' . $add_style . elgg_view('project_manager/css') . '</style>';

// Bloc dépliable : informations générales et mode d'emploi
$info_doc = elgg_echo('project_manager:world:details');
$content .= elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
$content .= '<br /><br />';


// Affichage du listing des projets
if (empty($tagstring)) {
	// @TODO : lister d'abord ses projets + ceux dont on est manager
	// @TODO : projets dont on est consultant interne ou externe
	// @TODO : puis ceux auxquels on a accès à l'extranet
	// et enfin les autres projets
	//$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'project_manager'));
	$projects_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'count' => true));
	$projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'limit' => $projects_count));
	$owner_projects = '';
	$manager_projects = '';
	$team_projects = '';
	$fullteam_projects = '';
	$extranet_projects = '';
	$other_projects = '';
	$closed_projects = '';
	$sidebar .= '<br /><div style="position:fixed; background:white; border:1px dashed #002E6E; padding:6px 12px;"><strong>Navigation dans la page</strong><br />';
	foreach ($projects as $ent) {
		// Projets terminés
		if ($ent->project_managertype == 'closed') {
		$closed_projects .= elgg_view_entity($ent, array('full_view' => false));
		// Ses projets
		} else if ($ownguid == $ent->owner_guid) {
			$owner_projects .= elgg_view_entity($ent, array('full_view' => false));
		// Ceux dont on est manager
		} else if ( ($ownguid == $ent->projectmanager) || (is_array($ent->projectmanager) && in_array($ownguid, $ent->projectmanager)) ) {
			$manager_projects .= elgg_view_entity($ent, array('full_view' => false));
		// Projets dont on est consultant interne
		} else if ( ($ownguid == $ent->team) || (is_array($ent->team) && in_array($ownguid, $ent->team)) ) {
			$team_projects .= elgg_view_entity($ent, array('full_view' => false));
		// Projets dont on est consultant externe
		} else if ( ($ownguid == $ent->fullteam) || (is_array($ent->fullteam) && in_array($ownguid, $ent->fullteam)) ) {
			$fullteam_projects .= elgg_view_entity($ent, array('full_view' => false));
		// Ceux auxquels on a accès à l'extranet
		} else if ( ($ownguid == $ent->extranet) || (is_array($ent->extranet) && in_array($ownguid, $ent->extranet)) ) {
			$extranet_projects .= elgg_view_entity($ent, array('full_view' => false));
		// et enfin les autres projets
		} else {
			$other_projects .= elgg_view_entity($ent, array('full_view' => false));
		}
	}
	if (!empty($owner_projects) || !empty($manager_projects)) {
		$content .= '<a name="manager"></a><h3>Mes Projets / Projets dont je suis manager</h3>' . $owner_projects . $manager_projects . '<br />';
		$sidebar .= '<a href="#manager">Mes Projets</a><br />';
	}
	if (!empty($team_projects) || !empty($fullteam_projects)) {
		$content .= '<a name="team"></a><h3>Projets sur lesquels j\'interviens</h3>' . $team_projects . $fullteam_projects . '<br />';
		$sidebar .= '<a href="#team">Projets (intervenant)</a><br />';
	}
	if (!empty($extranet_projects)) {
		$content .= '<a name="extranet"></a><h3>Projets pour lesquels j\'ai un accès extranet</h3>' . $extranet_projects . '<br />';
		$sidebar .= '<a href="#extranet">Projets (extranet)</a><br />';
	}
	if (!empty($closed_projects)) {
		$content .= '<a name="closed"></a><h3>Projets terminés / références</h3>' . $closed_projects . '<br />';
		$sidebar .= '<a href="#closed">Projets (terminés)</a><br />';
	}
	if (!empty($other_projects)) {
		$content .= '<a name="other"></a><h3>Tous les autres projets</h3>' . $other_projects . '<br />';
		$sidebar .= '<a href="#other">Projets (autres)</a><br />';
	}
	$sidebar .= '</div>';
	
// Recherche de projet
} else {
	//$content .= list_entities_from_metadata('tags',$tags,'object','project_manager');
	$content .= elgg_list_entities_from_metadata(array(
			'types' => 'object', 'subtypes' => 'project_manager', 
			'metadata_name' => 'tags', 'metadata_value' => $tags,
			'full_view' => false, 'limit' => 10, 
		));
	// Search other fields
	//$meta_array = array('title' => $tags, 'description' => $tags, 'tags' => $tags, 'date' => $tags, 'enddate' => $tags, 'clients' => $tags, 'clienttype' => $tags, 'budget' => $tags, 'status' => $tags, 'project_managertype' => $tags, 'clientcontact' => $tags, 'projectmanager' => $tags, 'team' => $tags, 'fullteam' => $tags, 'ispublic' => $tags, 'sector' => $tags);
	/*
	$meta_array = array('tags' => $tags, 'clients' => $tags, 'clienttype' => $tags, 'sector' => $tags);
	$entity_type = "object";
	$entity_subtype="project_manager";
	$owner_guid="";
	$limit = 30;
	$fullview = false;
	$viewtypetoggle = false;
	$pagination = true;
	*/
	//$content .= list_entities_from_metadata_multi($meta_array, $entity_type, $entity_subtype, $owner_guid, $limit, $fullview, $viewtypetoggle, $pagination);
	//$content .= list_entities_from_metadata_multi($meta_array, $entity_type, $entity_subtype, $owner_guid, $limit, $fullview, $viewtypetoggle, $pagination);
	
	/*
	// Search other fields
	$objects = search_for_object ($tag, 30, 0, "", false);
	foreach($objects as $object) { $content .= elgg_view_entity($object, false); }
	*/
}


elgg_set_context('project_manager');

$nav = elgg_view('project_manager/nav', array('selected' => 'project_manager', 'title' => $title));
$body = elgg_view_layout('one_sidebar', array('content' => $nav . $content, 'sidebar' => $sidebar));

$title = sprintf(elgg_echo("project_manager:yours"),$_SESSION['user']->name);

echo elgg_view_page($title, $body); // Finally draw the page

