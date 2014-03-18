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
	'notification_messages:settings:details' => "By activating detailed notification messages for each of these content types, you can replace the default mail title by a more meaningful subject, composed in this form: [Publication type Group or member name] Content title<br />This facilitates the identification of conversations by email clients.",
	'notification_messages:object:subtype' => "Object type",
	'notification_messages:setting' => "Setting",
	'notification_messages:subject:default' => "Default subject",
	'notification_messages:subject:allow' => "Improved subject",
	'notification_messages:subject:deny' => "Blocked (no notification at all)",
	
	// Notification subject
	'notification_messages:objects:subject' => "[%s %s] %s",
	'notification_messages:untitled' => "(untitled)",

);

add_translation("en", $english);

