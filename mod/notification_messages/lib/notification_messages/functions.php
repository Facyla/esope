<?php
/**
 * notification_messages functions
 *
 */

/* 0. PLUGIN SETTINGS */

/**
 * Saves the plugin settings.
 *
 * @param type $hook
 * @param type $type
 * @param type $value
 * @param type $params
 */
function notification_messages_plugin_settings($hook, $type, $value, $params) {
	$plugin_id = get_input('plugin_id');
	if ($plugin_id != 'notification_messages') { return $value; }

	$plugin = elgg_get_plugin_from_id($plugin_id);
	
	//$params = get_input('params');
	
	// get registered objects
	$objects = get_registered_entity_types('object');
	foreach($objects as $subtype) {
		// Save registered notificaiton events
		$value = (array)get_input("register_object_{$subtype}");
		$register_object_subtypes[$subtype] = $value;
		elgg_set_plugin_setting("register_object_{$subtype}", implode(',', $value), 'notification_messages');
		//echo $subtype . '<pre>' . print_r(get_input("register_object_{$subtype}"), true) . '</pre>';
		// Add setting to global config of prepared notifications
		
	}
	
	// Use complete PHP array setting so we need 1 single DB call...
	$register_object_subtypes = serialize($register_object_subtypes);
	elgg_set_plugin_setting('register_object_subtypes', $register_object_subtypes, 'notification_messages');
	
	// Also save basic settings (as we override, they won't be saved otherwise)
	$params = get_input('params');
	foreach($params as $param => $value) {
		elgg_set_plugin_setting($param, $value, 'notification_messages');
	}
	
	$plugin->save();
	
	forward(REFERER);
}



/* 1. REGISTER NOTIFICATIONS EVENTS */



/* 2. PREPARE NOTIFICATIONS CONTENT */

/* Determine setting for this particular object subtype */
function notification_messages_get_subtype_setting($subtype = '') {
	$setting = elgg_get_plugin_setting('object_' . $subtype, 'notification_messages');
	if (empty($setting)) { $setting == 'default'; }
	return $setting;
}

// Guess best subtype title depending on defined translation strings
function notification_messages_readable_subtype($subtype) {
	$msg_subtype = elgg_echo("item:object:$subtype");
	if ($msg_subtype == "item:object:$subtype") {
		$msg_subtype = elgg_echo($subtype);
	}
	return strip_tags($msg_subtype);
}


// Handle group topic reply subject hook
function notification_messages_reply_subject_hook($hook, $type, $returnvalue, $params) {
	$entity_guid = $params['annotation']->entity_guid;
	if ($entity_guid) {
		$entity = get_entity($entity_guid);
		if (elgg_instanceof($entity)) {
			$subject = notification_messages_build_subject($entity);
			if (!empty($subject)) { $returnvalue = $subject; }
		}
	}
	return $returnvalue;
}


