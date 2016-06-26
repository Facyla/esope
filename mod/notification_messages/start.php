<?php
/**
 * notification_messages plugin
 *
 */

// @DONE : direct messages
// @DONE : subjects for objects (including discussions)
// @DONE : handle comments
// @TODO : notify owner
// @TODO : handle file attachments
// @TODO : other plugins (comment_tracker)


elgg_register_event_handler('init', 'system', 'notification_messages_init'); // Init


/**
 * Init adf_notification_messages plugin.
 */
function notification_messages_init() {
	
	/* NOTIFICATION HOOKS */
	
	// Update subject + body + summary
	// Handle new (registered) objects notification subjects
	//elgg_register_plugin_hook_handler('notify:entity:subject', 'object', 'notification_messages_notify_subject');
	$subtypes = elgg_get_plugin_setting('object_subtypes', 'notification_messages');
	$subtypes = explode(',', $subtypes);
	// Add discussion replies if discussion is in the list
	if (in_array('groupforumtopic', $subtypes)) { $subtypes[] = 'discussion_reply'; }
	if ($subtypes) {
		foreach ($subtypes as $subtype) {
			// @TODO : also handle update and delete events ?
			// Note : we enable regular (create) and specific hook (publish) in all cases, because at worst it would be called twice and produce the same result, 
			// Regular hook
			// but this will avoid having to maintain the list here in case some plugin change called hook
			elgg_register_plugin_hook_handler('prepare', "notification:create:object:$subtype", 'notification_messages_prepare_notification', 900);
			// Some subtypes use a specific hook
			// @TODO : always register both hooks, just in case ?
			if (in_array($subtype, array('blog', 'survey', 'transitions'))) {
				elgg_register_plugin_hook_handler('prepare', "notification:publish:object:$subtype", 'notification_messages_prepare_notification', 900);
			}
		}
	}
	
	// @TODO Handle properly comment subjects
	// Register *earlier* to same hook and update (has to run before core and html_email_handler hook, which are default priority)
	elgg_register_plugin_hook_handler('email', 'system', 'notification_messages_comments_notification_email_subject', 100);
	// Remove system default comment subject handler (because it is loaded right before email sending hook)
	//elgg_unregister_plugin_hook_handler('email', 'system', '_elgg_comments_notification_email_subject');
	
	
	// Add owner to notification subscribers
	// note: setting is checked in hook
	// note 2: core function that sends notifications blocks adding owner to recipients : need to send email directly to owner
	// @TODO : remove send:before hook once core accepts sending to owner !
	elgg_register_plugin_hook_handler('get', 'subscriptions', 'notification_messages_get_subscriptions_addowner', 900);
	elgg_register_plugin_hook_handler('send:before', 'notifications', 'notification_messages_send_before_addowner', 900);
	
	
	// Replace message action so we can use our custom message content
	$messages_send = elgg_get_plugin_setting('messages_send', 'notification_messages');
	if ($messages_send != 'no') {
		$action_path = elgg_get_plugins_path() . 'notification_messages/actions/messages';
		elgg_unregister_action("messages/send");
		elgg_register_action("messages/send", "$action_path/send.php");
	}
	
	
	/* Except if other plugin breaks behaviour, this hook should not be useful anymore in 1.11+
	// NOTIFICATION MESSAGE HOOKS
	// Note : advanced_notifications should be able to act after this hook (can remove message content), so priority has to be < 999)
	$blog_message = elgg_get_plugin_setting('object_blog_message', 'notification_messages');
	if ($blog_message == 'allow') {
		elgg_unregister_plugin_hook_handler('notify:entity:message', 'object', 'blog_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'notification_messages_notify_message_blog');
	}
	
	// FORUM REPLIES
	$groupforumtopic = elgg_get_plugin_setting('object_groupforumtopic', 'notification_messages');
	if ($groupforumtopic == 'allow') {
		// Some advanced_notifications features are limiting flexibility, so unregister them first
		if (elgg_is_active_plugin('advanced_notifications')) {
			// Forum topic reply subject
			elgg_unregister_plugin_hook_handler("notify:annotation:subject", "group_topic_post", "advanced_notifications_discussion_reply_subject_hook");
		}
		// Handle forum topic reply subject
		elgg_register_plugin_hook_handler("notify:annotation:subject", "group_topic_post", "notification_messages_reply_subject_hook");
	}
	*/
	
	
	/*
	// GENERIC COMMENTS BEHAVIOUR
	// Some advanced_notifications features are limiting flexibility, so unregister them first
	if (elgg_is_active_plugin('advanced_notifications')) {
		elgg_unregister_plugin_hook_handler("action", "comments/add", "advanced_notifications_comment_action_hook");
	}
	// Handle generic comments notifications actions and notification
	elgg_register_plugin_hook_handler("action", "comments/add", "notification_messages_comment_action_hook", 1000);
	*/
	
	
	/* ENABLE ATTACHMENTS */
	// Note : attachments are now handled by html_email_handler : use $params['attachments']
	// register a hook to add a new hook that allows adding attachments and other params
	// Note : enabled by default because it is required by notifications messages
	/*
	if (elgg_get_plugin_setting("object_notifications_hook", "notification_messages") != "no"){
		elgg_register_plugin_hook_handler('object:notifications', 'all', 'notification_messages_object_notifications_hook');
	}
	*/
	
	/*
	// HANDLE CONFLICTS WITH OTHER PLUGINS
	// Comment tracker : generates a duplicate message with a different subject and content 
	// (because it does not use subject + message hooks)
	if (elgg_is_active_plugin('comment_tracker')) {
		elgg_unregister_event_handler('create', 'annotation','comment_tracker_notifications');
		elgg_register_event_handler('create', 'annotation','notification_messages_comment_tracker_notifications');
	}
	*/
	
}


