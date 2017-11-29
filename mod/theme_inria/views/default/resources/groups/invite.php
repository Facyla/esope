<?php
elgg_gatekeeper();

// Determine current workspace (page_owner, potentially a subgroup)
$guid = elgg_extract('group_guid', $vars);
elgg_entity_gatekeeper($guid, 'group');

$title = elgg_echo('groups:invite:title');

$group = get_entity($guid);
if (!elgg_instanceof($group, 'group') || !$group->canEdit()) {
	register_error(elgg_echo('groups:noaccess'));
	forward(REFERER);
}
elgg_group_gatekeeper();

elgg_set_page_owner_guid($guid);

elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb(elgg_echo('groups:invite'));

// Determine main group
$main_group = theme_inria_get_main_group($group);

$own = elgg_get_logged_in_user_entity();


$content = '';

// Workspaces switch
/*
if ($group->guid != $main_group->guid) {
	$content .= elgg_view('theme_inria/groups/workspaces_tabs', array('main_group' => $main_group, 'group' => $group, 'link_type' => 'members'));
}
*/
$content .= '<div class="group-profile-main">';
	
	if ($group->guid != $main_group->guid) {
		$content .= '<blockquote class="warning">' . elgg_echo('theme_inria:workspace:invites:warning') . '</blockquote>';
		//system_message(elgg_echo('theme_inria:workspace:invites:warning'));
		$content .= elgg_view_form('groups/parent_group_invite', array(
				'id' => 'invite_parent_to_group',
				'class' => 'elgg-form-alt mtm',
			), array(
				'entity' => $group,
			));
		$content .= '<br />';
		$content .= '<br />';
	}
	
	$content .= elgg_view_form('groups/invite', array(
			'id' => 'invite_to_group',
			'class' => 'elgg-form-alt mtm',
		), array(
			'entity' => $group,
		));
$content .= '</div>';

$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

