<?php
/**
 * Announcements plugin translations
 *
 * @package CourseWare
 * @subpackage Announcements
 * @author Evan Winslow
 */

$url = elgg_get_site_url();

return array(
	/**
	 * New object subtype: announcement
	 */
	'announcement' => 'Announcement', 
	'item:object:announcement' => 'Announcements',
	'announcement:write' => "Send a message to all members",
	
	/**
		* Settings
		*/
	'announcements:settings:group_recipients' => "Group announcements recipients",
	'announcements:group_recipients:default' => "Default (user settings)",
	'announcements:group_recipients:email_members' => "Force email to all group members",
	'announcements:settings:hide_groupmodule' => "Hide group module",
	'announcements:hide_groupmodule:no' => "No (default)",
	'announcements:hide_groupmodule:nonadmin' => "Non-admins (appears only for group admins)",
	'announcements:hide_groupmodule:yes' => "Yes (does not appear on group modules)",
	'announcements:settings:can_comment' => "Enable user comments on announcements",
	
	/**
	 * Plugin-specific
	 */
	'announcements:announcements' => 'Announcements',
	'announcements:inbox' => 'Announcements',
	'announcements:user' => "%s's announcements",
	'announcements:owner' => "%s's announcements",
	'announcements:enableannouncements' => "Enable announcements",
	'announcements:group' => 'Announcements', 
	'announcements:add' => 'Add an announcement',
	'announcements:date' => 'Published %s by %s.',
	'announcements:error' => 'Error posting announcement.',
	'announcements:message' => '%s<br /><br />%s (<a href="' . $url . 'profile/%s">Profile</a>)',
	'announcements:none' => "There is currently no announcement.",
	'announcements:post' => 'Publish Announcement', 
	'announcements:subject' => '%s Announcement: %s',
	'announcements:new' => 'New Announcement', 
	'announcement:new' => 'New Announcement', 
	'announcements:everyone' => "All les announcements",

	/**
	 * Actions
	 */
	'announcements:delete:success' => "Announcement deleted successfully.",
	'announcements:delete:failure' => "Sorry; we could not delete this announcement.",
	'announcements:post:success' => 'Announcement posted successfully.',
	'announcements:post:failure:permissiondenied' => 'Sorry, you are not allowed to post announcements in this group',
	'announcements:post:failure:blankbody' => 'Announcement body is required.',

	'river:object:announcement:create' => 'posted an announcement',
	'river:create:object:announcement' => 'New announcement',
	'river:commented:object:announcement' => '%s has made an announcement %s',
	'announcements:river:togroup' => "to the members of %s",
	
	
	// Errors
	'announcements:error:cannotsave' => "Error: we could not save the announcement.  You probably do not have the correct permissions",
	'announcements:error:invaliduser' => "Invalid username. Redrecting to all announcements page.",
	
	/**
	 * API
	 */
	'announcements.get' => 'Retrieve announcements from the system based on several parameters',
	
	
	// Notifications
	'announcements:notify:subject' => "[%2\$s] %1\$s",
	'announcements:notify:body' => "%s has made an announcement in group %s:
	
	<h3>%s</h3>
	
	%s
	
	
	See online: %s
	",
	'announcements:notify:summary' => "New announcement: %s",
	
);

