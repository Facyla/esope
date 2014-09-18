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




/* Create pad and apply some access controls over it
 * $padName : pad name
 * $groupName : false / group name - corresponds to Elgg container_guid (user, group, object)
 * $public : false / true
 * $password : password / false / null
 */
function elgg_etherpad_create_pad($padName, $groupName = false, $public = null, $password = null) {
	$client = elgg_etherpad_get_client();
	
	// Create pad
	if ($groupName) {
		// Get group ID from name
		$response = $client->createGroupIfNotExistsFor($groupName);
		$groupID = elgg_etherpad_get_response_data($response, 'groupID');
		// Create pad in group
		$response = $client->createGroupPad($groupID, $padName);
		if ($response->code > 0) return false;
		$padID = $groupID . '$' . $padName;
	} else {
		$response = $client->createPad($padName);
		if ($response->code > 0) return false;
		$padID = $padName;
	}
	
	// Apply access controls
	elgg_etherpad_set_pad_access($padID, $public, $password);
	
	return $padID;
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


/* Add a session to Etherpad session cookie for a given group
 * Note that domain MUST be the same for the cookie to be set
 * Also note that $validUntil param doesn't renew the sessions ! (which are set on Etherpad Lite side)
 * But it must last at least as long as the longuest EPL session...
 */
function elgg_etherpad_update_session($sessionID, $validUntil = 43200) {
	$cookiedomain = elgg_get_plugin_setting('cookiedomain', 'elgg_etherpad');
	if (!$cookiedomain) $cookiedomain = parse_url(elgg_get_site_url(), PHP_URL_HOST);
	
	// Check domain validity : the cookie domain should be the same, or the top domain of current site (sub)domain
	if (strpos(elgg_get_site_url(), $cookiedomain) === false) { return false; }

	$sessions = array();
	// Get existing sessions
	if ($_COOKIE['sessionID']) { $sessions = explode(',', $_COOKIE['sessionID']); }
	
	// Check if the session id is there, and add it if not
	if (in_array($sessionID, $sessions)) {
		return true;
	} else {
		$sessions[]= $sessionID;
		$sessionIDs = implode(',', $sessions);
		if (setcookie('sessionID', $sessionIDs, $validUntil, '/', $cookiedomain)) return true;
	}
	// If we got there, cookie could not be set..
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
	if ($response->code > 0) return false;
	//print_r($response);
	
	// @TODO : test locally before going live !!
	// Save it to target entity
	// Note : handle only subtypes we're sure of
	$subtype = $entity->getSubtype();
	switch($subtype) {
		// Pages : annotation
		case 'page':
		case 'page_top':
			//$object->annotate('page', $description, $object->access_id);
			break;
		
		// Blog, bookmarks, file : description
		case 'blog':
			// @TODO : blog should keep history...
			//$object->annotate('blog_revision', $object->description);
		case 'bookmarks':
		case 'file':
			//$object->description = $description;
			break;
		
		// Default : should we do anything if we're not sure ?
		default:
			return false;
	}
	
	return true;
}



