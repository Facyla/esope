<?php
/**
 * Edit edit members properties
 */

gatekeeper();
action_gatekeeper();

// Restriction de l'édition aux profils autorisés
$editor_profile_type = dossierdepreuve_get_user_profile_type(elgg_get_logged_in_user_entity());
if (!in_array($editor_profile_type, array('learner', 'tutor', 'evaluator', 'organisation', 'other_administrative')) && !elgg_is_admin_logged_in()) {
	register_error(elgg_echo('dossierdepreuve:error:cantedit'));
	forward(REFERER);
}

// Get vars
$user_guid = get_input('user_guid', false);
$field = get_input('field', false);
$value = get_input('field_value', false);


if (!$user_guid || !$field || (is_null($value))) {
	register_error(elgg_echo('dossierdepreuve:error:invaliduser'));
	forward(REFERER);
}

if ($user = get_entity($user_guid)) {
	if ($editor_profile_type == 'learner') {
		if ($user_guid != elgg_get_logged_in_user_guid()) {
				register_error(elgg_echo('dossierdepreuve:error:ownonly'));
				forward(REFERER);
		}
	}
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
	register_error(elgg_echo('dossierdepreuve:error:invaliduser'));
	forward(REFERER);
}

