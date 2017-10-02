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
	
	// Override settings save action so we can usr checkboxes / multiselect
	elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'notification_messages_plugin_settings');
	
	// Get all subtypes handled by this plugin
	$subtypes = elgg_get_plugin_setting('object_subtypes', 'notification_messages');
	$subtypes = explode(',', $subtypes);
	// Add discussion replies if discussion is in the list
	if (in_array('groupforumtopic', $subtypes)) { $subtypes[] = 'discussion_reply'; }
	$subtypes = array_unique($subtypes);
	
	
	/* STEP 1 : register notification events */
	// elgg_register_notification_event('object', 'photo', array('create'));
	$register_object_subtypes = elgg_get_plugin_setting('register_object_subtypes', 'notification_messages');
	$register_object_subtypes = unserialize($register_object_subtypes);
	
	if ($register_object_subtypes) {
		foreach ($register_object_subtypes as $subtype => $setting) {
			
			//elgg_register_notification_event($object_type, $object_subtype, $actions = array())
			//elgg_unregister_notification_event($object_type, $object_subtype)
			$actions = array();
			//if (elgg_get_plugin_setting('register_object_'))
		}
	}
	
	
	
	/* STEP 2 : define notification content => elgg_register_plugin_hook_handler('prepare', 'notification:create:object:photo', 'photos_prepare_notification'); */
	
	// Update subject + body + summary
	// Handle new (registered) objects notification subjects
	//elgg_register_plugin_hook_handler('notify:entity:subject', 'object', 'notification_messages_notify_subject');
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
	
	
	
	/* STEP 3 : define recipients => elgg_register_plugin_hook_handler('get', 'subscriptions', 'discussion_get_subscriptions'); */
	/* Add owner to notification subscribers
	 * note: setting is checked in hook
	 * note 2: core function that sends notifications blocks adding owner to recipients : this is why 
	   we need to send the notification email directly to the owner through the send:before hook
	   at least until owner is not blocked in core
	 * @TODO : remove send:before hook once core accepts sending to owner !
	*/
	elgg_register_plugin_hook_handler('get', 'subscriptions', 'notification_messages_get_subscriptions_addowner', 900);
	elgg_register_plugin_hook_handler('send:before', 'notifications', 'notification_messages_send_before_addowner', 900);
	
	
	
	
	/* NOTIFICATION HOOKS  - handle special cases and */
	
	// Ensure comments that pass through overrided comment action and comment_tracker get the right subject and message (as these use a different hook)
	// Note : should not be necessary as comment_tracker functions and comment action modified to use directly right message
	//elgg_register_plugin_hook_handler('notify:annotation:message', 'comment', 'notification_messages_prepare_notification', 900);
	
	
	// @TODO Handle properly comment subjects
	// Register *earlier* to same hook and update (has to run before core and html_email_handler hook, which are default priority)
	elgg_register_plugin_hook_handler('email', 'system', 'notification_messages_comments_notification_email_subject', 100);
	// Remove system default comment subject handler (because it is loaded right before email sending hook)
	elgg_unregister_plugin_hook_handler('email', 'system', '_elgg_comments_notification_email_subject');
	
	
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
	
	// Replace comment action if asked to
	$generic_comment = elgg_get_plugin_setting('generic_comment', 'notification_messages');
	switch ($generic_comment) {
		case 'allow':
			$action_path = elgg_get_plugins_path() . 'notification_messages/actions/';
			elgg_unregister_action('comment/save');
			elgg_register_action('comment/save', $action_path . 'comments/save.php');
			break;
		case 'deny':
			elgg_unregister_action('comment/save');
			break;
		default:
			// do not change anything
	}
	
}



// Include Inria functions
require_once(dirname(__FILE__) . '/lib/notification_messages/functions.php');

