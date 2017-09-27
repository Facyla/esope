<?php
gatekeeper();
// Note : use same logic as https://github.com/juho-jaakkola/elgg-favorites so can update the favorite plugin someday

// Get variables
$guid = get_input('guid');
$entity = get_entity($guid);

$user = elgg_get_logged_in_user_entity();
$user_guid = elgg_get_logged_in_user_guid();


if (elgg_instanceof($entity)) {
	if (check_entity_relationship($guid, 'favorite', $user_guid)) {
		if (remove_entity_relationship($guid, 'favorite', $user_guid)) {
			system_message(elgg_echo("favorite:removed"));
		} else {
			register_error(elgg_echo("favorite:remove:error"));
		}
	} else {
		if (add_entity_relationship($guid, 'favorite', $user_guid)) {
			system_message(elgg_echo("favorite:added"));
		} else {
			register_error(elgg_echo("favorite:add:error"));
		}
	}
} else {
	register_error('favorite:invalidentity');
}

forward(REFERER);

