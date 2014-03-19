<?php
/**
 * Announcements plugin translations
 *
 * @package CourseWare
 * @subpackage Announcements
 * @author Evan Winslow
 */

global $CONFIG;

$english = array(
	/**
	 * New object subtype: announcement
	 */
	'announcement' => 'Announcement', 
	'item:object:announcement' => 'Announcements',
	'announcement:write' => "Send a message to all members",

	/**
	 * Plugin-specific
	 */
	'announcements:announcements' => 'Announcements',
	'announcements:inbox' => 'Announcements',
	'announcements:user' => "%s's announcements",
	'announcements:owner' => "%s's announcements",
	'announcements:enableannouncements' => "Enable group announcements",
	'announcements:group' => 'Group announcements', 
	'announcements:add' => 'Add an announcement',
	'announcements:date' => 'Posted %s by %s.',
	'announcements:error' => 'Error posting announcement.',
	'announcements:message' => '%s<br /><br />%s (<a href="' . $CONFIG->wwwroot . 'profile/%s">Profile</a>)',
	'announcements:none' => "There are currently no announcements.",
	'announcements:post' => 'Post Announcement', 
	'announcements:subject' => '%s Announcement: %s',
	'announcements:new' => 'New Announcement', 
	'announcement:new' => 'New Announcement', 

	/**
	 * Actions
	 */
	'announcements:delete:success' => "Announcement deleted successfully.",
	'announcements:delete:failure' => "Sorry; we could not delete this announcement.",
	'announcements:post:success' => 'Announcement posted successfully.',
	'announcements:post:failure:permissiondenied' => 'Sorry, you are not allowed to post announcements in this group',
	'announcements:post:failure:blankbody' => 'Announcement body is required.',

	'river:object:announcement:create' => 'posted an announcement',
	'river:commented:object:announcement' => 'an announcement',
	/**
	 * API
	 */
	'announcements.get' => 'Retrieve announcements from the system based on several parameters',
);

add_translation("en", $english);
