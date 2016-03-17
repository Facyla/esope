<?php
/**
 * Post by mail plugin
 *
 * Author: Florian DANIEL aka Facyla
 * 
 * This plugin allows users to reply by email to a forum thread, or to any publication in an Elgg site, or even post new content
 *
 * This plugin is meant to be integrated within your notification system, please read carefully the documentation (in README and optionnally within code) for instructions
 * 
*/

elgg_register_event_handler('init','system','postbymail_init');

function postbymail_init() {
	
	// Register and load postbymail libraries
	elgg_register_library('elgg:postbymail', elgg_get_plugins_path() . 'postbymail/lib/functions.php');
	elgg_load_library('elgg:postbymail');
	
	// Include other required functions
	require_once(elgg_get_plugins_path() . 'postbymail/lib/hooks.php');
	
	
	// Page handler
	elgg_register_page_handler('postbymail', 'postbymail_pagehandler');
	
	// Register cron - no default - requires explicit setting
	$cron_freq = elgg_get_plugin_setting('cron', 'postbymail');
	if (in_array($cron_freq, array('minute', 'fiveminute', 'fifteenmin', 'halfhour', 'hourly', 'daily', 'weekly'))) {
		elgg_register_plugin_hook_handler('cron', $cron_freq, 'postbymail_cron_handler');
	}
	
	// Pass entity GUID (set it as global var)
	// Pour déterminer et transmettre le GUID qui doit être passé en paramètre
	// @TODO : vérifier fonctionnement !!
	elgg_register_plugin_hook_handler('send:before', 'notifications', 'postbymail_send_before_notifications_hook', 0);
	elgg_register_event_handler('annotate', 'all', 'postbymail_annotate_event_notifications', 0);
	
	
	// Add reply block to email
	//elgg_register_plugin_hook_handler("email", "system", "postbymail_email_hook");
	
	// Ajout du bloc de réponse au contenu à tous les messages de notification
	// Update notification body for new content
	$subtypes = elgg_get_plugin_setting('reply_object_subtypes', 'postbymail');
	$subtypes = explode(',', $subtypes);
	// Add discussion replies if discussion is in the list
	if (in_array('groupforumtopic', $subtypes)) { $subtypes[] = 'discussion_reply'; }
	if ($subtypes) {
		foreach ($subtypes as $subtype) {
			elgg_register_plugin_hook_handler('prepare', "notification:create:object:$subtype", 'postbymail_prepare_notification', 1000);
			// Some subtypes use a specific hook
			// @TODO : always register both hooks, just in case ?
			if (in_array($subtype, array('blog', 'survey', 'transitions'))) {
				elgg_register_plugin_hook_handler('prepare', "notification:publish:object:$subtype", 'postbymail_prepare_notification', 1000);
			}
		}
	}
	
	
	
	
	/*
	$subtypes = elgg_get_plugin_setting('object_subtypes', 'notification_messages');
	$subtypes = explode(',', $subtypes);
	// Add discussion replies if discussion is in the list
	if (in_array('groupforumtopic', $subtypes)) { $subtypes[] = 'discussion_reply'; }
	if ($subtypes) {
		foreach ($subtypes as $subtype) {
			// Note : we enable regular (create) and specific hook (publish) in all cases, because at worst it would be called twice and produce the same result, 
			// Regular hook
			// but this will avoid having to maintain the list here in case some plugin change called hook
			elgg_register_plugin_hook_handler('prepare', "notification:create:object:$subtype", 'notification_messages_prepare_notification', 900);
			// Some subtypes use a specific hook
			// @TODO : always register both hooks, just in case ?
			if (in_array($subtype, array('blog', 'survey', 'transitions'))) {
				elgg_register_plugin_hook_handler('prepare', "notification:publish:object:$subtype", 'notification_messages_prepare_notification', 900);
			}
		}
	}
	*/
	
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'postbymail_add_to_notify_message_hook', 1000);
	elgg_register_plugin_hook_handler('notify:entity:message', 'group_topic_post', 'postbymail_add_to_notify_message_hook', 1000);
	// Ajout du lien ajouté pour les réponses dans forum
	// Note debug : en mode CLI (advanced_notifications) il n'y a aucune entrée dans error_log !
	//  => mettre les infos de debug directement dans le mail envoyé pour avoir des infos sur ce qui se passe
	elgg_register_plugin_hook_handler("notify:annotation:message", 'group_topic_post', 'postbymail_add_to_notify_message_hook', 1000);
	
	// @TODO : Ajout pour tous les commentaires
	// @TODO vérifier qu'on a bien les infos pour répondre correctement
	// Apparemment GUID de la réponse et non de l'objet commenté
	//elgg_register_plugin_hook_handler("notify:annotation:message", 'all', 'postbymail_add_to_notify_message_hook', 1000);
	elgg_register_plugin_hook_handler("notify:annotation:message", 'comment', 'postbymail_add_to_notify_message_hook', 1000);
	
	// Ajout pour les messages
	elgg_register_plugin_hook_handler("notify:message:message", 'message', 'postbymail_add_to_notify_message_hook', 1000);
	
	
	// Replace sender email by postbymail reply email - NOT RECOMMENDED !
	/* @TODO : modifier le reply-to pour insérer +guid=XXXXX
	 * Possible via le hooks sur les params de notification_messages ?
	 */
	$replymode = elgg_get_plugin_setting('replymode', 'postbymail');
	if ($replymode == 'replyemail') {
		register_notification_handler("email", "postbymail_email_notify_handler");
	}
	
	// Extend group profile for post by email in groups
	// Note : setting check is made in the view itself
	elgg_extend_view("groups/edit", "postbymail/groupsetting");
	
}


