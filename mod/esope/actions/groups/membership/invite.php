<?php
/**
 * Invite users to join a group
 *
 * @package ElggGroups
 */

$logged_in_user = elgg_get_logged_in_user_entity();

$user_guids = get_input('user_guid');
// Note : use alternate input name, as the userpicker method only accepts 'members[]' (if view + JS not rewritten)
if (empty($user_guids)) $user_guids = get_input('members');
if (!is_array($user_guids)) {
	$user_guids = array($user_guids);
}
$group_guid = get_input('group_guid');
$group = get_entity($group_guid);

$allowregister = elgg_get_plugin_setting('allowregister', 'esope');
if ($allowregister == 'yes') { $group_register = get_input('group_register', false); }

if (count($user_guids) > 0 && elgg_instanceof($group, 'group') && $group->canEdit()) {
	$ia = elgg_set_ignore_access(true);
	foreach ($user_guids as $guid) {
		$user = get_user($guid);
		if (!$user) {
			continue;
		}
		
		// On permet de forcer l'inscription si demandé
		if (($allowregister == 'yes') && ($group_register == 'yes')) {
			if (!$group->isMember($user)) {
				if (groups_join_group($group, $user)) {
					$subject = elgg_echo('groups:welcome:subject', array($group->name), $user->language);
					$body = elgg_echo('groups:welcome:body', array($user->name, $group->name, $group->getURL()), $user->language);
					$params = [
						'action' => 'add_membership',
						'object' => $group,
					];
					// Send welcome notification to user
					notify_user($user->getGUID(), $group->owner_guid, $subject, $body, $params);
					system_message(elgg_echo("groups:addedtogroup"));
				} else {
					register_error(elgg_echo("groups:error:addedtogroup", array($user->name)));
				}
			} else register_error(elgg_echo("groups:add:alreadymember", array($user->name)));
			
		} else {
			if (check_entity_relationship($group->guid, 'invited', $user->guid)) {
				register_error(elgg_echo("groups:useralreadyinvited"));
				continue;
			}

			if (check_entity_relationship($user->guid, 'member', $group->guid)) {
				// @todo add error message
				register_error($user->name . ' - ' . elgg_echo("groups:add:alreadymember", array($user->name)));
				continue;
			}
			
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
			$result = notify_user($user->getGUID(), $group->owner_guid, $subject, $body, NULL);
			if ($result) {
				system_message(elgg_echo("groups:userinvited"));
			} else {
				register_error(elgg_echo("groups:usernotinvited"));
			}
			
		}
		
	}
	elgg_set_ignore_access($ia);
}

forward(REFERER);

