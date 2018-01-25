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
$content .= '<div class="group-profile-main" id="group-invites">';
	
	if ($group->guid != $main_group->guid) {
		$content .= '<blockquote class="warning">' . elgg_echo('theme_inria:workspace:invites:warning') . '</blockquote>';
		//system_message(elgg_echo('theme_inria:workspace:invites:warning'));
	}
	
	// Add tabs for the different invite methods
	$group_invite_tab = get_input('group_invite_tab');
	if (!in_array($group_invite_tab, ['main', 'search', 'email', 'parent_group'])) { $group_invite_tab = 'main'; }
	$content .= '<ul class="elgg-tabs">';
	
		//if (current_page_url() == elgg_get_site_url() . 'groups/invite/' . $group->guid) {
		if ($group_invite_tab == 'main') { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
		$content .= '<a href="#invite_to_group">' . elgg_echo('esope:groupinvite:standard:tab') . '</a></li>';
	
		if ($group->guid != $main_group->guid) {
			if ($group_invite_tab == 'parent_group') { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
			$content .= '<a href="#invite_parent_to_group">' . elgg_echo('theme_inria:groupinvite:parent:tab') . '</a></li>';
		}
	
		//if (current_page_url() == elgg_get_site_url() . 'groups/invite/' . $group->guid . '/search') {
		if ($group_invite_tab == 'search') { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
		$content .= '<a href="#esope-search-form-invite-groups">' . elgg_echo('esope:groupinvite:search:tab') . '</a></li>';
	
		//if (current_page_url() == elgg_get_site_url() . 'groups/invite/' . $group->guid . '/email') {
		if ($group_invite_tab == 'email') { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
		$content .= '<a href="#esope-form-email-invite-groups">' . elgg_echo('theme_inria:groupinvite:email:tab') . '</a></li>';
	
	$content .= '</ul>';
	
	// Main form
	$class = 'elgg-form-alt mtm';
	//if (current_page_url() != elgg_get_site_url() . 'groups/invite/' . $group->guid) { $class .= ' hidden'; }
	if ($group_invite_tab != 'main') { $class .= ' hidden'; }
	$content .= elgg_view_form('groups/invite', array(
			'id' => 'invite_to_group',
			'class' => $class,
		), array(
			'entity' => $group,
		));
	
	// Parent group form
	if ($group->guid != $main_group->guid) {
		$content .= elgg_view_form('groups/parent_group_invite', array(
				'id' => 'invite_parent_to_group',
				'class' => 'elgg-form-alt mtm hidden',
			), array(
				'entity' => $group,
			));
	}
	
	
$content .= '</div>';

$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

