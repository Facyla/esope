<?php
/**
 * All helper functions are bundled here
 */

/**
 * Validate the login attempt of the user
 *
 * @param array $credentials the user credentials
 *
 * @throws LoginException
 * @see register_pam_handler()
 *
 * @return null|bool
 */
function uservalidationbyadmin_pam_handler($credentials) {
	$result = null;
	
	if (!empty($credentials) && is_array($credentials)) {
		$username = elgg_extract("username", $credentials);
		if (!empty($username)) {
			$result = false;
			
			// make sure we can see all users
			$hidden = access_get_show_hidden_status();
			access_show_hidden_entities(true);
			
			$user = get_user_by_username($username);
			if (!empty($user)) {
				// check if the user is enabled
				if ($user->isEnabled()) {
					if ($user->isAdmin()) {
						// admins can always login
						$result = true;
					} elseif (isset($user->admin_validated)) {
						if (!$user->admin_validated) {
							// this user should be admin validated
							access_get_show_hidden_status($hidden);
							
							// throw exception
							throw new LoginException(elgg_echo("uservalidationbyadmin_pam_handler:failed"));
						} else {
							// user is validated
							$result = true;
						}
					} else {
						// user register before this plugin was activated
						$result = true;
					}
				}
			} else {
				// throw exception
				throw new LoginException(elgg_echo("login:baduser"));
			}
			
			// restore hidden status
			access_get_show_hidden_status($hidden);
		}
	}
	
	// user is validated, but does the password checkout?
	if ($result) {
		pam_auth_userpass($credentials);
	}
	
	return $result;
}

/**
 * Get the default options to use with elgg_get_entities*
 *
 * @param bool $count count users or not (default: false)
 *
 * @return array
 */
function uservalidationbyadmin_get_selection_options($count = false) {
	$result = array(
		"type" => "user",
		"site_guids" => false,
		"limit" => 25,
		"offset" => max(0, (int) get_input("offset")),
		"relationship" => "member_of_site",
		"relationship_guid" => elgg_get_site_entity()->getGUID(),
		"inverse_relationship" => true,
		"count" => (bool) $count,
		"metadata_name_value_pairs" => [
			[
				"name" => "admin_validated",
				"value" => 0,	// @todo this should be false, but Elgg doesn't support that (yet)
			],
		],
	);
	
	// extra options
	if (!elgg_is_active_plugin("uservalidationbyemail")) {
		// uservalidationbyemail handles part of this proccess
		$result["wheres"] = array("e.enabled = 'no'");
	} else {
		$result['metadata_name_value_pairs'][] = [
			'name' => 'validated',
			'value' => 0,
			'operand' => '<>',
		];
	}
	
	return $result;
}

/**
 * List users using a custom layout
 *
 * @param ElggEntity[] $entities the entities to list
 * @param array        $options  listing options
 *
 * @see elgg_view_entity_list()
 *
 * @return bool|string
 */
function uservalidationbyadmin_view_users_list($entities, $options) {
	$result = false;
	
	if (!empty($entities) && is_array($entities)) {
		$nav_options = $options;
		$nav_options["offset_key"] = elgg_extract("offset_key", $options, "offset");
		
		$nav = elgg_view("navigation/pagination", $nav_options);
		
		$list_class = "elgg-list";
		$extra_list_class = elgg_extract("list_class", $options);
		if (!empty($extra_list_class)) {
			$list_class .= " " . $extra_list_class;
		}
		
		$item_class = "elgg-item";
		$extra_item_class = elgg_extract("item_class", $options);
		if (!empty($extra_item_class)) {
			$item_class .= " " . $extra_item_class;
		}
		
		$result = "<ul class='" . $list_class . "'>";
		
		foreach ($entities as $entity) {
			if (elgg_instanceof($entity)) {
				$id = "elgg-" . $entity->getType() . "-" . $entity->getType();
			} else {
				$id = "elgg-" . $entity->getType() . "-" . $entity->id;
			}
			
			$result .= "<li id='" . $id . "' class='" . $item_class . "'>";
			$result .= elgg_view("uservalidationbyadmin/list/user", array("entity" => $entity));
			$result .= "</li>";
		}
		
		$result .= "</ul>";
		
		$result .= $nav;
	}
	
	return $result;
}

/**
 * Send a notification to the user that he/she is validated
 *
 * @param ElggUser $user the affected user
 *
 * @return bool|array
 */
function uservalidationbyadmin_notify_validate_user(ElggUser $user) {
	$result = false;
	
	if (!empty($user) && elgg_instanceof($user, "user")) {
		$site = elgg_get_site_entity();
		
		$subject = elgg_echo("uservalidationbyadmin:notify:validate:subject", array($site->name));
		$msg = elgg_echo("uservalidationbyadmin:notify:validate:message", array($user->name, $site->name, $site->url));
		
		$result = notify_user($user->getGUID(), $site->getGUID(), $subject, $msg, array(), "email");
	}
	
	return $result;
}

/**
 * Notify the site admins about pending approvals
 *
 * @return void
 */
function uservalidationbyadmin_notify_admins() {
	
	$notify_admins = uservalidationbyadmin_get_admin_notification_setting();
	if (!empty($notify_admins) && ($notify_admins != "none")) {
		// make sure we can see every user
		$hidden = access_get_show_hidden_status();
		access_show_hidden_entities(true);
		
		// get selection options
		$options = uservalidationbyadmin_get_selection_options(true);
		
		$user_count = elgg_get_entities_from_relationship($options);
		if (!empty($user_count)) {
			$site = elgg_get_site_entity();
			
			// there are unvalidated users, now find the admins to notify
			$admin_options = array(
				"type" => "user",
				"limit" => false,
				"site_guids" => false,
				"relationship" => "member_of_site",
				"relationship_guid" => $site->getGUID(),
				"inverse_relationship" => true,
				"joins" => array("JOIN " . elgg_get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
				"wheres" => array("ue.admin = 'yes'")
			);
			
			$admins = elgg_get_entities_from_relationship($admin_options);
			
			// trigger hook to adjust the admin list
			$params = array(
				"admins" => $admins,
				"user_count" => $user_count
			);
			$admins = elgg_trigger_plugin_hook("notify_admin", "uservalidationbyadmin", $params, $admins);
			
			// notify the admins
			if (!empty($admins)) {
				foreach ($admins as $admin) {
					// does the admin have notifications disabled
					if (elgg_get_plugin_user_setting("notify", $admin->getGUID(), "uservalidationbyadmin") != "no") {
						
						$subject = elgg_echo("uservalildationbyadmin:notify:admin:subject");
						$msg = elgg_echo("uservalildationbyadmin:notify:admin:message", array(
							$admin->name,
							$user_count,
							$site->name,
							$site->url . "admin/users/pending_approval"
						));
						
						notify_user($admin->getGUID(), $site->getGUID(), $subject, $msg, null, "email");
					}
				}
			}
		}
		
		// restore hidden setting
		access_show_hidden_entities($hidden);
	}
}

/**
 * Check the plugin setting for when admins should be notified
 *
 * @return bool|string
 */
function uservalidationbyadmin_get_admin_notification_setting() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		$setting = elgg_get_plugin_setting("admin_notify", "uservalidationbyadmin");
		if (!empty($setting)) {
			$result = $setting;
		}
	}
	
	return $result;
}