/* Override default action only if enabled */
function notification_messages_comment_action_hook($hooks, $type, $returnvalue, $params) {
	$generic_comment = elgg_get_plugin_setting('generic_comment', 'notification_messages');
	switch ($generic_comment) {
		case 'allow':
			include(dirname(__FILE__) . "/actions/comments/save.php");
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

// Core function override : Override system default comment email subject (forces full subject instead of adding Re:)
function notification_messages_comments_notification_email_subject($hook, $type, $returnvalue, $params) {
	if (!is_array($returnvalue)) {
		// another hook handler returned a non-array, let's not override it
		return;
	}
	/** @var Elgg\Notifications\Notification */
	$notification = elgg_extract('notification', $params['params']);
	if ($notification instanceof Elgg\Notifications\Notification) {
		$object = elgg_extract('object', $notification->params);
		if ($object instanceof ElggComment) {
			$container = $object->getContainerEntity();
			$new_subject = notification_messages_build_subject($object, $notification->params);
			if (!empty($new_subject)) {
				$returnvalue['params']['notification']->subject = $new_subject;
				//$returnvalue['subject'] = 'Re: ' . $new_subject;
			} else {
				$returnvalue['params']['notification']->subject = 'Re: ' . $container->getDisplayName();
			}
		}
	}
	return $returnvalue;
}


/**
 * Prepare a notification message about a new object (or comment)
 * 
 * Notes :
 * Target mask is : [subtype container] Title
 * This provides best structure for handling discussions in most email clients
 * We don't really need to tell if it's a new publication or not, 
 *   as long as we can follow the activity on this particular topic
 * Also only handle notifications that are sent, so use a comprehensive approach to determine best subject
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg_Notifications_Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg_Notifications_Notification
 */
function notification_messages_prepare_notification($hook, $type, $notification, $params) {
	$debug = false;
	
	$entity = $params['event']->getObject();
	$author = $params['event']->getActor();
	$action = $params['event']->getAction();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];
	
	if ($debug) error_log("NOT_MES functions.php : prepare hook for $action by $author->guid in $language using $method : $hook / $type");
	
	// @TODO adjust messages depending on events (create/publish/update/delete)
	
	// Note : we do not use behaviour setting anymore (update subject and content but do not block sending)
	// Determine behaviour - default is not changing anything (can be already specific)
	// $setting = notification_messages_get_subtype_setting($subtype);
	
	// Handle comments a bit differently (subject and summary should be based on original object)
	// This has to be handled in all 3 functions (because we need the acting entity too)
	
	// Notification subject
	$subject = notification_messages_build_subject($entity, $params, $action);
	if (!empty($subject)) {
		/*
		if (in_array($action, ['update', 'delete'])) {
			$subject = "[" . elgg_echo("notification_messages:$action") . "] $subject";
		}
		*/
		$notification->subject = $subject;
	}

	// Notification message body
	$body = notification_messages_build_body($entity, $params, $action);
	if (!empty($body)) {
		/*
		if (in_array($action, ['update', 'delete'])) {
			$body = "[" . elgg_echo("notification_messages:$action") . "]\r\n\r\n$body";
		}
		*/
		$notification->body = $body;
	}

	// Short summary about the notification
	$summary = notification_messages_build_summary($entity, $params, $action);
	if (!empty($summary)) {
		/*
		if (in_array($action, ['update', 'delete'])) {
			$summary = "[" . elgg_echo("notification_messages:$action") . "]\r\n\r\n$summary";
		}
		*/
		$notification->summary = $summary;
	}
	
	return $notification;
}


/* Build subject based on notified entity
 * Use new subject structure : [container | subtype] Title
 * or when no container : [subtype] Title
 * $entity : notified entity
 * $params : original hook $params
 * $action : notification event action (create|publish|update|delete)
 */
function notification_messages_build_subject($entity, $params = array(), $action = 'create') {
	if (elgg_instanceof($entity)) {
		//error_log(print_r($entity, true) . print_r($params, true));
		/*
		$owner = $params['event']->getActor();
		$recipient = elgg_extract('recipient', $params);
		$method = elgg_extract('method', $params, 'email');
		*/
		$language = get_current_language();
		$language = elgg_extract('language', $params, $language);
		
		// Get best readable subtype
		$subtype = $entity->getSubtype();
		$msg_subtype = notification_messages_readable_subtype($subtype);
		
		// Use original object instead, if commented or replied to
		$is_reply = false;
		if (elgg_instanceof($entity, 'object', 'comment')) {
			$is_reply = true;
			$entity = get_entity($entity->container_guid);
			$subtype = $entity->getSubtype();
			$msg_subtype = notification_messages_readable_subtype($subtype);
			// Update subtype text to "Comment on X" ?
			//$msg_subtype = elgg_echo('notification_messages:subject:comment', array($msg_subtype));
		} else if (elgg_instanceof($entity, 'object', 'discussion_reply')) {
			$is_reply = true;
			$entity = get_entity($entity->container_guid);
			$subtype = $entity->getSubtype();
			$msg_subtype = notification_messages_readable_subtype($subtype);
			// Update subtype to "Reply to X" ?
			//$msg_subtype = elgg_echo('notification_messages:subject:discussion_reply', array($msg_subtype));
		}
		
		// Container should be a group or user, can also be a site, and potentially an object (attached content)
		$msg_container = notification_messages_message_add_container($entity);
	
		/* @TODO Owner should be used for Sender name (using site email, not here)
		$owner = $entity->getOwnerEntity();
		$msg_owner = $owner->name;
		*/
	
		// Get best non-empty title
		$msg_title = $entity->title;
		if (empty($msg_title)) { $msg_title = $entity->name; }
		if (empty($msg_title)) { $msg_title = elgg_get_excerpt($entity->description, 25); }
		// If still nothing, fail-safe to untitled
		if (empty($msg_title)) { $msg_title = elgg_echo('notification_messages:untitled', $language); }
		// Strip optional tags or spaces
		$msg_title = trim(strip_tags($msg_title));
		
		// Handle when using a specific container
		if ($msg_container) {
			if (in_array($action, ['update', 'delete'])) {
				$subject = elgg_echo('notification_messages:objects:subject:' . $action, array($msg_container, $msg_subtype, $msg_title), $language);
			} else {
				$subject = elgg_echo('notification_messages:objects:subject', array($msg_container, $msg_subtype, $msg_title), $language);
			}
		} else {
			if (in_array($action, ['update', 'delete'])) {
				$subject = elgg_echo('notification_messages:objects:subject:nocontainer:' . $action, array($msg_subtype, $msg_title), $language);
			} else {
				$subject = elgg_echo('notification_messages:objects:subject:nocontainer', array($msg_subtype, $msg_title), $language);
			}
		}
		
		$subject = strip_tags($subject);
		
		// Add "Re: " (once) if reply ? (comment or discussion reply)
		if ($is_reply) {
			//$subject = elgg_echo('notification_messages:subject:reply', array($subject));
		}
		
		// Encode in UTF-8 so we have best subject title support ? @TODO : check before enabling !
		//$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
		
		return $subject;
	}
	return false;
}

// Notification summary
function notification_messages_build_summary($entity, $params = array(), $action = 'create') {
	if (elgg_instanceof($entity)) {
		$subject = notification_messages_build_subject($entity, $params, $action);
		// @TODO : add excerpt + URL
		/*
		$excerpt = elgg_get_excerpt($entity->description);
		$entity_url = $entity->getURL();
		$subject .= elgg_echo('notification_messages:summary:wrapper', array($excerpt, $entity_url));
		*/
		return $subject;
	}
	return false;
}

// Notification message body
function notification_messages_build_body($entity, $params = array(), $action = 'create') {
	if (elgg_instanceof($entity)) {
		
		$subtype = $entity->getSubtype();
		/*
		$allowed_subtypes = array('blog'); // Backward compat : at least for blog
		if (!in_array($subtype, $allowed_subtypes)) { return false; }
		*/
		// Get best readable subtype
		$msg_subtype = notification_messages_readable_subtype($subtype);
		
		//$owner = $params['event']->getActor();
		$owner = $entity->getOwnerEntity();
		//$recipient = $params['recipient']; // unused
		$language = $params['language'];
		//$method = $params['method']; // unused
		
		// Filtered tags for email notifications (text mostly)
		$allowed_tags = '<br><br/><p><a><ul><ol><li><strong><em><b><u><i><h1><h2><h3><h4><h5><h6><q><blockquote><code><pre>';
		
		// Handle replies : add excerpt of commented entity
		$is_reply = false;
		if (elgg_instanceof($entity, 'object', 'comment')) {
			$is_reply = true;
			$main_entity = get_entity($entity->container_guid);
			//$subtype = $main_entity->getSubtype();
			//$msg_subtype = notification_messages_readable_subtype($subtype);
			if (!empty($main_entity->excerpt)) {
				$reply_descr = $main_entity->excerpt;
			} else {
				$reply_descr = elgg_get_excerpt($main_entity->description);
			}
		} else if (elgg_instanceof($entity, 'object', 'discussion_reply')) {
			$is_reply = true;
			$main_entity = get_entity($entity->container_guid);
			//$subtype = $main_entity->getSubtype();
			//$msg_subtype = notification_messages_readable_subtype($subtype);
			if (!empty($main_entity->excerpt)) {
				$reply_descr = $main_entity->excerpt;
			} else {
				$reply_descr = elgg_get_excerpt($main_entity->description);
			}
		}
		
		// Add container message ?
		$msg_container = notification_messages_message_add_container($entity);
		
		switch($subtype) {
			case 'blog':
				$descr = '';
				if (!empty($entity->excerpt)) { $descr .= '<p><em>' . $entity->excerpt . '</em></p>'; }
				//$descr .= strip_tags($entity->description, $allowed_tags);
				$descr .= notification_messages_filter_text($entity->description);
				if (!empty($reply_descr)) { $descr = elgg_echo('notification_messages:body:inreplyto', array($descr, $reply_descr), $language); }
				$title = '<strong>' . $entity->title . '</strong>';
				$body = elgg_echo('blog:notify:body', array(
						$owner->name,
						$title,
						$descr,
						$entity->getURL()
					), $language);
				break;
				
			default:
				$descr = '';
				if (!empty($entity->excerpt)) { $descr .= '<p><em>' . $entity->excerpt . '</em></p>'; }
				//$descr .= strip_tags($entity->description, $allowed_tags);
				$descr .= notification_messages_filter_text($entity->description);
				if (!empty($reply_descr)) { $descr = elgg_echo('notification_messages:body:inreplyto', array($descr, $reply_descr), $language); }
				$title = $entity->title;
				if (empty($title)) { $title = $entity->name; }
				$title = '<strong>' . $title . '</strong>';
				if ($msg_container) {
					if (in_array($action, ['update', 'delete'])) {
						$body = elgg_echo('notification_messages:objects:body:' . $action, array(
								$owner->name,
								$title,
								$msg_container, 
								$descr,
								$entity->getURL()
							), $language);
					} else {
						$body = elgg_echo('notification_messages:objects:body', array(
								$owner->name,
								$title,
								$msg_container, 
								$descr,
								$entity->getURL()
							), $language);
					}
				} else {
					if (in_array($action, ['update', 'delete'])) {
						$body = elgg_echo('notification_messages:objects:body:nocontainer:' . $action, array(
								$owner->name,
								$title,
								$descr,
								$entity->getURL()
							), $language);
					} else {
						$body = elgg_echo('notification_messages:objects:body:nocontainer', array(
								$owner->name,
								$title,
								$descr,
								$entity->getURL()
							), $language);
					}
				}
		}
		
		return $body;
	}
	return false;
}

/* Prepare text content for HTML rendering in notifications
 * by converting plain text to HTML, removing newlines and carriage returns, and filtering the HTML
 * 
 * $string : text to be converted/filtered
 * $allowed_tags : concatenated list of HTML allowed tags. Use defined list to override defaults, true to skip
 */
function notification_messages_filter_text($string = '', $allowed_tags = null) {
	// Convert plain text to HTML if input did not use wysiwyg editor
	if($string == strip_tags($string)) {
		$string = elgg_autop($string);
	}
	
	// Remove any remaining \n or \r in HTML
	$string = str_replace(["\n", "\r", PHP_EOL], '', $string);
	
	// Filter HTML keeping only allowed tags
	if ($allowed_tags !== true) {
		// Set default filtered tags
		if ($allowed_tags !== false) {
			$allowed_tags = '<br><br/><p><a><ul><ol><li><strong><em><b><u><i><h1><h2><h3><h4><h5><h6><q><blockquote><code><pre>';
		}
		$string = strip_tags($string, $allowed_tags);
	}
	
	return $string;
}




/* 3. ADJUST RECIPIENTS
 * Note : core function remove author from recipients, so we need to add author afterwards, or send the notification separately
 * Design rule : never force if user is not suscribed to the (top level) container
 * - notify initial object owner on replies (if setting 'emailpersonal' is set)
 * - notify self (published object / reply author)
 * - notify replies the same way as initial entities (according to their own notification settings)
 * - notify discussion participants (can be not subscribed to group or member)
 */

// Should we also send notifications to the owner (of the comment) ?
function notification_messages_notify_owner() {
	$notify = false;
	
	// Setting is synchronized with comment_tracker's
	if (elgg_is_active_plugin('comment_tracker')) {
		$notify_owner = elgg_get_plugin_setting('notify_owner', 'comment_tracker');
	} else {
		$notify_owner = elgg_get_plugin_setting('notify_owner', 'notification_messages');
		// @TODO enable the 'emailpersonal' user setting too
	}
	if ($notify_owner == 'yes') { $notify = true; }
	
	// @TODO : should we force to true if using postbymail ?
	//if (elgg_is_active_plugin('postbymail')) { $notify = true; }
	
	return $notify;
}


// Should we also send notifications to the author (notify self)
function notification_messages_notify_self() {
	$notify_self = elgg_get_plugin_setting('notify_self', 'notification_messages');
	if ($notify_self == 'yes') { return true; }
	return false;
}



/**
 * Adjust subscribers
 * 
 * - notify initial object owner on replies (if setting 'emailpersonal' is set)
 * - notify self (published object / reply author)
 * - notify replies the same way as initial entities (according to their own notification settings) => use top level container instead of entity
 * - notify all discussion participants (can be not subscribed to group or member)
 *
 * @param string $hook          'get'
 * @param string $type          'subscriptions'
 * @param array  $subscriptions Array containing subscriptions in the form
 *                       <user guid> => array('email', 'site', etc.)
 * @param array  $params        Hook parameters
 * @return array
 */
// Note : this will not work as expected because NotificationsService core class function "sendNotification()" blocks sending to owner
function notification_messages_get_subscriptions($hook, $type, $subscriptions, $params) {
	$debug = false;
	$object = $params['event']->getObject();
	if (!elgg_instanceof($object)) { return $subscriptions; }
	
	// Check plugin setting
	$notify_owner = elgg_get_plugin_setting('notify_owner', 'notification_messages');
	$notify_self = elgg_get_plugin_setting('notify_self', 'notification_messages');
	$notify_participants = elgg_get_plugin_setting('notify_participants', 'notification_messages');
	$notify_replies = elgg_get_plugin_setting('notify_replies', 'notification_messages');
	
	$notify_owner = notification_messages_notify_owner();
	if ($notify_owner) {
		$owner_guid = $object->getOwnerGUID();
		if (!isset($subscriptions[$owner_guid])) {
			$subscriptions[$owner_guid] = array('email');
		}
		if (!in_array('email', $subscriptions[$owner_guid])) {
			$subscriptions[$owner_guid][] = 'email';
		}
	}
	if ($debug) error_log("NOTIF subscriptions for {$object->guid} {$object->getType()} / {$object->getSubtype()} : " . print_r($subscriptions, true));
	
	$top_object = notification_messages_get_top_object_entity($object);
	if ($debug) error_log(" - Top object : {$top_object->guid} {$top_object->getType()} / {$top_object->getSubtype()}");
	$top_container = notification_messages_get_top_container_entity($object);
	if ($debug) error_log(" - Top container : {$top_container->guid} {$top_container->getType()} / {$top_container->getSubtype()}");
	
	$self = $object->getOwnerEntity();
	$top_owner = $top_object->getOwnerEntity();
	
	// Notify initial object owner
	if ($notify_owner) {
		if ($top_owner->guid != $self->guid) {
			$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $top_owner->guid);
		}
	}
	if ($debug) error_log(" + notify_owner $notify_owner : " . print_r($subscriptions, true));
	
	// Notify self : note that it won't work (because owner is removed from reciepients so we need to use the send:before hook)
	if ($notify_self == 'yes') {
		$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $self->guid);
	}
	if ($debug) error_log(" + notify_self $notify_self : " . print_r($subscriptions, true));
	
	/* Notify all participants
	 * - from comments
	 * - from thread (parent objects)
	 * - from replies
	 * - from wiki versions
	 * - from wire thread
	 */
	if ($notify_participants == 'yes') {
		
		// Comments : for any object subtype (get comments from original content)
		if ($debug) error_log(" ..from comments :");
		$comments = elgg_get_entities(array(
				'type' => 'object', 'subtype' => 'comment',
				'container_guid' => $top_object->guid,
				'limit' => false,
			));
		foreach ($comments as $ent) {
			$ent_owner_guid = $ent->getOwnerGUID();
			$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $ent_owner_guid);
			if ($debug) error_log("   adding comment owner $ent_owner_guid");
		}
		
		// Also add all thread participants (alll parent objects owners)
		$parent = $object;
		while(elgg_instanceof($parent, 'object')) {
			$parent_owner_guid = $parent->getOwnerGUID();
			$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $parent_owner_guid);
			if ($debug) error_log("   adding parent object owner (thread participant) $parent_owner_guid");
			$parent = $parent->getContainerEntity();
		}

		switch($top_object->getSubtype()) {
			case 'groupforumtopic':
			case 'discussion':
				if ($debug) error_log(" ..from discussion replies :");
				$replies = elgg_get_entities(array(
					'type' => 'object', 'subtype' => 'discussion_reply',
					'container_guid' => $top_object->guid,
					'limit' => false,
				));
				foreach ($replies as $ent) {
					$ent_owner_guid = $ent->getOwnerGUID();
					$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $ent_owner_guid);
					if ($debug) error_log("   adding discussion reply owner $ent_owner_guid");
				}
				break;
				
			case 'page_top':
				if ($debug) error_log(" ..from page versions :");
				$versions = elgg_get_annotations(array(
					'guid' => $object->guid,
					'annotation_name' => 'page',
					'limit' => false,
				));
				foreach ($versions as $ent) {
					$ent_owner_guid = $ent->getOwnerGUID();
					$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $ent_owner_guid);
					if ($debug) error_log("   adding pages version owner $ent_owner_guid");
				}
				break;
				
			case 'thewire':
				if ($debug) error_log(" ..from wire thread :");
				$wire_replies = elgg_get_entities_from_metadata(array(
					"type" => "object", "subtype" => "thewire",
					"metadata_name" => "wire_thread", "metadata_value" => $object->wire_thread,
					'limit' => false,
				));
				if ($debug) error_log("   adding wire to $object->guid $object->wire_thread $top_object->guid");
				foreach ($wire_replies as $ent) {
					$ent_owner_guid = $ent->getOwnerGUID();
					$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $ent_owner_guid);
					if ($debug) error_log("   adding wire reply owner $ent_owner_guid");
				}
				break;
			
			default:
				// 
		}
		
	}
	if ($debug) error_log(" + notify_participants $notify_self : " . print_r($subscriptions, true));
	
	// Notify replies as objects (to members subscribed to the top parent container)
	if ($notify_replies == 'yes') {
		$container_subscribers = elgg_get_subscriptions_for_container($top_container->guid);
		if ($debug) error_log(" + notify_replies : container subscribers : " . print_r($container_subscribers, true));
		foreach($container_subscribers as $guid => $methods) {
			$subscriptions = notification_messages_add_to_subscriptions($subscriptions, $guid, $methods);
			if ($debug) error_log("   adding group member $guid / " . implode(', ', $methods));
		}
	}
	if ($debug) error_log(" + notify_replies $notify_self : " . print_r($subscriptions, true));
	
	
	return $subscriptions;
}

