<?php
/**
 * notification_messages plugin
 *
 */

// @DONE : subjects for objects (including discussions)
// @DONE : handle comments
// @DONE : direct messages
// @TODO : notify owner
// @TODO : handle file attachments
// @TODO : other plugins (comment_tracker)


/* @DOC : NOTIFICATION PROCESS AND FUNCTIONS :

 * engine/lib/notifications.php => Initie l'envoi des notifications
 
function _elgg_notifications_cron() {
  // calculate when we should stop
  // @todo make configurable?
  $stop_time = time() + 45;
  _elgg_services()->notifications->processQueue($stop_time);
}


 * engine/classes/Elgg/Notifications/NotificationsService.php => Dépile les notifications en attente, récupère la liste des abonnés, et envoie les notifications
 * Hooks sur : abonnements, avant envoi, après envoi
 
public function processQueue($stopTime) {
  $this->subscriptions->methods = $this->methods;
  $count = 0;
  // @todo grab mutex
  $ia = $this->session->setIgnoreAccess(true);

  while (time() < $stopTime) {
    // dequeue notification event
    $event = $this->queue->dequeue();
    if (!$event) { break; }
    // $event = Elgg\Notifications\Event Object(action:protected, object_type:protected, object_subtype:protected, object_id:protected, actor_guid:protected)

    // test for usage of the deprecated override hook
    if ($this->existsDeprecatedNotificationOverride($event)) { continue;  }

    $subscriptions = $this->subscriptions->getSubscriptions($event);
    // 

    // return false to stop the default notification sender
    $params = array('event' => $event, 'subscriptions' => $subscriptions);
    if ($this->hooks->trigger('send:before', 'notifications', $params, true)) {
      $this->sendNotifications($event, $subscriptions);
    }
    $this->hooks->trigger('send:after', 'notifications', $params);
    $count++;
  }

  // release mutex
  $this->session->setIgnoreAccess($ia);
  return $count;
}


 * engine/classes/Elgg/Notifications/sendNotifications.php => boucle d'envoi des notifications


 * engine/classes/Elgg/Notifications/SubscriptionsService.php => Récupère les abonnements + méthodes, sur la base du container uniquement 
 * (donc contenus initiaux seulement mais pas les réponses)

public function getSubscriptions(\Elgg\Notifications\Event $event) {
  $subscriptions = array();
  if (!$this->methods) { return $subscriptions; }
  
  $object = $event->getObject();
  if (!$object) { return $subscriptions; }
  
  if ($object instanceof \ElggEntity) {
    $prefixLength = strlen(self::RELATIONSHIP_PREFIX);
    $records = $this->getSubscriptionRecords($object->getContainerGUID());
    foreach ($records as $record) {
      $deliveryMethods = explode(',', $record->methods);
      $subscriptions[$record->guid] = substr_replace($deliveryMethods, '', 0, $prefixLength);
    }
  }
  $params = array('event' => $event);
  
  // Note : this hook overrrides the former results
  return _elgg_services()->hooks->trigger('get', 'subscriptions', $params, $subscriptions);
}


 */



elgg_register_event_handler('init', 'system', 'notification_messages_init'); // Init


/**
 * Init notification_messages plugin
 */
