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
		"metadata_name_value_pairs" => array(
			"name" => "admin_validated",
			"value" => 0	// @todo this should be false, but Elgg doesn't support that (yet)
		)
	);
	
	// extra options
	if (!elgg_is_active_plugin("uservalidationbyemail")) {
		// uservalidationbyemail handles part of this proccess
		$result["wheres"] = array("e.enabled = 'no'");
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
		
		// Add more information if asked to
		$user_notification_info = elgg_get_plugin_setting("user_notification_info", "uservalidationbyadmin");
		if ($user_notification_info == 'yes') {
			$msg = elgg_echo("uservalidationbyadmin:notify:validate:message:alternate", array($user->name, $site->name, $user->username, $user->email, $site->url));
		}
		
		$result = notify_user($user->getGUID(), $site->getGUID(), $subject, $msg, null, "email");
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
				$admin_validation_link = elgg_get_plugin_setting("admin_validation_link", "uservalidationbyadmin");
				$admin_notification_info = elgg_get_plugin_setting("admin_notification_info", "uservalidationbyadmin");
				// Prepare detailed user list
				if (($admin_notification_info == 'yes') || ($admin_validation_link == 'yes')) {
					$options['count'] = false;
					$options['limit'] = false;
					$pending_users = elgg_get_entities_from_relationship($options);
					$user_list = '';
					foreach ($pending_users as $pending_user) {
						if ($admin_notification_info == 'yes') {
							// Note : use 'uservalidationbyadmin:userinfo:geo' to include also IP and guessed geolocation
							// We are using stored registration IP because information can only be available at registration time - not in cron
							if (!empty($pending_user->register_ip)) {
								$geoloc = uservalidationbyadmin_detect_geoloc($pending_user->register_ip);
							} else {
								$geoloc = elgg_echo('uservalidationbyadmin:noipinfo');
							}
							// $ip_address = $_SERVER['REMOTE_ADDR'];
							$user_list .= "\n" . elgg_echo('uservalidationbyadmin:userinfo:geo', array(
										$pending_user->name,
										$pending_user->username,
										$pending_user->email,
										$geoloc,
									)
								);
						}
						if ($admin_validation_link == 'yes') {
							$user_code = uservalidationbyadmin_generate_code($pending_user->guid, $pending_user->email);
							$user_validation_link = elgg_get_site_url() . 'uservalidationbyadmin/validate?u=' . $pending_user->guid . '&c=' . $user_code;
							$user_list .= "\n" . elgg_echo('uservalidationbyadmin:user_validation_link', array($pending_user->name, $user_validation_link));
						}
						$user_list .= "\n";
					}
				}
				
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
						
						// Alternate message with detailed list and/or direct email validation link (without log in)
						if (!empty($user_list)) {
							$msg = elgg_echo("uservalidationbyadmin:notify:admin:message:alternate", array(
							$admin->name,
							$user_count,
							$site->name,
							$user_list,
							$site->url . "admin/users/pending_approval"
						));
						}
						
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

// Generate unique user validation code
function uservalidationbyadmin_generate_code($user_guid, $email_address) {
	$site_url = elgg_get_site_url();
	// Note I bind to site URL, this is important on multisite!
	return md5($user_guid . $email_address . $site_url . get_site_secret());
}

// Returns guessed geolocation
// Note : this works only for direct validation (as it depends on server global vars)
function uservalidationbyadmin_detect_geoloc($ip_address = false) {
		// IP detection
		if (!$ip_address) {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		
		// http://freegeoip.net/ => up to 10k requests per hour
		$geo_api = 'http://freegeoip.net/json/' . $ip_address;
		$geo_json = file_get_contents($geo_api);
		$geoloc = json_decode($geo_json, true);
		//echo '<pre>' . print_r($geoloc, true) . '</pre>'; // Test and dev
		/* Response content format
		[ip] => xxx.xxx.xxx.xxx
		[country_code] => XX
		[country_name] => Xxxxx
		[region_code] => X
		[region_name] => Xxxxxx
		[city] => Xxxxx
		[zip_code] => XXXXX
		[time_zone] => Europe/Xxxx
		[latitude] => xx.xx
		[longitude] => xx.xx
		[metro_code] => X
		*/
		$geostring = "{$geoloc['zip_code']} {$geoloc['city']}, {$geoloc['region_name']}, {$geoloc['country_name']} (TZ {$geoloc['time_zone']})";
		return elgg_echo('uservalidationbyadmin:geoinfo', array($ip_address, $geostring));
}