// Adds a specific GUID and notification methods to the subscriptions array
function notification_messages_add_to_subscriptions($subscriptions, $guid, $methods = array('email')) {
	if (!is_array($methods)) { $methods = array($methods); }
	if (!isset($subscriptions[$guid])) {
		$subscriptions[$guid] = $methods;
	} else {
		foreach ($methods as $method) {
			if (!in_array($method, $subscriptions[$guid])) {
				$subscriptions[$guid][] = $method;
			}
		}
	}
	return $subscriptions;
}

/* Sends directly the notification to the owner
 * Reason : NotificationsService core class function "sendNotification()" blocks sending to owner
 * So we have to send email directly, without modifying subscribers
 * @TODO once core accepts sending to owner : remove hook and direct notification sending
 */
function notification_messages_send_before_addowner($hook, $type, $return, $params) {
	$object = $params['event']->getObject();
	if (!elgg_instanceof($object)) { return $return; }
	
	// Check plugin setting
	//$notify_owner = notification_messages_notify_owner();
	$notify_self = elgg_get_plugin_setting('notify_self', 'notification_messages');
	//if ($notify_owner) {
	if ($notify_self == 'yes') {
		$owner_guid = $object->getOwnerGUID();
		$self = $params['event']->getActor();
		//$subscriptions = array("$owner_guid" => array('email'));
		// Send notification (to owner only) right now
		// Note : this method is not very friendly, better remove blocking check in core function (PR submitted on 20160317)
		$result = notification_messages_sendNotification($params['event'], $owner_guid, 'email');
		//$result = notification_messages_sendNotification($params['event'], $self->guid, 'email');
	}
	
	// Return $result (default: true) so we keep through the normal process (sends to member but the owner)
	// false stops the process
	return $return;
}


