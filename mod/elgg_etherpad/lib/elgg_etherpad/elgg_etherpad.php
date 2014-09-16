<?php
include 'EtherpadLiteClient.php';


function elgg_etherpad_view_response($response) {
	$content = false;
	if ($response) {
		$content = '<pre>' . print_r($response, true) . '</pre>';
	}
	return $content;
}

function elgg_etherpad_get_response_data($response, $key = false) {
	$return = false;
	if ($response) {
		$return = $response->data;
		if ($key) { $return = $return->$key; }
	}
	return $return;
}

/* Creates a new EtherpadLiteClient */
function elgg_etherpad_get_client() {
	$server = elgg_get_plugin_setting('server', 'elgg_etherpad');
	$api_key = elgg_get_plugin_setting('api_key', 'elgg_etherpad');
	$client = new EtherpadLiteClient($api_key, $server.'/api');
	return $client;
}




/* Create pad and apply some access controls over it
 * $groupName : false / group name
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


/* Set pad access : visibility and password
 * $public : false / true / null
 * $password : password / false / null
 */
function elgg_etherpad_set_pad_access($padID, $public = null, $password = null) {
	$return = true;
	$client = elgg_etherpad_get_client();
	
	// Set public status
	if ($public !== NULL) {
		if ($public) $response = $client->setPublicStatus($padID, 'true');
		else $response = $client->setPublicStatus($padID, 'false');
		if ($response->code > 0) $return = false;
		//print_r($response);
	}
	
	// Set password
	if ($password !== NULL) {
		if (!$password) $password = '';
		$response = $client->setPassword($padID, $password);
		if ($response->code > 0) $return = false;
		//print_r($response);
	}
	
	return $return;
}


/* Checks if pad is public */
function elgg_etherpad_is_public($padID) {
	$client = elgg_etherpad_get_client();
	$response = $client->getPublicStatus($padID);
	$publicStatus = elgg_etherpad_get_response_data($response, 'publicStatus');
	//print_r($response);
	if ($response->code > 0) return false;
	if (empty($publicStatus)) $publicStatus = 'false';
	return $publicStatus;
}

/* Checks if pad is password protected */
function elgg_etherpad_is_password_protected($padID) {
	$client = elgg_etherpad_get_client();
	$response = $client->isPasswordProtected($padID);
	$isPasswordProtected = elgg_etherpad_get_response_data($response, 'isPasswordProtected');
	//print_r($response);
	if ($response->code > 0) return false;
	if ($isPasswordProtected == '1') $isPasswordProtected = 'true';
	if (empty($isPasswordProtected)) $isPasswordProtected = 'false';
	return $isPasswordProtected;
}


