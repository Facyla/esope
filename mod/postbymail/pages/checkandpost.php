<?php
/*
 * Plugin loosely based on MailFeed v1.0.1
 * Copyright © 2004 Ryan Grove <ryan@wonko.com>. All rights reserved.
 * Checks a POP3, IMAP, or NNTP mailbox on demand and returns an RSS feed
 * containing the messages in the mailbox. See the MailFeed website at
 * http://wonko.com/software/mailfeed/ for details.
 *

TODO
Marqueurs de réponse : les adresses email avec param ne passent pas dans la plupart des messageries texte (gmail sur mobile...)

Autres pistes de développements :
  * Mail pour un nouveau post personnel : pas pour le RS Fing, mais paramètres avec une adresse personnalisée et privée pour publier par mail
  * Mail pour un nouveau post dans un groupe : email de publication spécifique au groupe

*/

//require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

// require custom libraries
elgg_load_library('elgg:postbymail');


$title = elgg_echo('postbymail:title');

#################
# Configuration #
#################

/* POP3/IMAP/NNTP server to connect to, with optional port. */

// Allow configuration file inclusion
// @TODO : test si file_exists
$settings_file = elgg_get_plugins_path() . 'postbymail/settings.php';
if (file_exists($settings_file) && include_once($settings_file)) {
	$body .= '<p>' . elgg_echo('postbymail:settings:loadedfromfile') . '</p>';
	//$body .= "DEBUG : $server $protocol $mailbox $username $password $markSeen $bodyMaxLength $separator";
} else {
	$body .= '<p>' . elgg_echo('postbymail:settings:loadedfromadmin') . '</p>';
}

// Use custom admin settings for settings that were not set in config file (no set = variable not defined, eg. can be empty)

//$server = "localhost:143";
if (!isset($server)) $server = elgg_get_plugin_setting('server', 'postbymail');

/* Protocol specification (optional) */
//$protocol = "/notls";
if (!isset($protocol)) $protocol = elgg_get_plugin_setting('protocol', 'postbymail');

/* Name of the mailbox to open. */
// Boîte de réception = presque toujours INBOX mais on peut récupérer les messages d'un dossier particulier également..
if (!isset($mailbox)) $mailbox = elgg_get_plugin_setting('inboxfolder', 'postbymail');

/* Mailbox username. */
if (!isset($username)) $username = elgg_get_plugin_setting('username', 'postbymail');

/* Mailbox password. */
if (!isset($password)) $password = elgg_get_plugin_setting('password', 'postbymail');

/* Whether or not to mark retrieved messages as seen. */
if (!isset($markSeen)) $markSeen = false;
//if (empty($markSeen)) $markSeen = elgg_get_plugin_setting('markSeen', 'postbymail');

/* If the message body is longer than this number of bytes, it will be trimmed. Set to 0 for no limit. */
//$bodyMaxLength = 0; //$bodyMaxLength = 4096;
// This (65536) is actually default MySQL configuration for Elgg's description fields
// (set appropriate field to longtext in your database if you want to ovveride that limit)
if (!isset($bodyMaxLength)) $bodyMaxLength = 65536;
//if (empty($bodyMaxLength)) $bodyMaxLength = elgg_get_plugin_setting('bodymaxlength', 'postbymail');

// Séparateurs du message
if (!isset($separator)) $separator = elgg_get_plugin_setting('separator', 'postbymail');
// Force a default separator, just because we need it
if (empty($separator)) $separator = elgg_echo('postbymail:default:separator');

#################################
# End of User-Editable Settings #
#################################


// Set up the parameters for the MimeDecode object.
$mimeParams = array();
$mimeParams['decode_headers'] = true;
$mimeParams['crlf']           = "\r\n";
$mimeParams['include_bodies'] = true;
$mimeParams['decode_bodies']  = true;

/*
$postbymail_vars = array();
$postbymail_vars['server'] = $server;
$postbymail_vars['protocol'] = $protocol;
$postbymail_vars['mailbox'] = $mailbox;
$postbymail_vars['username'] = $username;
$postbymail_vars['password'] = $password;
$postbymail_vars['markSeen'] = $markSeen;
$postbymail_vars['bodyMaxLength'] = $bodyMaxLength;
$postbymail_vars['separator'] = $separator;
$postbymail_vars['mimeParams'] = $mimeParams;
*/

// Required for simulation purpose (can be called and displayed by an admin, and we need it to behave exactly the same as when launched by a cron task)
elgg_set_context('cron');


// Check settings
if (empty($server) || empty($username) || empty($password)) {
	$body .= '<p>' . elgg_echo('postbymail:settings:error:missingrequired') . '</p>';
}
$body .= '<p>' . elgg_echo('postbymail:settings:separator') . '&nbsp;: ' . $separator . '</p>';
$body .= '<hr />';

// Perform check only if we have the required parameters
if (!empty($server) && !empty($username) && !empty($password)) {
	$body .= postbymail_checkandpost($server, $protocol, $mailbox, $username, $password, $markSeen, $bodyMaxLength, $separator, $mimeParams);
}



// Par défaut on n'affiche rien sinon on se retrouve avec deux pages...

// Exception si on veut une page de contrôle - à différencier
$display = get_input('display', false);
if (elgg_is_admin_logged_in() && ($display == "yes")) {
	$body = elgg_view_layout('one_column', array('title' => $title, 'content' => '<div class="contentWrapper">' . $body . '</div>'));
	echo elgg_view_page($title, $body);
}


