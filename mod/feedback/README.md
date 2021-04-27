Feedback plugin for Elgg 2.3
----------------------------
Provides a powerful feedback tool with communication and bugtracker features
License: GNU General Public License version 2
Copyright: (c) Facyla (1.8 improvements), iionly (for Elgg 1.8), Simon ST (for Elgg 1.7), Prashant Juvekar (initial plugin)

This plugin displays a feedback dialog window on the left hand side of the pages on your Elgg site. 
The dialog window starts minimized and can be opened by a "feedback" "button. The feedback button shows up on all pages on your site when a user is logged in. For logged-out site visitors you can configure the feedback button to show or not via a plugin setting.

The feedback sent by users will be listed in the admin section of your site ("Administer" - "Utilities" - "Site feedback") and additionally you can add a feedback widget to the admin dashboard. Also, you have the option to enter up to five users who should receive notifications about new feedback.


## Main features
 * add feedback on any page
 * choose optional mood and feedback category
 * choose optional feedback access (admin only, group, other... depends on plugin settings)
 * discussion between admins and user who submitted feedback
 * for admins: several useful listing features : open/closed feedbacks + listings per feedback category
 * for admins: keep track of reported page URL, posting user, date
 * for admins: mark feedbacks as closed (or reopen them))


## Installation
1. copy the feedback folder into the mod folder of your site.
2. enable the plugin in the admin section of your site.
3. go to plugin settings and enter up to five usernames of site members who should get notified about new feedbacks. Configure other plugin settings - see below. 

Note: if updating from Elgg 1.8 version, or from an early Elgg 1.12 version, you may have feedbacks with no title. To correct this, please log in as an admin, and visit the URL SITE_URL://path/to/mod/feedback/tools/feedbacks_title.php?action=convert_feedbacks to convert the old feedback objects



## Plugin settings
 * enable public feedbacks
 * define notified users (up to 5)
 * allow users to view feedbacks
 * enable feedback discussions (comments)
 * associate feedbacks with groups (none, main, multiple)
 * enable/disable mood
 * enable/disable feedback categories
 * define feedback categories


## Changelog
 * 2.3 - AMD for JS
 * 1.12.1 : Production version released as independant plugin
 * 1.12.0 : 2016 Updated to Elgg 1.12
	 - FA icons
 * 1.8.19 - Facyla additions
	 - listing page and categorization menu, public comments, feedback status, notifications, various rewrites...
	 - Update from older version which do not have a feedback title : run mod/feedback/tools/feedbacks_title.php
 * 1.8.14 : Facyla 2013.04
	 - french translation
	 - admin settings
	 - many changes and improvements to let admins use feedbacks as an animation tool : 
		 * access rights, 
		 * "about" filtering, 
		 * status + filtering, 
		 * association to groups, 
		 * etc.
* 1.8.0beta1:
	 - Initial release for Elgg 1.8,
	 - Captcha check (only used when logged out) currently commented out in code as it does not refresh in the way I would like to.
	 - For logged-out visitors it does not yet work with Elgg's walled-garden option enabled or when the Loginrequired plugin is used.


