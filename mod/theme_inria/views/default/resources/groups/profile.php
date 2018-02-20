<?php

// Determine current workspace (page_owner, potentially a subgroup)
$guid = elgg_extract('group_guid', $vars);
$group = get_entity($guid);
if (!elgg_instanceof($group, 'group')) {
	register_error(elgg_echo('groups:error:invalid'));
	forward();
}
elgg_set_page_owner_guid($guid);
// Determine main group
$main_group = theme_inria_get_main_group($group);

// turn this into a core function
global $autofeed;
$autofeed = true;
$url = elgg_get_site_url();

// If workspace => forward to workspace home
if ($group->guid != $main_group->guid) {
	forward($url . 'groups/workspace/' . $group->guid);
}

elgg_push_context('group_profile');
elgg_entity_gatekeeper($guid, 'group');
elgg_push_breadcrumb($group->name);

groups_register_profile_buttons($group);


$content = '';
$sidebar = '';
$sidebar_alt = '';


// Workspaces tabs
//$workspaces_tabs = elgg_view('theme_inria/groups/workspaces_tabs', array('main_group' => $main_group, 'group' => $group, 'link_type' => 'home'));
$workspaces_tabs = '';

// Compose content
$content .= $workspaces_tabs;

$content .= '<div class="group-profile-main">';
	
	$content .= elgg_view('theme_inria/groups/profile_info', array('group' => $group, 'main_group' => $main_group));
	
$content .= '</div>';


// Autres espaces de travail : on va sur l'URL de l'espace de travail correspondant (seul les onglets sont communs)
/*if ($subgroups) {
	foreach($subgroups as $subgroup) {
		$content .= '<div class="group-workspace-X">';
			$content .= '<div class="group-workspace-about">';
			$content .= '<h3>A propos</h3>';
			$content .= '<p>' . $subgroup->description . '</p>';
			$content .= '</div>';
			$content .= '<h3>Propriétaire / Responsables (X)</h3>';
			$content .= '<p>' . 'XXX XXX XXX' . '</p>';
			$content .= '<h3>Tous les membres</h3>';
			$content .= '<p>' . 'XXX XXX XXX' . '</p>';
			//$content .= '<h3>Invitations en attente (X)</h3>';
			//$content .= elgg_view('groups/invitationrequests');
			$content .= '<h3>Demandes d\'adhésion en attente (X)</h3>';
			$requests = elgg_get_entities_from_relationship(array('type' => 'user', 'relationship' => 'membership_request', 'relationship_guid' => $subgroup->guid, 'inverse_relationship' => true));
			$content .= elgg_view('groups/membershiprequests', array('requests' => $requests, 'entity' => $subgroup));
			$content .= '<p>' . 'XXX XXX XXX' . '</p>';
		$content .= '</div>';
	}
}
*/


$content .= $workspaces_tabs;

// Activité (sociale)
if (elgg_group_gatekeeper(false)) {
	$content .= '<div class="group-profile-main">';
	
		$content .= elgg_view('theme_inria/groups/profile_activity', array('group' => $group, 'main_group' => $main_group));
	
	$content .= '</div>';
}



// Config
$sidebar .= elgg_view('theme_inria/groups/sidebar', $vars);


// Membres : total et en ligne
$sidebar_alt .= elgg_view('theme_inria/groups/sidebar_members');






$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'sidebar-alt' => $sidebar_alt,
	'title' => $group->name,
);
$body = elgg_view_layout('iris_group', $params);

echo elgg_view_page($group->name, $body);

