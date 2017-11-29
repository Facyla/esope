<?php
/**
 * Invite parent group users to join a subgroup
 *
 * @package ElggGroups
 */

$logged_in_user = elgg_get_logged_in_user_entity();

$group_guid = get_input('group_guid');
$main_group_guid = get_input('main_group_guid');
$group = get_entity($group_guid);
$main_group = get_entity($main_group_guid);

if (!elgg_instanceof($group, 'group') || !elgg_instanceof($main_group, 'group')) {
	register_error(elgg_echo('theme_inria:workspace:invite_parent_members:invalidgroups'));
	forward(REFERER);
}

if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$group_register = false;
$allowregister = elgg_get_plugin_setting('allowregister', 'esope');
if ($allowregister == 'yes') { $group_register = get_input('group_register', false); }


$ia = elgg_set_ignore_access(true);
$errors = 0;
$parent_group_members = $main_group->getMembers(array('limit' => false));
$parent_group_members_count = $main_group->getMembers(array('count' => true));
foreach ($parent_group_members as $user) {
	if ($group->isMember($user)) { continue; }
	
	// On permet de forcer l'inscription si demandé
	if ($group_register == 'yes') {
		if (groups_join_group($group, $user)) {
			$subject = elgg_echo('groups:welcome:subject', array($group->name), $user->language);
			$body = elgg_echo('groups:welcome:body', array($user->name, $group->name, $group->getURL()), $user->language);
			$params = [
				'action' => 'add_membership',
				'object' => $group,
			];
			// Send welcome notification to user
			notify_user($user->guid, $group->owner_guid, $subject, $body, $params);
		} else {
			$errors++;
			register_error(elgg_echo("groups:error:addedtogroup", array($user->name)));
		}
		
	} else {
		
		// Action already performed
		if (check_entity_relationship($group->guid, 'invited', $user->guid)) { continue; }
		
		// Create relationship
		add_entity_relationship($group->guid, 'invited', $user->guid);

		// Send notification
		$url = elgg_normalize_url("groups/invitations/$user->username");

		$subject = elgg_echo('groups:invite:subject', array(
				$user->name,
				$group->name
			), $user->language);

		$body = elgg_echo('groups:invite:body', array(
				$user->name,
				$logged_in_user->name,
				$group->name,
				$url,
			), $user->language);

		// Send notification
		$result = notify_user($user->guid, $group->owner_guid, $subject, $body, array('object' => $group, 'action' => 'invite'));
		if (!$result) {
			$errors++; // this counts as an error
			register_error(elgg_echo("groups:usernotinvited"));
		}
		
	}
	
}
elgg_set_ignore_access($ia);

if ($errors > 0) {
	if ($group_register == 'yes') {
		register_error(elgg_echo('theme_inria:workspace:invite_parent_members:errors'), array($errors, $parent_group_members_count));
	} else {
		register_error(elgg_echo('theme_inria:workspace:register_parent_members:errors'), array($errors, $parent_group_members_count));
	}
} else {
	if ($group_register == 'yes') {
		system_message(elgg_echo('theme_inria:workspace:register_parent_members:success'));
	} else {
		system_message(elgg_echo('theme_inria:workspace:invite_parent_members:success'));
	}
}

forward(REFERER);

