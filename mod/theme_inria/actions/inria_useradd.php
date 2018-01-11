<?php
/**
 * Elgg add action
 *
 * @package Elgg
 * @subpackage Core
 */

/* External members invitation rules
- any Inria member may invite <=> create account for external member (and also other Inria members)
- if account is identified as Inria, it is created using LDAP data
- email validation required
- no admin validation required
- optional invited groups
*/



// Debug mode
$debug = false;

// Get plugin config
$admin_validation = elgg_get_plugin_setting('admin_validation', 'theme_inria');
if (($admin_validation == 'yes') && elgg_is_active_plugin('uservalidationbyadmin')) { $admin_validation = true; } else { $admin_validation = false; }
// Notified admins
$notified = array();
$admins = array();
$notified[] = elgg_get_plugin_setting('useradd_notify1', 'theme_inria');
$notified[] = elgg_get_plugin_setting('useradd_notify2', 'theme_inria');
$notified[] = elgg_get_plugin_setting('useradd_notify3', 'theme_inria');
foreach ($notified as $admin_username) {
	$notify_user = get_user_by_username($admin_username);
	if ($notify_user) { $admins[] = $notify_user; }
}
// Other used vars
$site = elgg_get_site_entity();
// Invited people should be friend with inviter...
$inviter = elgg_get_logged_in_user_entity();
$inviter_guid = elgg_get_logged_in_user_guid();

if ($debug) { error_log("Inria user_add action : validation : $admin_validation / notif : " . print_r($notified, true)); }


elgg_make_sticky_form('useradd');

// Get variables
// Personal fields
$emails = get_input('email');
if (!is_array($emails)) { $emails = array($emails); }
//$username = get_input('username');
//$password = get_input('password');
$name = get_input('name');
$organisations = get_input('organisation');
$briefdescription = get_input('briefdescription'); // fonction
// Common fields
$reason = get_input('reason');
$message = get_input('message');
$group_guids = get_input('group_guid');

$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

if ($debug) error_log("  Emails : " . print_r($emails, true)); // debug

