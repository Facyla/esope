<?php
/**
 * Edit members properties
 *
 * @package ElggPages
 */
project_manager_gatekeeper();
project_manager_manager_gatekeeper();
action_gatekeeper();

//admin_gatekeeper();

// Get vars
$user_guid = get_input('user_guid', false);
$field = get_input('field', false);
$value = get_input('field_value', false);

if (!$user_guid || !$field || (is_null($value))) {
	register_error(elgg_echo('project_manager:error:invaliduser'));
	forward(REFERER);
}

if ($user = get_entity($user_guid)) {
	$user->$field = $value;
	//$user->save();
	echo json_encode(array(
			"result" => "true", 
			"user_guid" => $user->guid, 
			"field" => $field, 
			"value" => $value, 
		));
	exit();
} else {
	register_error(elgg_echo('project_manager:error:invaliduser'));
	forward(REFERER);
}

