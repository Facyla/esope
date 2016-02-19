<?php

$group_guid = get_input('mygroup');
$user_guid = get_input('who');
$group = get_entity($group_guid);

// Note : do not check for real user entity because we want to be able to remove a deleted user from group admin
// Even if this should not happen if relationships are cleared properly
if (elgg_instanceof($group, 'group') && $group->canEdit()) {
	if (check_entity_relationship($user_guid, 'operator', $group_guid)) {
		remove_entity_relationship($user_guid, 'operator', $group_guid);
	}
	system_message(elgg_echo('group_operators:removed'));
} else {
	register_error(elgg_echo('groups:permissions:error'));
}
forward(REFERER);

