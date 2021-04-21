<?php
/**
 * My groups + pending invites
 */

// Mes groupes
elgg_push_context('widgets');
$mygroups_ents = elgg_get_entities([
	'type' => 'group', 
	'relationship' => 'member',
	'relationship_guid' => elgg_get_logged_in_user_guid(),
	'limit' => false,
	'pagination' => false,
	'no_results' => elgg_echo('groups:none'), 
	'full_view' => false,
	'list_type' => 'gallery',
	'list_class' => "elgg-gallery flex-grid", 
	]);
$mygroups .= '<ul class="elgg-gallery">';
$user_groups_guids = []; // for groups guid list
foreach($mygroups_ents as $mygroup_ent) {
	$user_groups_guids[] = $mygroup_ent->guid;
	$mygroups .= elgg_format_element('li', 
		[
			'class' => 'elgg-item groups-profile-icon',
			'id' => "elgg-group-{$mygroup_ent->guid}",
		], 
		elgg_view_entity_icon($mygroup_ent, 'large', [
			//'href' => '',
			'width' => '100',
			'height' => '100',
		])
	);
}
$mygroups .= '</ul>';
elgg_pop_context();
if (count($user_groups_guids) > 0) { $user_groups_guids_list = implode(',', $user_groups_guids); }


// Groups invites
$invitations = elgg_list_relationships([
	'relationship' => 'invited',
	'relationship_guid' => $group->guid,
	'no_results' => false,
]);

echo $mygroups . $invitations;

