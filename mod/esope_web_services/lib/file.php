<?php
/**
 * Elgg Webservices plugin 
 * 
 * @package Webservice
 * @author Mark Harding
 *
 */

/**
 * Web service to get file list by all users
 *
 * @param string $context eg. all, friends, mine, groups
 * @param int $limit  (optional) default 10
 * @param int $offset (optional) default 0
 * @param int $group_guid (optional)  the guid of a group, $context must be set to 'group'
 * @param string $username (optional) the username of the user default loggedin user
 *
 * @return array $file Array of files uploaded
 */
function file_get_files($context,  $limit = 10, $offset = 0, $group_guid, $username) {
	if(!$username) {
		$user = elgg_get_logged_in_user_entity();
	} else {
		$user = get_user_by_username($username);
		if (!$user) {
			throw new InvalidParameterException('registration:usernamenotvalid');
		}
	}
		
	if($context == "all"){
	$params = array(
		'types' => 'object',
		'subtypes' => 'file',
		'limit' => $limit,
		'full_view' => FALSE,
	);
	}
	if($context == "mine" || $context == "user"){
	$params = array(
		'types' => 'object',
		'subtypes' => 'file',
		'owner_guid' => $user->guid,
		'limit' => $limit,
		'full_view' => FALSE,
	);
	}
	if($context == "group"){
	$params = array(
		'types' => 'object',
		'subtypes' => 'file',
		'container_guid'=> $group_guid,
		'limit' => $limit,
		'full_view' => FALSE,
	);
	}
	$latest_file = elgg_get_entities($params);
	
	if($context == "friends"){
		$latest_file = get_user_friends_objects($user->guid, 'file', $limit, $offset);
	}
	
	
	if($latest_file) {
		foreach($latest_file as $single ) {
			$file['guid'] = $single->guid;
			$file['title'] = $single->title;
			
			$owner = get_entity($single->owner_guid);
			$file['owner']['guid'] = $owner->guid;
			$file['owner']['name'] = $owner->name;
			$file['owner']['avatar_url'] = $owner->getIconURL('small');
			
			$file['container_guid'] = $single->container_guid;
			$file['access_id'] = $single->access_id;
			$file['time_created'] = (int)$single->time_created;
			$file['time_updated'] = (int)$single->time_updated;
			$file['last_action'] = (int)$single->last_action;
			$file['MIMEType'] = $single->mimetype;
			$file['file_icon'] = $single->getIconURL('small');
			$return[] = $file;
		}
	}
	else {
		$msg = elgg_echo('file:none');
		throw new InvalidParameterException($msg);
	}
	return $return;
}

expose_function('file.get_files',
	"file_get_files",
	array(
		'context' => array ('type' => 'string', 'required' => false, 'default' => 'all'),
		'limit' => array ('type' => 'int', 'required' => false, 'default' => 10),
		'offset' => array ('type' => 'int', 'required' => false, 'default' => 0),
		'group_guid' => array ('type'=> 'int', 'required'=>false, 'default' =>0),
		'username' => array ('type' => 'string', 'required' => false),
	),
	elgg_echo('web_services:file:get_files'),
	'GET',
	true,
	true
);


function file_get_info($guid) {
	$file = get_entity($guid);
	if (!elgg_instanceof($file, 'object', 'file')) {
		$return['content'] = elgg_echo('web_services:file:not_found');
		return $return;
	}
	$return['name'] = $file->getFilename();
	$return['title'] = $file->get('title');
	$return['description'] = $file->get('description');
	$return['mimeType'] = $file->getMimeType();
	$return['size'] = $file->size();
	$return['time_created'] = (int)$file->time_created;

	$owner = get_entity($file->owner_guid);
	$return['owner']['guid'] = $owner->guid;
	$return['owner']['name'] = $owner->name;
	$return['owner']['username'] = $owner->username;
	$return['owner']['avatar_url'] = $owner->getIconURL('small');
	return $return;
}

expose_function('file.get_info',
	"file_get_info",
	array(
		'guid' => array ('type'=> 'int', 'required'=>false, 'default' =>0),
		),
	elgg_echo('web_services:file:get_info'),
	'POST',
	true,
	true
);


function file_get_file($guid) {
	$file = get_entity($guid);
	if (!elgg_instanceof($file, 'object', 'file')) {
		$return['content'] = elgg_echo('web_services:file:not_found');
		return $return;
	}
	$return['content'] = base64_encode($file->grabFile());
	return $return;
}

expose_function('file.get_file',
	"file_get_file",
	array(
		'guid' => array ('type'=> 'int', 'required'=>false, 'default' =>0),
		),
	elgg_echo('web_services:file:get_content'),
	'POST',
	true,
	true
);