// Get postbymail config (from file or admin settings)
function postbymail_get_config() {
	
	$settings_file = elgg_get_plugins_path() . 'postbymail/settings.php';
	if (file_exists($settings_file)) { include_once($settings_file); }

	// Use custom admin settings for settings that were not set in config file (no set = variable not defined, eg. can be empty)
	
	/* POP3/IMAP/NNTP server to connect to, with optional port. */
	//$server = "localhost:143";
	if (!isset($server)) { $server = elgg_get_plugin_setting('server', 'postbymail'); }

	/* Protocol specification (optional) */
	//$protocol = "/notls";
	if (!isset($protocol)) { $protocol = elgg_get_plugin_setting('protocol', 'postbymail'); }

	/* Name of the mailbox to open. */
	// Boîte de réception = presque toujours INBOX mais on peut récupérer les messages d'un dossier particulier également..
	if (!isset($mailbox)) { $mailbox = elgg_get_plugin_setting('inboxfolder', 'postbymail'); }

	/* Mailbox username. */
	if (!isset($username)) { $username = elgg_get_plugin_setting('username', 'postbymail'); }

	/* Mailbox password. */
	if (!isset($password)) { $password = elgg_get_plugin_setting('password', 'postbymail'); }
	
	/* Whether or not to mark retrieved messages as seen. */
	if (!isset($markSeen)) { $markSeen = false; }
	//if (empty($markSeen)) $markSeen = elgg_get_plugin_setting('markSeen', 'postbymail');

	/* If the message body is longer than this number of bytes, it will be trimmed. Set to 0 for no limit. */
	//$bodyMaxLength = 0; //$bodyMaxLength = 4096;
	// This (65536) is actually default MySQL configuration for Elgg's description fields
	// (set appropriate field to longtext in your database if you want to ovveride that limit)
	if (!isset($bodyMaxLength)) { $bodyMaxLength = 65536; }
	//if (empty($bodyMaxLength)) $bodyMaxLength = elgg_get_plugin_setting('bodymaxlength', 'postbymail');

	// Séparateurs du message
	if (!isset($separator)) { $separator = elgg_get_plugin_setting('separator', 'postbymail'); }
	// Force a default separator, just because we need it
	if (empty($separator)) { $separator = elgg_echo('postbymail:default:separator'); }
	
	// Set up the parameters for the MimeDecode object.
	if (!isset($mimeParams)) {
		$mimeParams = array(
				'decode_headers' => true,
				'crlf' => "\r\n",
				'include_bodies' => true,
				'decode_bodies' => true,
			);
	}
	
	// Return full config
	return array(
			'server' => $server,
			'protocol' => $protocol,
			'mailbox' => $mailbox,
			'username' => $username,
			'password' => $password,
			'markSeen' => $markSeen,
			'bodyMaxLength' => $bodyMaxLength,
			'separator' => $separator,
			'mimeParams' => $mimeParams,
		);
}


// Check required parameters : returns true if OK, false is missing mandatory
function postbymail_check_required($config = false) {
	if (!$config) {
		$config = postbymail_get_config();
	}
	// Stop process if missing required parameters for mailbox connection
	if (empty($config['server']) || empty($config['username']) || empty($config['password'])) {
		return false;
	}
	return true;
}


