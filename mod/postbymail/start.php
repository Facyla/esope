<?php
/**
 * Post by mail plugin
 *
 * Author: Florian DANIEL aka Facyla
 * 
 * This plugin allows users to reply by email to a forum thread, or to any publication in an Elgg site, or even post new content
 *
 * This plugin is meant to be integrated within your notification system, please read carefully the documentation (in README and optionanally within code) for instructions
 * 
*/

elgg_register_event_handler('init','system','postbymail_init');

function postbymail_init() {
	// Register and load postbymail libraries
	elgg_register_library('elgg:postbymail', elgg_get_plugins_path() . 'postbymail/lib/functions.php');
	elgg_load_library('elgg:postbymail');
	
	// Page handler
	elgg_register_page_handler('postbymail', 'postbymail_pagehandler');
	
	// Register cron
	$cron_freq = elgg_get_plugin_setting('cron', 'postbymail');
	if (!in_array($cron_freq, array('minute', 'fiveminute', 'fifteenmin', 'halfhour', 'hourly', 'daily', 'weekly'))) { $cron_freq = 'fiveminute'; }
	elgg_register_plugin_hook_handler('cron', $cron_freq, 'postbymail_cron_handler');
	
	// Pass entity GUID
	// Pour déterminer et transmettre le GUID qui doit être passé en paramètre
	elgg_register_plugin_hook_handler('object:notifications', 'all', 'postbymail_object_notifications_handler', 0);
	elgg_register_event_handler('annotate', 'all', 'postbymail_annotate_event_notifications', 0);
	
	
	// Add reply block to email
	
	elgg_register_plugin_hook_handler("email", "system", "postbymail_email_hook");
	
	// Ajout du bloc de réponse au contenu à tous les messages de notification
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


function postbymail_pagehandler($page) {
	if (include elgg_get_plugins_path() . 'postbymail/pages/checkandpost.php') { return true; }
	return false;
}


// Postbymail CRON : check mails and publish...
function postbymail_cron_handler($hook, $entity_type, $returnvalue, $params) {
	//error_log("MARQUEUR DU CRON DU START.PHP DE POSTBYMAIL");
	// require libraries
	elgg_load_library('elgg:postbymail');
	
	require_once(elgg_get_plugins_path() . 'postbymail/pages/checkandpost.php');
	$resulttext = elgg_echo("postbymail:mailprocessed");
	return $returnvalue . $resulttext;
}


// Ce hook (sensible) se contente ici de passer le GUID de l'objet commenté
function postbymail_object_notifications_handler($hook, $entity_type, $returnvalue, $params) {
	if (elgg_instanceof($params['object'], 'object')) {
		global $postbymail_guid;
		if (!$postbymail_guid || empty($postbymail_guid)) { $postbymail_guid = $params['object']->guid; }
	}
	// pas de modification du comportement (défini par ailleurs)
	return $returnvalue;
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



// Permet de notifier le contenu du commentaire au lieu du sujet commenté
// @todo : si pls réponses en //, seul l'un des contenus est bon :-(
function postbymail_groupforumtopic_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'groupforumtopic')) {
		$descr = $entity->description;
		$title = $entity->title;
		$url = $entity->getURL();
		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
		$reply = get_input('group_topic_post'); // Note : vide si via cron et import mail..
		if (empty($reply)) {
			// Note : si pls messages publiés en même temps on n'aura que le dernier
			global $postbymail_content;
			$reply = $postbymail_content;
		}
		/*
		error_log("POSTBYMAIL start : via le site = " . $reply);
		error_log("POSTBYMAIL start : via postbymail = " . $postbymail_content);
		*/
		// Selon les cas, on notifie avec le sujet initial ou la réponse
		if (!empty($reply)) {
			// Réponse à un sujet de forum
			// @TODO notifie avec l'auteur du post initial et non celui qui publie !
			// cf. http://reference.elgg.org/1.8/annotations_8php_source.html#l00065
			$member_name = elgg_echo('postbymail:someone');
			return elgg_echo('groups:notification:reply', array(
				$member_name,
				$group->name,
				$entity->title,
				$reply,
				$entity->getURL()
			));
		} else {
			// Nouveau sujet de forum
			return elgg_echo('groups:notification', array(
				$owner->name,
				$group->name,
				$entity->title,
				$entity->description,
				$entity->getURL()
			));
		}
	}
	
	return null;
}