// Guess best subtype title depending on defined translation strings
function notification_messages_readable_subtype($subtype) {
	$msg_subtype = elgg_echo("item:object:$subtype");
	if ($msg_subtype == "item:object:$subtype") {
		$msg_subtype = elgg_echo($subtype);
	}
	return strip_tags($msg_subtype);
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
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];
	
	// Note : we do not use behaviour setting anymore (update subject and content but do not block sending)
	// Determine behaviour - default is not changing anything (can be already specific)
	// $setting = notification_messages_get_subtype_setting($subtype);
	
	// Handle comments a bit differently (subject and summary should be based on original object)
	// This has to be handled in all 3 functions (because we need the acting entity too)
	
	// Notification subject
	$subject = notification_messages_build_subject($entity, $params);
	if (!empty($subject)) { $notification->subject = $subject; }

	// Notification message body
	$body = notification_messages_build_body($entity, $params);
	if (!empty($body)) { $notification->body = $body; }

	// Short summary about the notification
	$summary = notification_messages_build_summary($entity, $params);
	if (!empty($summary)) { $notification->summary = $summary; }
	
	return $notification;
}



/* Determine setting for this entity type */
function notification_messages_get_subtype_setting($subtype = '') {
	$setting = elgg_get_plugin_setting('object_' . $subtype, 'notification_messages');
	if (empty($setting)) { $setting == 'default'; }
	return $setting;
}


/* Build subject based on notified entity
 * Use new subject structure : [container | subtype] Title
 * or when no container : [subtype] Title
 * $entity : notified entity
 * $params : original hook $params
 */
