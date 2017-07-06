<?php
elgg_gatekeeper();

// Determine current workspace (page_owner, potentially a subgroup)
$guid = elgg_extract('group_guid', $vars);
$page = elgg_extract('page', $vars);

elgg_require_js('elgg/groups/edit');

$own = elgg_get_logged_in_user_entity();

$content = '';

if ($page == 'add') {
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('groups:add');
	elgg_push_breadcrumb($title);
	if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
		$params = array();
		$parent_group_guid = get_input('au_subgroup_parent_guid');
		if ($parent_group_guid) {
			$parent_group = get_entity($parent_group_guid);
			if (elgg_instanceof($parent_group, 'group')) {
				$title = elgg_echo('workspace:groups:add');
				$params['au_subgroup_of'] = $parent_group;
			}
		}
		$content .= elgg_view('groups/edit', $params);
	} else {
		$content .= elgg_echo('groups:cantcreate');
	}
} else {
	$title = elgg_echo("groups:edit");
	$group = get_entity($guid);
	
	// Determine main group
	$main_group = theme_inria_get_main_group($group);
	
	// Workspaces switch ?
	/*
	if ($group->guid != $main_group->guid) {
		$content .= elgg_view('theme_inria/groups/workspaces_tabs', array('main_group' => $main_group, 'group' => $group, 'link_type' => 'edit'));
	}
	*/
	// Edit form
	$content .= '<div class="group-profile-main">';
		if (elgg_instanceof($group, 'group') && $group->canEdit()) {
			$params = array('entity' => $group);
			// Group or workspace ?
			if (elgg_is_active_plugin('au_subgroups')) {
				$parent_group = AU\SubGroups\get_parent_group($group);
				if ($parent_group) {
					$params['au_subgroup_of'] = $parent_group;
					$title = elgg_echo("workspace:groups:edit");
				}
			}
			
			elgg_set_page_owner_guid($group->getGUID());
			elgg_push_breadcrumb($group->name, $group->getURL());
			elgg_push_breadcrumb($title);
			$content .= elgg_view("groups/edit", $params);
		} else {
			$content .= elgg_echo('groups:noaccess');
		}
	$content .= '</div>';
}

$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

