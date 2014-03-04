<?php
/**
 * prevent_notificationss
 *
 */

elgg_register_event_handler('init', 'system', 'prevent_notifications_init'); // Init

// @TODO : add a more flexible way to add prevent field to forms, 
// using e.g. forms extension + objects registered for notifications


/**
 * Init prevent_notifications plugin.
 */
function prevent_notifications_init() {
	global $CONFIG;
	// Hook pour bloquer les notifications si on a demandé à les désactiver
	// Note : load at first, because we want to block the process early, if it needs to be blocked
	// See html_email_handler :
	// Facyla : warning, if a plugin hook returned "true" (e.g. for blocking notification process), this won't be handled, so we should check it before going through the whole process !!
	elgg_register_plugin_hook_handler('object:notifications', 'all', 'prevent_notifications_object_notifications_disable', 1);
}

function prevent_notifications_object_notifications_disable($hook, $entity_type, $returnvalue, $params) {
	$send_notification = get_input('send_notification', 'yes');
	if ($send_notification == 'no') {
		// Don't notify
		$msg = elgg_echo('prevent_notifications:notsent');
		system_messages($msg);
		return true;
	}
	// Don't change default behaviour
	return $returnvalue;
}



