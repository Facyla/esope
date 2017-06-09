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
	
	// Workspaces tabs
	$max_title = 30;
	$max_title_more = 50;
	$more_tabs_threshold = 1; // Displays if > 3 (main workspace + index 0 + index 1)
	$all_subgroups_guids = AU\SubGroups\get_all_children_guids($main_group);
	$add_more_tab = (sizeof($all_subgroups_guids) >= $more_tabs_threshold);
	$workspaces_tabs = '';
	$workspaces_tabs .= '<div class="group-workspace-tabs"><ul class="elgg-tabs elgg-htabs">';
		
		// Main workspace
		if ($group->guid == $main_group->guid) { $workspaces_tabs .= '<li class="elgg-state-selected">'; } else { $workspaces_tabs .= '<li>'; }
		$workspaces_tabs .= '<a href="' . $main_group->getURL() . '" title="' . elgg_echo('theme_inria:workspace:title', array($main_group->name)) . '">' . elgg_get_excerpt($main_group->name, $max_title) . '</a></li>';
		// Onglets des sous-groupes
		// Note : on prend tous les sous-groupes qq soit le niveau - mais on ne pourra créer de nouveaux sous-groupes qu'au 1er niveau
		// Espaces de travail : si > 3 onglets, on en affiche 2 et le reste en sous-menu + limitation longueur du titre
		$more_tabs = '';
		$more_selected = false;
		if ($all_subgroups_guids) {
			foreach($all_subgroups_guids as $k => $guid) {
				$ent = get_entity($guid);
				$workspace_url = $url . 'groups/workspace/' . $ent->guid;
				$title_excerpt = elgg_get_excerpt($ent->name, $max_title);
				$tab_class = '';
				if ($ent->guid == $group->guid) { $tab_class .= "elgg-state-selected"; $more_selected = true; }
				if ($add_more_tab && ($k >= $more_tabs_threshold)) {
					$title_excerpt = elgg_get_excerpt($ent->name, $max_title_more);
					$more_tabs .= '<li class="' . $tab_class . '"><a href="' . $ent->getURL() . '" title="' . elgg_echo('theme_inria:workspace:title', array($ent->name)) . '">' . $title_excerpt . '</a></li>';
				} else {
					$workspaces_tabs .= '<li class="' . $tab_class . '"><a href="' . $ent->getURL() . '" title="' . elgg_echo('theme_inria:workspace:title', array($ent->name)) . '">' . $title_excerpt . '</a></li>';
				}
				
			}
		}
		if ($add_more_tab) {
			if ($more_selected) {
				$workspaces_tabs .= '<li class="tab tab-more active">';
			} else {
				$workspaces_tabs .= '<li class="tab tab-more">';
			}
			$workspaces_tabs .= '<a href="javascript:void(0);" onClick="javascript:$(this).parent().toggleClass(\'elgg-state-selected\'); $(this).parent().find(\'.tab-more-content\').toggleClass(\'hidden\')">' . elgg_echo('theme_inria:workspaces:more', array((sizeof($all_subgroups_guids) - $more_tabs_threshold))) . '</a>
					<ul class="tab-more-content hidden">' . $more_tabs . '</ul>
			</li>';
		}
		
	$workspaces_tabs .= '</ul></div>';
	
	
	
	
	// Compose content
	$content .= $workspaces_tabs;
	
	$content .= '<div class="group-profile-main">';
		
		$content .= elgg_view('theme_inria/groups/profile_info', array('group' => $group));
		
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
				$content .= elgg_view('groups/membershiprequests', array('requests' => $requests));
				$content .= '<p>' . 'XXX XXX XXX' . '</p>';
			$content .= '</div>';
		}
	}
	*/
	
	
	$content .= $workspaces_tabs;
	
	// Activité (sociale)
	$content .= '<div class="group-profile-main">';
		
		$content .= elgg_view('theme_inria/groups/profile_activity', array('group' => $group));
		
	$content .= '</div>';
	
	
	
	// Config
	$sidebar .= elgg_view('theme_inria/groups/sidebar', $vars);
	
	
	// Membres : total et en ligne
	$sidebar_alt .= '<h3>' . elgg_echo('members') . '</h3>';
	$sidebar_alt .= '<div class="group-members-count">' . theme_inria_get_group_active_members($group, array('count' => true)) . '</div>';
	//$sidebar_alt .= '<h3>' . elgg_echo('members:online') . '</h3>';
	$sidebar_alt .= elgg_view('groups/sidebar/online_groupmembers', array('entity' => $group));
	
	
}





$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'sidebar-alt' => $sidebar_alt,
	'title' => $group->name,
);
$body = elgg_view_layout('iris_group', $params);

echo elgg_view_page($group->name, $body);

