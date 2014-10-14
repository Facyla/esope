<?php
include 'EtherpadLiteClient.php';


/* Creates a new EtherpadLiteClient, or return previously created one */
function elgg_etherpad_get_client() {
	global $elgg_etherpad_client;
	if (!isset($elgg_etherpad_client)) {
		$server = elgg_get_plugin_setting('server', 'elgg_etherpad');
		$api_key = elgg_get_plugin_setting('api_key', 'elgg_etherpad');
		$elgg_etherpad_client = new EtherpadLiteClient($api_key, $server.'/api');
	}
	return $elgg_etherpad_client;
}

/* View raw response (debug tool) */
function elgg_etherpad_view_response($response) {
	$content = false;
	if ($response) {
		$content = '<pre>' . print_r($response, true) . '</pre>';
	}
	return $content;
}

/* Get response data for a named key */
function elgg_etherpad_get_response_data($response, $key = false) {
	$return = false;
	if ($response) {
		$return = $response->data;
		if ($key) { $return = $return->$key; }
	}
	return $return;
}




/* Get an author ID, or create it if not available
 * $update : force checking the EPL instance, and eventually update it (e.g. name can change)
 * IMPORTANT : if the etherpad session is updated to a new/other instance, authorID may change
 *             In that case, authorID should be flushed to update the authorID
 *             This should not happen in a standard use
 */
function elgg_etherpad_get_author_id($user = false) {
	if (!$user) $user = elgg_get_logged_in_user_entity();
	
	if (elgg_instanceof($user, 'user')) {
		// Check known info and return it if no need to double-check
		if (!empty($user->etherpad_authorID) && !$update) return $user->etherpad_authorID;
		
		$client = elgg_etherpad_get_client();
		// Author doesn't exist or data should be updated
		// Check we have an author by that (unique) GUID, or create it
		// Portal maps the internal user id to an etherpad authorID
		$response = $client->createAuthorIfNotExistsFor($user->guid, $user->name);
		$authorID = elgg_etherpad_get_response_data($response, 'authorID');
		
		// Update user data
		$user->etherpad_authorID = $authorID;
		return $authorID;
	}
	return false;
}


/* Get a group ID for a given entity (container), or create it if not available
 * IMPORTANT : pads can be used in several ways :
 * - to edit a given entity : then the pad should not have any public existence, and only be accessible from Elgg
 * - to be more remanent as a shared pad itself : then it should be accessible
 * So groups can be mapped to several elgg objects : 
 * - user : user GUID
 * - site : site GUID
 * - group : group GUID
 * - object : object GUID
 * Note : the reason we're using GUID and not elgg access collections is that changing the entity access level 
 *        will not update the pad group. Also note that public status or password is not related to group.
 *        So we rather have "shared pads" that people can control, and "editing pads" 
 *        that live only for the time of edition (created when editing, and destroyed after synchronization)
 * $update : force checking the EPL instance, and eventually update it
 */
function elgg_etherpad_get_entity_group_id($entity, $update = false) {
	if (!$entity) $entity = elgg_get_logged_in_user_entity();
	
	// Groups can only be created with a mapping to existing Elgg-known entities
	if (elgg_instanceof($entity, 'site') || elgg_instanceof($entity, 'user') || elgg_instanceof($entity, 'group') || elgg_instanceof($entity, 'object')) {
		// Check known info and return it if no need to double-check
		if (!empty($entity->etherpad_groupID) && !$update) return $entity->etherpad_groupID;
		
		$groupID = elgg_etherpad_get_group_id($entity->guid, $update);
		
		// Update entity mapping data
		$entity->etherpad_groupID = $groupID;
		return $groupID;
	}
	return false;
}

/* Get Elgg entity from groupID
 * Returns the entity associated to a specific groupID, if any
 * Note : should match only 1 Elgg entity, because a groupID (access) is created for each entity (and not for its container)
 */
function elgg_etherpad_get_entity_from_group_id($groupID = '') {
	if (!empty($groupID)) {
		// Apply some filtering, just in case...
		//$groupID = elgg_get_friendly_title($groupID);
		$entities = elgg_get_entities_from_metadata(array('types' => array('site', 'user', 'group', 'object'), 'metadata_name_value_pairs' => array('name' => 'etherpad_groupID', 'value' => $groupID)));
		if ($entities) {
			if (sizeof($entities > 1)) {
				error_log("Elgg Etherpad LIB : multiple matching entities found for groupID $groupID");
			}
			return $entities[0];
		}
	}
	return false;
}


