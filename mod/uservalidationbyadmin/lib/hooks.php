<?php
/**
 * All plugin hook handlers are bundled here
 */

/**
 * Listen to the registration of a new user
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param bool   $return_value the current return value
 * @param array  $params       supplied params
 *
 * @return bool
 */
function uservalidationbyadmin_register_user_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$user = elgg_extract("user", $params);
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $return_value;
	}
	
	// make sure we can see everything
	$hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	
	// make sure we can save metadata
	elgg_push_context("uservalidationbyadmin_new_user");
	
	// this user needs validation
	$user->admin_validated = false;
	
	// check who to notify
	$notify_admins = uservalidationbyadmin_get_admin_notification_setting();
	if ($notify_admins == "direct") {
		uservalidationbyadmin_notify_admins();
	}
	
	// check if we need to disable the user
	if ($user->isEnabled()) {
		$user->disable();
	}
	
	// restore context
	elgg_pop_context();
	
	// restore access settings
	access_show_hidden_entities($hidden);
	
	return $return_value;
}

/**
 * check the user's permissions
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param bool   $return_value the current return value
 * @param array  $params       supplied params
 *
 * @return bool
 */
function uservalidationbyadmin_permissions_check_hook($hook, $type, $return_value, $params) {
	
	if ($return_value) {
		// already have permission
		return $return_value;
	}
	
	if (empty($params) || !is_array($params)) {
		// invalid params
		return $return_value;
	}
	
	$user = elgg_extract("entity", $params);
	
	// do we have a user
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $return_value;
	}
	
	// are we setting our validation flags
	if (elgg_in_context("uservalidationbyadmin_new_user")) {
		$return_value = true;
	}
	
	return $return_value;
}

/**
 * Listen to the CRON to notify the admins about pending approvals
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param string $return_value the current return value
 * @param array  $params       supplied params
 *
 * @return string
 */
function uservalidationbyadmin_cron_hook($hook, $type, $return_value, $params) {
	
	$notify_admins = uservalidationbyadmin_get_admin_notification_setting();
	
	if (empty($notify_admins) || ($notify_admins !== $type)) {
		return $return_value;
	}
	
	// notify the admins about pending approvals
	uservalidationbyadmin_notify_admins();
	
	return $return_value;
}

/**
 * Adjust the error message from the PAM handler (to be translated)
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param string $return_value the current return value
 * @param array  $params       supplied params
 *
 * @return string
 */
function uservalidationbyadmin_auth_fail_hook($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	// check if the translated text is different
	$string = elgg_echo($result);
	if ($string != $result) {
		$result = $string;
	}
	
	return $result;
}
