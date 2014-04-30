<?php
/** Elgg notification_messages plugin language
 * @author Florian DANIEL - Facyla
 * @copyright Florian DANIEL - Facyla 2014
 * @link http://id.facyla.net/
 */

$english = array(

	'notification_messages' => "Notification messages",
	
	// Actions
	'notification_messages:create' => "has published",
	'notification_messages:delete' => "has deleted",
	'notification_messages:update' => "has updated",
	
	// Settings
	'notification_messages:settings:objects' => "New content (registered objects)",
	'notification_messages:settings:details' => "By activating detailed notification messages for each of these content types, you can replace the default mail title by a more meaningful subject, composed in this form: [Publication type Group or member name] Content title<br />This facilitates the identification of conversations by email clients.",
	'notification_messages:object:subtype' => "Object type",
	'notification_messages:setting' => "Setting",
	'notification_messages:subject:default' => "Default subject",
	'notification_messages:subject:allow' => "Improved subject",
	'notification_messages:subject:deny' => "Blocked (no notification at all)",
	'notification_messages:settings:group_topic_post' => "Enable for group topic replies",
	'notification_messages:settings:comments' => "Comments",
	'notification_messages:settings:comments:details' => "If you have enabled this plugin, you probably wish to enable this setting, so all comments will use the same subject as the new content.",
	'notification_messages:settings:generic_comment' => "Enable for all generic comments",
	
	// Notification subject
	'notification_messages:objects:subject' => "[%s | %s] %s",
	'notification_messages:objects:subject:nocontainer' => "[%s] %s",
	'notification_messages:untitled' => "(untitled)",
	
	// Object:notifications hook control
	'notification_messages:settings:object_notifications_hook' => "Enable the hook on object:notifications",
	'notification_messages:settings:object_notifications_hook:subtext' => "This hook lets other plugins easily add attachments and other parameters to notify_user, and therefor to emails, the same way messages can be changed. Caution because the use of this hook can break other notification plugins processes -at least advanced_notifications- because it handles the sending process, and replies \"true\" to the hook, which blocks the process when the hook is triggered.<br />If you don't know what to choose, leave on default.",
	
);

add_translation("en", $english);