/* Get Elgg entity details from groupID
 * Returns details about the entity associated to a specific groupID, if any
 */
function elgg_etherpad_get_entity_details_from_group_id($groupID = '') {
	$entity = elgg_etherpad_get_entity_from_group_id($groupID);
	$default_return = "? ($groupID)";
	if ($entity) {
		$type = $entity->getType();
		switch($type) {
			case 'site':
			case 'user':
			case 'group':
				$title = $entity->name;
				break;
			case 'object':
				$title = $entity->title;
				break;
			default:
				return $default_return;
		}
		return '<a href="' . $entity->getURL() . '" target="_blank">' . $title . ' (' . $type . ')</a>';
	}
	return $default_return;
}

/* Get the groupID from groupName */
function elgg_etherpad_get_group_id($groupName, $update = false) {
	$client = elgg_etherpad_get_client();
	// Create the associated group for the given name
	// Portal maps the internal name to an etherpad groupID
	$response = $client->createGroupIfNotExistsFor($groupName);
	if ($response->code > 0) return false;
	return elgg_etherpad_get_response_data($response, 'groupID');
}


/* Create pad and apply some access controls over it
 * $padName : pad name
 * $groupName : false / group name - corresponds to Elgg container_guid (user, group, object)
 * $public : false / true
 * $password : password / false / null
 * Note : will return code 1 (and so => false) if pad already exists
 */
function elgg_etherpad_create_pad($padName, $groupName = false, $public = null, $password = null, $text = false) {
	if (!$text) $text = elgg_echo('elgg_etherpad:pad:defaultcontent');
	
	$client = elgg_etherpad_get_client();
	
	// Create pad
	if ($groupName) {
		// Get group ID from name
		$groupID = elgg_etherpad_get_group_id($groupName);
		
		// Create pad in group
		$response = $client->createGroupPad($groupID, $padName);
		//print_r($response);
		if ($response->code > 0) return false;
		$padID = $groupID . '$' . $padName;
	} else {
		$response = $client->createPad($padName);
		//print_r($response);
		if ($response->code > 0) return false;
		$padID = $padName;
	}
	
	// Apply access controls
	elgg_etherpad_set_pad_access($padID, $public, $password);
	
	// Set pad content
	elgg_etherpad_set_pad_content($padID, $text);
	
	return $padID;
}

/* Set pad content (HTML) */
function elgg_etherpad_set_pad_content($padID, $html) {
	$client = elgg_etherpad_get_client();
	
	// Etherpad Lite requires that HTML content is wrapped into a <div>...</div>
	// Otherwise it will break at first parapgraph (or closing tag)
	// See https://github.com/ether/etherpad-lite/pull/204
	$html = '<div>' . $html . '</div>';
	
	$response = $client->setHTML($padID, $html);
	//print_r($response);

	if ($response->code > 0) return false;
	return true;
}


// ACCESS AND VISIBILITY CONTROLS

/* Set pad access : visibility and password
 * $public : false / true / null
 * $password : password / false / null
 */
function elgg_etherpad_set_pad_access($padID, $public = null, $password = null) {
	$return = elgg_etherpad_set_pad_publicstatus($padID, $public);
	$return = elgg_etherpad_set_pad_password($padID, $password);
	return $return;
}

/* Checks if pad is public
 * Returns yes/no or false for error (unknown)
 */
function elgg_etherpad_is_public($padID) {
	$client = elgg_etherpad_get_client();
	$response = $client->getPublicStatus($padID);
	$status = elgg_etherpad_get_response_data($response, 'publicStatus');
	//print_r($response);
	if ($response->code > 0) return false;
	if (($status == 1) || ($status == 'true')) return 'yes';
	return 'no';
}

/* Set pad access : visibility
 * $public : false / true / null
 * Returns true for success, false for error
 */
function elgg_etherpad_set_pad_publicstatus($padID, $public = null) {
	$client = elgg_etherpad_get_client();
	if ($public !== NULL) {
		if ($public) $response = $client->setPublicStatus($padID, 'true');
		else $response = $client->setPublicStatus($padID, 'false');
		//print_r($response);
		if ($response->code > 0) return false;
	}
	return true;
}

/* Checks if pad is password protected
 * Returns yes/no or false for error (unknown)
 */
