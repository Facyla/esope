<?php
/**
 * Elgg add action
 *
 * @package Elgg
 * @subpackage Core
 */

elgg_make_sticky_form('useradd');

// Get variables
$username = get_input('username');
$password = get_input('password');
$email = get_input('email');
$name = get_input('name');
$reason = get_input('name');

// Invited people should be friend with inviter...
$friend = elgg_get_logged_in_user_entity();
$friend_guid = elgg_get_logged_in_user_guid();


$use_default_access = get_input('use_default_access', false);
if (is_array($use_default_access)) {
	$use_default_access = $use_default_access[0];	
}

$custom_profile_fields = get_input("custom_profile_fields"); 

// For now, just try and register the user
try {
	// No duplicate emails !
	$guid = register_user($username, $password, $name, $email, false);

	if ((trim($password) != "") && ($guid)) {
		$new_user = get_entity($guid);
		
		elgg_clear_sticky_form('useradd');

		//$new_user->admin_created = TRUE;
		$new_user->membertype = 'external';
		$new_user->memberstatus = 'active'; // requires validation !
		$new_user->firstmemberreason = 'created_by_inria_member';
		esope_set_user_profile_type($new_user, 'external');
		
		// Remember account creation + make mutual friends
		$new_user->created_by_guid = $friend_guid;
		$new_user->addFriend($friend_guid);
		$friend->addFriend($guid);
		
		$subject = elgg_echo('theme_inria:useradd:subject');
		$body = elgg_echo('theme_inria:useradd:body', array(
			$name,
			elgg_get_site_entity()->name,
			$friend->name,
			elgg_get_site_entity()->url,
			$username,
			$password,
		));
		notify_user($new_user->guid, elgg_get_site_entity()->guid, $subject, $body);
		
		
		// We can notify up to 3 admins so new members can be moderated
		$subject = elgg_echo('theme_inria:useradd:admin:subject');
		$body = elgg_echo('theme_inria:useradd:admin:body', array(
			$name,
			$email,
			$friend->name . ' (' . $friend_guid . ')',
			$reason,
			$new_user->getURL(),
		));
		$notified[] = elgg_get_plugin_setting('useradd_notify1', 'theme_inria');
		$notified[] = elgg_get_plugin_setting('useradd_notify2', 'theme_inria');
		$notified[] = elgg_get_plugin_setting('useradd_notify3', 'theme_inria');
		foreach ($notified as $username) {
			$notify_user = get_user_by_username($username);
			if ($notify_user) {
				notify_user($notify_user->guid, elgg_get_site_entity()->guid, $subject, $body);
			}
		}
		
		system_message(elgg_echo("adduser:ok", array(elgg_get_site_entity()->name)));
	} else {
		register_error(elgg_echo("adduser:bad"));
	}
} catch (RegistrationException $r) {
	register_error($r->getMessage());
}

forward(REFERER);

