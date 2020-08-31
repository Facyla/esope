# Notification messages plugin for Elgg

This plugins provides useful subjects for email messages, when new content is created, and replies or comments are made. It uses html_email_handler with object:notifications hook activated, and/or advanced_notifications plugin enabled.

Notes : 
 * This plugin is inspired by former plugin notification_messages for Elgg 1.6 (discontinued due to API changes)
 * Developped after an initial PR on html_email_handler to add a hook to change subject 
 *   (same as notify:entity:message core hook, but for subjects)
 * Used hook is implemented in advanced_notifications (by Coldtrick) / and this html_email_handler version
 * Also built after careful reading of notification_subjects by Matt Backet


HISTORY :

1.12.2-rc2 : 20180125 - Avoid duplicate messages for comments (use only hooks to send emails)

1.12.2-rc1 : 20171103

1.12.2-beta : 20171031 - Better settings
 * Added several settings to control recipients and notification events :
   - notify owner
   - notify self
   - notify participants
   - notifify top container subscribers
 * Rewrite some helper functions

1.12.1 : 20171004 - Better settings and explanations
 * Adding registered notifications events settings and support
 * Added list of registered hooks and events related to notifications control

1.12.0-dev : 20160311 - Updating to Elgg 1.12

0.3 : 20140326 - Forum replies and generic_comment support

0.2 : 201403.. - First functionnal version (new objects)

0.1 : 20140317 - Initial version

