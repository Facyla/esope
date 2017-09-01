<?php
// This sidebar block is disabled by au_subgroups (which rewrites group profile handler)
// So let's add it again here

$entity = $vars['entity'];

$subscribed = false;
if (elgg_is_active_plugin('notifications')) {
	global $NOTIFICATION_HANDLERS;
	foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
		$relationship = check_entity_relationship(elgg_get_logged_in_user_guid(), 'notify' . $method, $entity->guid);
		if ($relationship) {
			$subscribed = true;
			break;
		}
	}
}

/*
echo elgg_view('groups/sidebar/my_status', array(
	'entity' => $entity,
	'subscribed' => $subscribed
));
*/

