<?php


/* Performs some actions after registration
 * @TODO : not used ?
 */
function adf_platform_register_handler($event, $object_type, $object) {
	// Groupe principal (à partir du GUID de ce groupe)
	$homegroup_guid = elgg_get_plugin_setting('homegroup_guid', 'adf_public_platform');
	$homegroup_autojoin = elgg_get_plugin_setting('homegroup_autojoin', 'adf_public_platform');
	if (elgg_is_active_plugin('groups') && !empty($homegroup_guid) && ($homegroup = get_entity($homegroup_guid)) && in_array($homegroup_autojoin, array('yes', 'force'))) {
		$user = elgg_get_logged_in_user_entity();
		// Si pas déjà fait, on l'inscrit
		if (!$homegroup->isMember($user)) { $homegroup->join($user); }
	}
}


/*
 * Forwards to internal referrer, if set
 * Otherwise redirects to home after login
 * @TODO : not used ?
*/
function adf_platform_login_handler($event, $object_type, $object) {
	global $_SESSION;
	// Si on vient d'une page particulière, retour à cette page
	$back_to_last = $_SESSION['last_forward_from'];
	if(!empty($back_to_last)) {
		//register_error("Redirection vers $back_to_last");
		forward($back_to_last);
	}
	// Sinon, pour aller sur la page indiquée à la connexion (accueil par défaut)
	$loginredirect = elgg_get_plugin_setting('redirect', 'adf_public_platform');
	// On vérifie que l'URL est bien valide - Attention car on n'a plus rien si URL erronée !
	if (!empty($loginredirect)) { forward(elgg_get_site_url() . $loginredirect); }
	forward();
}


// Perform some post-login actions (join groups, etc.)
function esope_login_user_action($event, $type, $user) {
	if (elgg_instanceof($user, "user")) {
		if (!$user->isBanned()) {
			// Try to join groups asked at registration
			if ($user->join_groups) {
				foreach($user->join_groups as $group_guid) {
					if ($group = get_entity($group_guid)) {
						// Process only groups that haven't been joined yet
						if (!$group->isMember($user)) {
							if (!$group->join($user)) {
								// Handle subgroups cases
								if (elgg_is_active_plugin('au_subgroups')) {
									system_message(elgg_echo('esope:subgroups:tryjoiningparent', array($group->name)));
									while ($parent = au_subgroups_get_parent_group($group)) {
										//  Join only if parent group is public membership or if we have a join pending
										if (!$parent->isMember($user) && ($parent->isPublicMembership() || in_array($parent->guid, $user->join_groups))) {
											// Join group, or add to join list
											if (!$parent->join($user)) { $join_children[] = $parent->guid; }
										}
									}
									// Start joining from upper parents if needed
									if ($join_children) {
										$join_children = array_reverse($join_children);
										foreach($join_children as $children) { $children->join($user); }
									}
									// Try to join group again
									if ($group->join($user)) {}
								}
							}
						}
					}
				}
				// Update waiting list
				$user->join_groups = null;
			}
		}
	}
	return null;
}


// Ajoute -ou pas- les notifications lorsqu'on rejoint un groupe
function adf_public_platform_group_join($event, $object_type, $relationship) {
	if (elgg_is_logged_in()) {
		if (($relationship instanceof ElggRelationship) && ($event == 'create') && ($object_type == 'member')) {
			global $NOTIFICATION_HANDLERS;
			$groupjoin_enablenotif = elgg_get_plugin_setting('groupjoin_enablenotif', 'adf_public_platform');
			if (empty($groupjoin_enablenotif) || ($groupjoin_enablenotif != 'no')) {
				switch($groupjoin_enablenotif) {
					case 'site':
						add_entity_relationship($relationship->guid_one, 'notifysite', $relationship->guid_two);
						break;
					case 'all':
						foreach($NOTIFICATION_HANDLERS as $method => $foo) {
							add_entity_relationship($relationship->guid_one, "notify{$method}", $relationship->guid_two);
						}
						break;
					case 'email':
					default:
						add_entity_relationship($relationship->guid_one, 'notifyemail', $relationship->guid_two);
				}
			} else if ($groupjoin_enablenotif == 'no') {
				// loop through all notification types
				foreach($NOTIFICATION_HANDLERS as $method => $foo) {
					remove_entity_relationship($relationship->guid_one, "notify{$method}", $relationship->guid_two);
				}
			}
		}
	}
	return true;
}

// Retire les notifications lorsqu'on quitte un groupe
function adf_public_platform_group_leave($event, $object_type, $relationship) {
	global $NOTIFICATION_HANDLERS;
	if (($relationship instanceof ElggRelationship) && ($event == 'delete') && ($object_type == 'member')) {
		// loop through all notification types
		foreach($NOTIFICATION_HANDLERS as $method => $foo) {
			remove_entity_relationship($relationship->guid_one, "notify{$method}", $relationship->guid_two);
		}
	}
	return true;
}


/* TheWire create event handler 
 * Changes access level of wire object
 * Adds a container information and updates access level if wire object is published in a group
 */
function esope_thewire_handler_event($event, $type, $object) {
	//if (!empty($object) && elgg_instanceof($object, "object", "thewire") && elgg_is_active_plugin('thewire')) {
	if (!empty($object) && elgg_instanceof($object, "object", "thewire")) {
		$access_id = get_input('access_id', false);
		$container_guid = get_input('container_guid', false);
		
		// If replying to a previous post, default to parent container and access
		$parent_guid = get_input('parent_guid', false);
		if ($parent_guid) {
			$parent_post = get_entity($parent_guid);
			if (elgg_instanceof($parent_post, 'object', 'thewire')) {
				if (!$access_id) { $access_id = $parent_post->access_id; }
				if (!$container_guid) { $container_guid = $parent_post->container_guid; }
			}
		}
		
		// Define Wire container (if valid)
		if ($container_guid) {
			$container = get_entity($container_guid);
			if (elgg_instanceof($container, 'group')) {
				$object->container_guid = $container_guid;
				// Update entity (may be overriden if specific access is set)
				update_entity($object->guid, $object->owner_guid, $container->group_acl, $container_guid);
			}
		}
		
		// Default to previous access if none defined
		if ($access_id) {
			update_entity($object->guid, $object->owner_guid, $access_id, $object->container_guid);
		}
		
	}
	
	// Only returning false will break, return true or nothing is the same
	//return true;
}



