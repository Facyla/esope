<?php
$group = elgg_extract('group', $vars);

$content = '';


// Owner and operators
$owner = $group->getOwnerEntity();
$max_operators = 2;
$operators_opt = array('types'=>'user', 'limit'=> $max_operators, 'relationship_guid'=> $group->guid, 'relationship'=>'operator', 'inverse_relationship'=>true, 'wheres' => "e.guid != {$owner->guid}");
$operators_count = elgg_get_entities_from_relationship($operators_opt + array('count' => true));
$operators = elgg_get_entities_from_relationship($operators_opt);

// Members
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



// Présentation
if (!empty($group->description)) {
	$content .= '<div class="group-workspace-module group-workspace-about">';
		$content .= '<h3>' . elgg_echo('theme_inria:groups:about') . '</h3>';
		$content .= '<p>' . $group->description . '</p>';
	$content .= '</div>';
}

// Admins
// Lien admin des responsables de groupes
if ($group->canEdit()) {
	$manage_group_admins = '<a href="' . elgg_get_site_url() . 'group_operators/manage/' . $group->guid . '" class="iris-manage float-alt">' . elgg_echo('theme_inria:manage') . '</a>';
}
$content .= '<div class="group-workspace-module group-workspace-admins">';
	$content .= '<div class="group-admin">
			<h3>' . elgg_echo('groups:owner') . '</h3>
			<a href="' . $owner->getURL() . '">
				<img src="' . $owner->getIconURL(array('size' => 'medium')) . '" /><br />
				' . $owner->name . '
			</a>
		</div>';
	$content .= '<div class="group-operators">' . $manage_group_admins;
		if ($operators_count > 0) {
			$content .= '<h3>' . elgg_echo('theme_inria:groups:operators', array($operators_count)) . '</h3>';
			if ($operators) {
				foreach($operators as $ent) {
					$content .= '<div class="group-operator">
							<a href="' . $ent->getURL() . '">
								<img src="' . $ent->getIconURL(array('size' => 'medium')) . '" /><br />
								' . $ent->name . '
							</a>
						</div>';
				}
			}
			if ($operators_count > $max_operators) {
				$operators_more_count = $operators_count - $max_operators;
				$content .= '<div class="group-operator">' . elgg_view('output/url', array(
					'href' => 'group_operators/manage/' . $group->guid,
					'text' => "+".$operators_more_count,
					'is_trusted' => true, 'class' => 'operators-more',
				)) . '</div>';
			}
		}
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

// Members
$content .= '<div class="group-workspace-module group-workspace-members">';
	$content .= '<h3>' . $members_string . '</h3>';
	foreach($members as $ent) {
		$content .= '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIconURL(array('size' => 'small')) . '" title="' . $ent->name . '" /></a>';
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

/*
$content .= '<div class="group-workspace-module group-workspace-invites">';
	$content .= '<h3>Invitations non acceptées (X)</h3>';
	$content .= elgg_view('groups/invitationrequests'); // pas cette vue
$content .= '</div>';
*/

$requests = elgg_get_entities_from_relationship(array('type' => 'user', 'relationship' => 'membership_request', 'relationship_guid' => $group->guid, 'inverse_relationship' => true, 'limit' => false));
$requests_count = sizeof($requests);
if ($requests_count > 0) {
	$content .= '<div class="group-workspace-module group-workspace-requests">';
		$content .= '<h3>' . elgg_echo('theme_inria:groups:requests', array($requests_count)) . '</h3>';
		$content .= elgg_view('groups/membershiprequests', array('requests' => $requests));
	$content .= '</div>';
}


echo '<div class="group-workspace-info" id="group-workspace-info-' . $group->guid . '">' . $content . '</div>';

