<?php
/**
 * Elgg add action
 *
 * @package Elgg
 * @subpackage Core
 */

/* External members invitation rules
- any Inria member may invite <=> create account for external member
- email validation required
- no admin validation required
- optional invited groups
*/

elgg_make_sticky_form('useradd');

// Get variables
$emails = get_input('email');
if (!is_array($emails)) { $emails = array($emails); }
//$username = get_input('username');
//$password = get_input('password');
$name = get_input('name');
$organisation = get_input('organisation');
$organisation = string_to_tag_array($organisation);
$briefdescription = get_input('briefdescription');
$reason = get_input('reason');
$message = get_input('message');
$group_guid = get_input('group_guid');
if (!is_array($group_guid)) { $group_guid = array($group_guid); }

$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);
foreach ($emails as $email) {
	
	if (!is_email_address($email)) {
		register_error(elgg_echo("Invalid email : {$email}"));
		//forward(REFERER);
		continue;
	}

	if (!elgg_trigger_plugin_hook('registeruser:validate:email', 'all', array('email' => $email), true)) {
		register_error(elgg_echo("Invalid email (hook) : {$email}"));
		//forward(REFERER);
		continue;
	}


	$already_registered = get_user_by_email($email);
	if (sizeof($already_registered) > 1) {
		register_error(elgg_echo("Users already exist with this email : {$email}"));
		//forward(REFERER);
		continue;
	} else if (sizeof($already_registered) < 1) {
		// we can register without problem
		$already_registered = false;
	} else {
		// User is already registered
		$already_registered = $already_registered[0];
		if (elgg_instanceof($already_registered, 'user')) {
			register_error('User already exists : <a href="' . $already_registered->getURL() . '">' . $already_registered->name . '</a>');
		}
	}


	// Account creation
	if (!$already_registered) {
		$password = generate_random_cleartext_password();
		// We can safely add the 'ext_' prefix here to avoid duplicates
		$real_username = profile_manager_generate_username_from_email('ext_'.$email);
		/*
		if (strpos($username, 'ext_') === 0) {
			$real_username = $username;
		} else {
			$real_username = 'ext_' . $username;
		}
		*/
	
		$real_name = trim(strip_tags($name));
		if (empty($real_name)) { $real_name = substr($real_username, 4); }
	
		// For now, just try and register the user - No duplicate emails !
		$guid = register_user($real_username, $password, $real_name, $email, false);
		if (!$guid) {
			register_error($email . ' : ' . elgg_echo("adduser:bad"));
			//forward(REFERER);
			continue;
		}
	
		// Handle new account meta and validation rules
		$user = get_entity($guid);

		$site = elgg_get_site_entity();

		// Invited people should be friend with inviter...
		$inviter = elgg_get_logged_in_user_entity();
		$inviter_guid = elgg_get_logged_in_user_guid();

		$admin_validation = elgg_get_plugin_setting('admin_validation', 'theme_inria');
		if (($admin_validation == 'yes') && elgg_is_active_plugin('uservalidationbyadmin')) { $admin_validation = true; } else { $admin_validation = false; }

		$notified = array(); $admins = array();
		$notified[] = elgg_get_plugin_setting('useradd_notify1', 'theme_inria');
		$notified[] = elgg_get_plugin_setting('useradd_notify2', 'theme_inria');
		$notified[] = elgg_get_plugin_setting('useradd_notify3', 'theme_inria');
		foreach ($notified as $admin_username) {
			$notify_user = get_user_by_username($admin_username);
			if ($notify_user) { $admins[] = $notify_user; }
		}
	
		//$user->admin_created = TRUE;
// @TODO Handle Inria emails ?  useless, as it will be handled on next LDAP sync ?
		$user->membertype = 'external';
		$user->memberstatus = 'active';
		$user->firstmemberreason = 'created_by_inria_member';
		$user->membercreatedby = $inviter_guid;
		$user->registermemberreason = "Account registered by {$inviter->name} ($inviter_guid) with motive : $reason";
		// Initiate this because account would be disabled if not set at creation
		$user->last_action = time();
		esope_set_user_profile_type($user, 'external');
		
		// Add some fields values
		$user->organisation = $organisation;
		$user->briefdescription = $briefdescription;

		// Remember account creation + make mutual friends
		$user->created_by_guid = $inviter_guid;
		$user->addFriend($inviter_guid);
		$inviter->addFriend($guid);

		// elgg_set_user_validation_status

		// Add disabled notice to notification messages
		if ($admin_validation) {
			$disable_notice = '<p>' . elgg_echo('theme_inria:useradd:disabled:adminvalidation') . '</p>';
		}

		// USER NOTIFICATION
		$user_subject = elgg_echo('theme_inria:useradd:subject', array($site->name, $inviter->name));
		$user_body = elgg_echo('theme_inria:useradd:body', array(
			$name,
			$inviter->name,
			$site->name,
			$site->url,
			$message,
			$real_username,
			$email,
			$password,
		));
		if ($disable_notice) { $user_body .= $disable_notice; }
		notify_user($user->guid, $site->guid, $user_subject, $user_body);

		// ADMIN VALIDATION
		if ($admin_validation) {
			// Now all is done : disable new user account if required by plugin setting
			// Use the same code as in uservalidationbyadmin uservalidationbyadmin_register_user_hook hook
			
			elgg_push_context('uservalidationbyadmin_new_user');
			
			// this user needs validation
			$user->admin_validated = false;
			
			// set user as unvalidated
			//elgg_set_user_validation_status($user->guid, FALSE, 'theme_inria');
			
			// Store registration IP address (for further guessed geolocation detection)
			$user->register_ip = $_SERVER['REMOTE_ADDR'];
	
			// check who to notify
			$notify_admins = uservalidationbyadmin_get_admin_notification_setting();
			if ($notify_admins == "direct") {
				uservalidationbyadmin_notify_admins();
			}
	
			// check if we need to disable the user
			if ($user->isEnabled()) {
				$user->disable('uservalidationbyadmin_new_user', FALSE);
			}
	
			// restore context
			elgg_pop_context();
			
			/* Note : admin emails are sent after that
			//uservalidationbyadmin_request_validation($user->guid); // was used in previous plugin version
			// notify the admins about pending approvals
			uservalidationbyadmin_notify_admins();
			elgg_pop_context();
			*/
		}

		// ADMIN NOTIFICATION : always notify, wether validation is needed or not
		// We can notify up to 3 admins so new members can be moderated
		if ($admin_validation) {
			$admin_subject = elgg_echo('theme_inria:useradd:admin:subject');
		} else {
			$admin_subject = elgg_echo('theme_inria:useradd:admin:subject:confirm');
		}
		$admin_body = elgg_echo('theme_inria:useradd:admin:body', array(
			$name,
			$email,
			$inviter->name . ' (' . $inviter_guid . ')',
			$reason,
			$user->getURL(),
		));
		if ($disable_notice) { $admin_body .= $disable_notice; }
		foreach ($admins as $notify_user) {
			notify_user($notify_user->guid, $site->guid, $admin_subject, $admin_body);
		}
	
		system_message(elgg_echo("adduser:ok", array($site->name)));
		elgg_clear_sticky_form('useradd');
	}


	// Groups invitation(s) - also for already registered users
	// Note : invite = bypass for closed group (user must canEdit())
	// join : idem
	// request = "invite" by a regular member
	// @TODO add invite message + notification to group admin
	if ($group_guid) {
		foreach($group_guid as $guid) {
			$group = get_entity($guid);
			if (elgg_instanceof($group, 'group')) {
				if (!$group->isMember($user)) {
					if ($group->canEdit() || elgg_is_admin_logged_in() || $group->isPublicMembership()) {
						// Join group - handle subgroups
						if (elgg_is_active_plugin('au_subgroups')) {
							if (elgg_is_admin_logged_in()) {
								\AU\SubGroups\join_parents_recursive($group, $user);
							} else {
								$parent = \AU\SubGroups\get_parent_group($group);
								if ($parent) {
									if ($parent->canEdit() || elgg_is_admin_logged_in() || $parent->isPublicMembership()) {
										// Join parent
										if ($parent->join($user)) { system_message("Group {$parent->name} joined."); }
										// Join group
										if ($group->join($user)) { system_message("Workspace {$group->name} joined."); }
										$group->join($user);
									} else {
										add_entity_relationship($user->guid, 'membership_request', $parent->guid);
										add_entity_relationship($user->guid, 'membership_request', $group->guid);
									}
								} else {
									if ($group->join($user)) { system_message("Group {$group->name} joined."); }
								}
							}
						} else {
							if ($group->join($user)) { system_message("Group {$group->name} joined."); }
						}
					
					} else if ($group->isMember()) {
						// Invite with no admin rights
						if (add_entity_relationship($user->guid, 'membership_request', $group->guid)) {
							system_message("Group membership for {$group->name}.");
						} else {
							system_message("Membership request already existing for {$group->name}.");
						}
				
					} else {
						// Invite with no admin rights
						if (add_entity_relationship($user->guid, 'membership_request', $group->guid)) {
							system_message("Group membership for {$group->name}.");
						} else {
							system_message("Membership request already existing for {$group->name}.");
						}
					}
				
				} else {
					system_message("Already member of {$group->name}.");
				}
			}
		}
	}
}
access_show_hidden_entities($hidden_entities);


forward(REFERER);

