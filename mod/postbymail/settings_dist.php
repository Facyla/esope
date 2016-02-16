<?php
/**
 * Postbymail settings template file
 * Overrides admin settings if set (settings that are not set here will use admin config)
 * Use this if you do not feel like using a plain email password in Elgg admin interface
 * Note that any variable that is set here will override admin settings and default behaviour
 * ...so better comment the variables if you are not sure, or you wish to set them through admin interface
 * 
 * Settings are commented with : SETTING
 * @author Florian DANIEL aka Facyla <facyla@gmail.com>
 */


/* MANDATORY SETTINGS */

/* Mail server address and port, eg. $server = "localhost:143"; $server = 'localhost:993';
 * SETTING - mandatory
 */
//$server = '';

/* Mailbox username.
 * SETTING - mandatory
 */
//$username = '';

/* Mailbox password.
 * SETTING - mandatory
 */
//$password = '';


/* OPTIONAL SETTINGS */

/* Protocol specification (optional), eg. $protocol = "/notls"; $protocol = '/imap/ssl/novalidate-cert';
 * SETTING - optional
 */
//$protocol = '';

/* Name of the mailbox to open.
 * Boîte de réception = presque toujours INBOX mais on peut récupérer les messages d'un dossier particulier également..
 * SETTING - optional
 * $mailbox = 'INBOX';
 */
//$mailbox = '';

/* Whether or not to mark retrieved messages as seen.
 * SETTING - better set it through admin
 */
//$markSeen = false;

/* If the message body is longer than this number of bytes, it will be trimmed. Set to 0 for no limit.
 * This (65536) is actually default MySQL configuration for Elgg's description fields
 * (set appropriate field to longtext in your database if you want to ovveride that limit)
 * SETTING - set only if you know exactly what this does...
 */
//$bodyMaxLength = 65536;

/* Message separator
 * Has to be set to something (not empty), or will default to the separator set in translation file
 * SETTING - better set it through admin interface
 */
//$separator = '';



