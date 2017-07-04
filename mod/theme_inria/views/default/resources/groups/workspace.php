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

// Filter for content activity
$filter_opt = theme_inria_group_object_subtypes_opt($group);
$filter = get_input('filter', '');
if (!isset($filter_opt[$filter])) { $filter = ''; }
switch($filter) {
	case 'pages':
		//$subtypes = array('page', 'page_top');
		$subtypes = array('page_top');
		break;
	case 'discussion':
		//$subtypes = array('groupforumtopic', 'discussion_reply');
		$subtypes = array('groupforumtopic',);
		break;
	default:
		$subtypes = $filter;
}
if (empty($subtypes)) { $subtypes = theme_inria_group_object_subtypes($group); }


// turn this into a core function
global $autofeed;
$autofeed = true;
$url = elgg_get_site_url();
elgg_push_context('workspace');
elgg_push_context('group_workspace');
elgg_entity_gatekeeper($guid, 'group');
elgg_push_breadcrumb($group->name);

groups_register_profile_buttons($group);

$content = '';
$sidebar = '';
$sidebar_alt = '';

if (elgg_group_gatekeeper(false)) {
	
	// SIDEBAR GAUCHE
	//$sidebar .= elgg_view('theme_inria/groups/sidebar', $vars);
	$sidebar .= elgg_view('theme_inria/groups/sidebar_workspace', $vars);
	
	
	// SIDEBAR DROITE
	$sidebar_alt .= elgg_view('theme_inria/groups/sidebar_workspace_alt', $vars);
	/*
	// Agenda
	$sidebar_alt .= elgg_view('theme_inria/groups/sidebar_agenda');
	
	// Sondages
	$sidebar_alt .= elgg_view('theme_inria/groups/sidebar_poll');
	
	// Feedbacks
	$sidebar_alt .= elgg_view('theme_inria/groups/sidebar_feedback');
	*/
	
	
	
	// COLONNE PRINCIPALE
	$class = 'group-workspace-main';
	if (empty($sidebar_alt)) { $class .= ' no-sidebar-alt'; }
	$content .= '<div class="' . $class . '" id="group-workspace-addcontent">';
			
		$content .= '<div class="group-workspace-add-tabs">';
			$content .= '<a href="#group-workspace-add-discussion" class="elgg-state-selected" rel="nofollow"><i class="fa fa-quote-left"></i></a>';
			$content .= '<a href="#group-workspace-add-file" rel="nofollow"><i class="fa fa-file-o"></i></a>';
			$content .= '<a href="#group-workspace-add-blog" rel="nofollow"><i class="fa fa-file-text-o"></i></a>';
		$content .= '</div>';
		
		$content .= '<div class="group-workspace-add-content">';
			$content .= '<div id="group-workspace-add-discussion" class="group-workspace-addcontent-tab">';
				$own_image = '<img src="' . $own->getIconURL(array('size' => 'small')) . '" />';
				$discussion_form = '';
				$discussion_form .= elgg_view('input/plaintext', array('name' => 'description', 'placeholder' => "Partagez un message avec le groupe"));
				$discussion_form .= elgg_view('input/submit', array('value' => elgg_echo('publish')));
				$discussion_form .= '</form>';
				$content .= elgg_view_image_block($own_image, $discussion_form);
			$content .= '</div>';
			$content .= '<div id="group-workspace-add-file" class="group-workspace-addcontent-tab hidden">';
				/*
				$content .= elgg_view('output/url', array(
						'href' => $url . 'file/add/' . $group->guid,
						'text' => elgg_echo('file:add'),
						'class' => "elgg-button elgg-button-action",
					));
				*/
				$content .= elgg_view_form('theme_inria/file/quick_upload', array(), array('action' => 'file/upload'));
			$content .= '</div>';
			$content .= '<div id="group-workspace-add-blog" class="group-workspace-addcontent-tab hidden">';
				// @TODO pour édition directe : on ajoute un début de texte puis on bascule sur le form complet pour finir d'éditer
				//$content .= elgg_view_form('blog/save');
				$content .= elgg_view('output/url', array(
						'href' => $url . 'blog/add/' . $group->guid,
						'text' => elgg_echo('blog:add'),
						'class' => "elgg-button elgg-button-action",
					));
				$content .= elgg_view('output/url', array(
						'href' => $url . 'groups/content/' . $group->guid . '/blog/draft',
						'text' => elgg_echo('theme_inria:blog:editdraft'),
						'class' => "elgg-button elgg-button-action",
					));
			$content .= '</div>';
		$content .= '</div>';
			
	$content .= '</div>';
	
	
	// Entités par date (*pas* la river/l'activité)
	$content .= '<div class="group-workspace-main">';
		$content .= '<div class="group-workspace-activity-filter">';
			// Switch form for content filter
			// Filters by available subtypes in group (+ files as they are always enabled through embed)
			//$content .= print_r(get_registered_entity_types('object'), true);
			
			$content .= '<form id="group-workspace-content-filter">';
				$content .= '<label>' . elgg_echo('theme_inria:filter');
					$content .= elgg_view('input/select', array('name' => 'filter', 'value' => $filter, 'options_values' => $filter_opt, 'onChange' => "javascript:this.form.submit();"));
				$content .= '</label>';
			$content .= '</form>';
		$content .= '</div>';
		$content .= '<div class="group-workspace-activity">';
			$db_prefix = elgg_get_config('dbprefix');
			$content_activity_opt = array(
				'type' => 'object',
				'wheres' => array(
					"(e.container_guid = $group->guid OR e.owner_guid = $group->guid)",
				),
				'limit' => 10,
				'pagination' => true,
				'no_results' => elgg_echo('theme_inria:groups:content:no_result'),
			);
			if (!empty($subtypes)) { $content_activity_opt['subtypes'] = $subtypes; }
			//$content .= "SUBTYPES => " . print_r($subtypes, true);
			$content .= elgg_list_entities($content_activity_opt);
		$content .= '</div>';
	$content .= '</div>';
	
	
}


$sidebar = '<div class="elgg-sidebar iris-group-sidebar">
		<div class="menu-sidebar-toggle hidden" style=""><i class="fa fa-compress"></i> ' . elgg_echo('hide') . ' ' . elgg_echo('esope:menu:sidebar') . '</div>
		<div class="iris-sidebar-content">' . $sidebar . '</div>
	</div>';


$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'sidebar-alt' => $sidebar_alt,
	'title' => $group->name,
);
$body = elgg_view_layout('iris_group', $params);

echo elgg_view_page($group->name, $body);

