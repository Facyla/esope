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
	
	// register events
	elgg_register_event_handler("login", "user", "uservalidationbyadmin_login_event");
	elgg_register_event_handler("enable", "user", "\ColdTrick\UserValidationByAdmin\User::enableUser");
	
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
	
}

/**
 * Gets called just befor the first output is generated
 *
 * @return void
 */
function uservalidationbyadmin_pagesetup() {
	// register admin menu item
	elgg_register_admin_menu_item("administer", "pending_approval", "users");
}
