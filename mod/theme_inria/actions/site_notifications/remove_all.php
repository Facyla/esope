<?php
gatekeeper();

// Get variables

$user = elgg_get_logged_in_user_entity();

$all_notifications = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'site_notification',
	'owner_guid' => $user->guid,
	'metadata_name' => 'read',
	'metadata_value' => false,
	'limit' => false,
));

foreach($all_notifications as $ent) {
	$ent->read = true;
}

/*
if (elgg_instanceof($user, 'user') && !($user->isAdmin()) && ($user->membertype != 'inria')) {
	system_message(elgg_echo("theme_inria:archiveuser:ok"));
} else {
	register_error(elgg_echo("theme_inria:archiveuser:error"));
}
*/

forward(REFERER);

