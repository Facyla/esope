<?php
/**
 * prevent_notificationss
 *
 */

elgg_register_event_handler('init', 'system', 'prevent_notifications_init'); // Init


/**
 * Init prevent_notifications plugin.
 */
function prevent_notifications_init() {
  global $CONFIG;
  // Hook pour bloquer les notifications si on a demandé à les désactiver
  elgg_register_plugin_hook_handler('object:notifications', 'all', 'prevent_notifications_object_notifications_disable', 1000);
}

function prevent_notifications_object_notifications_disable($hook, $entity_type, $returnvalue, $params) {
	$send_notification = get_input('send_notification', 'yes');
	if ($send_notification == 'no') {
		// Don't notify
		system_messages("Aucune notification envoyée.");
		return true;
	}
	// Don't change default behaviour
	return $returnvalue;
}



