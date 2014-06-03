<?php
/**
 * Action for adding a wire post
 * 
 */

// don't filter since we strip and filter escapes some characters
$body = get_input('body', '', false);

$access_id = 1; // Niveau d'accès réservé Membres
$method = 'site';
$parent_guid = (int) get_input('parent_guid');

// Niveau d'accès associé à un groupe
$group_guid = (int) get_input('group_guid');;
/*
if ($group_guid) {
	$group = get_entity($group_guid);
	//$access_id = $group->group_acl;
	register_error("Groupe {$group->name} : $access_id = {$group->group_acl}");
}
*/
// Niveau d'accès manuel
$access_id = (int) get_input('access_id', 1);

if ($parent_guid) {
	$parent = get_entity($parent_guid);
	$access_id = $parent->access_id;
	//register_error("Parent {$parent->title} : $access_id = {$parent->access_id}");
}


// make sure the post isn't blank
if (empty($body)) {
	register_error(elgg_echo("thewire:blank"));
	forward(REFERER);
}

$guid = thewire_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method);
if (!$guid) {
	register_error(elgg_echo("thewire:error"));
	forward(REFERER);
}

system_message(elgg_echo("thewire:posted"));

// Send response to original poster if not already registered to receive notification
if ($parent_guid) {
	thewire_send_response_notification($guid, $parent_guid, $user);
	forward("thewire/thread/$parent->wire_thread");
}

forward(REFERER);

