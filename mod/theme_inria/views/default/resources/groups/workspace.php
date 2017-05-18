<?php

// Determine current workspace (page_owner, potentially a subgroup)
$guid = elgg_extract('group_guid', $vars);
$group = get_entity($guid);
if (!elgg_instanceof($group, 'group')) {
	register_error('groups:error:invalid');
	forward();
}
elgg_set_page_owner_guid($guid);
// Determine main group
$main_group = theme_inria_get_main_group($group);

$own = elgg_get_logged_in_user_entity();

// turn this into a core function
global $autofeed;
$autofeed = true;
$url = elgg_get_site_url();
elgg_push_context('group_profile');
elgg_entity_gatekeeper($guid, 'group');
elgg_push_breadcrumb($group->name);

groups_register_profile_buttons($group);

$content = '';
$sidebar = '';
$sidebar_alt = '';

if (elgg_group_gatekeeper(false)) {
	
	$content .= '<div class="group-workspace-main">';
		$content .= '<div class="group-workspace-activity">';
			
			$content .= '<div class="group-workspace-add-tabs">';
				$content .= '<a href="#discussion"><i class="fa fa-quote-left"></i></a>';
				$content .= '<a href="#file"><i class="fa fa-file-o"></i></a>';
				$content .= '<a href="#blog"><i class="fa fa-file-text-o"></i></a>';
			$content .= '</div>';
			
			$content .= '<div class="group-workspace-add-content">';
				$content .= '<img src="' . $own->getIconURL(array('size' => 'small')) . '" />';
				$content .= elgg_view('input/plaintext', array('name' => 'description'));
			$content .= '</div>';
			
		$content .= '</div>';
	$content .= '</div>';
	
	
	// Entités par date (*pas* la river/l'activité)
	$content .= '<div class="group-workspace-main">';
		$content .= '<div class="group-workspace-activity">';
		elgg_push_context('widgets');
		$db_prefix = elgg_get_config('dbprefix');
		$content .= elgg_list_entities(array(
			'pagination' => true,
			'limit' => 10,
			'type' => 'object',
			/*
			'joins' => array(
				"JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid",
				"LEFT JOIN {$db_prefix}entities e2 ON e2.guid = rv.target_guid",
			),
			*/
			'wheres' => array(
				"(e.container_guid = $group->guid OR e.owner_guid = $group->guid)",
			),
			//'action_types' => array('join', 'vote', 'tag'),
		));
		elgg_pop_context();
		$content .= '</div>';
	$content .= '</div>';
	
	
	
	// Config
	//$sidebar .= elgg_view('theme_inria/groups/sidebar', $vars);
	$sidebar .= '<h3>' . "Description" . '</h3>';
	$desc = $group->briefdescription;
	if (empty($desc)) { $desc = elgg_get_excerpt($group->description); }
	$sidebar .= '<p>' . $desc . '</p>';
	
	$sidebar .= '<h3>' . "Les fichiers (X)" . '</h3>';
	$sidebar .= elgg_view('file/group_module');
	
	$sidebar .= '<h3>' . "Les articles (X)" . '</h3>';
	$sidebar .= elgg_view('blog/group_module');
	
	$sidebar .= '<h3>' . "Pages wiki (X)" . '</h3>';
	$sidebar .= elgg_view('pages/group_module');
	
	$sidebar .= '<h3>' . "Les liens web (X)" . '</h3>';
	$sidebar .= elgg_view('bookmarks/group_module');
	
	$sidebar .= '<h3>' . "Les lettres d'info (X)" . '</h3>';
	$sidebar .= elgg_view('newsletter/group_module');
	
	
	// Agenda, sondages
	$sidebar_alt .= '<h3>' . elgg_echo('agenda') . '</h3>';
	$sidebar_alt .= elgg_view('event_calendar/group_module');
	
	$sidebar_alt .= '<h3>' . elgg_echo('survey') . '</h3>';
	$sidebar_alt .= elgg_view('survey/group_module');
	
}


$sidebar = '<div class="elgg-sidebar iris-group-sidebar"><div class="iris-sidebar-content">' . $sidebar . '</div></div>';


$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'sidebar-alt' => $sidebar_alt,
	'title' => $group->name,
);
$body = elgg_view_layout('iris_group', $params);

echo elgg_view_page($group->name, $body);

