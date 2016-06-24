<?php


// Perform some post-creation actions (join groups, etc.)
function esope_create_user_event($event, $type, $user) {
	if (elgg_instanceof($user, 'user') && ($event == 'create') && ($type == 'user')) {
		
		// Auto-join groups : imported from autosubscribegroup plugin
		//auto submit relationships between user & groups
		//retrieve groups ids from plugin
		$autojoin_groups = elgg_get_plugin_setting('groups_autojoin', 'esope');
		$groups = esope_get_input_array($autojoin_groups);
		if ($groups) {
			//for each group ids
			foreach($groups as $groupId) {
				$ia = elgg_set_ignore_access(true);
				$groupEnt = get_entity($groupId);
				elgg_set_ignore_access($ia);
				//if group exist : submit to group
				if ($groupEnt) {
					//join group succeed?
					if ($groupEnt->join($user)) {
						// Remove any invite or join request flags
						elgg_delete_metadata(array('guid' => $user->guid, 'metadata_name' => 'group_invite', 'metadata_value' => $groupEnt->guid, 'limit' => false));
						elgg_delete_metadata(array('guid' => $user->guid, 'metadata_name' => 'group_join_request', 'metadata_value' => $groupEnt->guid, 'limit' => false));
					}
				}
			}
		}
		
		// Groupe principal (à partir du GUID de ce groupe)
		$homegroup_guid = elgg_get_plugin_setting('homegroup_guid', 'esope');
		$homegroup_autojoin = elgg_get_plugin_setting('homegroup_autojoin', 'esope');
		if (elgg_is_active_plugin('groups') && !empty($homegroup_guid) && ($homegroup = get_entity($homegroup_guid)) && in_array($homegroup_autojoin, array('yes', 'force'))) {
			$user = elgg_get_logged_in_user_entity();
			// Si pas déjà fait, on l'inscrit
			if (!$homegroup->isMember($user)) { $homegroup->join($user); }
		}
		
	}
}


// Perform some post-login actions (join groups, etc.)
function esope_login_user_event($event, $type, $user) {
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
									while ($parent = AU\SubGroups\get_parent_group($group)) {
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
			
			/*
			 * Forwards to internal referrer, if set
			 * Otherwise redirects to home after login
			// @TODO réintégrer ?
			// Si on vient d'une page particulière, retour à cette page
			$back_to_last = $_SESSION['last_forward_from'];
			if(!empty($back_to_last)) {
				//register_error("Redirection vers $back_to_last");
				forward($back_to_last);
			}
			// Sinon, pour aller sur la page indiquée à la connexion (accueil par défaut)
			$loginredirect = elgg_get_plugin_setting('redirect', 'esope');
			// On vérifie que l'URL est bien valide - Attention car on n'a plus rien si URL erronée !
			if (!empty($loginredirect)) { forward(elgg_get_site_url() . $loginredirect); }
			forward();
			*/
			
		}
	}
	return null;
}


/* TheWire create event handler 
 * Changes access level of wire object
 * Adds a container information and updates access level if wire object is published in a group
 * Inherits parent container and access by default if post is a reply
 */
function esope_thewire_handler_event($event, $type, $object) {
	if (!empty($object) && elgg_instanceof($object, "object", "thewire")) {
		$parent_guid = get_input('parent_guid', false);
		$access_id = get_input('access_id', ACCESS_DEFAULT);
		$container_guid = get_input('container_guid', false);
		
		// If replying to a previous post, default to parent container and access
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
				if (!$access_id) { $access_id = $container->group_acl; }
				$object->container_guid = $container_guid;
				$object->access_id = $access_id;
				// Update entity (may be overriden if specific access is set)
				$object->save();
				// @TODO Notify (force) to the group ? this should be done in another event hook (registered after this one)
			}
		}
		// Change access if asked to
		if ($access_id) {
			$object->access_id = $access_id;
			$object->save();
		}
	}
	// Return false halts the process, true or no return is equivalent
}




