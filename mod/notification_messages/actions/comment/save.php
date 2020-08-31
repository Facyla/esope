<?php
/**
 * Action for adding and editing comments
 *
 * @package Elgg.Core
 * @subpackage Comments
 */

$entity_guid = (int) get_input('entity_guid', 0, false);
$comment_guid = (int) get_input('comment_guid', 0, false);
$comment_text = get_input('generic_comment');
$is_edit_page = (bool) get_input('is_edit_page', false, false);

if (empty($comment_text)) {
	register_error(elgg_echo("generic_comment:blank"));
	forward(REFERER);
}

// Convert to HTML if input did not use wysiwyg editor
if($comment_text == strip_tags($comment_text)) {
	$comment_text = elgg_autop($comment_text);
}
// Remove any remaining \n or \r in HTML ? (useless because wysiwyg editor adds CR anyway on edition)
//$comment_text = str_replace(["\n", "\r", PHP_EOL], '', $comment_text);

if ($comment_guid) {
	// Edit an existing comment
	$comment = get_entity($comment_guid);

	if (!elgg_instanceof($comment, 'object', 'comment')) {
		register_error(elgg_echo("generic_comment:notfound"));
		forward(REFERER);
	}
	if (!$comment->canEdit()) {
		register_error(elgg_echo("actionunauthorized"));
		forward(REFERER);
	}

	$comment->description = $comment_text;
	if ($comment->save()) {
		system_message(elgg_echo('generic_comment:updated'));

		if (elgg_is_xhr()) {
			// @todo move to its own view object/comment/content in 1.x
			echo elgg_view('output/longtext', array(
				'value' => $comment->description,
				'class' => 'elgg-inner',
				'data-role' => 'comment-text',
			));
		}
	} else {
		register_error(elgg_echo('generic_comment:failure'));
	}
} else {
	// Create a new comment on the target entity
	$entity = get_entity($entity_guid);
	if (!$entity) {
		register_error(elgg_echo("generic_comment:notfound"));
		forward(REFERER);
	}

	$user = elgg_get_logged_in_user_entity();

	$comment = new ElggComment();
	$comment->description = $comment_text;
	$comment->owner_guid = $user->getGUID();
	$comment->container_guid = $entity->getGUID();
	$comment->access_id = $entity->access_id;
	$guid = $comment->save();

	if (!$guid) {
		register_error(elgg_echo("generic_comment:failure"));
		forward(REFERER);
	}

	// Note : notification should now be sent through the plugin hooks, even to self, so no need for this
	// @TODO : remove this action override and use the send:before hook instead
	/*
	// Notify if poster wasn't owner
	//if ($entity->owner_guid != $user->guid) {
	// Always notify owner if poster is not owner, use setting otherwise
	$notify_owner = false;
	if ($user->guid != $entity->owner_guid) {
		//$notify_owner = true;
		// Note : this is handled afterwards (through hooks)
	} else {
		// Also notify owner (self) if it is set so (required to notify the author itself)
		//$notify_owner = notification_messages_notify_owner();
		$notify_owner = notification_messages_notify_self();
	}

	if ($notify_owner) {
		$owner = $entity->getOwnerEntity();

		// Build more explicit subject
		$subject = elgg_echo('generic_comment:email:subject', array(), $owner->language);
		$new_subject = notification_messages_build_subject($comment, array('language' => $owner->language));
		if (!empty($new_subject)) { $subject = $new_subject; }

		// Build message content (no change compared to core action)
		$message = elgg_echo('generic_comment:email:body', array(
				$entity->title,
				$user->name,
				$comment_text,
				$comment->getURL(),
				$user->name,
				$user->getURL()
			), $owner->language);
		// Trigger a hook to enable integration with other plugins
		//$hook_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', array('entity' => $entity, 'to_entity' => $user), $message);
		$hook_message = notification_messages_build_body($comment, array('language' => $user->language));
		
		// Support adding postbymail button
		if (elgg_is_active_plugin('postbymail')) {
			$hook_message = postbymail_add_to_message($hook_message, $entity->guid);
		}
		// Failsafe backup if hook as returned empty content but not false (= stop)
		if (!empty($hook_message) && ($hook_message !== false)) { $message = $hook_message; }
		//error_log("NOTIFICATION SHOULD BE SENT TO {$user->guid}  {$user->username} {$user->name}  {$user->email}");
		// Send notifications
		notify_user($owner->guid,
			$user->guid,
			$subject,
			$message,
			array(
				'object' => $comment,
				'action' => 'create',
			)
		);
	}
	*/

	// Add to river
	elgg_create_river_item(array(
		'view' => 'river/object/comment/create',
		'action_type' => 'comment',
		'subject_guid' => $user->guid,
		'object_guid' => $guid,
		'target_guid' => $entity_guid,
	));
	
	system_message(elgg_echo('generic_comment:posted'));
	}

if ($is_edit_page) {
	forward($comment->getURL());
}

forward(REFERER);