function postbymail_pagehandler($page) {
	// Required for simulation purpose (can be called and displayed by an admin, and we need it to behave exactly the same as when launched by a cron task)
	elgg_set_context('cron');
	if (include elgg_get_plugins_path() . 'postbymail/pages/checkandpost.php') { return true; }
	return false;
}


// Permet de définir le GUID de l'objet commenté s'il ne l'a pas déjà été
// Nécessaire car object_notifications n'est pas appelé ou pas à temps dans certains cas
function postbymail_annotate_event_notifications($event, $object_type, $object) {
	if (is_callable('object_notifications')) {
		global $postbymail_guid;
		// @TODO : pb = risque de redéfinition si envoi d'un message (qui a son propre GUID), 
		// cependant on doit aussi réinitialiser le guid dans le cas d'un cron
		// => fait dans la boucle de traitement des mails
		if (!$postbymail_guid || empty($postbymail_guid)) {
			if (elgg_instanceof($object, 'object')) {
				$postbymail_guid = $object->guid;
			}
		}
	}
}


// Réécriture des messages envoyés
/*
unregister_plugin_hook('notify:entity:message', 'object', 'groupforumtopic_notify_message');
register_plugin_hook('notify:entity:message', 'object', 'groupforumtopic_notify_message_postbymail');

unregister_plugin_hook('notify:entity:message', 'object', 'blog_notify_message');
register_plugin_hook('notify:entity:message', 'object', 'blog_notify_message_postbymail');

unregister_plugin_hook('notify:entity:message', 'object', 'page_notify_message');
register_plugin_hook('notify:entity:message', 'object', 'page_notify_message_postbymail');

unregister_plugin_hook('notify:entity:message', 'object', 'bookmarks_notify_message');
register_plugin_hook('notify:entity:message', 'object', 'file_notify_message_postbymail');

unregister_plugin_hook('notify:entity:message', 'object', 'file_notify_message');
register_plugin_hook('notify:entity:message', 'object', 'bookmarks_notify_message_postbymail');
*/





/* Adds the reply block to the message
 * Ajoute le séparateur pour réponse au message
 */
function postbymail_add_to_message($message, $postbymail_guid = false, $language = false) {
	if (!$postbymail_guid) {
		global $postbymail_guid;
		error_log("POSTBYMAIL : GUID not passed");
	}
	
	// @TODO : use recipient language
	if (!$language) { $language = get_language(); }
	
	//if (empty($postbymail_guid)) { error_log("Cannot determine valid reply GUID"); }
	
	$separator = elgg_get_plugin_setting('separator', 'postbymail');
	if (empty($separator)) { $separator = elgg_echo('postbymail:default:separator'); }
	$separatordetails = elgg_get_plugin_setting('separatordetails', 'postbymail');
	if (empty($separatordetails)) { $separatordetails = elgg_echo('postbymail:default:separatordetails'); }
	$replybuttonaddtext = elgg_get_plugin_setting('replybuttonaddtext', 'postbymail');
	
	// Prepare reply url
	$url_param = '+guid=' . $postbymail_guid;
	$email_address = postbymail_reply_email_address();
	$email_parts = explode('@', $email_address);
	$reply_email = $email_parts[0] . $url_param . '@' . $email_parts[1];
	$reply_email_link = '<a href="mailto:' . $reply_email . '">' . $reply_email . '</a>';
	
	// Use direct email reply mode ?
	$replymode = elgg_get_plugin_setting('replymode', 'postbymail');
	// Choix par défaut et recommandé : 'replybutton'
	if ($replymode == 'replyemail') {
		// Add separator + explanations below
		$link = elgg_echo('postbymail:mail:replyemail', array($reply_email_link));
		$reply_block = '<span style="font-size:10px; color:grey;">' . $separator . "<br />\n" . $separatordetails . "<br />\n" . $link . "</span><hr />\n\n";
		$reply_block .= $message;
		
	} else {
		// Add reply button + alternative email address (failsafe mode)
		// rawurlencode et non urlencode qui utilise des "+" (ancienne spécification) au lieu des "%20"
		$separator = rawurlencode($separator);
		$separatordetails = rawurlencode($separatordetails);
		$wrapper_style = elgg_echo('postbymail:replybutton:wrapperstyle');
		$button_style = elgg_echo('postbymail:replybutton:style');
		$button_title = elgg_echo('postbymail:replybutton:title');
		// Avoid looking for the object only for a title, so use no more than the GUID
		//$reply_subject = elgg_echo('postbymail:replybutton:basicsubject');
		$reply_subject = elgg_echo('postbymail:replybutton:subject', array($postbymail_guid));
		
		/* Build reply button
		 * Add timestamp to avoid content being hidden by some email (GMail)
		 * Note : éviter de revenir à la ligne car la conversion html risque d'ajouter des <br /> à chaque fois !
		 * Le lien de réponse doit être défini ici car délicat à construire (à cause des % et autres..)
		 * mieux vaut le faire direct dans le code...
		 * Basic helper: #: %23, <: %3C, <: %3E, saut de ligne: %0D%0A
		*/
		$reply_block = '<div style="' . $wrapper_style . '">';
		$reply_block .= '<p class="postbymail-reply-button"><a href="mailto:' . $reply_email . '?subject=' . $reply_subject . '&body=%0D%0A%0D%0A%0D%0A' . $separator . '%0D%0A' . $separatordetails . '" style="' . $button_style . '">' . $button_title . '<span style="color:transparent; font-size:0px;">' . date("Y-m-d G:i ") . microtime(true) . '</span></a></p>';
		
		// Add failsafe block with clear email address, for text emails
		if ($replybuttonaddtext == 'yes') {
			$reply_block .= '<p><em>' . elgg_echo('postbymail:replybutton:failsafe', array($reply_email_link)) . '</em></p>';
		}
		
		$reply_block .= '</div>';
		
		// Add original message content
		$reply_block .= $message;
	}
	
	return $reply_block;
}



