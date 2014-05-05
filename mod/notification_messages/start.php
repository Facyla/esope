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
	
	// OBJECTS
	// Handle new (registered) objects notification subjects
	elgg_register_plugin_hook_handler('notify:entity:subject', 'object', 'notification_messages_notify_subject');
	
	
	// FORUM REPLIES
	$groupforumtopic = elgg_get_plugin_setting('object_groupforumtopic', 'notification_messages');
	if ($groupforumtopic == 'allow') {
		// Some advanced_notifications features are limiting flexibility, so unregister them first
		if (elgg_is_active_plugin('advanced_notifications')) {
			// Forum topic reply subject
			elgg_unregister_plugin_hook_handler("notify:annotation:subject", "group_topic_post", "advanced_notifications_discussion_reply_subject_hook");
		}
		// Handle forum topic replyu subject
		elgg_register_plugin_hook_handler("notify:annotation:subject", "group_topic_post", "notification_messages_reply_subject_hook");
	}
	
	
	// GENERIC COMMENTS
	// Some advanced_notifications features are limiting flexibility, so unregister them first
	if (elgg_is_active_plugin('advanced_notifications')) {
		elgg_unregister_plugin_hook_handler("action", "comments/add", "advanced_notifications_comment_action_hook");
	}
	// Handle generic comments notifications actions and notification
	elgg_register_plugin_hook_handler("action", "comments/add", "notification_messages_comment_action_hook");
	
	// register a hook to add a new hook that allows adding attachments and other params
	// Note : enabled by default because it was previously embedded in html_email_handler, 
	// but is required by notifications messages
	if (elgg_get_plugin_setting("object_notifications_hook", "notification_messages") != "no"){
		elgg_register_plugin_hook_handler('object:notifications', 'all', 'notification_messages_object_notifications_hook');
	}
	
	
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
		$setting = notification_messages_get_subtype_setting($subtype);
		switch ($setting) {
			case 'allow':
				// Keep going => update subject
				break;
			case 'deny':
				// Break notification process before sending
				return true;
				break;
			case 'default':
				return $returnvalue;
		}
		
		// Build new subject
		$returnvalue = notification_messages_build_subject($entity);
		
		// Encode in UTF-8 so we have best subject title support ? @TODO : not working at all !
		//$returnvalue = '=?utf-8?B?'.base64_encode($returnvalue).'?=';
	}
	
	// Return default or updated subject
	return $returnvalue;
}


/* Determine setting for this entity type */
function notification_messages_get_subtype_setting($subtype = '') {
	$setting = elgg_get_plugin_setting('object_' . $subtype, 'notification_messages');
	if (empty($setting)) $setting == 'default';
	return $setting;
}


/* Build subject based on notified entity
 * Use new subject structure : [container | subtype] Title
 * or when no container : [subtype] Title
 */
function notification_messages_build_subject($entity) {
	if (elgg_instanceof($entity)) {
		// Get best readable subtype
		$subtype = $entity->getSubtype();
		$msg_subtype = notification_messages_readable_subtype($subtype);
	
		// Container should be a group or user, can also be a site
		$msg_container = '';
		$container = $entity->getContainerEntity();
		if (elgg_instanceof($container, "user") || elgg_instanceof($container, "group") || elgg_instanceof($container, "site")) { $msg_container = $container->name; }
	
		/* @TODO Owner should be used for Sender name (using site email, not here)
		$owner = $entity->getOwnerEntity();
		$msg_owner = $owner->name;
		*/
	
		// Get best non-empty title
		$msg_title = $entity->title;
		if (empty($msg_title)) { $msg_title = $entity->name; }
		if (empty($msg_title)) { $msg_title = elgg_get_excerpt($entity->description, 25); }
		// If still nothing, fail-safe to untitled
		if (empty($msg_title)) { $msg_title = elgg_echo('notification_messages:untitled'); }
	
		if (empty($msg_container)) {
			return elgg_echo('notification_messages:objects:subject:nocontainer', array($msg_subtype, $msg_title));
		} else {
			return elgg_echo('notification_messages:objects:subject', array($msg_container, $msg_subtype, $msg_title));
		}
	}
	return false;
}


// Handle group topic reply subject hook
function notification_messages_reply_subject_hook($hook, $type, $returnvalue, $params) {
	$entity_guid = $params['annotation']->entity_guid;
	if ($entity_guid && ($entity = get_entity($entity_guid))) {
		$subject = notification_messages_build_subject($entity);
		if (!empty($subject)) $returnvalue = $subject;
	}
	return $returnvalue;
}


