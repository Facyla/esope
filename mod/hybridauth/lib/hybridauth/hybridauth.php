<?php

// These functions are helpers for interacting with Elgg
// Main lib is included (as is) in vendors folder

// Creates a user out of some Hybridauth info -not really useful...
function hybridauth_create_user($params) {
	//create_user_entity($guid, $name, $username, $password, $salt, $email, $language, $code);
	return false;
}


// Updates a user photo from a photo URL
function hybridauth_update_avatar($img_url, $user) {
	
	if (elgg_instanceof($user, 'user') && !empty($img_url)) {
		$sizes = array(
			'topbar' => array(16, 16, TRUE),
			'tiny' => array(25, 25, TRUE),
			'small' => array(40, 40, TRUE),
			'medium' => array(100, 100, TRUE),
			'large' => array(200, 200, FALSE),
			'master' => array(550, 550, FALSE),
		);

		$filehandler = new ElggFile();
		$filehandler->owner_guid = $user->guid;
		foreach ($sizes as $size => $dimensions) {
			$image = get_resized_image_from_existing_file($img_url, $dimensions[0], $dimensions[1], $dimensions[2]);
			$filehandler->setFilename("profile/{$user->guid}{$size}.jpg");
			$filehandler->open('write');
			$filehandler->write($image);
			$filehandler->close();
		}
		$user->icontime = time(); 
		
	} else return false;
	return true;
}


// Update specific user details
// $params = array('field' => 'field_value')
function hybridauth_update_user_details($fields, $user) {
	if (elgg_instanceof($user, 'user')) {
		foreach ($fields as $key => $value) {
			$user->{$fields} = $value;
		}
	} else return false;
	return true;
}