/* Intercepts and replaces the sendNotifications function so we can use our own function instead
 * @TODO Non fonctionnel et non utilisé : car le hook ne passe pas $this qui ne peut donc pas être correctement initialisé
 */
function notification_messages_send_before_sendNotifications_override($hook, $type, $return, $params) {
	notification_messages_sendNotifications($params['event'], $params['subscriptions']);
	//return false to stop the default notification sender
	return false;
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

	// Facyla : warning, if a plugin hook returned "true" (e.g. for blocking notification process, 
	// or because it already sent the message), this wouldn't be handled, 
	// so we should check it before going through the whole process !!
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
						$notify_owner = notification_messages_notify_owner();
						// Do not rely on logged in user but on object owner and current notified user
						//if (($user->guid != $SESSION['user']->guid) && has_access_to_entity($object, $user) && $object->access_id != ACCESS_PRIVATE) {
						if (($notify_owner || ($user->guid != $object->owner_guid)) && has_access_to_entity($object, $user) && ($object->access_id != ACCESS_PRIVATE)) {
							// Message content
							$body = elgg_trigger_plugin_hook('notify:entity:message', $object->getType(), array(
									'entity' => $object,
									'to_entity' => $user,
									'method' => $method), $string);
							if (empty($body) && $body !== false) { $body = $string; }
							
							// Message subject
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
							
							// Notify the user
							if ($body !== false) {
								notify_user($user->guid, $object->container_guid, $subject, $body, $options, array($method));
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



/**
 * Send an internal message
 *
 * @param string $subject The subject line of the message
 * @param string $body The body of the mesage
 * @param int $recipient_guid The GUID of the user to send to
 * @param int $sender_guid Optionally, the GUID of the user to send from
 * @param int $original_msg_guid The GUID of the message to reply from (default: none)
 * @param bool $notify Send a notification (default: true)
 * @param bool $add_to_sent If true (default), will add a message to the sender's 'sent' tray
 * @return bool
 */
// Note : change is avoid to strip tags in sent message when html_email_handler is used
function notification_messages_send($subject, $body, $recipient_guid, $sender_guid = 0, $original_msg_guid = 0, $notify = true, $add_to_sent = true) {
	// @todo remove globals
	global $messagesendflag;
	$messagesendflag = 1;

	// @todo remove globals
	global $messages_pm;
	if ($notify) { $messages_pm = 1; } else { $messages_pm = 0; }

	// If $sender_guid == 0, set to current user
	if ($sender_guid == 0) {
		$sender_guid = (int) elgg_get_logged_in_user_guid();
		//error_log("No sender GUID $sender_guid => block ?");
	}

	// Initialise 2 new ElggObject
	$message_to = new ElggObject();
	$message_sent = new ElggObject();

	$message_to->subtype = "messages";
	$message_sent->subtype = "messages";

	$message_to->owner_guid = $recipient_guid;
	$message_to->container_guid = $recipient_guid;
	$message_sent->owner_guid = $sender_guid;
	$message_sent->container_guid = $sender_guid;

	$message_to->access_id = ACCESS_PUBLIC;
	$message_sent->access_id = ACCESS_PUBLIC;

	$message_to->title = $subject;
	$message_to->description = $body;

	$message_sent->title = $subject;
	$message_sent->description = $body;

	$message_to->toId = $recipient_guid; // the user receiving the message
	$message_to->fromId = $sender_guid; // the user receiving the message
	$message_to->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_to->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_to->hiddenTo = 0; // this is used when a user deletes a message in their inbox

	$message_sent->toId = $recipient_guid; // the user receiving the message
	$message_sent->fromId = $sender_guid; // the user receiving the message
	$message_sent->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_sent->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_sent->hiddenTo = 0; // this is used when a user deletes a message in their inbox

	$message_to->msg = 1;
	$message_sent->msg = 1;

	// Save the copy of the message that goes to the recipient
	$success = $message_to->save();

	// Save the copy of the message that goes to the sender
	if ($add_to_sent) {
		$message_sent->save();
	}

	$message_to->access_id = ACCESS_PRIVATE;
	$message_to->save();

	if ($add_to_sent) {
		$message_sent->access_id = ACCESS_PRIVATE;
		$message_sent->save();
	}

	// if the new message is a reply then create a relationship link between the new message
	// and the message it is in reply to
	if ($original_msg_guid && $success) {
		add_entity_relationship($message_sent->guid, "reply", $original_msg_guid);
	}

	// Facyla : don't strip tags if sending by email, but use output filters
	if (elgg_is_active_plugin('html_email_handler')) {
		$message_contents = $body;
		// Note : CSS inliner add HTML doctype headers to the generated content
		// should no be very useful anyway as styles should be already inline in messages
		//$message_contents = html_email_handler_css_inliner($message_contents);
		$message_contents = parse_urls($message_contents);
		$message_contents = filter_tags($message_contents);
		$message_contents = elgg_autop($message_contents);
	} else {
		$message_contents = strip_tags($body);
	}
	
	// Allow cron override - This is only for simulation purpose
	// As when using a real cron there is no one logged in so it should pass anyway
	if ((($recipient_guid != elgg_get_logged_in_user_guid()) || elgg_in_context('cron')) && $notify) {
		$recipient = get_user($recipient_guid);
		$sender = get_user($sender_guid);
		
		//$subject = elgg_echo('messages:email:subject');
		$excerpt = $subject;
		if (strlen($excerpt) > 12) $excerpt = elgg_get_excerpt($excerpt, 12) . '..';
		$subject = elgg_echo('notification_messages:email:subject', array(elgg_get_site_entity()->name, $sender->name, $excerpt));
		$body = elgg_echo('messages:email:body', array(
			$sender->name,
			$message_contents,
			elgg_get_site_url() . "messages/inbox/" . $recipient->username,
			$sender->name,
			elgg_get_site_url() . "messages/compose?send_to=" . $sender_guid
		),
		$recipient->language
	);
		
		// Trigger a hook to provide better integration with other plugins
		$hook_subject = elgg_trigger_plugin_hook('notify:message:subject', 'message', array('entity' => $message_to, 'from_entity' => $sender, 'to_entity' => $recipient), $subject);
		// Failsafe backup if hook as returned empty content but not false (= stop)
		if (!empty($hook_subject) && ($hook_subject !== false)) { $subject = $hook_subject; }
	
		// Trigger a hook to provide better integration with other plugins
		$hook_body = elgg_trigger_plugin_hook('notify:message:message', 'message', array('entity' => $message_to, 'from_entity' => $sender, 'to_entity' => $recipient), $body);
		// Failsafe backup if hook as returned empty content but not false (= stop)
		if (!empty($hook_body) && ($hook_body !== false)) { $body = $hook_body; }
		
		notify_user($recipient_guid, $sender_guid, $subject, $body);
	}

	$messagesendflag = 0;
	return $success;
}



/* CORE FUNCTIONS OVERRIDES */

/* Overrides a core function to allow using our own function
 * @TODO non fonctionnel et non utilisé : car $this n'est pas passé via le hook et donc pas initialisé corrrectement
 * Note : $this is replaced by _elgg_services()
 */
function notification_messages_sendNotifications($event, $subscriptions) {
	if (!$this->methods) { return 0; }
	$count = 0;
	foreach ($subscriptions as $guid => $methods) {
		foreach ($methods as $method) {
			if (in_array($method, _elgg_services()->methods)) {
				//if ($this->sendNotification($event, $guid, $method)) { $count++; }
				if (notification_messages_sendNotification($event, $guid, $method)) { $count++; }
			}
		}
	}
	return $count;
}


/* Overrides a core function to allow sending to owner
 * Note : $this is replaced by _elgg_services()
 */
function notification_messages_sendNotification(\Elgg\Notifications\Event $event, $guid, $method) {
	$recipient = get_user($guid);
	if (!$recipient || $recipient->isBanned()) { return false; }

	// ESOPE : we DO want to allow sending to the author
	// don't notify the creator of the content
	if ($recipient->getGUID() == $event->getActorGUID()) {
		//return false;
		//error_log("NOT_MES functions.php : sending to author $guid about {$event->getObject()->guid}");
	}

	$actor = $event->getActor();
	$object = $event->getObject();
	if (!$actor || !$object) { return false; }

	if (($object instanceof ElggEntity) && !has_access_to_entity($object, $recipient)) { return false; }

	$language = $recipient->language;
	$params = array(
		'event' => $event,
		'method' => $method,
		'recipient' => $recipient,
		'language' => $language,
		'object' => $object,
	);

	$subject = _elgg_services()->translator->translate('notification:subject', array($actor->name), $language);
	$body = _elgg_services()->translator->translate('notification:body', array($object->getURL()), $language);
	$notification = new \Elgg\Notifications\Notification($event->getActor(), $recipient, $language, $subject, $body, '', $params);

	$type = 'notification:' . $event->getDescription();
	if (_elgg_services()->hooks->hasHandler('prepare', $type)) {
		$notification = _elgg_services()->hooks->trigger('prepare', $type, $params, $notification);
	} else {
		// pre Elgg 1.9 notification message generation
		$notification = _elgg_services()->getDeprecatedNotificationBody($notification, $event, $method);
	}

	if (_elgg_services()->hooks->hasHandler('send', "notification:$method")) {
		// return true to indicate the notification has been sent
		$params = array(
			'notification' => $notification,
			'event' => $event,
		);
		return _elgg_services()->hooks->trigger('send', "notification:$method", $params, false);
	} else {
		// pre Elgg 1.9 notification handler
		$userGuid = $notification->getRecipientGUID();
		$senderGuid = $notification->getSenderGUID();
		$subject = $notification->subject;
		$body = $notification->body;
		$params = $notification->params;
		return (bool)_elgg_notify_user($userGuid, $senderGuid, $subject, $body, $params, array($method));
	}
}




/* COMMENT TRACKER FUNCTIONS OVERRIDES
 * Réécriture de comment_tracker_notifications pour pouvoir définir une fonction de remplacement 
 * et ainsi pouvoir définir le contenu de la notification envoyée, mais avec les destinataires définis via comment_tracker...
 */
if (elgg_is_active_plugin('comment_tracker')) {
	
	// ESOPE : la fonction doit être identique à celle d'origine, à l'exception de la fonction de notification utilisée
	// annotation event handler function to manage comment notifications
	function notification_messages_comment_tracker_notifications($event, $type, $annotation) {
		// ESOPE changes : need to determine user earlier, from annotation, and do not block if not logged in (cron)
		//if ($type == 'annotation' && elgg_is_logged_in()) {
		if ($type == 'annotation') {
			if ($annotation->name == "generic_comment" || $annotation->name == "group_topic_post") {
				$user = get_user($annotation->owner_guid);
				
				// ESOPE : subscribe first so we can notify if self-notification is enabled
				// subscribe the commenter to the thread if they haven't specifically unsubscribed
				//$user = get_user($annotation->owner_guid);
				$entity = get_entity($annotation->entity_guid);
			
				$autosubscribe = elgg_get_plugin_user_setting('comment_tracker_autosubscribe', $user->guid, 'comment_tracker');
			
				if (!comment_tracker_is_unsubscribed($user, $entity) && $autosubscribe != 'no') {
					// don't subscribe the owner of the entity
					if ($entity->owner_guid != $user->guid) {
							comment_tracker_subscribe($user->guid, $entity->guid);
					}
				}
				
				notification_messages_comment_tracker_notify($annotation, $user);
			}
		}
		return TRUE;
	}
	
	// ESOPE : la fonction doit être identique à celle d'origine, à l'exception de l'ajout des hooks sur le sujet et le contenu du message
	function notification_messages_comment_tracker_notify($annotation, $ann_user, $params = array()) {
		global $NOTIFICATION_HANDLERS, $CONFIG;
	
		if (!($annotation instanceof ElggAnnotation)) {
			return false;
		}
	
		$entity = get_entity($annotation->entity_guid);
	
		if (elgg_instanceof($entity, 'object')) {
		
			$container = get_entity($entity->container_guid);
			if ($entity->getSubtype() == 'groupforumtopic') {
				$subject = elgg_echo('comment:notify:subject:groupforumtopic', array(
					$ann_user->name,
					$entity->title,
					$container->name
				));
			} else {
				$content_type = elgg_echo($entity->getSubtype());
				if ($content_type == $entity->getSubtype()) {
					// wasn't translated that way, try item:object:subtype
					$content_type = elgg_echo('item:object:'.$entity->getSubtype());
				
					if ($content_type == 'item:object:'.$entity->getSubtype()) {
						$content_type = elgg_echo('comment_tracker:item');
					}
				}
			
				// construct subject for an entity
				if (elgg_instanceof($container, 'group')) {
					$subject = elgg_echo('comment:notify:subject:comment:group', array(
						$ann_user->name,
						$content_type,
						$entity->title ? $entity->title : $entity->name,
						$container->name
					));
				}
				else {
					$subject = elgg_echo('comment:notify:subject:comment', array(
						$ann_user->name,
						$content_type,
						$entity->title ? $entity->title : $entity->name
					));
				}
			}
			
			$entity_link = elgg_view('output/url', array(
				'url' => $entity->getUrl(),
				'text' => $entity->title,
			));
		
			$commenter_link = elgg_view('output/url', array(
				'url' => $ann_user->getUrl(),
				'text' => $ann_user->name,
			));
		
			$options = array(
				'relationship' => COMMENT_TRACKER_RELATIONSHIP,
				'relationship_guid' => $annotation->entity_guid,
				'inverse_relationship' => true,
				'types' => 'user',
				'limit' => 0
			);
		
			$users = elgg_get_entities_from_relationship($options);
			$notify_owner = notification_messages_notify_owner();
		
			$result = array();
			foreach ($users as $user) {
				// Make sure user is real
				// ESOPE : check if we should notify the comment author or not
				//if (elgg_instanceof($user, 'user') && ($user->guid != $ann_user->guid)) {
				if (elgg_instanceof($user, 'user')) {
					// Do not notify the author of comment if set to not notify self
					if (!$notify_owner && ($user->guid == $ann_user->guid)) { continue; }
					// Do not notify the owner of the entity being commented on ?  because always notified before (in comment action)
					if ($user->guid == $entity->owner_guid) { continue; }
				
					$notify_settings_link = elgg_get_site_url() . "notifications/personal/{$user->username}";
				
					// Results for a user are...
					$result[$user->guid] = array();
				
					foreach ($NOTIFICATION_HANDLERS as $method => $details)	{
						if (check_entity_relationship($user->guid, 'block_comment_notify'.$method, $CONFIG->site_guid))	{
							continue;
						}
					
						$from = $ann_user;
						switch ($method) {
							case 'sms':
							case 'site':
							case 'web':
								$message = elgg_echo("comment:notify:{$group_lang}body:web", array(
									$user->name,
									$entity_link,
									$commenter_link,
									$annotation->value,
									$entity->getUrl(),
									$notify_settings_link,
									$notify_unsubscribe_link
								));
								break;
							case 'email':
							default:
								$message = elgg_echo("comment:notify:{$group_lang}body:email:text", array(
									$user->name,
									$entity_link,
									$commenter_link,
									$annotation->value,
									$entity->getUrl(),
									$CONFIG->sitename,
									$notify_settings_link,
									$notify_unsubscribe_link
								));
								if (empty($group_lang)) {
									$from = $CONFIG->site;
								}
								break;
						}
					
						// Extract method details from list
						$handler = $details->handler;
					
						if ((!$NOTIFICATION_HANDLERS[$method]) || (!$handler)) {
							error_log(sprintf(elgg_echo('NotificationException:NoHandlerFound'), $method));
						}
					
						// ESOPE : avoid NOTICE logging
						//elgg_log("Sending message to {$user->guid} using $method");
						
						// ESOPE : Custom message subject
						$new_subject = notification_messages_build_subject($entity);
						if (!empty($new_subject)) { $subject = $new_subject; }
						
						// ESOPE : Custom message content : keep the one from comment_tracker (which is nice)
						// @TODO : normalize message here with custom improved content...
						// Trigger a hook to provide better integration with other plugins
						//$new_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', array('entity' => $entity, 'to_entity' => $user), $message);
						$new_message = notification_messages_build_body($entity, array('language' => $user->language));
						// Failsafe backup if hook as returned empty content but not false (= stop)
						if (!empty($new_message)) { $message = $new_message; }
						
	
						// Trigger handler and retrieve result.
						try {
							$result[$user->guid][$method] = $handler(
								$from , 	// From entity
								$user, 		// To entity
								$subject,	// The subject
								$message, 	// Message
								$params		// Params
							);
						} catch (Exception $e) {
							error_log($e->getMessage());
						}
					}
				}
			}
			return $result;
		}
		return false;
	}
	
}




// Helper functions

// Get top parent object entity (that is commentable without thread)
// If top object, return initial object
function notification_messages_get_top_object_entity($entity = false) {
	if (!elgg_instanceof($entity, 'object')) { return false; }
	$parent = $entity;
	while(elgg_instanceof($parent, 'object')) {
		$entity = $parent;
		$parent = $entity->getContainerEntity();
	}
	return $entity;
}

// Get real container (user, group, site) for special object types (forum, comments)
function notification_messages_get_top_container_entity($entity = false) {
	if (!elgg_instanceof($entity, 'object')) { return false; }
	$entity = notification_messages_get_top_object_entity($entity);
	return $entity->getContainerEntity();
}

/* Get top group (if using subgroups)
 * @return ElggGroup entity | false
 * bool $false_if_noparent : returns false instead of group entity if group has no parent
 */
function notification_messages_get_top_group($group = false, $false_if_noparent = true) {
	if (!elgg_instanceof($group, 'group')) { return false; }
	$parent = $group;
	if (elgg_is_active_plugin('au_subgroups')) {
		while ($has_parent = AU\SubGroups\get_parent_group($parent)) {
			$parent = $has_parent;
		}
	}
	if ($false_if_noparent && ($parent->guid == $group->guid)) { return false; }
	return $parent;
}

/* Return container for notification message (ie do not return container if meaningless)
 * Container can be a group, user, site, object
 * If using subgroups, main group can be added too
 */
function notification_messages_message_add_container($entity = false) {
	$msg_container = false;
	$container = $entity->getContainerEntity();
	// User : pointless
	//if (elgg_instanceof($container, "user")) { $msg_container = $container->name; }
	// Group
	if (elgg_instanceof($container, "group")) {
		$msg_container = $container->name;
		// Add top group only if existing
		if (elgg_is_active_plugin('au_subgroups')) {
			if ($topgroup = notification_messages_get_top_group($container)) {
				$msg_container = elgg_echo('notification_messages:container:subgroup', array($topgroup->name, $container->name));
			}
		}
	}
	// @TODO Site : multisite installation ?
	//if (elgg_instanceof($container, "site")) { $msg_container = $container->name; }
	// @TODO Object : attached content ?
	//if (elgg_instanceof($container, "object")) { $msg_container = $container->title; }
	
	return $msg_container;
}


