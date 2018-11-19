<?php
/** Elgg notification_messages plugin language
 * @author Florian DANIEL - Facyla
 * @copyright Florian DANIEL - Facyla 2015-2017
 * @link https://facyla.fr/
 */

$url = elgg_get_site_url();

return array(
	'notification_messages' => "Notification messages",
	
	// Actions
	'notification_messages:create' => "has published",
	'notification_messages:delete' => "has deleted",
	'notification_messages:update' => "has updated",
	
	// Explanations
	'notification_messages:process' => "How do notifications work?",
	'notification_messages:process:details' => "2 different modes:
		<ol>
			<li>Direct: notifications are sent immediately, through a system's action, by notify_user. This is especially the case for registration or requests notifications, direct messages, and any notification where the number of recipients is limited.</li>
			<li>Scheduled queue: notifications are sent when a registered notification happens. The notifications are then sent through the \"minute\" cron, so the current action is not slowed down.
				<ul>
					<li>Notifications-triggering events are registered through <code>elgg_register_notification_event('object', 'photo', array('create'))</code><br />Other event handlers may afffect the notifications behaviour, eg. by blocking them.</li>
					<li>Subject and message content can be modified by the hook <code>elgg_register_plugin_hook_handler('prepare', 'notification:create:object:photo', 'photos_prepare_notification')</code></li>
					<li>Recipients can be modified by the hook <code>elgg_register_plugin_hook_handler('get', 'subscriptions', 'discussion_get_subscriptions')</code></li>
				</ul>
			</li>
		</ol>",
	
	// Settings
	'notification_messages:settings:objects' => "Registered notification events and subject handling",
	'notification_messages:settings:details' => "By activating detailed notification messages for each of these content types, you can replace the default mail title by a more meaningful subject, composed in this form: [Publication type Group or member name] Content title<br />This facilitates the identification of conversations by email clients.",
	'notification_messages:object:subtype' => "Object type",
	'notification_messages:setting' => "Setting",
	'notification_messages:events' => "Notification for event types",
	'notification_messages:recipients:setting' => "Recipients",
	'notification_messages:recipients:setting:details' => "Use get,subscriptions hook",
	'notification_messages:register:default' => "Default",
	'notification_messages:recipients:default' => "Default",
	'notification_messages:prepare:setting' => "Prepare message content",
	'notification_messages:subject:default' => "Default subject",
	'notification_messages:subject:allow' => "Improved subject",
	'notification_messages:subject:deny' => "Blocked (no notification at all)",
	'notification_messages:message:default' => "Default message",
	'notification_messages:message:allow' => "Improved message",
	'notification_messages:settings:group_topic_post' => "Enable for group topic replies",
	'notification_messages:settings:comments' => "Comments notifications",
	'notification_messages:settings:comments:details' => "If you have enabled this plugin, you probably wish to enable this setting, so all comments will use the same subject as the new content.",
	'notification_messages:settings:generic_comment' => "Enable for all generic comments",
	'notification_messages:settings:messages' => "Messages",
	'notification_messages:settings:recipients' => "Notifications recipients",

	'notification_messages:settings:notify_owner' => "Notify the owner?",
	'notification_messages:settings:notify_owner:details' => "Notify the author of a content when a reply or a comment has been made, or it has been updated.",
	'notification_messages:settings:notify_owner:comment_tracker' => "When comment_tracker plugin is enabled, this setting is not available and should be set directly in <a href=\"" . $url . "admin/plugin_settings/comment_tracker\">comment_tracker plugin settings</a>.",
	
	'notification_messages:settings:notify_self' => "Notify self?",
	'notification_messages:settings:notify_self:details' => "By default, the comment author is not notified. You can change this behaviour, which can be particularly useful when using email reply.",
	
	'notification_messages:settings:notify_participants' => "Notify all participants",
	'notification_messages:settings:notify_participants:details' => "Notify all members who take part in the discussion (replies, comments, edits).",
	
	'notification_messages:settings:notify_replies' => "Notify replies as new content",
	'notification_messages:settings:notify_replies:details' => "Notify the replies and comments the same way as new content is notified, ie. all group members, or all members subscribed to the top container entity.",

	'notification_messages:settings:expert' => "Expert",
	'notification_messages:settings:messagehandledby' => "Message defined by: ",
	'notification_messages:settings:nomessage' => "NO",
	'notification_messages:settings:notify_replies' => "Replies notification",
	'notification_messages:settings:notify_replies:details' => "Notify replies and comments the same way as initial publications",
	
	'notification_messages:notify:create' => "create",
	'notification_messages:notify:publish' => "publish",
	'notification_messages:notify:update' => "update",
	'notification_messages:notify:delete' => "delete",
	
	'notification_messages:create' => "CREATE",
	'notification_messages:publish' => "PUBLISH",
	'notification_messages:update' => "UPDATE",
	'notification_messages:delete' => "DELETE",
	'notification_messages:create:body' => "",
	'notification_messages:publish:body' => "",
	'notification_messages:update:body' => "The content has been updated.\r\n\r\n",
	'notification_messages:delete:body' => "The content has been removed.\r\n\r\n",
	
	// Notification containers
	'notification_messages:container:subgroup' => "%s / %s",
	
	// Notification message content
	'notification_messages:settings:objects:message' => "Notification messages content",
	'notification_messages:message:default:blog' => "By default, blog notification messages contains only the extract.",
	
	// Notification subject
	'notification_messages:objects:subject' => "[%s | %s] %s",
	'notification_messages:objects:subject:update' => "[%s | Update %s] %s",
	'notification_messages:objects:subject:delete' => "[%s | Delete %s] %s",
	'notification_messages:objects:subject:nocontainer' => "[%s] %s",
	'notification_messages:objects:subject:nocontainer:update' => "[Update %s] %s",
	'notification_messages:objects:subject:nocontainer:delete' => "[Delete %s] %s",
	'notification_messages:untitled' => "(untitled)",
	
	'notification_messages:objects:body' => "%s has published %s in %s:

%s

Read and comment online:
%s
",
	'notification_messages:objects:body:update' => "%s has updated %s in %s:

%s

Read and comment online:
%s
",
	'notification_messages:objects:body:delete' => "%s has deleted %s in %s:

%s

Read and comment online:
%s
",
	
	'notification_messages:objects:body:nocontainer' => "%s has published %s:

%s

Read and comment online:
%s
",
	'notification_messages:objects:body:nocontainer:update' => "%s has updated %s:

%s

Read and comment online:
%s
",
	'notification_messages:objects:body:nocontainer:delete' => "%s has deleted %s:

%s

Read and comment online:
%s
",
	
	// Messages
	'notification_messages:email:subject' => "[%s] Message from %s: %s",
	
	// Object:notifications hook control
	'notification_messages:settings:object_notifications_hook' => "Enable the hook on object:notifications",
	'notification_messages:settings:object_notifications_hook:subtext' => "This hook lets other plugins easily add attachments and other parameters to notify_user, and therefor to emails, the same way messages can be changed. Caution because the use of this hook can break other notification plugins processes -at least advanced_notifications- because it handles the sending process, and replies \"true\" to the hook, which blocks the process when the hook is triggered.<br />If you don't know what to choose, leave on default.",
	
	'notification_messages:settings:messages_send' => "Use HTML in direct messages",
	'notification_messages:settings:messages_send:subtext' => "By default, direct messages sent by the platform via email are using plain text. This setting doesn't strip HTML tags before sending direct messages by email",
	
	'notification_messages:subject:comment' => "%s | Comment",
	'notification_messages:subject:discussion_reply' => "%s | Reply",
	'notification_messages:subject:reply' => "Re: %s",
	
	'notification_messages:summary:wrapper' => "%s

%s

%s",
	
	'notification_messages:body:inreplyto' => "%s


In reply to:
<blockquote>
%s
</blockquote>",
	
	
);

