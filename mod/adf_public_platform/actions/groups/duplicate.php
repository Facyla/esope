<?php
/**
 * Elgg groups duplicate action.
 *
 */

// Cette action n'est pas "en service"
return;

// Load configuration
global $CONFIG;


// Get group fields
$duplicate_group_id = get_input('duplicate_group_id');
$groupname = get_input('groupname');
$user = elgg_get_logged_in_user_entity();

$duplicate_group = get_entity($duplicate_group_id);
if (($duplicate_group instanceof ElggGroup) && ($duplicate_group->canEdit()) && !empty($groupname)) {
  $group = new ElggGroup(); // create a new group
	$group->name = $groupname;
	$group->access_id = $duplicate_group->access_id;
  // Set group values
  foreach ($CONFIG->group as $shortname => $valuetype) {
    if ($shortname != 'name') { $group->$shortname = $duplicate_group->$shortname; }
  }
} else {
  register_error("$duplicate_group_id  $groupname");
  register_error(elgg_echo("groups:cantedit"));
  forward(REFERER);
}

// Set group tool options
if (isset($CONFIG->group_tool_options)) {
	foreach ($CONFIG->group_tool_options as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		$group->$group_option_toggle_name = $duplicate_group->$group_option_toggle_name;
	}
}

// Group membership - should these be treated with same constants as access permissions?
$group->membership = $duplicate_group->membership;
$group->save();

// Si la visibilité du groupe est restreinte au groupe lui-même, on fait de même pour le nouveau groupe
// Note : pour une liste spécifique autre que celle du groupe lui-même, on ne change pas (ex. privé => privé)
if ($duplicate_group->access_id == $duplicate_group->group_acl) {
  $group->access_id == $group->group_acl;
  $group->save();
}

// group creator needs to be member of new group
elgg_set_page_owner_guid($group->guid);
$group->join($user);

// Enfin on inscrit les membres dans le nouveau groupe
// Note : cela va générer des notifications d'inscription au groupe : est-ce gênant ?
$members = $duplicate_group->getMembers(999999,0);
foreach ($members as $member) {
  $group->join($member);
}

// river entry created
add_to_river('river/group/create', 'create', $user->guid, $group->guid, $group->access_id);
system_message(elgg_echo("groups:saved"));

forward("groups/edit/{$group->guid}");