function notification_messages_init() {
	
	$action_path = elgg_get_plugins_path() . 'notification_messages/actions/messages';
	
	// Get all subtypes handled by this plugin
	$prepare_object_subtypes = elgg_get_plugin_setting('object_subtypes', 'notification_messages');
	$prepare_object_subtypes = explode(',', $prepare_object_subtypes);
	// Add discussion replies if discussion is in the list
	if (in_array('groupforumtopic', $prepare_object_subtypes)) { $prepare_object_subtypes[] = 'discussion_reply'; }
	$prepare_object_subtypes = array_unique($prepare_object_subtypes);
	
	
	// Override settings save action so we can usr checkboxes / multiselect
	elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'notification_messages_plugin_settings');
	
	
	/* STEP 1 : register notification events */
	// elgg_register_notification_event('object', 'photo', array('create'));
	// Settings array lists for each object subtype the array of actions that should be registered as notification events (no notification if none)
	$register_object_subtypes = elgg_get_plugin_setting('register_object_subtypes', 'notification_messages');
	$register_object_subtypes = unserialize($register_object_subtypes);
	//error_log(print_r($register_object_subtypes, true));
	
	// Note : SKIP OVERRIDE in admin context, so we can know what happens otherwise (and display defaults values)
	//error_log("NOTIFICATION MESSAGES register events : " . print_r(elgg_get_context_stack(), true));
	if (!elgg_in_context('admin') && $register_object_subtypes) {
		foreach ($register_object_subtypes as $subtype => $events) {
			//error_log("NOT_MES : register notif events for $subtype : " . print_r($events, true));
			elgg_unregister_notification_event('object', $subtype);
			if (sizeof($events) > 0) { elgg_register_notification_event('object', $subtype, $events); }
		}
	}
	
	
	
	/* STEP 2 : prepare notification content 
	 * => elgg_register_plugin_hook_handler('prepare', 'notification:create:object:photo', 'photos_prepare_notification');
	 */
	
	// Update subject + body + summary
	// Handle new (registered) objects notification subjects
	// Also handle publish, update and delete events
	//elgg_register_plugin_hook_handler('notify:entity:subject', 'object', 'notification_messages_notify_subject');
	if ($prepare_object_subtypes) {
		foreach ($prepare_object_subtypes as $subtype) {
			// Note : we enable regular (create) and specific hook (publish) in all cases, because at worst it would be called twice and produce the same result, 
			// Regular hook
			// but this will avoid having to maintain the list here in case some plugin change called hook
			elgg_register_plugin_hook_handler('prepare', "notification:create:object:$subtype", 'notification_messages_prepare_notification', 900);
			// Some subtypes use a specific hook
			// Note : Always register all hooks, as we can set the notification event on any of these
			//if (in_array($subtype, array('blog', 'survey', 'transitions'))) {
				elgg_register_plugin_hook_handler('prepare', "notification:publish:object:$subtype", 'notification_messages_prepare_notification', 900);
			//}
			elgg_register_plugin_hook_handler('prepare', "notification:update:object:$subtype", 'notification_messages_prepare_notification', 900);
			elgg_register_plugin_hook_handler('prepare', "notification:delete:object:$subtype", 'notification_messages_prepare_notification', 900);
		}
	}
	
	
	/* Handle special cases : these are not triggered by a registered event but an action, and require an action override
	 * Comments : direct notification for owner only, registered event for other recipients
	 * Direct messages : direct notificaiton only (but also 1 single recipient)
	 */
	
	/* Generic comments support
	 * Why ?   because default comment,save action (always) notifies owner if someone else posted a comment, using a basic title and content
	 * When ?   If prepare,notification:create:object:comment is handled by notification_messages 
	 *          we have to override the action, so we can set the proper message title and content.
	 * How ?   replace comment action so we can set our custom notification subject and content
	 */
	if (in_array('comment', $prepare_object_subtypes)) {
		elgg_unregister_action('comment/save');
		elgg_register_action('comment/save', elgg_get_plugins_path() . 'notification_messages/actions/comment/save.php');
	}
	/* Comments subject override
	 * Why ?   Core function that adds the "Re: " for replies is loaded right before email sending hook, and can be skipped 
	 *         only by passing a non-array value.
	 *         But we need a parameters array to keep going, so we need to register our own instead
	 * How ?    Replace system default comment subject handler
	 */
	elgg_unregister_plugin_hook_handler('email', 'system', '_elgg_comments_notification_email_subject');
	// Register *earlier* to same hook and update (has to run before core and html_email_handler hook, which are both default priority 500)
	elgg_register_plugin_hook_handler('email', 'system', 'notification_messages_comments_notification_email_subject', 100);
	
	/* Direct Messages support
	 * Why ?   Control subject/content of message notifications
	 * When ?   If setting are set so DM are handled through this plugin..
	 * How ?   replace message action so we can use our custom message content
	 */
	$messages_send = elgg_get_plugin_setting('messages_send', 'notification_messages');
	if ($messages_send == 'yes') {
		elgg_unregister_action("messages/send");
		elgg_register_action("messages/send", elgg_get_plugins_path() . 'notification_messages/actions/messages/send.php');
	}
	
	
	
	/* STEP 3 : define recipients => elgg_register_plugin_hook_handler('get', 'subscriptions', 'discussion_get_subscriptions'); */
	/* Add owner to notification subscribers
	 * note: setting is checked in hook
	 * note 2: core function that sends notifications blocks adding owner to recipients : this is why 
	   we need to send the notification email directly to the owner through the send:before hook
	   at least until owner is not blocked in core
	 * @TODO : remove send:before hook once core accepts sending to owner !
	 * Note : we could alternatively use prepare hook, but send:before is the most logical
	 
	 * Alternative : use send:before hook to override core functions, and 
	*/
	elgg_register_plugin_hook_handler('get', 'subscriptions', 'notification_messages_get_subscriptions', 900);
	elgg_register_plugin_hook_handler('send:before', 'notifications', 'notification_messages_send_before_addowner', 900);
	// Serait une bonne méthode mais le hook ne passe pas $this qui n'est pas initialisé correctement
	//elgg_register_plugin_hook_handler('send:before', 'notifications', 'notification_messages_send_before_sendNotifications_override', 1000);
	
	
	
	
	/* NOTIFICATION HOOKS  - handle special cases and */
	
	// Ensure comments that pass through overrided comment action and comment_tracker get the right subject and message (as these use a different hook)
	// Note : should not be necessary as comment_tracker functions and comment action modified to use directly right message
	//elgg_register_plugin_hook_handler('notify:annotation:message', 'comment', 'notification_messages_prepare_notification', 900);
	
	
	
	
	/* Deprecated notes : 
	 * hook on notify:entity:message : replaced by prepare:notification:... hook since 1.9, not used if prepare hook is set
	 * hook on notify:annotation:subject (used by advanced_notifications) : handled differntly since replies are regular discussion_reply objects
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


// Include notification_messages functions & hooks
require_once(dirname(__FILE__) . '/lib/notification_messages/functions.php');