// Ce hook ajoute le bloc de notification aux messages de tous types
// Prend en charge : object, annotation
function postbymail_add_to_notify_message_hook($hook, $entity_type, $returnvalue, $params) {
	global $postbymail_guid;
	$entity = $params['entity'];
	$annotation = $params['annotation'];
	//$to_entity = $params['to_entity'];
	//$method = $params['method'];
	//error_log("DEBUG POSTBYMAIL : $postbymail_guid / $entity->guid || $hook, $entity_type, $returnvalue, " . print_r($params, true));
	
	if (elgg_instanceof($entity, 'object')) {
		// Note : all new content and comments use this, and also the messages
		if (empty($postbymail_guid)) { $postbymail_guid = $entity->guid; }
		$returnvalue = postbymail_add_to_message($returnvalue);
		
	} else if ($annotation instanceof ElggAnnotation) {
		// Only forum replies should use this
		// Dans ce cas le mode d'envoi peut demander de déterminer l'entité concernée
		global $postbymail_guid;
		// Note : always get commented entity from annotation ?
		if (empty($postbymail_guid)) {
			$postbymail_guid = $annotation->entity_guid;
		}
		$returnvalue = postbymail_add_to_message($returnvalue);
		
	} else {
		// On ne peut ajouter le lien que si on a l'info sur l'entité concernée...
		if (!empty($postbymail_guid)) { $returnvalue = postbymail_add_to_message($returnvalue); }
	}
	
	return $returnvalue;
}


/* Adds the reply block to the message
 * Ajoute le séparateur pour réponse au message
 */
function postbymail_add_to_message($message) {
	global $postbymail_guid;
	
	//if (empty($postbymail_guid)) { error_log("Cannot determine valid reply GUID"); }
	
	$separator = elgg_get_plugin_setting('separator', 'postbymail');
	if (empty($separator)) $separator = elgg_echo('postbymail:default:separator');
	$separatordetails = elgg_get_plugin_setting('separatordetails', 'postbymail');
	if (empty($separatordetails)) $separatordetails = elgg_echo('postbymail:default:separatordetails');
	$replybuttonaddtext = elgg_get_plugin_setting('replybuttonaddtext', 'postbymail');
	if ($replybuttonaddtext == 'no') { $replybuttonaddtext = false; } else { $replybuttonaddtext = true; }
	
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
		
		// Build reply button
		// Add timestamp to avoid content being hidden by some email (GMail)
		// Note : éviter de revenir à la ligne car la conversion html risque d'ajouter des <br /> à chaque fois !
		/* Le lien de réponse doit être défini ici car délicat à construire (à cause des % et autres..)
		 * mieux vaut le faire direct dans le code...
		 * Basic helper: #: %23, <: %3C, <: %3E, saut de ligne: %0D%0A
		*/
		$reply_block = '<div style="' . $wrapper_style . '">';
		$reply_block .= '<p class="postbymail-reply-button"><a href="mailto:' . $reply_email . '?subject=' . $reply_subject . '&body=%0D%0A%0D%0A%0D%0A' . $separator . '%0D%0A' . $separatordetails . '" style="' . $button_style . '">' . $button_title . '<span style="color:transparent; font-size:0px;">' . date("Y-m-d G:i ") . microtime(true) . '</span></a></p>';
		// Add failsafe block with clear email address, for text emails
		if ($replybuttonaddtext) {
			$reply_block .= '<p><em>' . elgg_echo('postbymail:replybutton:failsafe', array($reply_email_link)) . '</em></p>';
		}
		$reply_block .= '</div>';
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
		
		// generate HTML mail body
		$html_message = html_email_handler_make_html_body($subject, $message);
		// Ajout du séparateur de réponse
		$html_message = postbymail_add_to_message($html_message);
		
		// Adresse email d'expédition ou de réponse - à affiner selon le contexte d'utilisation
		$postbymail_email = postbymail_reply_email_address();
		// Si l'adresse existe (configurée), on l'utilise à la place de l'adresse définie plus tôt, 
		// mais on garde le nom d'expéditeur
		if (!empty($postbymail_email) && is_email_address($postbymail_email)) {
			$postbymail_email = explode('@', $postbymail_email);
			global $postbymail_guid;
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
		
		// Adresse email d'expédition et/ou de réponse - à déterminer
		$postbymail_email = postbymail_reply_email_address();
		// Si l'adresse existe (configurée), on l'utilise à la place de l'adresse définie plus tôt, 
		// mais on garde le nom d'expéditeur
		if (!empty($postbymail_email) && is_email_address($postbymail_email)) {
			$postbymail_email = explode('@', $postbymail_email);
			global $postbymail_guid;
			$postbymailparam = '+guid=' . $postbymail_guid;
			$postbymail_replyaddress = $postbymail_email[0] . $postbymailparam . '@'. $postbymail_email[1];
			$params['from'] = $postbymail_replyaddress;
		}
		
		// Ajout du séparateur de réponse
		$message = postbymail_add_to_message($message);
		
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


