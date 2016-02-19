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

$config = postbymail_get_config();
/*
$server = $config['server'];
$protocol = $config['protocol'];
$mailbox = $config['mailbox'];
$username = $config['username'];
$password = $config['password'];
$markSeen = $config['markSeen'];
$bodyMaxLength = $config['bodyMaxLength'];
$separator = $config['separator'];
$mimeParams = $config['mimeParams'];
*/


// Required for simulation purpose (can be called and displayed by an admin, and we need it to behave exactly the same as when launched by a cron task)
elgg_set_context('cron');


// Display separator
if (!empty($config['separator'])) {
	$body .= '<p>' . elgg_echo('postbymail:settings:separator') . '&nbsp;: ' . $config['separator'] . '</p>';
	$body .= '<hr />';
}

// Perform check only if we have the required parameters
if (postbymail_check_required($config)) {
	//$body .= postbymail_checkandpost($server, $protocol, $mailbox, $username, $password, $markSeen, $bodyMaxLength, $separator, $mimeParams);
	$body .= postbymail_checkandpost($config);
} else {
	$body .= '<p>' . elgg_echo('postbymail:settings:error:missingrequired') . '</p>';
}



// Par défaut on n'affiche rien sinon on se retrouve avec deux pages...
// Mais exception si on veut une page de contrôle pour les admins
$display = get_input('display', false);
if (elgg_is_admin_logged_in() && ($display == "yes")) {
	$body = elgg_view_layout('one_column', array('title' => $title, 'content' => '<div class="contentWrapper">' . $body . '</div>'));
	echo elgg_view_page($title, $body);
}


