<?php
/**
 * Elgg group operators adding action
 *
 * @package ElggGroupOperators
 */

$group = get_entity(get_input('mygroup'));
$user = get_entity(get_input('who'));

$success = false;
if (elgg_instanceof($group, 'group') && elgg_instanceof($user, 'user') && $group->canEdit()) {
	if ($group->isMember($user) && !check_entity_relationship($user->guid, 'operator', $group->guid)) {
		add_entity_relationship($user->guid, 'operator', $group->guid);
		system_message(elgg_echo('group_operators:added', array($user->name, $group->name)));
	} else {
		register_error(elgg_echo('group_operators:add:error', array($user->name, $group->name)));
	}
} else {
	register_error(elgg_echo('groups:permissions:error'));
}

forward(REFERER);