function elgg_etherpad_is_password_protected($padID) {
	$client = elgg_etherpad_get_client();
	$response = $client->isPasswordProtected($padID);
	$isPasswordProtected = elgg_etherpad_get_response_data($response, 'isPasswordProtected');
	//print_r($response);
	if ($response->code > 0) return false;
	if (($isPasswordProtected == '1') || ($isPasswordProtected == 'true')) return 'yes';
	return 'no';
}

/* Set pad access : password
 * $password : password / false / null
 * Returns true for success, false for error
 */
function elgg_etherpad_set_pad_password($padID, $password = null) {
	$client = elgg_etherpad_get_client();
	if ($password !== NULL) {
		if (!$password) $password = '';
		$response = $client->setPassword($padID, $password);
		if ($response->code > 0) return false;
		//print_r($response);
	}
	return true;
}


/* Create a session for a given user in a given group */
function elgg_etherpad_create_session($groupID, $authorID, $validUntil = 43200) {
	$validUntil = time() + $validUntil;
	$client = elgg_etherpad_get_client();
	$response = $client->createSession($groupID, $authorID, $validUntil);
	//error_log(print_r($response, true));
	if ($response->code > 0) return false;
	return elgg_etherpad_get_response_data($response, 'sessionID');
}


/* Add a session to Etherpad session cookie for a given group
 * Note that domain MUST be the same for the cookie to be set
 * Also note that $validUntil param doesn't renew the sessions ! (which are set on Etherpad Lite side)
 * But it must last at least as long as the longuest EPL session...
 */
function elgg_etherpad_update_session($sessionID, $validUntil = 43200) {
	$validUntil = time() + $validUntil;
	$cookiedomain = elgg_get_plugin_setting('cookiedomain', 'elgg_etherpad');
	$site_url = elgg_get_site_url();
	if (!$cookiedomain) $cookiedomain = parse_url($site_url, PHP_URL_HOST);
	
	// Check domain validity : the cookie domain should be the same, or the top domain of current site (sub)domain
	if (strpos($site_url, $cookiedomain) === false) {
		error_log("Cookie domain $cookiedomain does not match site domain $site_url");
		//return false;
	}

	// Get existing sessions
	if ($_COOKIE['sessionID']) { $sessions = explode(',', $_COOKIE['sessionID']); }
	else $sessions = array();
	//error_log("Previous session : " . $_COOKIE['sessionID']);
	
	// Check if the session id is there, and add it if not
	if ((sizeof($sessions) > 0) && in_array($sessionID, $sessions)) {
		return true;
	} else {
		$sessions[] = $sessionID;
		$sessionIDs = implode(',', $sessions);
		//error_log("New session (adding $sessionID) : $sessionIDs");
		//error_log("setcookie('sessionID', $sessionIDs, $validUntil, '/', $cookiedomain)");
		if (setcookie('sessionID', $sessionIDs, $validUntil, '/', $cookiedomain)) return true;
		//error_log("Cookie not set");
	}
	// If we got there, cookie could not be set..
	return false;
}


/* Has access to pad ? This determines if we can read and contribute to a pad (not edit its settings !)
 * A user has access to a pad if :
 * - pad is public status
 * - user is pad owner (user group <=> pad group)
 * - user has access to container group (group or object group <=> pad group)
 * - user is admin (bypass) ?
 */
function elgg_etherpad_can_read_pad($padID, $user = false, $entity = false) {
	if (empty($padID)) return false;
	
	// Is it a Public Pad ?
	if (!strpos($padID, '$')) return true;
	
	// Now we're only dealing with group pads
	
	// Is the Pad in public access ?
	if (elgg_etherpad_is_public($padID) == 'yes') return true;
	
	// Now we're getting into detailed access rights...
	$pad_name = explode('$', $padID);
	$groupID = $pad_name[0];
	// It's time to convoke the user...
	if (!$user) $user = elgg_get_logged_in_user_entity();
	if (!elgg_instanceof($user, 'user')) return false;
	
	// Is user the pad owner ?
	if ($groupID == $user->etherpad_groupID) return true;
	
	// Does this user have an admin bypass ?
	if (elgg_is_admin_logged_in($user)) return true;
	
	// If no entity set, it's time to get it...
	$entity = elgg_etherpad_get_entity_from_group_id($groupID);
	// Wrong entity will lead to an error, something went wrong
	if (!$entity) return false;
	
	// Does user have write access to associated entity ?
	if ($entity->canEdit($user)) return true;
	
	// Does user have access to container ?
	// Note we don't want to allow editing other user's pads only because we can view their profile
	// This should work only for group and site pads, which 
	if (elgg_instanceof($entity, 'object')) {
		$container = $entity->getContainerEntity();
		if ($container && $container->isMember($user)) return true;
	} else if (elgg_instanceof($entity, 'site')) {
		if (has_access_to_entity($entity, $user)) return true;
	} else if (elgg_instanceof($entity, 'group')) {
		if ($entity->isMember($user)) return true;
	}
	
	// If we cannot allow access at this step, forget it
	return false;
}


