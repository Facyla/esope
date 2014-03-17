<?php
/**
 * notification_messages plugin
 *
 */

elgg_register_event_handler('init', 'system', 'notification_messages_init'); // Init


/**
 * Init adf_notification_messages plugin.
 */
function notification_messages_init() {
	global $CONFIG;
	
	elgg_register_plugin_hook_handler('notify:entity:subject', 'object', 'notification_messages_notify_subject');
	
}


// Guess best subtype title depending on defined translation strings
function notification_messages_readable_subtype($subtype) {
	$msg_subtype = elgg_echo('item:object:'.$subtype);
	if ($msg_subtype == 'item:object:'.$subtype) {
		$msg_subtype = elgg_echo($subtype);
	}
	return $msg_subtype;
}


/**
* Returns a more meaningful message for objects notifications
* 
* Notes :
* Target mask is : [subtype container] Title
* This provides best structure for handling discussions in most email clients
* We don't really need to tell if it's a new publication or not, 
*   as long as we can follow the activity on this particular topic
* Also only handle notifications that are sent, so use a comprehensive approach to determine best subject
* 
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function notification_messages_notify_subject($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (elgg_instanceof($entity, 'object')) {
		$subtype = $entity->getSubtype();
		
		// Determine behaviour - default is not changing anything (can be already specific)
		$setting = elgg_get_plugin_setting('object_' . $subtype, 'notification_messages');
		if (empty($setting)) $setting == 'default';
		switch ($setting) {
			case 'deny':
				// Break notification process before sending
				return true;
				break;
			case 'allow':
				// Keep going => update subject
				break;
			case 'default':
				return $returnvalue;
				break;
		}
		
		// Get best readable subtype
		$msg_subtype = notification_messages_readable_subtype($subtype);
		
		// Get best non-empty title
		$msg_title = $entity->title;
		if (empty($msg_title)) { $msg_title = $entity->name; }
		if (empty($msg_title)) { $msg_title = elgg_get_excerpt($entity->description, 25); }
		// If still nothing, fail-safe to untitled
		if (empty($msg_title)) { $msg_title = elgg_echo('notification_messages:untitled'); }
		
		// Container should be a group or user, can also be a site
		$container = $entity->getContainerEntity();
		if (elgg_instanceof($container, "user") || elgg_instanceof($container, "group")) { $msg_container = $container->name; }
		
		/* Owner should be used for Sender name (using site email)
		$owner = $entity->getOwnerEntity();
		$msg_owner = $owner->name;
		*/
		
		// Use new subject structure : [subtype container] Title
		$returnvalue = elgg_echo('notification_messages:objects:subject', array($msg_subtype, $msg_container, $msg_title));
		
	}
	
	// Return default or updated subject
	return $returnvalue;
}
