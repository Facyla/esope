<?php
$group = elgg_extract('group', $vars);
$main_group = elgg_extract('main_group', $vars);

$content = '';


// Présentation
if (!empty($main_group->description)) {
	$content .= '<div class="group-workspace-module group-workspace-about">';
		$content .= '<h3>' . elgg_echo('theme_inria:groups:about') . '</h3>';
		$content .= '<p>' . $main_group->description . '</p>';
	$content .= '</div>';
}

// Show only for workspaces ?
if ($group->guid != $main_group->guid) {
	$content .= elgg_view('theme_inria/groups/workspaces_select', array('main_group' => $main_group, 'group' => $group, 'link_type' => 'home'));
}

// Owner and operators
$owner = $group->getOwnerEntity();
$max_operators = 2;
$operators_opt = array('types'=>'user', 'limit'=> $max_operators, 'relationship_guid'=> $group->guid, 'relationship'=>'operator', 'inverse_relationship'=>true, 'wheres' => "e.guid != {$owner->guid}");
$operators_count = elgg_get_entities_from_relationship($operators_opt + array('count' => true));
$operators = elgg_get_entities_from_relationship($operators_opt);

// Lien admin et responsables du groupe
if ($group->canEdit()) {
	//$manage_group_admins = '<a href="' . elgg_get_site_url() . 'group_operators/manage/' . $group->guid . '" class="iris-manage float-alt">' . elgg_echo('theme_inria:manage') . '</a>';
	$manage_group_admins = '<a href="' . elgg_get_site_url() . 'groups/members/' . $group->guid . '" class="iris-manage">' . elgg_echo('theme_inria:manage') . '</a>';
}

$profile_type = esope_get_user_profile_type($owner);
if (empty($profile_type)) { $profile_type = 'external'; }
$content .= '<div class="group-workspace-module group-workspace-admins">';
	$content .= '<div class="group-admins">
			<div class="group-admin">
				<h3>' . elgg_echo('groups:owner') . '</h3>
				<a href="' . $owner->getURL() . '" class="elgg-avatar elgg-avatar-medium profile-type-' . $profile_type . '">
					<img src="' . $owner->getIconURL(array('size' => 'medium')) . '" /><br />
					' . $owner->name . '
				</a>
			</div>
		</div>';
	$content .= '<div class="group-operators">' . $manage_group_admins;
		if ($operators_count > 0) {
			$content .= '<h3>' . elgg_echo('theme_inria:groups:operators', array($operators_count)) . '</h3>';
			if ($operators) {
				foreach($operators as $ent) {
					if ($ent->guid == $owner->guid) { continue; }
					$profile_type = esope_get_user_profile_type($ent);
					if (empty($profile_type)) { $profile_type = 'external'; }
					$content .= '<div class="group-operator">
							<a href="' . $ent->getURL() . '" class="elgg-avatar elgg-avatar-medium profile-type-' . $profile_type . '">
								<img src="' . $ent->getIconURL(array('size' => 'medium')) . '" /><br />
								' . $ent->name . '
							</a>
						</div>';
				}
			}
			if (($max_operators > 0) && ($operators_count > $max_operators)) {
				$operators_more_count = $operators_count - $max_operators;
				$content .= '<div class="group-operator more">' . elgg_view('output/url', array(
					//'href' => 'group_operators/manage/' . $group->guid,
					'href' => 'groups/members/' . $group->guid,
					'text' => "+".$operators_more_count,
					'is_trusted' => true, 'class' => 'operators-more',
				)) . '</div>';
			}
		}
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';