/* Can user edit a pad (settings) ?
 * It's like reading it, but requires a little more control (need to be able to edit associated entities)
 * A user can edit a pad if :
 * - user is pad owner (user group <=> pad group)
 * - user can edit container group (group or object group <=> pad group)
 * - user is admin (bypass)
 * Notes :
 * - users CANNOT edit public pads because anyone could modify them (create private pads and open them if access controls needed)
 */
function elgg_etherpad_can_edit_pad($padID, $user = false, $entity = false) {
	if (empty($padID)) return false;
	
	// Is it a Public Pad ? 
	// @TODO well, how can we determine who should be able to edit public pads ?  the same people who can create them...
	if (!strpos($padID, '$')) return true;
	
	// Now we're only dealing with group pads
	
	// Is the Pad in public access ? this is not a valid criteria for editing pads settings (we're talking about ownership)
	//if (elgg_etherpad_is_public($padID) == 'yes') return true;
	
	// Now we're getting into detailed access rights...
	$pad_name = explode('$', $padID);
	$groupID = $pad_name[0];
	// It's time to convoke the user...
	if (!$user) $user = elgg_get_logged_in_user_entity();
	if (!elgg_instanceof($user, 'user')) return false;
	
	// Is user the pad owner ?
	if ($groupID == $user->etherpad_groupID) return true;
	
	// Does this user have an admin bypass ?
	if (elgg_is_admin_logged_in($user)) return true;
	
	// If no entity set, it's time to get it...
	$entity = elgg_etherpad_get_entity_from_group_id($groupID);
	// If we can't tell which entity is associated with this pad, we won't allow editing rights
	if (!$entity) return false;
	
	// Does user have write access to associated entity ?
	if ($entity->canEdit($user)) return true;
	
	// Does user have write access to container ? (group or site owner)
	if (elgg_instanceof($entity, 'object')) {
		$container = $entity->getContainerEntity();
		if ($container && $container->canEdit($user)) return true;
	}
	
	// If we cannot allow access at this step, forget it
	return false;
}


/* Save pad in an entity metadata
 * $entity : the target entity
 * $metadata : the target metadata
 * $padID : the pad
 */
function elgg_etherpad_save_pad_content_to_entity($padID = false, $entity = false, $metadata = false) {
	// Get pad content
	$client = elgg_etherpad_get_client();
	$response = $client->getHTML($padID);
	//print_r($response);
	if ($response->code > 0) return false;
	$description = elgg_etherpad_get_response_data($response, 'html');
	// Remove some added tags
	$description = str_replace(array('<!DOCTYPE HTML>', '<html>', '<body>', '</body>', '</html>'), '', $description);
	// Try to wrap paragraphs correctly
	$description = '<p>' . str_replace('<br><br>', '</p><p>', $description) . '</p>';
	// Remove ending <p></p>
	$description = substr($description, 0, -7);
	
	// @TODO : test locally before going live !!
	// Save it to target entity
	// Note : handle only subtypes we're sure of
	$subtype = $entity->getSubtype();
	switch($subtype) {
		// Pages : annotation
		case 'page':
		case 'page_top':
			// For pages, latest annotation AND description is the current content
			$entity->description = $description;
			$entity->annotate('page', $description, $entity->access_id);
			$entity->save();
			break;
		
		// Blog, bookmarks, file : description
		case 'blog':
			// For blogs, the annotation keeps track of previous description
			$entity->annotate('blog_revision', $entity->description);
			$entity->description = $description;
			$entity->save();
			break;
		
		// Other subtypes : we do not want to handle them (no history)
		case 'bookmarks':
		case 'file':
		// Default : should we do anything if we're not sure ?
		default:
			return false;
	}
	
	return true;
}



