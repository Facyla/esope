<?php
/**
* Elgg time_tracker delete
* 
* @package ElggProjectManager
*/

//error_log("DEBUG delete time_tracker : ");
gatekeeper();
//error_log("DEBUG delete time_tracker : gate OK");

$guid = (int) get_input('time_tracker');
$user = elgg_get_logged_in_user_entity();

if ($time_tracker = get_entity($guid)) {
//error_log("DEBUG delete time_tracker : entity OK");
	// Auteur ou admin seulement
	if (($time_tracker->owner_guid == $user->guid) || elgg_is_admin_logged_in()) {
		//error_log("DEBUG delete time_tracker : valid user OK");
		if ($time_tracker->delete()) {
			system_message(elgg_echo("time_tracker:deleted"));
		} else {
			register_error(elgg_echo("time_tracker:deletefailed"));
		}
	} else {
		register_error(elgg_echo('time_tracker:error:invaliduser'));
		forward(REFERER);
	}
} else { register_error(elgg_echo("time_tracker:deletefailed")); }

forward(REFERER);

