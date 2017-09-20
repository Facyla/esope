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
$is_main_group = true;
if ($group->guid != $main_group->guid) { $is_main_group = false; }

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
	// Publication rapide : membres seulement
	$content .= '<div class="' . $class . '" id="group-workspace-addcontent">';
		// Avertissement si non membre
		if (!$group->isMember()) {
			$content .= '<div class="group-workspace-add-tabs">';
				if ($is_main_group) {
					$content .= '<p><a href="' . $group->getURL() . '">' . elgg_echo('theme_inria:group:notmember') . '</a></p>';
				} else {
					$content .= '<p><a href="' . $group->getURL() . '">' . elgg_echo('theme_inria:workspace:notmember') . '</a></p>';
					// join - admins can always join.
					if ($group->isPublicMembership() || $group->canEdit()) {
						$content .= elgg_view('output/url', array(
								'href' => $url . "action/groups/join?group_guid={$group->guid}",
								'text' => '<i class="fa fa-sign-in"></i>&nbsp;' . elgg_echo('workspace:groups:join'),
								'class' => "workspace-button-join",
								'is_action' => true,
							));
					} else {
						// request membership
						$content .= elgg_view('output/url', array(
								'href' => $url . "action/groups/join?group_guid={$group->guid}",
								'text' => '<i class="fa fa-sign-in"></i>&nbsp;' . elgg_echo('workspace:groups:joinrequest'),
								'class' => "workspace-button-join",
								'is_action' => true,
							));
					}
				}
			$content .= '</div>';
			
		}
		if ($group->isMember() || $group->canEdit()) {
			$selected = 'elgg-state-selected'; // First tab selected sets this to '';
			// Switch publication de nouveau contenu
			$content .= '<div class="group-workspace-add-tabs">';
				if ($group->thewire_enable == 'yes') {
					$content .= '<a href="#group-workspace-add-thewire" class="' . $selected . '" rel="nofollow"><i class="fa fa-comment-o fa-fw"></i></a>';
					$selected = '';
				}
				//if ($group->forum_enable == 'yes') $content .= '<a href="#group-workspace-add-discussion" class="elgg-state-selected" rel="nofollow"><i class="fa fa-coments-o fa-fw"></i></a>';
				if ($group->blog_enable == 'yes') {
					$content .= '<a href="#group-workspace-add-blog" rel="nofollow" class="' . $selected . '"><i class="fa fa-file-text-o fa-fw"></i></a>';
					$selected = '';
				}
				//if ($group->file_enable == 'yes') {
				$content .= '<a href="#group-workspace-add-file" rel="nofollow" class="' . $selected . '"><i class="fa fa-file fa-fw"></i></a>';
				//$selected = '';
				//}
			$content .= '</div>';
			
			// Publication tab contents (only first is displayed)
			$content .= '<div class="group-workspace-add-content">';
				$hidden = ''; // First tab that is displayed sets this to 'hidden'
				
				// The Wire
				if ($group->thewire_enable == 'yes') {
					$content .= '<div id="group-workspace-add-thewire" class="group-workspace-addcontent-tab ' . $hidden . '">';
						$own_image = '<img src="' . $own->getIconURL(array('size' => 'small')) . '" />';
						$discussion_form = elgg_view_form('thewire/group_add', array('action' => 'action/thewire/add'), array());
						$content .= elgg_view_image_block($own_image, $discussion_form);
					$content .= '</div>';
					$hidden = 'hidden';
				}
			
				// Articles / discussions (blog)
				if ($group->blog_enable == 'yes') {
					$content .= '<div id="group-workspace-add-blog" class="group-workspace-addcontent-tab ' . $hidden . '">';
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
					$hidden = 'hidden';
				}
			
				// Discussion (forum) : à fusionner dans les blogs
				/*
				if ($group->forum_enable == 'yes') {
					$content .= '<div id="group-workspace-add-discussion" class="group-workspace-addcontent-tab ' . $hidden . '">';
						$own_image = '<img src="' . $own->getIconURL(array('size' => 'small')) . '" />';
						$discussion_form = elgg_view_form('theme_inria/discussion/quick_save', array('action' => 'action/discussion/save'), array());
						$content .= elgg_view_image_block($own_image, $discussion_form);
					$content .= '</div>';
					$hidden = 'hidden';
				}
				*/
			
				// Fichiers : toujours présents (activés ou pas - cf. embed)
				//if ($group->file_enable == 'yes') {
					$content .= '<div id="group-workspace-add-file" class="group-workspace-addcontent-tab ' . $hidden . '">';
						/*
						$content .= elgg_view('output/url', array(
								'href' => $url . 'file/add/' . $group->guid,
								'text' => elgg_echo('file:add'),
								'class' => "elgg-button elgg-button-action",
							));
						*/
						$content .= elgg_view_form('theme_inria/file/quick_upload', array('action' => 'action/file/upload', 'enctype' => "multipart/form-data"), array());
					$content .= '</div>';
					$hidden = 'hidden';
				//}
			
			$content .= '</div>';
		}
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

