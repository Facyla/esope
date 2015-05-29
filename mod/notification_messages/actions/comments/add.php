<?php
/**
 * Elgg add comment action
 *
 * @package Elgg.Core
 * @subpackage Comments
 */

$entity_guid = (int) get_input('entity_guid');
$comment_text = get_input('generic_comment');

if (empty($comment_text)) {
	register_error(elgg_echo("generic_comment:blank"));
	forward(REFERER);
}

// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("generic_comment:notfound"));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

$annotation = create_annotation($entity->guid, 'generic_comment', $comment_text, "", $user->guid, $entity->access_id);

// tell user annotation posted
if (!$annotation) {
	register_error(elgg_echo("generic_comment:failure"));
	forward(REFERER);
}


// Always notify if poster is not owner
$notify = false;
if ($entity->owner_guid != $user->guid) {
	$notify = true;
} else {
	$notify = notification_messages_notify_owner();
}


if ($notify) {
	// Build more explicit subject
	$default_subject = elgg_echo('generic_comment:email:subject');
	$subject = notification_messages_build_subject($entity);
	if (empty($subject)) { $subject = $default_subject; }
	// Build message content (no change compared to core action)
	$message = elgg_echo('generic_comment:email:body', array(
				$entity->title,
				$user->name,
				$comment_text,
				$entity->getURL(),
				$user->name,
				$user->getURL(),
			));
	// Trigger a hook to enable integration with other plugins
	$hook_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', array('entity' => $entity, 'to_entity' => $user), $message);
	// Failsafe backup if hook as returned empty content but not false (= stop)
	if (!empty($hook_message) && ($hook_message !== false)) { $message = $hook_message; }
	
	// Send notifications
	notify_user($entity->owner_guid, $user->guid, $subject, $message);
}

system_message(elgg_echo("generic_comment:posted"));

//add to river
add_to_river('river/annotation/generic_comment/create', 'comment', $user->guid, $entity->guid, "", 0, $annotation);

// Forward to the page the action occurred on
forward(REFERER);

