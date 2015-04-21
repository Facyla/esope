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
if (!is_array($user_guids)) { $user_guids = array($user_guids); }
$group_guid = get_input('group_guid');
$group = get_entity($group_guid);

$allowregister = elgg_get_plugin_setting('allowregister', 'adf_public_platform');
if ($allowregister == 'yes') { $group_register = get_input('group_register', false); }

if (count($user_guids) > 0 && elgg_instanceof($group, 'group') && $group->canEdit()) {
	$ia = elgg_set_ignore_access(true);
	foreach ($user_guids as $guid) {
		$user = get_user($guid);
		if (!$user) { continue; }
		
		// On permet de forcer l'inscription si demandé
		if (($allowregister == 'yes') && ($group_register == 'yes')) {
			if (!$group->isMember($user)) {
				if ($group->join($user)) system_message(elgg_echo("groups:join:success"));
				else register_error(elgg_echo("groups:join:error"));
			} else register_error(elgg_echo("groups:alreadymember"));
			
		} else {
			if (check_entity_relationship($group->guid, 'invited', $user->guid)) {
				register_error(elgg_echo("groups:useralreadyinvited"));
				continue;
			}

			if (check_entity_relationship($user->guid, 'member', $group->guid)) {
				// @todo add error message
				continue;
			}
			
			// Create relationship
			add_entity_relationship($group->guid, 'invited', $user->guid);

			// Send notification
			$url = elgg_normalize_url("groups/invitations/$user->username");
			$result = notify_user($user->getGUID(), $group->owner_guid,
					elgg_echo('groups:invite:subject', array($user->name, $group->name)),
					elgg_echo('groups:invite:body', array(
						$user->name,
						$logged_in_user->name,
						$group->name,
						$url,
					)),
					NULL);
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