// Note : cette fonction ne s'applique que dans le cas d'une réponse à l'email d'expédition (mode déconseillé)
// Version en cours de modification sur la base des devs de Simon/Inria
// @TODO : si on garde ça, le faire plus proprement pour meilleure intégration avec d'autres plugins
// @TODO : modifier le handler de html_email_handler car celui-ci envoie réellement le message
if (elgg_is_active_plugin('html_email_handler')) {
	// Si html_email_handler est activé, on utilise ce handler à la place, sinon l'autre n'est pas chargé
	function postbymail_email_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL){
		$site = elgg_get_site_entity();

		// Check missing vars
		if (!$from) {
			$msg = elgg_echo("NotificationException:MissingParameter", array("from"));
			throw new NotificationException($msg);
		}
		if (!$to) {
			$msg = elgg_echo("NotificationException:MissingParameter", array("to"));
			throw new NotificationException($msg);
		}
		if (empty($to->email)) {
			$msg = elgg_echo("NotificationException:NoEmailAddress", array($to->guid));
			throw new NotificationException($msg);
		}
	
		// TO : recipient name <email>
		$to = $to->email;
		if (!empty($to->name)) { $to = $to->name . " <$to>"; }

		// FROM : sender name <email>
		// Sender email : use sender mail, then site email, then inexisting noreply address (never use personal user email)
		if (!elgg_instanceof($from, 'user') && !empty($from->email)) {
			$msg_from = $from->email;
		} elseif ($site && !empty($site->email)) {
			// Use email address of current site if we cannot use sender's email
			$msg_from = $site->email;
		} else {
			// If all else fails, use the domain of the site.
			$msg_from = "noreply@" . get_site_domain($site->guid);
		}
		// Sender name : best is user, then site, then none
		if (empty($from->name)) {
			$msg_from_name = $from->name . ' via ' . $site->name;
		} else if (!empty($site->name)) {
			$msg_from_name = $site->name;
		} else {
			$msg_from_name = false;
		}
		
		global $postbymail_guid;
		
		// generate HTML mail body
		$html_message = html_email_handler_make_html_body($subject, $message);
		// Ajout du séparateur de réponse
		$html_message = postbymail_add_to_message($html_message, $postbymail_guid);
		
		// Adresse email d'expédition ou de réponse - à affiner selon le contexte d'utilisation
		$postbymail_email = postbymail_reply_email_address();
		// Si l'adresse existe (configurée), on l'utilise à la place de l'adresse définie plus tôt, 
		// mais on garde le nom d'expéditeur
		if (!empty($postbymail_email) && is_email_address($postbymail_email)) {
			$postbymail_email = explode('@', $postbymail_email);
			$postbymailparam = '+guid=' . $postbymail_guid;
			$postbymail_replyaddress = $postbymail_email[0] . $postbymailparam . '@'. $postbymail_email[1];
			//$msg_from = $postbymail_replyaddress;
			$msg_from = $postbymail_replyaddress;
		}
		
		// Ajout du nom de l'auteur à la notification
		if (!empty($msg_from_name)) $msg_from = "$msg_from_name <$msg_from>";
		// set options for sending
		$options = array(
			"to" => $to,
			"from" => $msg_from,
			"subject" => $subject,
			"html_message" => $html_message,
			"plaintext_message" => $message
		);
	
		return html_email_handler_send_email($options);
	}
} else {
	// Fonction de Simon (Inria) revue : on utilise le nom du membre comme expéditeur, mais pas son mail (email générique ou celui de réponse par mail)
	// Adaptations en ce sens pour n'utiliser que le nom d'expéditeur mais pas son adresse email perso
	function postbymail_email_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL) {
		$site = elgg_get_site_entity();
		if (!($from instanceof ElggEntity)) { throw new NotificationException(elgg_echo('NotificationException:MissingParameter', array('from'))); }
		if (!elgg_instanceof($to, 'user')) { throw new NotificationException(elgg_echo('NotificationException:MissingParameter', array('to'))); }
		if ($to->email=="") { throw new NotificationException(elgg_echo('NotificationException:NoEmailAddress', array($to->guid))); }
		$params = array();
		
		// FROM : sender name <email>
		// Sender email : use sender mail, then site email, then inexisting noreply address (never use personal user email)
		if (!elgg_instanceof($from, 'user') && !empty($from->email)) {
			$params['from'] = $from->email;
		} else if (elgg_instanceof($from, 'group') && $site && $site->email) {
			// Use email address of current site if we cannot use sender's email
			// Attention : $from->guid n'est pas le guid de l'objet notifié mais de l'expéditeur...
			$params['from'] = $site->email . "+" . $from->guid;
		} else if ($site && $site->email) {
			// Use email address of current site if we cannot use sender's email
			$params['from'] = $site->email;
		} else {
			// If all else fails, use the domain of the site.
			$params['from'] = 'noreply@' . get_site_domain($site->guid);
		}
		// Sender name : best is user, then site, then none
		$params['from_name'] = '';
		if (elgg_instanceof($from, 'user')) {
			$params['from_name'] = $from->name . ' via ' . $site->name;
		} else if (elgg_instanceof($from, 'group') && $site && $site->email) {
			// Attention : $from->guid n'est pas le guid de l'objet notifié mais de l'expéditeur...
			$params['from_name'] = '[' . $from->name. ']';
		} else if ($site) {
			$params['from_name'] = $site->name;
		}
		
		global $postbymail_guid;
		
		// Adresse email d'expédition et/ou de réponse - à déterminer
		$postbymail_email = postbymail_reply_email_address();
		// Si l'adresse existe (configurée), on l'utilise à la place de l'adresse définie plus tôt, 
		// mais on garde le nom d'expéditeur
		if (!empty($postbymail_email) && is_email_address($postbymail_email)) {
			$postbymail_email = explode('@', $postbymail_email);
			$postbymailparam = '+guid=' . $postbymail_guid;
			$postbymail_replyaddress = $postbymail_email[0] . $postbymailparam . '@'. $postbymail_email[1];
			$params['from'] = $postbymail_replyaddress;
		}
		
		// Ajout du séparateur de réponse
		$message = postbymail_add_to_message($message, $postbymail_guid);
		
		$params['to'] = $to->email;
		$params['to_name']= $to->name;
		$params['subject'] = $subject;
		$params['body'] = $message;
	
		return trigger_plugin_hook('email', 'system', $params, NULL);
	}
}


/* Get publication email address
 * Determines which address should be used : username or email address
 * Use email first, and username if no email set
 */
function postbymail_reply_email_address() {
	$email = elgg_get_plugin_setting('email', 'postbymail');
	$email = trim($email);
	if (empty($email)) {
		$email = elgg_get_plugin_setting('username', 'postbymail');
		$email = trim($email);
	}
	return $email;
}


// Guess best subtype title depending on defined translation strings
function postbymail_readable_subtype($subtype) {
	$msg_subtype = elgg_echo("item:object:$subtype");
	if ($msg_subtype == "item:object:$subtype") {
		$msg_subtype = elgg_echo($subtype);
	}
	return strip_tags($msg_subtype);
}




