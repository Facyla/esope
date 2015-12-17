<?php
/**
 * The main plugin file
 */

require_once(dirname(__FILE__) . "/lib/events.php");
require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");

// register on default Elgg events
elgg_register_event_handler("init", "system", "uservalidationbyadmin_init");
elgg_register_event_handler("pagesetup", "system", "uservalidationbyadmin_pagesetup");

/**
 * Gets called during system initialization
 *
 * @return void
 */
function uservalidationbyadmin_init() {
	
	// register pam handler to check authentication
	register_pam_handler("uservalidationbyadmin_pam_handler", "required");
	
	// extend admin js
	elgg_extend_view("js/admin", "js/uservalidationbyadmin/admin");
	
	// register events
	elgg_register_event_handler("login", "user", "uservalidationbyadmin_login_event");
	
	// register hooks
	elgg_register_plugin_hook_handler("register", "user", "uservalidationbyadmin_register_user_hook");
	elgg_register_plugin_hook_handler("permissions_check", "user", "uservalidationbyadmin_permissions_check_hook");
	elgg_register_plugin_hook_handler("fail", "auth", "uservalidationbyadmin_auth_fail_hook");
	
	elgg_register_plugin_hook_handler("cron", "daily", "uservalidationbyadmin_cron_hook");
	elgg_register_plugin_hook_handler("cron", "weekly", "uservalidationbyadmin_cron_hook");
	
	// register actions
	elgg_register_action("uservalidationbyadmin/validate", dirname(__FILE__) . "/actions/validate.php", "admin");
	elgg_register_action("uservalidationbyadmin/delete", dirname(__FILE__) . "/actions/delete.php", "admin");
	elgg_register_action("uservalidationbyadmin/bulk_action", dirname(__FILE__) . "/actions/bulk_action.php", "admin");
	
	// Register page handler to validate users
	// This doesn't need to be an action because security is handled by the validation codes.
	elgg_register_page_handler('uservalidationbyadmin', 'uservalidationbyadmin_page_handler');
	
}

/**
 * Gets called just before the first output is generated
 *
 * @return void
 */
function uservalidationbyadmin_pagesetup() {
	// register admin menu item
	elgg_register_admin_menu_item("administer", "pending_approval", "users");
}

// Page handler to handle public validation through confirm link
function uservalidationbyadmin_page_handler($page) {
	
	// Check that this functionnality is enabled
	$admin_validation_link = elgg_get_plugin_setting("admin_validation_link", "uservalidationbyadmin");
	if ($admin_validation_link != 'yes') {
		$forward();
	}
	
	if (isset($page[0]) && $page[0] == 'validate') {
		$user_guid = (int) get_input("u", FALSE);
		$user_code = sanitise_string(get_input('c', FALSE));

		// we need to see all users
		access_show_hidden_entities(true);

		if (!empty($user_guid) && !empty($user_code)) {
			$user = get_user($user_guid);
			if (!empty($user)) {
				$code = uservalidationbyadmin_generate_code($user->guid, $user->email);
		
				// Check validation code
				if ($user_code == $code) {
					// we got a user, so validate him/her
					$user->admin_validated = true;
					// do we also need to enable the user
					if (!$user->isEnabled()) {
						$user->enable();
					}
					
					if ($user->save()) {
						// notify the user about the validation
						uservalidationbyadmin_notify_validate_user($user);
						system_message(elgg_echo("uservalidationbyadmin:actions:validate:success", array($user->name)));
					} else {
						register_error(elgg_echo("uservalidationbyadmin:actions:validate:error:save", array($user->name)));
					}
				} else {
					register_error(elgg_echo("uservalidationbyadmin:actions:validate:error:code", array($user->name)));
				}
			} else {
				register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($user_guid)));
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:MissingParameter"));
		}
		
		access_show_hidden_entities(false);
		// forward to front page
		forward(REFERER);
	}
}