// Members
if (elgg_group_gatekeeper(false)) {
	$max_members = 25;
	$all_members = $group->getMembers(array('count' => true));
	$members_count = $group->getMembers(array('count' => true, 'wheres' => array(theme_inria_active_members_where_clause())));
	$members = $group->getMembers(array('wheres' => array(theme_inria_active_members_where_clause())));
	$members_string = elgg_echo('theme_inria:groups:members', array($all_members));
	if ($all_members != $members_count) {
		if ($members_count > 1) {
			$members_string = elgg_echo('theme_inria:groups:entity_menu', array($all_members, $members_count));
		} else {
			if ($all_members > 1) {
				$members_string = elgg_echo('theme_inria:groups:entity_menu:singular', array($all_members, $members_count));
			} else {
				$members_string = elgg_echo('theme_inria:groups:entity_menu:none', array($all_members, $members_count));
			}
		}
	}

	$content .= '<div class="group-workspace-module group-workspace-members">';
		if ($group->canEdit()) {
			$content .= '<a href="' . elgg_get_site_url() . 'groups/members/' . $group->guid . '" class="iris-manage">' . elgg_echo('theme_inria:manage') . '</a>';
		} else {
			$content .= '<a href="' . elgg_get_site_url() . 'groups/members/' . $group->guid . '" class="iris-manage">' . elgg_echo('theme_inria:view') . '</a>';
		}
		$content .= '<h3>' . $members_string . '</h3>';
		foreach($members as $ent) {
			$profile_type = esope_get_user_profile_type($ent);
			if (empty($profile_type)) { $profile_type = 'external'; }
			$content .= '<a href="' . $ent->getURL() . '" class="elgg-avatar profile-type-' . $profile_type . '"><img src="' . $ent->getIconURL(array('size' => 'small')) . '" title="' . $ent->name . '" /></a>';
		}
		if ($members_count > $max_members) {
			$members_more_count = $members_count - $max_members;
			$content .= elgg_view('output/url', array(
				'href' => 'groups/members/' . $group->guid,
				'text' => "+".$members_more_count,
				'is_trusted' => true, 'class' => 'members-more',
			));
		}
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
}

/*
$content .= '<div class="group-workspace-module group-workspace-invites">';
	$content .= '<h3>Invitations non acceptées (X)</h3>';
	$content .= elgg_view('groups/invitationrequests'); // pas cette vue
$content .= '</div>';
*/


// Membership requests
if ($group->canEdit()) {
	$requests = elgg_get_entities_from_relationship(array('type' => 'user', 'relationship' => 'membership_request', 'relationship_guid' => $group->guid, 'inverse_relationship' => true, 'limit' => false));
	$requests_count = sizeof($requests);
	if ($requests_count > 0) {
		$content .= '<div class="group-workspace-module group-workspace-requests">';
			$content .= '<h3>' . elgg_echo('theme_inria:groups:requests', array($requests_count)) . '</h3>';
			$content .= elgg_view('groups/membershiprequests', array('requests' => $requests, 'entity' => $group));
		$content .= '</div>';
	}
}



// Membership action (for self)
$actions_content = '';
// group members
if ($group->isMember($own)) {
	if ($group->getOwnerGUID() != $own->guid) {
		// leave
		$actions_content .= elgg_view('output/url', array(
				'href' => $url . "action/groups/leave?group_guid={$group->guid}",
				'text' => '<i class="fa fa-sign-out"></i>&nbsp;' . elgg_echo('groups:leave'),
				'class' => "elgg-button elgg-button-delete",
				'confirm' => elgg_echo('groups:leave:confirm'),
				'is_action' => true,
			));
	}
} elseif (elgg_is_logged_in()) {
	// join - admins can always join.
	if ($group->isPublicMembership() || $group->canEdit()) {
		$actions_content .= elgg_view('output/url', array(
				'href' => $url . "action/groups/join?group_guid={$group->guid}",
				'text' => '<i class="fa fa-sign-in"></i>&nbsp;' . elgg_echo('groups:join'),
				'class' => "elgg-button elgg-button-action",
				'is_action' => true,
			));
	} else {
		// request membership
		$actions_content .= elgg_view('output/url', array(
				'href' => $url . "action/groups/join?group_guid={$group->guid}",
				'text' => '<i class="fa fa-sign-in"></i>&nbsp;' . elgg_echo('groups:joinrequest'),
				'class' => "elgg-button elgg-button-action",
				'is_action' => true,
			));
	}
}
if (!empty($actions_content)) {
	$content .= '<div class="group-workspace-module group-workspace-membership"><h3>' . elgg_echo('theme_inria:ownmembership') . '</h3>' . $actions_content . '</div>';
}



echo '<div class="group-workspace-info" id="group-workspace-info-' . $group->guid . '">' . $content . '</div>';

