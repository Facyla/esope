<?php
$group = elgg_extract('group', $vars);

$content = '';


// Owner and operators
$owner = $group->getOwnerEntity();
$operators = elgg_get_entities_from_relationship(array('types'=>'user', 'limit'=>2, 'relationship_guid'=>$group->guid, 'relationship'=>'operator', 'inverse_relationship'=>true));
$operators_count = elgg_get_entities_from_relationship(array('types'=>'user', 'limit'=>0, 'relationship_guid'=>$group->guid, 'relationship'=>'operator', 'inverse_relationship'=>true, 'count' => true));
unset($operators[$owner->guid]);

$max_members = 25;
$members_count = $group->getMembers(array('count' => true));
//$members = $group->getMembers();


// Présentation
if (!empty($group->description)) {
	$content .= '<div class="group-workspace-module group-workspace-about">';
		$content .= '<h3>' . elgg_echo('theme_inria:groups:about') . '</h3>';
		$content .= '<p>' . $group->description . '</p>';
	$content .= '</div>';
}

// Admins
$content .= '<div class="group-workspace-module group-workspace-admins">';
	$content .= '<div class="group-admin"><h3>' . elgg_echo('groups:owner') . '</h3>' . elgg_view_entity_icon($owner, 'medium') . '<br />' . $owner->name . '</div>';
	if (sizeof($operators) > 0) {
		$content .= '<div class="group-operators"><h3>' . elgg_echo('theme_inria:groups:operators', array($operators_count)) . '</h3>';
			foreach($operators as $ent) {
				$content .= '<div class="group-operator">' . elgg_view_entity_icon($ent, 'medium') . '<br />' . $ent->name . '</div>';
			}
		$content .= '</div>';
	}
	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

$content .= '<div class="group-workspace-module group-workspace-members">';
	$content .= '<h3>' . elgg_echo('theme_inria:groups:members', array($members_count)) . '</h3>';
	$content .= elgg_list_entities_from_relationship(array(
		'type' => 'user', 'relationship' => 'member', 'relationship_guid' => $group->guid, 'inverse_relationship' => true,
		'limit' => $max_members, 'pagination' => false, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users',
	));
	if ($members_count > $max_members) {
		$members_more_count = $members_count - $max_members;
		$members_link = elgg_view('output/url', array(
			'href' => 'groups/members/' . $group->guid,
			'text' => $members_more_count, //elgg_echo('groups:members:more'),
			'is_trusted' => true,
		));
		$content .= $members_link;
	}
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