/* Override default action only if enabled */
function notification_messages_comment_action_hook($hooks, $type, $returnvalue, $params) {
	$generic_comment = elgg_get_plugin_setting('generic_comment', 'notification_messages');
	switch ($generic_comment) {
		case 'allow':
			include(dirname(__FILE__) . "/actions/comments/add.php");
			// Block process because we don't want to be notified twice
			return false;
			break;
		case 'deny':
			// Break notification process before sending
			return false;
			break;
	}
	return $returnvalue;
}


/**
 * Automatically triggered notification on 'create' events that looks at registered
 * objects and attempts to send notifications to anybody who's interested
 *
 * @see register_notification_object
 *
 * @param string $event       create
 * @param string $object_type mixed
 * @param mixed  $object      The object created
 *
 * @return bool
 * @access private
 */
/* Note : this hook is used to add a new hook that let's plugins set $params 
 * This makes it easy for plugins to add attachments
 * (Note : this is more generic to support further settings (just in case...)
 * Use : return $options['attachments'] = $attachments
 * With $attachments being an array of file attachments :
 * $attachments[] = array(
 * 		'content' => $file_content, // File content
 * 		'filepath' => $file_content, // Alternate file path for file content retrieval
 * 		'filename' => $file_content, // Attachment file name
 * 		'mimetype' => $file_content, // MIME type of attachment
 * 	);
 */
function notification_messages_object_notifications_hook($hook, $entity_type, $returnvalue, $params) {
	// Get config data
	global $CONFIG, $SESSION, $NOTIFICATION_HANDLERS;

	// Facyla : warning, if a plugin hook returned "true" (e.g. for blocking notification process), 
	// this wouldn't be handled, so we should check it before going through the whole process !!
	if ($returnvalue === true) return true;

	$event = $params['event'];
	$object = $params['object'];
	$object_type = $params['object_type'];

	// Have we registered notifications for this type of entity?
	$object_type = $object->getType();
	if (empty($object_type)) {
		$object_type = '__BLANK__';
	}

	$object_subtype = $object->getSubtype();
	if (empty($object_subtype)) {
		$object_subtype = '__BLANK__';
	}

	if (isset($CONFIG->register_objects[$object_type][$object_subtype])) {
		$subject = $CONFIG->register_objects[$object_type][$object_subtype];
		$string = $subject . ": " . $object->getURL();

		// Get users interested in content from this person and notify them
		// (Person defined by container_guid so we can also subscribe to groups if we want)
		foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
			$interested_users = elgg_get_entities_from_relationship(array(
				'site_guids' => ELGG_ENTITIES_ANY_VALUE,
				'relationship' => 'notify' . $method,
				'relationship_guid' => $object->container_guid,
				'inverse_relationship' => TRUE,
				'type' => 'user',
				'limit' => false
			));
			/* @var ElggUser[] $interested_users */

			if ($interested_users && is_array($interested_users)) {
				foreach ($interested_users as $user) {
					if ($user instanceof ElggUser && !$user->isBanned()) {
						if (($user->guid != $SESSION['user']->guid) && has_access_to_entity($object, $user)
						&& $object->access_id != ACCESS_PRIVATE) {
							$body = elgg_trigger_plugin_hook('notify:entity:message', $object->getType(), array(
								'entity' => $object,
								'to_entity' => $user,
								'method' => $method), $string);
							if (empty($body) && $body !== false) {
								$body = $string;
							}
							
							// this is new, trigger a hook to make a custom subject
							$new_subject = elgg_trigger_plugin_hook("notify:entity:subject", $object->getType(), array(
								"entity" => $object,
								"to_entity" => $user,
								"method" => $method), $subject);
							// Keep new value only if correct subject
							if (!empty($new_subject)) { $subject = $new_subject; }
							
							// Params hook : see doc above
							$options = elgg_trigger_plugin_hook('notify:entity:params', $object->getType(), array(
								'entity' => $object,
								'to_entity' => $user,
								'method' => $method), null);
							
							if ($body !== false) {
								notify_user($user->guid, $object->container_guid, $subject, $body,
									$options, array($method));
							}
						}
					}
				}
			}
		}
	}
	// Stop notifications here once done
	return true;
}



