<?php

	$english = array(
	'rssimport:back:to:blog' => "Back to Blogs",
	'rssimport:back:to:bookmarks' => "Back to Bookmarks",
	'rssimport:back:to:file' => "Back to Files",
	'rssimport:back:to:pages' => "Back to Pages",
	'rssimport:blacklist:checked' => "Ignore Checked",
	'rssimport:blacklisted' => "Item has been deactivated and will not be imported.",
	'rssimport:blog' => "Blog",
	'rssimport:bookmarks' => "Bookmarks",
	'rssimport:by' => "By",
	'rssimport:title' => "RSSImport into Blog",
	'rssimport:check:all' => "Check All",
	'rssimport:check:none' => "Check None",
	'rssimport:create:new' => "Create New Import",
	'rssimport:create' => "Create",
	'rssimport:name' => "Feed Name",
	'rssimport:url' => "Feed URL",
	'rssimport:defaulttags' => "Default Tags",
	'rssimport:delete:confirm' => "This action cannot be undone.  Are you sure you want to delete this import feed?",
	'rssimport:copyright' => "By importing this feed you assert that you have rights to re-use the content.",
	'rssimport:copyright:error' => "You must acknowledge that you have the right to use the content of this feed",
	'rssimport:copyright:warning' => "This tool does not simply display feeds from other sites: it actually imports content from them and re-publishes it on this one. If you do not have the rights to do this you may be breaking the law and you should stop right now. If you are not the owner of the original feed, please ensure that the terms and conditions of the site from which you are downloading content explicitly give you the right to re-publish it. Remember that you are responsible for all content that will be added in your name to this site",
	'rssimport:cancel' => "Cancel",
	'rssimport:cron:description' => "Import schedule: ",
	'rssimport:cron:15m' => "15 min",
	'rssimport:cron:hourly' => "Hourly",
	'rssimport:cron:daily' => "Daily",
	'rssimport:cron:never' => "Manual Import",
	'rssimport:cron:weekly' => "Weekly",
	'rssimport:empty:copyright' => "You must acknowledge your understanding and acceptance of the copyright issues involved in importing external content",
	'rssimport:empty:field' => "Please fill out all fields",
	'rssimport:enableblog' => "Enable RSS importing into blogs?",
	'rssimport:enablebookmarks' => "Enable RSS importing into bookmarks?",
	'rssimport:enablepages' => "Enable RSS importing into pages?",
	'rssimport:defaultaccess:0' => "Private",
	'rssimport:defaultaccess:1' => "Logged In",
	'rssimport:defaultaccess:2' => "Public",
	'rssimport:defaultaccess:description' => "Access level for imported content",
	'rssimport:delete' => "Never Import",
	'rssimport:delete:fail' => "The feed could not be deleted.",
	'rssimport:delete:success' => "The feed was successfully deleted",
	'rssimport:edit:settings' => "Edit Feed Settings",
	'rssimport:group' => "Group",
	'rssimport:group:disabled' => "Importing into this content type is disabled for this group",
	'rssimport:history' => "History",
	'rssimport:ignore:description' => "Ignored items will not be automatically imported and will be invisible on this preview.",
	'rssimport:import' => "Import",
	'rssimport:import:lc' => "import",
	'rssimport:import:checked' => "Import Checked",
	'rssimport:import:created' => "Import has been created",
	'rssimport:import:rss' => "Import RSS Feed",
	'rssimport:import:selected' => "Import Selected",
	'rssimport:import:title' => "Import into %s's %s",
	'rssimport:import:updated' => "Import has been updated",
	'rssimport:imported:on' => "Imported on",
	'rssimport:imported' => "Items have been imported",
	'rssimport:into' => "Import into",
	'rssimport:invalid:content:type' => "Cannot import into the %s content type at this time",
	'rssimport:invalid:id' => "Invalid RSS Feed",
	'rssimport:invalid:history' => "Invalid history",
	'rssimport:invalid:permalink' => "Invalid link.",
	'rssimport:less' => "less",
	'rssimport:listing' => "Import Listing",
	'rssimport:menu' => "RSSImport",
	'rssimport:more' => "more",
	'rssimport:my' => "My",
	'rssimport:no:feed' => "Feed not found.",
	'rssimport:no:history' => "No history was found for this feed.",
	'rssimport:none:selected' => "No items selected",
	'rssimport:nothing:selected' => "Create a new feed to import, or select a feed you have previously created.",
	'rssimport:nothing:to:import' => "No items are available to import",
	'rssimport:not:owner' => "You do not have permission to perform this action",
	'rssimport:original' => "Original",
	'rssimport:page' => "Pages",
	'rssimport:postedon' => "Posted on ",
	'rssimport:posted' => "Posted",
	'rssimport:save:error' => "Feed could not be saved",
	'rssimport:select:all' => "Select all",
	'rssimport:tags' => "Tags",
	'rssimport:unblacklisted' => "Item has been activated, it can now be imported",
	'rssimport:undelete' => "Allow Import",
	'rssimport:undo:import' => "Undo Import",
	'rssimport:undo:import:confirm' => "This will delete any imported items.  This action cannot be undone.  Are you sure you want to continue?",
	'rssimport:undoimport:success' => "Import has been undone.",
	'rssimport:update' => "Update",
	'rssimport:view:history' => "View History",
	'rssimport:view:import' => "View Import",
	'rssimport:wrong:id' => "Incorrect feed id.",
	'rssimport:wrong:permissions' => "You don't have permission to do that.",
	'rssimport:error:ajax' => 'Could not process the request',
	
	/* Settings */
	'rssimport:allow:cron:hourly' => "Hourly",
	'rssimport:allow:cron:daily' => "Daily",
	'rssimport:allow:cron:weekly' => "Weekly",
	'rssimport:cron:frequency' => "Allowed Import Frequencies",
	'rssimport:cron:frequency:explanation' => 'If all import frequencies are disallowed imports can still be achieved manually. These settings only affect automatic scheduled imports.',
	'rssimport:grouptools' => "Tools enabled for group import",
	'rssimport:setting:adminonly' => "Restrict importing rss feeds to administrators only",
	
	/* common curl errors */
	'rssimport:curl:error:default' => 'There was an issue getting your feed.  Please make sure all settings are correct.',
	'rssimport:curl:error:6' => 'Could not find a valid feed at this location.  Please double-check the url.',
	'rssimport:curl:error:7' => 'Cannot connect to the destination network.  Ensure that the location you provided is correct.  If the location uses a non-default protocol (eg. https) it may be due to firewall restrictions on your server.',
	
	// Fing additions
	'rssimport:ownership' => "Imported content ownership",
	'rssimport:ownership:explanation' => "Content can be published in the name of the member who set up the import, or to the container of the content, which means the container group when importing into a group.",
	'rssimport:ownership:container' => "Container : group or member",
	'rssimport:ownership:owner' => "Owner of import",
	'rssimport:roles' => "Access to import tools",
	'rssimport:roles:explanation' => "Lets you define who has access to the import tool : everyone, group admins ou administrators",
	'rssimport:role:user' => "All members",
	'rssimport:role:groupadmin' => "Groups admins",
	'rssimport:role:admin' => "Administrators only",
	
	// ESOPE : internationalize date string
	'rssimport:date:format' => 'F j, Y, g:i a',
	
);

add_translation("en",$english);