function notification_messages_build_subject($entity, $params) {
	if (elgg_instanceof($entity)) {
		//error_log(print_r($entity, true) . print_r($params, true));
		$owner = $params['event']->getActor();
		$recipient = $params['recipient'];
		$language = $params['language'];
		$method = $params['method'];
		
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
		
		// Container should be a group or user, can also be a site
		$msg_container = false;
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
		if (empty($msg_title)) { $msg_title = elgg_echo('notification_messages:untitled', $language); }
		// Strip optional tags or spaces
		$msg_title = trim(strip_tags($msg_title));
		
		// Handle when using a specific container
		if ($msg_container) {
			$subject = elgg_echo('notification_messages:objects:subject', array($msg_container, $msg_subtype, $msg_title), $language);
		} else {
			$subject = elgg_echo('notification_messages:objects:subject:nocontainer', array($msg_subtype, $msg_title), $language);
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
function notification_messages_build_summary($entity, $params) {
	if (elgg_instanceof($entity)) {
		$subject = notification_messages_build_subject($entity, $params);
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


// @TODO Notification message content
function notification_messages_build_body($entity, $params) {
	if (elgg_instanceof($entity)) {
		
		$subtype = $entity->getSubtype();
		/*
		$allowed_subtypes = array('blog'); // Backward compat : at least for blog
		if (!in_array($subtype, $allowed_subtypes)) { return false; }
		*/
		// Get best readable subtype
		$msg_subtype = notification_messages_readable_subtype($subtype);
		
		$owner = $params['event']->getActor();
		$recipient = $params['recipient'];
		$language = $params['language'];
		$method = $params['method'];
		
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
		
		
		switch($subtype) {
			case 'blog':
				$descr = '';
				if (!empty($entity->excerpt)) { $descr .= '<p><em>' . $entity->excerpt . '</em></p>'; }
				$descr .= strip_tags($entity->description, $allowed_tags);
				if (!empty($reply_descr)) { $descr = elgg_echo('notification_messages:body:inreplyto', array($descr, $reply_descr)); }
				$title = '<strong>' . $entity->title . '</strong>';
				$owner = $entity->getOwnerEntity();
				$body = elgg_echo('blog:notify:body', array(
						$owner->name,
						$title,
						$descr,
						$entity->getURL()
					));
				break;
				
			default:
				$owner = $entity->getOwnerEntity();
				$container = $entity->getContainerEntity();
				if (elgg_instanceof($container, "user") || elgg_instanceof($container, "group") || elgg_instanceof($container, "site")) { $msg_container = $container->name; }
				
				$descr = '';
				if (!empty($entity->excerpt)) { $descr .= '<p><em>' . $entity->excerpt . '</em></p>'; }
				$descr .= strip_tags($entity->description, $allowed_tags);
				if (!empty($reply_descr)) { $descr = elgg_echo('notification_messages:body:inreplyto', array($descr, $reply_descr)); }
				$title = $entity->title;
				if (empty($title)) { $title = $entity->name; }
				$title = '<strong>' . $title . '</strong>';
				if ($msg_container) {
					$body = elgg_echo('notification_messages:objects:body', array(
							$owner->name,
							$title,
							$msg_container, 
							$descr,
							$entity->getURL()
						));
				} else {
					$body = elgg_echo('notification_messages:objects:body:nocontainer', array(
							$owner->name,
							$title,
							$descr,
							$entity->getURL()
						));
				}
		}
		
		return $body;
	}
	return false;
}

/**
 * Set the notification message body : add content (with some tags filtering)
 * 
 * @param string $hook    Hook name
 * @param string $type    Hook type
 * @param string $message The current message body
 * @param array  $params  Parameters about the blog posted
 * @return string
 */
/* SHould be useless in 1.11+
function notification_messages_notify_message_blog($hook, $type, $message, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (elgg_instanceof($entity, 'object', 'blog')) {
		$allowed_tags = '<br><br/><p><a><ul><ol><li><strong><em><b><u><i><h1><h2><h3><h4><h5><h6><q><blockquote><code><pre>';
		$descr = '<p><em>' . $entity->excerpt . '</em></p>';
		$descr .= strip_tags($entity->description, $allowed_tags);
		$title = '<strong>' . $entity->title . '</strong>';
		$owner = $entity->getOwnerEntity();
		return elgg_echo('blog:notification', array(
				$owner->name,
				$title,
				$descr,
				$entity->getURL()
			));
	}
	return null;
}
*/


// Handle group topic reply subject hook
function notification_messages_reply_subject_hook($hook, $type, $returnvalue, $params) {
	$entity_guid = $params['annotation']->entity_guid;
	if ($entity_guid && ($entity = get_entity($entity_guid))) {
		$subject = notification_messages_build_subject($entity);
		if (!empty($subject)) { $returnvalue = $subject; }
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



if (elgg_is_active_plugin('comment_tracker')) {
	// Réécriture de comment_tracker_notifications pour pouvoir définir une fonction de remplacement 
	// et ainsi pouvoir définir le contenu de la notification envoyée, mais avec les destinataires définis via comment_tracker...
	
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
						$new_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', array('entity' => $entity, 'to_entity' => $user), $message);
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



// Should we also send notifications to the owner (of the comment) ?
function notification_messages_notify_owner() {
	$notify = false;
	
	// Setting is synchronized with comment_tracker's
	if (elgg_is_active_plugin('comment_tracker')) {
		$notify_owner = elgg_get_plugin_setting('notify_owner', 'comment_tracker');
	} else {
		$notify_owner = elgg_get_plugin_setting('notify_owner', 'notification_messages');
	}
	if ($notify_owner == 'yes') { $notify = true; }
	
	// @TODO : should we force to true if using postbymail ?
	//if (elgg_is_active_plugin('postbymail')) { $notify = true; }
	
	return $notify;
}


/**
 * Add owner to subscribers
 *
 * @param string $hook          'get'
 * @param string $type          'subscriptions'
 * @param array  $subscriptions Array containing subscriptions in the form
 *                       <user guid> => array('email', 'site', etc.)
 * @param array  $params        Hook parameters
 * @return array
 */
// Note : this will not work as expected because NotificationsService core class function "sendNotification()" blocks sending to owner
function notification_messages_get_subscriptions_addowner($hook, $type, $subscriptions, $params) {
	$object = $params['event']->getObject();
	if (!elgg_instanceof($object)) { return $subscriptions; }
	
	// Check plugin setting
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
	//error_log("NOTIF : " . print_r($subscriptions, true));
	
	return $subscriptions;
}

// @TODO remove hook and direct notification sending once core accepts sending to owner
// Note : NotificationsService core class function "sendNotification()" blocks sending to owner
// So we have to send email directly, without modifying subscribers
function notification_messages_send_before_addowner($hook, $type, $return, $params) {
	$object = $params['event']->getObject();
	if (!elgg_instanceof($object)) { return $return; }
	
	// Check plugin setting
	$notify_owner = notification_messages_notify_owner();
	if ($notify_owner) {
		$owner_guid = $object->getOwnerGUID();
		$subscriptions = array("$owner_guid" => array('email'));
		// Send notification (to owner only) right now
		// Note : this method is not very friendly, better remove blocking check in core function (PR submitted on 20160317)
		$result = notification_messages_sendNotification($params['event'], $owner_guid, 'email');
	}
	
	return $return;
}


/* Overrides a core function but allows sending to owner
 */
function notification_messages_sendNotification(\Elgg\Notifications\Event $event, $guid, $method) {
	$recipient = get_user($guid);
	if (!$recipient || $recipient->isBanned()) {
		return false;
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

	$subject = elgg_echo('notification:subject', array($actor->name), $language);
	$body = elgg_echo('notification:body', array($object->getURL()), $language);
	$from = elgg_get_site_entity();
	$notification = new \Elgg\Notifications\Notification($from, $recipient, $language, $subject, $body, '', $params);
	$type = 'notification:' . $event->getDescription();
	$params['notification'] = $notification;
	$notification = elgg_trigger_plugin_hook('prepare', $type, $params, $notification);

	return elgg_trigger_plugin_hook('send', "notification:$method", $params, false);
}


// Override system default comment email subject (forces full subject instead of adding Re:)
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