// Process each email
foreach ($emails as $k => $email) {
	if ($debug) error_log("email $k : $email"); // debug
	$user = false;
	
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

	// Ensure user does not already exists
	$already_registered = get_user_by_email($email);
	if (sizeof($already_registered) > 1) {
		register_error(elgg_echo("Users already exist with this email : {$email}, but only 1 account should be associated with a given email. Please contact a site administrator."));
		//forward(REFERER);
		continue;
	} else if (sizeof($already_registered) < 1) {
		// we can register without problem
		$already_registered = false;
	} else {
		// User is already registered
		$already_registered = $already_registered[0];
		if (elgg_instanceof($already_registered, 'user')) {
			system_message('User already exists : <a href="' . $already_registered->getURL() . '">' . $already_registered->name . '</a>');
			if ($user->memberstatus != 'active') {
				register_error(elgg_echo("User account has been un-archived, but archived account usually have wrong emails which should be updated: please contact the site administrator with the following username and a valid email so it can be updated if needed: %s", array($already_registered->username)));
				$user->memberstatus = 'active';
				$user->memberreason = 'unarchived_by_inria_member';
			}
		}
	}
	if ($debug) error_log("  Registered : " . print_r($already_registered, true)); // debug


	// Handle Inria emails (even if they could be handled on next LDAP sync)
	// Create account through LDAP, if exists
	if (!$already_registered) {
		if ($debug) error_log("  Trying LDAP");  // debug
		// Check if user exists in Inria LDAP => different creation process
		if (elgg_is_active_plugin('ldap_auth')) {
			elgg_load_library("elgg:ldap_auth");
			$ldap_username = ldap_get_username($email);
			if ($debug) error_log("  LDAP active : username found = " . print_r($ldap_username, true));
			if ($ldap_username) {
				// User exists in LDAP : register
				// If LDAP account can be associated with multiple emails, ensure the account doesn't exist
				$already_registered = get_user_by_username($ldap_username);
				if ($debug) error_log("  Checking if registered : " . print_r($already_registered, true));
				if (elgg_instanceof($already_registered)) {
					$already_registered = true;
				} else {
					$already_registered = false;
					$password = generate_random_cleartext_password();
					$user = ldap_auth_create_profile($ldap_username, $password, false);
					// Send a different email (no password, use CAS, etc.)
					if (elgg_instanceof($user, 'user')) {
						$already_registered = true;
						// user and admin notifications
						
						// Update some meta if not set yet
						if (empty($user->membertype)) { $user->membertype = 'inria'; }
						if (empty($user->memberstatus)) { $user->memberstatus = 'active'; }
						if (empty($user->firstmemberreason)) { $user->firstmemberreason = 'created_by_inria_member'; }
						if (empty($user->membercreatedby)) { $user->membercreatedby = $inviter_guid; }
						if (empty($user->registermemberreason)) { $user->registermemberreason = "Account registered by {$inviter->name} ($inviter_guid) with motive : $reason"; }
						// Initiate this because account would be disabled if not set at creation
						$user->last_action = time();
						// Add some fields values
						if ($organisations[$k] && empty($user->organisation)) { $user->organisation = string_to_tag_array($organisations[$k]); }
						if (!empty($briefdescription[$k]) && empty($user->briefdescription)) { $user->briefdescription = $briefdescription[$k]; }
						// Remember account creation + make mutual friends
						if (empty($user->created_by_guid)) { $user->created_by_guid = $inviter_guid; }
						$user->addFriend($inviter_guid);
						$inviter->addFriend($guid);
						
						// USER NOTIFICATION
						// Note: registration email with cleartext credentials should be sent by email *only* (don't leave this in the site itself !)
						$user_subject = elgg_echo('theme_inria:useradd:inria:subject', array($site->name, $inviter->name));
						$user_body = elgg_echo('theme_inria:useradd:inria:body', array(
							$name[$k],
							$inviter->name,
							$site->name,
							$message,
							$site->url,
						));
						notify_user($user->guid, $site->guid, $user_subject, $user_body, array(), array('email'));
						
						// ADMIN NOTIFICATION : always notify, whether validation is needed or not
						// We can notify up to 3 admins so new members can be moderated
						$admin_subject = elgg_echo('theme_inria:useradd:inria:admin:subject');
						$admin_body = elgg_echo('theme_inria:useradd:inria:admin:body', array(
							$name[$k],
							$email,
							$inviter->name . ' (' . $inviter_guid . ')',
							$reason,
							$user->getURL(),
						));
						foreach ($admins as $notify_user) {
							notify_user($notify_user->guid, $site->guid, $admin_subject, $admin_body, array('object' => $user), array('email', 'site'));
						}
						
						//system_message(elgg_echo("adduser:ok", array($site->name)));
						system_message(elgg_echo("theme_inria:useradd:inria:ok", array($user->name, $user->email, $user->getUrl())));
						elgg_clear_sticky_form('useradd');
					}
				}
			}
		}
	}


	// If LDAP failed, create the user as guest account
	if (!$already_registered) {
		$password = generate_random_cleartext_password();
		// We can safely add the 'ext_' prefix here to avoid duplicates
		$real_username = profile_manager_generate_username_from_email('ext_' . $email);
		/*
		if (strpos($username, 'ext_') === 0) {
			$real_username = $username;
		} else {
			$real_username = 'ext_' . $username;
		}
		*/
		$real_name = trim(strip_tags($name[$k]));
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
		
		//$user->admin_created = TRUE;
		$user->membertype = 'external';
		$user->memberstatus = 'active';
		$user->firstmemberreason = 'created_by_inria_member';
		$user->membercreatedby = $inviter_guid;
		$user->registermemberreason = "Account registered by {$inviter->name} ($inviter_guid) with motive : $reason";
		// Initiate this because account would be disabled if not set at creation
		$user->last_action = time();
		esope_set_user_profile_type($user, 'external');
		
		// Add some fields values
		if ($organisations[$k]) { $user->organisation = string_to_tag_array($organisations[$k]); }
		if (!empty($briefdescription[$k])) { $user->briefdescription = $briefdescription[$k]; }

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
		// Note: registration email with cleartext credentials should be sent by email *only* (don't leave this in the site itself !)
		$user_subject = elgg_echo('theme_inria:useradd:subject', array($site->name, $inviter->name));
		$user_body = elgg_echo('theme_inria:useradd:body', array(
			$name[$k],
			$inviter->name,
			$site->name,
			$message,
			$site->url,
			$real_username,
			$email,
			$password,
		));
		if ($disable_notice) { $user_body .= $disable_notice; }
		notify_user($user->guid, $site->guid, $user_subject, $user_body, array(), array('email'));

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
			$admin_subject = elgg_echo('theme_inria:useradd:admin:subject:confirm');
		} else {
			$admin_subject = elgg_echo('theme_inria:useradd:admin:subject');
		}
		$admin_body = elgg_echo('theme_inria:useradd:admin:body', array(
			$name[$k],
			$email,
			$inviter->name . ' (' . $inviter_guid . ')',
			$reason,
			$user->getURL(),
		));
		if ($disable_notice) { $admin_body .= $disable_notice; }
		foreach ($admins as $notify_user) {
			notify_user($notify_user->guid, $site->guid, $admin_subject, $admin_body, array('object' => $user), array('email', 'site'));
		}
		
		//system_message(elgg_echo("adduser:ok", array($site->name)));
		system_message(elgg_echo("theme_inria:useradd:ok", array($user->name, $user->email, $user->getUrl())));
		elgg_clear_sticky_form('useradd');
	}


	// Groups invitation(s) - also for already registered users
	// Note : invite = bypass for closed group (user must canEdit())
	// join : idem
	// request = "invite" by a regular member
	// add invite message + notification to group admin
	if ($group_guids) {
		// Also support CSV input
		if (is_string($group_guids) && strpos($group_guids, ',') !== false) { $group_guids = explode(',', $group_guids); }
		if (!is_array($group_guids)) { $group_guids = array($group_guids); }
		foreach($group_guids as $guid) {
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
										// Add membership request
										// Notify group owner + operators => through event handler on create,relationship
										add_entity_relationship($user->guid, 'membership_request', $parent->guid);
										// Notify group owner + operators => through event handler on create,relationship
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
						// Invite with no admin rights = membership request
						if (add_entity_relationship($user->guid, 'membership_request', $group->guid)) {
							// Notify group owner + operators => through event handler on create,relationship
							system_message("Group membership request for {$group->name}.");
						} else {
							system_message("Membership request already existing for {$group->name}.");
						}
				
					} else {
						// Invite with no admin rights = membership request
						if (add_entity_relationship($user->guid, 'membership_request', $group->guid)) {
							// Notify group owner + operators => through event handler on create,relationship
							system_message("Group membership request for {$group->name}.");
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

//forward(REFERER);
// Better clear URL paramters if any (eg. group invite)
forward('inria/invite');

