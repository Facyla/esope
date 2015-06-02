<?php

// require external libraries if needed
if (!class_exists('DecodeMessage')) {
	require_once(elgg_get_plugins_path() . 'postbymail/lib/mimeDecode.php');
}
if (!class_exists('Mail_mimeDecode')) {
	require_once(elgg_get_plugins_path() . 'postbymail/lib/Mail_mimeDecode.php');
}

/* Post by mail functions */

/* postbymail_checkandpost	 Vérifie la présence de nouveaux messages dans une boîte IMAP (ou POP, marche moins bien) et publie les messages s'ils sont valides (publiés par un auteur valide à un endroit où il en a le droit)
 * 
 * $server = "localhost:143";	 POP3/IMAP/NNTP server to connect to, with optional port.
 * $protocol = "/notls";	 Protocol specification (optional)
 * $mailbox = "INBOX";	 Name of the mailbox to open. - Boîte de réception = toujours INBOX mais on peut récupérer les messages d'un dossier particulier également..
 * $username = "user@domain.tld";	 Mailbox username.
 * $password = "********";	 Mailbox password.
 * $markSeen = false;	 Whether or not to mark retrieved messages as seen.
 * $bodyMaxLength = 65536; //$bodyMaxLength = 0; //$bodyMaxLength = 4096;	 If the message body is longer than this number of bytes, it will be trimmed.
	- Set to 0 for no limit.
	- 65536 is actually default MySQL configuration for Elgg's description fields
	- set appropriate field to longtext in your database if you want to ovveride that limit
 * $separator = elgg_echo('postbymail:default:separator');	 Séparateur du message (pour retirer la signature, les messages joints intégrés dans la réponse..)
	*
*/
function postbymail_checkandpost($server, $protocol, $mailbox, $username, $password, $markSeen, $bodyMaxLength, $separator, $mimeParams) {
	global $sender_reply;
	global $admin_reply;
	
	$site = elgg_get_site_entity();
	
	$ia = elgg_set_ignore_access(true);
	$debug = true;
	$use_attachments = false;
	// @TODO : vérifier si on doit faire un check has_access_to_entity => normalement plus besoin en 1.8
	
	$body = ''; $pub_counter = 0;
	
	
	// COLLECT BASE PARAMS AND VARS
	
	// Paramétrage du champ d'application des publications par mail
	$mailpost = elgg_get_plugin_setting('mailpost', 'postbymail');
	$group_mailpost = false;
	$user_mailpost = false;
	switch($mailpost) {
		// Pas de publication par mail du tout : on ne notifie pas non plus et on peut sortir de suite sans parcourir les messages..
		case 'none': $mailpost = false; break;
		case 'grouponly': $group_mailpost = true; break;
		case 'useronly': $user_mailpost = true; break;
		case 'userandgroup': $group_mailpost = $user_mailpost = true; break;
	}
	// Paramétrage du champ d'application des réponses par mail
	$mailreply = elgg_get_plugin_setting('scope', 'postbymail');
	$forumonly = false;
	switch($mailreply) {
		// Pas de réponse par mail du tout
		case 'none': $mailreply = false; break;
		case 'forumonly': $forumonly = true; break;
		case 'comments': break;
	}
	// Si ni les réponses, ni les publications ne sont autorisées => pas de publication par mail du tout : on ne notifie pas non plus et on peut sortir de suite sans parcourir les messages..
	if (!$mailpost && !$mailreply) {
		elgg_set_ignore_access($ia);
		return false;
	}
	
	// Liste des admins à notifier
	$notifylist = elgg_get_plugin_setting('notifylist', 'postbymail');
	$body .= elgg_echo('postbymail:notifiedadminslist', array($notifylist));
	if ($notified_users = explode(',', trim($notifylist)) ) {
		foreach($notified_users as $notified_user) {
			$admin_ent = get_entity($notified_user);
			if (!$admin_ent) $admin_ent = get_user_by_username($notified_user);
			if (elgg_instanceof($admin_ent, 'user')) {
				$admin_email = $admin_ent->email;
				$body .= "{$admin_ent->name} ($admin_email), ";
			}
		}
	}
	$body .= "<hr />";
	
	// Niveau de notifications
	$notify_scope = elgg_get_plugin_setting('notify_scope', 'postbymail');
	if (empty($notify_scope)) { $notify_scope = 'error'; }
	$notify_scope = explode(':', $notify_scope);
	if (in_array('error', $notify_scope)) { $notify_admin_error = true; } else { $notify_admin_error = false; }
	if (in_array('success', $notify_scope)) { $notify_admin_success = true; } else { $notify_admin_success = false; }
	if (in_array('groupadmin', $notify_scope)) { $notify_groupadmin = true; } else { $notify_groupadmin = false; }
	
	
	// CONNEXION AU SERVEUR IMAP ET TRAITEMENT DES EMAILS
	$conn = imap_open('{'.$server.$protocol.'}'.$mailbox, $username, $password);
	if (!$conn) {
		// Connection error (bad config)
		$body .= elgg_echo('postbymail:badpluginconfig');
		$imap_errors = imap_errors();
		$body .= "<p>REQUEST = imap_open('{".$server.$protocol."}$mailbox, $username, PASSWORD);</p>";
		$body .= "IMAP errors : <pre>" . print_r($imap_errors, true) . '</pre>';
		$imap_alerts = imap_alerts();
		$body .= "IMAP alerts : <pre>" . print_r($imap_alerts, true) . '</pre>';
	} else {
		$body .= elgg_echo('postbymail:connectionok');
		
		// Création des dossiers s'ils n'existent pas
		/* @todo : marche pas..
		if (imap_createmailbox($conn, imap_utf7_encode("{".$server.$protocol."}INBOX.Published"))) { $body .= "Boîte 'Published' créée"; }
		if (imap_createmailbox($conn, imap_utf7_encode("{".$server.$protocol."}INBOX.Errors"))) { $body .= "Boîte 'Errors' créée"; }
		if (imap_createmailbox($conn, imap_utf7_encode("{".$server.$protocol."}INBOX.TESTS"))) { $body .= "Boîte 'TEST' créée"; }
		*/
		$purge = false;
		
		// See if the mailbox contains any messages.
		// On récupère les messages non lus seulement.. - nbx autres paramètres
		//$allmsgCount = imap_num_msg($conn); // Compte tous les messages de la boîte
		//if ($unreadmessages = imap_sort($conn, SORTARRIVAL, 0, null, 'UNSEEN')) {
		if ($unreadmessages = imap_search($conn,'UNSEEN')) {
			$body .= elgg_echo('postbymail:newmessagesfound', array(sizeof($unreadmessages)));
			
			// Loop through the messages.
			// Pour chaque message à traiter : on vérifie d'abord quelques pré-requis (messages systèmes)
			// Puis on vérifie les paramètres et on poste si tout est OK
			// + prévenir l'expéditeur (dans tous les cas) 
			// + prévenir un admin (idem ?)
			foreach ($unreadmessages as $i => $msg_id) {
				error_log("Processing email $i => $msg_id");
				// @TODO : imap_body(): Bad message number error => process only 1 message per cron ?
				
				// Réinitialisation de la variable globale, afin de traiter chaque envoi de notifications indépendament
				global $postbymail_guid;
				$postbymail_guid = '';
				
				$body .= elgg_echo('postbymail:processingmsgnumber', array(($i+1), $msg_id));
				// Get the message header.
				$header = imap_fetchheader($conn, $msg_id, FT_PREFETCHTEXT);
				// Set the message as read if told to
				if ($markSeen) { $msgbody = imap_body($conn, $msg_id); } else { $msgbody = imap_body($conn, $msg_id, FT_PEEK); }
				// Send the header and body through mimeDecode.
				$mimeParams['input'] = $header.$msgbody;
				$message = Mail_mimeDecode::decode($mimeParams);
				
				// Some mail servers and clients use special messages for holding mailbox data; ignore that message if it exists.
				if ($message->headers['subject'] == "DON'T DELETE THIS MESSAGE -- FOLDER INTERNAL DATA") { continue; }
				
				// A partir d'ici on a un message "traitable" et on peut notifier expéditeur et admin
				
				// @TODO : si le flag \\Answered est présent, on saute direct au suivant (traité et publié) !
				// if () { continue; }
				
				// Marqueurs selon motifs de ne pas notifier
				$member = false; $post_body = false;
				$published = false; $sender_reply = ''; $admin_reply = '';
				
				
				/****************************/
				/*   EXTRACT POST CONTENT   */
				/****************************/
// @DEBUG testing encoding
$body .= "Message info : <pre>" . print_r($message, true) . '</pre><br />';
$body .= "detected encoding : " . mb_detect_encoding($msgbody) . '<br />';
				// Extract the message body from email content, in html or text if not available
				// Extraction function also ensures its encoded into UTF-8
				$msgbody = mailparts_extract_body($message, true);
$body .= "original html body : " . $msgbody . '<hr />';
				// On utilise la version texte si la version html (par défaut) ne renvoie rien
				if (empty($msgbody)) { $msgbody = mailparts_extract_body($message, false); }
$body .= "original text body : " . $msgbody . '<hr />';
$body .= "original body encoded to utf8 : " . utf8_encode($msgbody) . '<hr />';
$body .= "mb_convert_encoding : " . mb_convert_encoding($msgbody, "UTF-8") . '<hr />';
$body .= "mb_convert_encoding autodetect : " . mb_convert_encoding($msgbody, "UTF-8", mb_detect_encoding($msgbody)) . '<hr />';
$body .= "htmlentities : " . htmlentities($msgbody, ENT_QUOTES, "UTF-8") . '<hr />';
$body .= "################################################################";
continue;
					
				if (empty($msgbody)) {
					// @TODO : mauvaise détection ISO-8859-1
					// @TODO Encoding is explicit in headers, should get it from there rather than auto-detect
					/* Note : coupure au premier accent si envoi avec Zimbra !!
					$original_encoding = mb_detect_encoding($msgbody);
					if ($original_encoding != "UTF-8") {
						$msgbody = mb_convert_encoding($msgbody, "UTF-8", $original_encoding);
					}
					*/
					if (mb_strlen(htmlentities($msgbody, ENT_QUOTES, "UTF-8")) == 0) {
						// Cas envoi en Windows-1252 (logiciels anciens ou mal configurés, certains webmails, etc.)
						$msgbody = mb_convert_encoding($msgbody, "UTF-8");
					} else {
						// Cas standard
						$msgbody = mb_convert_encoding($msgbody, "UTF-8", mb_detect_encoding($msgbody));
					}
				}
				
				// Format the message to get the required data and content
				if ($msgbody) {
					// On filtre de la même manière que depuis le site
					$msgbody = filter_tags($msgbody);
					// On ne garde que ce qu'il y a avant le marqueur de fin de réponse (la suite est inutile et potentiellement volumineuse)
					// on publie quand même si le message ne porte pas de marqueur
					$cutat = mb_strpos($msgbody, $separator);
					if ($cutat !== false) { $post_body = mb_substr($msgbody, 0, $cutat); } else { $post_body = $msgbody; }
					// On coupe aussi tout ce qu'il y a avant </head>, si présent
					$cutatbody = mb_strpos($msgbody, '</head>');
					if (($cutatbody !== false) && ($cutatbody > 0)) { $post_body = mb_substr($post_body, $cutatbody + 7); } // + longueur du texte à couper (</head>)
					// @TODO	on pourrait aussi chercher le prochain > après <body et couper là puis faire un trim..
					$post_body = trim($post_body);
					//$post_body = preg_replace('`[<br />]*$`', '', $post_body); // Fin de chaîne
					// Regex : en début de chaîne (^), on prend autant de fois que possible (*) la chaîne <br> (avec 0 ou + espace (*) 
					// suivi d'un / facultatif (?)), ou les chaînes \n, \r, \t (tabulation), et les espaces
					// ou idem en fin de chaîne ($)
					$post_body = mb_eregi_replace('^(<br */?>|<p>|\n|\r| |\t|&nbsp;)*|(<br */?>|</p>| |\n|\r|\t|&nbsp;)*$', '', $post_body);
					$post_body = trim($post_body);
					// Trim the post body to $bodyMaxLength characters if desired.
					if ($bodyMaxLength && mb_strlen($post_body) > $bodyMaxLength) {
						$post_body = mb_substr($post_body, 0, $bodyMaxLength).'...';
					}
				}
				
				/***************************/
				/*   EXTRACT ATTACHMENTS   */
				/***************************/
				// Does the message have an attachment?
				// @TODO ça pourra servir à publier lesdites pièces jointes
				// Note : très discutable à cause des signatures et autres icônes embarquées..
				if ($use_attachments) {
					// Lecture de tout le message pour identification des pièces jointes
					$content = mailparts_extract_content($message);
					$full_msgbody = count($message->parts) . ' : ' . $content['body'];
					$attachment = $content['attachment'];
				}
				
				/******************/
				/*   EXPEDITEUR   */
				/******************/
				$sendermail = postbymail_extract_email($message->headers['from']);
				$realsendermail = postbymail_extract_email($message->headers['sender']);
				$member = postbymail_find_sender($message->headers);
				
				
				/**********************************/
				/*   PREVENT DOUBLE PUBLICATION   */
				/**********************************/
				// Hash unique (contenu utilisé du mail) afin d'éviter les doublons et de republier un article supprimé (qu'on suppose modéré)
				// On prend aussi la date du message (mail) : si le message est publié à une autre date ça peut poser pb de se contenter du contenu
				// par exemple avec des réponses courtes type "oui", "ok" qui peuvent être multiples sur un unique thread
				//$hash = md5($realmember->guid . $post_body);
				// @TODO : add a light time frame to mail date ? (use minute or 5-10 minutes approximation instead of timestamp)
				$hash = md5($realmember->guid . $message->headers['date'] . $post_body);
				
				// Extraction des paramètres du message : entité concernée (et autres ?)
				$header_to = postbymail_extract_email($message->headers['to']);
				$mailparams = explode('@', $header_to);
				$mailparams = explode('+', $mailparams[0]);
				$parameters = '';
				if (!empty($mailparams[1])) {
					$mailparams = explode('&', $mailparams[1]);
					$guid = null; $entity = null; $post_key = null; $post_subtype = null; $post_access = null; 
					foreach($mailparams as $mailparam) {
						$mailparam = explode('=', $mailparam);
						// @TODO use new elgg_echo
						//$parameters .= elgg_echo('postbymail:info:memberandmail', array($mailparam[0], $mailparam[1]));
						$parameters .= elgg_echo('postbymail:info:parameters', array($mailparam[0] . ' = ' . $mailparam[1])) . '<br />';
						//$guid = null; $entity = null;
						// Switch pour gérer d'autres params plus tard
						// guid : entité à commenter ()ou modifier), utilisé pour les réponses par mail
						// key : clef unique associée à un GUID "auteur", utilisé pour publier au nom d'un groupe ou d'un user
						// subtype : type de contenu à publier (nouvelles publications seulement)
						switch($mailparam[0]) {
							case 'guid':
								$guid = (int) $mailparam[1];
								if ($entity = get_entity($guid)) {} else {
									$sender_reply .= elgg_echo('postbymail:invalidguid');
									$admin_reply .= elgg_echo('postbymail:validguid');
								}
								break;
							case 'key':
								$post_key = $mailparam[1];
								break;
							case 'subtype':
								$post_subtype = $mailparam[1];
								break;
							case 'access':
								$post_access = (int) $mailparam[1];
								break;
						}
					}
					if (!empty($parameters)) $parameters = elgg_echo('postbymail:info:paramwrap', array($parameters));
				}
				
				
				/****************************/
				/*   NOTIFICATION CONTENT   */
				/****************************/
				// Informations sur le contenu du message
				$body .= elgg_echo('postbymail:info:parameters', array($parameters));
				$body .= '<br class="clearfloat" /><hr />';
				
				// Infos pour l'expéditeur
				$sender_reply .= elgg_echo('postbymail:info:emails', array($sendermail, $realsendermail));
				$sender_reply .= elgg_echo('postbymail:info:publicationmember', array($member->name));
				$sender_reply .= elgg_echo('postbymail:info:postfullmail', array(htmlentities($message->headers['to'])));
				$sender_reply .= elgg_echo('postbymail:info:mailtitle', array($message->headers['subject']));
				$sender_reply .= elgg_echo('postbymail:info:maildate', array(dateToFrenchFormat($message->headers['date'])));
				$sender_reply .= elgg_echo('postbymail:info:hash', array($hash));
				if ($use_attachments) $sender_reply .= elgg_echo('postbymail:info:attachment', array($attachment));
				//$sender_reply .= elgg_echo('postbymail:info:parameters', array($parameters));
				if ($entity) {
					$sender_reply .= elgg_echo('postbymail:info:objectok', array($entity->getURL(), $entity->title, htmlentities($guid)));
				} else {
					$sender_reply .= elgg_echo('postbymail:info:badguid');
				}
				
				// Infos pour l'admin
				$admin_reply .= elgg_echo('postbymail:info:emails', array($sendermail, $realsendermail));
				$admin_reply .= elgg_echo('postbymail:info:publicationmember', array($member->name));
				$admin_reply .= elgg_echo('postbymail:info:postfullmail', array(htmlentities($message->headers['to'])));
				$admin_reply .= elgg_echo('postbymail:info:mailbox', array($mailbox));
				$admin_reply .= elgg_echo('postbymail:info:mailtitle', array($message->headers['subject']));
				$admin_reply .= elgg_echo('postbymail:info:maildate', array(dateToFrenchFormat($message->headers['date'])));
				$admin_reply .= elgg_echo('postbymail:info:hash', array($hash));
				if ($use_attachments) $admin_reply .= elgg_echo('postbymail:info:attachment', array($attachment));
				$admin_reply .= $parameters;
				if ($entity) {
					$admin_reply .= elgg_echo('postbymail:info:objectok', array($entity->getURL(), $entity->title, htmlentities($guid)));
				} else {
					$admin_reply .= elgg_echo('postbymail:info:badguid');
				}
				
				$body .= "<br class=\"clearfloat\" /><br />";
				
				
				/************************************/
				/* VERIFICATION ACTIONS A EFFECTUER */
				/************************************/
				// Switch here between reply by mail and post by mail
				// We assume that 'guid' param is exclusive for replies, and 'key' is exclusive for new publications
				
				// NOUVELLES PUBLICATIONS
				$mailpost_check = false;
				// Si les publications par mail sont activées, on vérifie qu'on a les paramètres requis
				// We need : a posting "key" (unically associated to the container group or user), and a "subtype" parameter.
				// Sender should be identified when possible, but the post is sent by the group or user itself if email can't be found.
				// @TODO Use normalized array for easier vars passing
				$pbm_params = array('post_key' => $post_key, 'member' => $member, 'post_subtype' => $post_subtype, 'post_access' => $post_access, 'hash' => $hash, 'entity' => $entity, 'post_body' => $post_body, 'email_headers' => $message->headers);
				
				if ($mailpost && !empty($post_key)) {
					// string or false	false, ou $hash publication pour vérifier si déjà publié via le hash (et supprimé par exemple, ou si on a remis les messages comme non lus..)
					// @TODO pass an retrieve arrays to avoid settings unique vars..
					//$post_check = postbymail_checkeligible_post($post_key, $member, $post_subtype, $post_access, $hash);
					$post_check = postbymail_checkeligible_post($pbm_params);
					$mailpost_check = $post_check['check']; // Ok pour publier ?
					$post_owner = $post_check['member']; // Auteur effectif du post
					$post_container = $post_check['container']; // Emplacement de publication
					$post_access = $post_check['access']; // Niveau d'accès de la publication
					$post_subtype = $post_check['subtype']; // Type de publication
					$hash_arr = $reply_check['hash']; // Hashs (sérialisés) des publications déjà faites dans ce container
					$report = $post_check['report'];
					$body .= $report;
					if ($debug) $admin_reply .= $report;
					//$sender_reply .= $report;
				}
				// Désactivation de l'autre fonction si la publication par clef est valide
				if ($mailpost_check === true) { $mailreply = false; }
//$mailreply = false; // DEBUG
				
				
				// RÉPONSES ET COMMENTAIRES
				$mailreply_check = false;
				// Si les réponses par mail sont activées, on vérifie qu'on a les paramètres requis
				if ($mailreply && !empty($guid)) {
					// string or false	false, ou $hash publication pour vérifier si déjà publié via le hash (et supprimé par exemple, ou si on a remis les messages comme non lus..)
					// @TODO pass an retrieve arrays to avoid settings unique vars..
					//$reply_check = postbymail_checkeligible_reply($entity, $member, $post_body, $message->headers, $hash);
					$reply_check = postbymail_checkeligible_reply($pbm_params);
					$mailreply_check = $reply_check['check'];
					$member = $reply_check['member'];
					$group_entity = $reply_check['group'];
					$hash_arr = $reply_check['hash'];
					$report = $reply_check['report'];
					$body .= $report;
					//$admin_reply .= $report;
					//$sender_reply .= $report;
				}
				
				
				/*******************************/
				/* PUBLICATION NOUVEAU CONTENU */
				/*******************************/
				if ($mailpost && $mailpost_check) {
					// @TODO : add setting to define which subtypes are eligible
					$admin_reply .= "Subtype = $post_subtype<br />";
					switch($post_subtype) {
						case 'bookmarks':
							$new_post = new ElggObject;
							$new_post->subtype = "bookmarks";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_container->guid;
							$new_post->title = $message->headers['subject'];
							$new_post->address = $post_address;
							$new_post->description = $post_body;
							$new_post->access_id = $post_access;
							$new_post->tags = $post_tagarray;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							break;
						case 'blog':
							$new_post = new ElggObject;
							$new_post->subtype = "blog";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_container->guid;
							$new_post->title = $message->headers['subject'];
							$new_post->description = $post_body;
							$new_post->excerpt = $post_excerpt;
							$new_post->access_id = $post_access;
							if ($post_access !== 0) $new_post->status = "published"; else $new_post->status = "draft";
							$new_post->comments_on = "On";
							$new_post->tags = $post_tagarray;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							break;
						case 'groupforumtopic':
							$new_post = new ElggObject;
							$new_post->subtype = "groupforumtopic";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_container->guid;
							$new_post->title = $message->headers['subject'];
							$new_post->description = $post_body;
							$new_post->access_id = $post_access;
							$new_post->tags = $post_tagarray;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							break;
						case 'page':
							$new_post = new ElggObject;
							$new_post->subtype = "page";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_container->guid;
							// @TODO add parent relation
							$new_post->title = $message->headers['subject'];
							$new_post->description = $post_body;
							$new_post->access_id = $post_access;
							// @TODO choose write access or set to private or same as post ?
							$new_post->write_access_id = $post_access;
							$new_post->tags = $post_tagarray;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							break;
						case 'page_top':
							$new_post = new ElggObject;
							$new_post->subtype = "page_top";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_container->guid;
							$new_post->title = $message->headers['subject'];
							$new_post->description = $post_body;
							$new_post->access_id = $post_access;
							// @TODO choose write access or set to private or same as post ?
							$new_post->write_access_id = $post_access;
							$new_post->tags = $post_tagarray;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							break;
						case 'thewire':
							$new_post = new ElggObject;
							$new_post->subtype = "thewire";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_owner->guid;
							//$new_post->title = $message->headers['subject'];
							// @TODO add reply to
							//$new_post->wire_thread
							$new_post->description = $post_body;
							$new_post->access_id = $post_access;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							break;
						default:
							/*
							$new_post = new ElggObject;
							$new_post->subtype = "blog";
							$new_post->owner_guid = $post_owner->guid;
							$new_post->container_guid = $post_container->guid;
							$new_post->title = $message->headers['subject'];
							$new_post->description = $post_body;
							$new_post->excerpt = $post_excerpt;
							$new_post->access_id = $post_access;
							if ($post_access !== 0) $new_post->status = "published"; else $new_post->status = "draft";
							$new_post->comments_on = "On";
							$new_post->tags = $post_tagarray;
							if ($new_post->save()) {
								$published = true;
								$body .= elgg_echo("postbymail:newpost:posted");
							}
							*/
					}
					if ($published) {
						$pub_counter++;
						// A ce stade on peut marquer le message
						imap_setflag_full($conn, $msg_id, "\\Answered");
						if (@imap_mail_move($conn, $msg_id, "Published")) { $purge = true; }
						$body .= elgg_echo('postbymail:published');
						// @todo : Enregistrement du hash dans le container pour éviter un message exactement identique de la même personne..
						// @todo voir si le même message est publié à une autre date ça pose pb ou pas - par exemple des réponse courtes type "oui", "ok"
						$hash_arr[] = $hash;
						$post_container->mail_post_hash = serialize($hash_arr);
					} else {
						// A ce stade on peut marquer le message
						// Si le message a été traité, on le range dans un dossier
						if (@imap_mail_move($conn, $msg_id, "Errors")) { $purge = true; }
						// Gestion des erreurs de publication inconnues
						// La publication n'a pas pu être faite alors qu'elle était a priori valide : à vérifier par un admin
						$notify_admin = true;
						$admin_reply = elgg_echo('postbymail:error:lastminutedebug', array($admin_reply));
					}
					
				}
				$body .= '<div class="clearfloat"></div>';
				
				
				/*************************************/
				/* PUBLICATION DU MESSAGE DE REPONSE */
				/*************************************/
				if ($mailreply && $mailreply_check) {
					$body .= elgg_echo('postbymail:info:usefulcontent', array($post_body));
					$sent = false;
					// Vérification du subtype, pour utiliser le bon type de publication
					if ($subtype = $entity->getSubtype()) {
						$admin_reply .= "Subtype = $subtype<br />";
						// Important pour notification_messages qui récupère cette info pour publier avec le bon auteur..
						set_input('postbymail_editor_id', $member->guid);
						set_input('topic_post', $post_body);
						// Publication effective : message de réussite, et ajout du hash pour noter que ce message a été publié
						// Ajout du hash aux publications déjà faites (peu importe de matcher hash et mail, ce qui importe c'est les doublons)
						switch($subtype) {
							case 'groupforumtopic':
								$annotation = $entity->annotate('group_topic_post', $post_body, $entity->access_id, $member->guid);
								if ($annotation) {
									//set_input('group_topic_post', $post_body);
									$published = true;
									$body .= elgg_echo("groupspost:success");
									// Add to river
									//add_to_river('river/forum/create', 'create', $member->guid, $entity->guid);
									add_to_river('river/annotation/group_topic_post/reply', 'reply', $member->guid, $entity->guid, "", 0, $annotation);
									// @TODO notification
									//elgg_trigger_event('create', 'annotation', $annotation);
									//error_log("Annotation triggered : $subtype");
									//elgg_trigger_plugin_hook('action', 'discussion/reply/save', null, true); // breaks execution
									//error_log("Action triggered on $subtype : discussion/reply/save");
									/*
									// Add notification
									notify_user($entity->owner_guid,
										$member->guid,
										elgg_echo('generic_comment:email:subject'),
										elgg_echo('generic_comment:email:body', array(
											$entity->title,
											$member->name,
											$post_body,
											$entity->getURL(),
											$member->name,
											$member->getURL()
										))
									);
									*/
								}
								break;
							case 'messages':
								/*
								error_log("DEBUG messages post : from = {$entity->fromId}, to = {$entity->toId}");
								error_log("DEBUG messages reply : from = {$member->guid}, to = {$entity->fromId}");
								*/
								// Post the message + add to sent message (need it once)
								if (elgg_is_active_plugin('notification_messages')) {
									$result = notification_messages_send($entity->title,$post_body, $entity->fromId, $member->guid, $entity->guid, true, true);
								} else {
									$result = messages_send($entity->title,$post_body, $entity->fromId, $member->guid, $entity->guid, true, true);
								}
								if ($result) {
									set_input('generic_comment', $post_body);
									$published = true;
									$body .= elgg_echo("postbymail:mailreply:success");
								}
								break;
							case 'thewire':
								// River OK + Notification OK
								// Nouvelle publication en réponse à la première(parent = $entity dans ce cas)
								$thewire_guid = thewire_save_post($post_body, $member->guid, $entity->access_id, $entity->guid, 'site');
								if ($thewire_guid) {
									$published = true;
									$body .= elgg_echo("postbymail:mailreply:success");
									// Send response to original poster if not already registered to receive notification
									thewire_send_response_notification($thewire_guid, $entity->guid, $member);
								}
								break;
							case 'blog':
							case 'page':
							case 'page_top':
							case 'event_calendar':
							default:
								// River OK + @TODO notification
								//set_input('topic_post', $post_body);
								// Les commentaires sont acceptés en fonctions des paramétrages aussi
								if ($forumonly) {
									$admin_reply .= elgg_echo('postbymail:admin:error:forumonly');
									$sender_reply = elgg_echo('postbymail:sender:error:forumonly', array($sender_reply));
									break;
								} else {
									//if ($entity->annotate('generic_comment', $post_body, $entity->access_id, $member->guid)) {
									$annotation = $entity->annotate('generic_comment', $post_body, $entity->access_id, $member->guid);
									if ($annotation) {
										$published = true;
										$body .= elgg_echo("generic_comment:posted");
										// Add to river
										//add_to_river('annotation/annotate','comment',$member->guid,$entity->guid); // @TODO update to latest structure
										add_to_river('river/annotation/generic_comment/create', 'comment', $member->guid, $entity->guid, "", 0, $annotation);
										// @Owner notification OK (usually happens in action), but here we need to notify the author too
										// @TODO Check subscribed users notifications
										$notification_subject = elgg_echo('generic_comment:email:subject');
										if (function_exists('notification_messages_build_subject')) {
											$new_notification_subject = notification_messages_build_subject($entity);
											if (!empty($new_notification_subject)) { $notification_subject = $new_notification_subject; }
										}
										$notification_message = elgg_echo('generic_comment:email:body', array(
												$entity->title,
												$member->name,
												$post_body,
												$entity->getURL(),
												$member->name,
												$member->getURL()
											));
										// Trigger a hook to provide better integration with other plugins
										$hook_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', array('entity' => $entity, 'to_entity' => $user), $notification_message);
										// Failsafe backup if hook as returned empty content but not false (= stop)
										if (!empty($hook_message) && ($hook_message !== false)) { $notification_message = $hook_message; }
										// Notify owner
										notify_user($entity->owner_guid, $member->guid, $notification_subject, $notification_message);
									}
								}
						}
					} else {
						// Subtype invalide
						$admin_reply .= elgg_echo('postbymail:admin:error:invalidsubtype');
						$sender_reply .= elgg_echo('postbymail:sender:error:invalidsubtype');
					}
					
					// Gestion des erreurs de publication lorsque a priori tout était bon
					if ($published) {
						$pub_counter++;
						// A ce stade on peut marquer le message
						imap_setflag_full($conn, $msg_id, "\\Answered");
						if (@imap_mail_move($conn, $msg_id, "Published")) { $purge = true; }
						$body .= elgg_echo('postbymail:published');
						// Enregistrement du hash dans l'objet pour éviter un message exactement identique de la même personne..
						// @TODO décider si le même message publié à une autre date pose pb ou pas - par exemple des réponse courtes type "oui", "ok"
						$hash_arr[] = $hash;
						$entity->mail_post_hash = serialize($hash_arr);
					} else {
						// A ce stade on peut marquer le message
						// Si le message a été traité, on le range dans un dossier
						if (@imap_mail_move($conn, $msg_id, "Errors")) { $purge = true; }
						// Gestion des erreurs de publication inconnues
						// Le commentaire n'a pas pu être publié alors qu'il était a priori valide : à vérifier par un admin
						$notify_admin = true;
						$admin_reply = elgg_echo('postbymail:error:lastminutedebug', array($admin_reply));
					}
				}
				$body .= '<div class="clearfloat"></div>';
				
				if (!$published) {
					// Pas publiable
					$admin_reply .= elgg_echo('postbymail:admin:reportmessage:error', array($cutat, $post_body, $msgbody));
					$sender_reply .= elgg_echo('postbymail:sender:reportmessage:error', array($post_body));
					$body .= '<div class="clearfloat"></div>';
				}
				
				
				/*
				$errorlog_message = "DEBUG POSTBYMAIL functions : editor = {$member->guid}, subtype = $subtype, guid = {$entity->guid}, check = $forum_post_check, body = " . print_r($entity, true);
				error_log($errorlog_message);
				$admin_reply .= "<hr />$errorlog_message<hr />";
				*/
				
				
				
				/*********************/
				/*   NOTIFICATIONS   */
				/*********************/
				
				// NOTIFICATIONS - notify anyone who should be after it's posted (or not)
				// 1. Check notification conditions first
				$notify_sender = false; $notify_admin = false;
				if ($published) {
					// L'auteur n'a pas besoin de notification pour un message accepté
					// En cas de publication, l'admin doit être prévenu pour pouvoir modérer
					$admin_reply = elgg_echo('postbymail:adminmessage:success', array($admin_reply));
					if ($notify_admin_success) { $notify_admin = true; }
				} else {
					// NOTIFICATIONS AUTEUR
					$sender_reply = elgg_echo('postbymail:sendermessage:error', array($sender_reply));
					// On notifie dans tous les cas d'échec ? a priori oui..
					$notify_sender = true;
					
					// NOTIFICATIONS ADMIN
					if ($notify_sender) {
						// @TODO à voir si on prévient quand même l'admin 
						// quand l'auteur est informé et qu'on explique pourquoi avec les infos fournies
						if ($notify_admin_error) { $notify_admin = true; }
					} else {
						// L'admin a besoin d'intervenir pour gérer du spam (blacklist) 
						// ou aider des membres qui ont besoin d'aide et ne sont pas prévenus
						$notify_admin = true;
					}
				}
				
				// 2. Envoi des notifications / send notifications
				$site_name = $site->name;
				// Protect the name with quotations if it contains a comma
				if (strstr($site_name, ",")) { $site_name = '"' . $site_name . '"'; }
				$site_name = "=?UTF-8?B?" . base64_encode($site_name) . "?="; // Encode the name. If may content nos ASCII chars.
				
				// Headers communs
				$headers = "From: Publication par mail {$site_name} <{$site->email}>\n";
				$headers .= "Return-Path: <{$site->email}>\n";
				$headers .= "X-Sender: <{$site_name}>\n";
				$headers .= "X-auth-smtp-user: {$site->email} \n";
				$headers .= "X-abuse-contact: {$site->email} \n";
				$headers .= "X-Mailer: PHP\n";
				// Auto-Submitted and X-Auto-Response-Suppress helps avoiding automatic replies, 
				// and reduce loop risks - see also incoming mails headers filtering
				// This tells other systems that it's an automated mail, and they shouldn't answer it automatically
				$headers .= "Auto-Submitted: notification\n";
				$headers .= "X-Auto-Response-Suppress: DR, RN, NRN, OOF, AutoReply\n";
				$headers .= "Date: ".date("D, j M Y G:i:s O")."\n";
				$headers .= "MIME-Version: 1.0\n";
				//$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				// On vérifie aussi s'il n'y a pas eu une raison autre de ne pas notifier
				if ($notify_sender) {
					$sender_subject = elgg_echo('postbymail:sender:notpublished');
					$sender_reply = elgg_echo('postbymail:sender:reportmessage:error', array($post_body));
					$sender_reply = elgg_echo('postbymail:sender:debuginfo', array($sender_subject, $report, $sender_reply));
					if (elgg_instanceof($member, 'user') && is_email_address($member->email)) {
						// Si c'est le membre, on le prévient (son compte peut avoir été piraté donc on le prévient de préférence)
						mail($member->email, $sender_subject, $sender_reply, $headers);
					} else if (is_email_address($sendermail)) {
						// Sinon on prend de préférence l'adresse email annoncée
						mail($sendermail, $sender_subject, $sender_reply, $headers);
					} else if (is_email_address($realsendermail)) {
						// En dernier recours celle réellement utilisée
						mail($realsendermail, $sender_subject, $sender_reply, $headers);
					} else {
						// et si on ne peut pas le prévenir, on prévient l'admin !
						$notify_admin = true;
					}
					$body .= elgg_echo('postbymail:sender:notified');
				} else {
					$body .= elgg_echo('postbymail:sender:notnotified');
				}
				if ($notify_admin) {
					if ($published) {
						$admin_subject = elgg_echo('postbymail:adminsubject:newpublication');
						// Si c'est OK, on ne garde pas les messages de débuggage
						$admin_reply = elgg_echo('postbymail:adminmessage:newpublication', array($member->name, $member->email, $entity->getURL(), $entity->title, $entity->getSubtype(), $post_body, $entity->getURL()));
					} else {
						$admin_subject = elgg_echo('postbymail:admin:notpublished');
						$admin_reply = elgg_echo('postbymail:admin:debuginfo', array($admin_subject, $report, $admin_reply));
					}
					//$subject = elgg_echo('postbymail:admin:subject', array());
					//$message = elgg_echo('postbymail:admin:message', array());
					//mail($admin_email, $admin_subject, $admin_reply, $headers);
					$notifylist = elgg_get_plugin_setting('notifylist', 'postbymail');
					if ($notified_users = explode(',', trim($notifylist)) ) {
						//notify_user($notified_users, $site->guid, $admin_subject, $admin_reply, NULL, 'email');
						foreach($notified_users as $notified_user) {
							$admin_ent = get_entity($notified_user);
							$admin_email = $admin_ent->email;
							// Envoi par mail (mieux en HTML mais expéditeur à améliorer), sinon on passe par les moyens habituels (mais en texte brut)
							if (mail($admin_email, $admin_subject, $admin_reply, $headers)) {
							} else {
								notify_user($notified_user, $site->guid, $admin_subject, $admin_reply, NULL, 'email');
							}
						}
					}
					$body .= elgg_echo('postbymail:admin:notified');
				} else {
					$body .= elgg_echo('postbymail:admin:notnotified');
				}
				// Notification responsable du groupe
				if ($notify_groupadmin) {
					// @todo : notifier l'admin du groupe
					if ($groupowner = get_entity($group_entity->owner_guid)) {
						if (($admin_email = $groupowner->email) && mail($admin_email, $admin_subject, $admin_reply, $headers)) {
						} else {
							notify_user($groupowner->guid, $site->guid, $admin_subject, $admin_reply, NULL, 'email');
						}
					}
				}
				$body .= elgg_echo('postbymail:report:notificationmessages', array($sender_reply, $admin_reply));
				
				
				
				/**********************************/
				/*   IMAP : MARQUAGE DU MESSAGE   */
				/**********************************/
				// Que le message soit publié ou pas il est traité, donc on le marque comme lu : sauf re-marquage comme non lu, on ne le traitera plus
				//imap_setflag_full($conn, $msg_id, "\\Seen \\Deleted");	 Marquage comme lu, Params : Seen, Answered, Flagged (= urgent), Deleted (sera effacé), Draft, Recent
				imap_setflag_full($conn, $msg_id, "\\Seen");
				// Si le message est publié, on le marque en plus comme traité et on le range dans un dossier
				if ($published) {
					imap_setflag_full($conn, $msg_id, "\\Answered");
					if (@imap_mail_move($conn, $msg_id, "Published")) { $purge = true; }
				} else {
					// Si le message a été traité, on le range dans un dossier
					if (@imap_mail_move($conn, $msg_id, "Errors")) { $purge = true; }
					if ($notify_sender || $notify_admin) {
						// Si le message fait l'objet d'une notification, on le marque en plus comme traité
						imap_setflag_full($conn, $msg_id, "\\Answered");
					}
				}
				
			} // END foreach - MESSAGES LOOP
			
		} else {
			$body .= elgg_echo('postbymail:nonewmail');
		} // END unread messages check - $unreadmessages
		
		
		// Nettoie les messages effacés ou déplacés
		if ($purge) {
			imap_close($conn, CL_EXPUNGE); // semble effacer un peu trop ?? (si tentative de déplacement dans un dossier inexistant)
		} else {
			imap_close($conn);
		}
	} // END IMAP CONNECT CHECK
	
	
	// Publication results
	if ($pub_counter > 0) {
		$body .= elgg_echo('postbymail:numpublished', array($pub_counter));
	} else {
		$body .= elgg_echo('postbymail:nonepublished');
	}
	
	// Rétablissement des droits originaux
	elgg_set_ignore_access($ia);
	
	return $body;
}



/* NEW POST CHECK - Checks if all parameters are ok to publish a new post
 * $checkhash	 false, or publication hash to use hash check (hashed message will be ignored and not published)
	
		Posting by mail is for groups and users
		Use cases :
		- allow automatic posting into groups, from anyone who knows the key. The content is owned by the group itself, no need to consider sending email.
		- allow to post personnal content by mail, only for valid users. Requires personnal key but no need to check the sending email itself.
		Uses new parameters :
		- a posting "key", associated to the container group or user. This key should be unique, and add some protection against spamming, but also allow anyone to post.
		- a "subtype" parameter, to allow 
		=> in both cases, sender should be identified when it's possible, but the post is sent by the group or user itself if email can't be found.
 */
function postbymail_checkeligible_post($params = array()) {
	$defaults = array('key' => false, 'member' => false, 'subtype' => 'blog', 'access' => false, 'hash' => false);
	$params = array_merge($defaults, $params);
	
	global $sender_reply;
	global $admin_reply;
	// Vérifications préliminaires - au moindre problème, on annule la publication
	$mailpost_check = true;
	
	// KEY CHECK : doit exister et correspondre à celle d'un user ou d'un group
	if (!empty($params['key'])) {
		// pour connaître le container autorisé, on coupe sur le 1er "k" et on prend ce qui précède comme GUID
		$kpos = mb_strpos($params['key'], 'k');
		if ($kpos) $container_guid = mb_substr($params['key'], 0, $kpos);
		
		// Vérification du container
		if ($container_guid && ($container = get_entity($container_guid))) {
			// Conteneur OK
			$report .= elgg_echo('postbymail:validcontainer');
			if (elgg_instanceof($container, 'user')) {
				$report .= elgg_echo('postbymail:container:isuser') . ' ' . $container->name;
			} else if (elgg_instanceof($container, 'group')) {
				$report .= elgg_echo('postbymail:container:isgroup') . ' ' . $container->name;
			} else if (elgg_instanceof($container, 'site')) {
				$report .= elgg_echo('postbymail:container:issite') . ' ' . $container->name;
			} else {
				// Mauvais container - inconnu
				$report .= elgg_echo('postbymail:error:unknowncontainer', array($container_guid));
				$mailpost_check = false;
			}
			
			// Vérification de la clef (doit être identique pour cet user ou ce group)
			if (!empty($container->pubkey) && ($container->pubkey == $params['key'])) {
				// Ok pour la clef : existe et valide
				$report .= elgg_echo('postbymail:validkey');
			} else {
				// Clef invalide ou inexistante
				$report .= elgg_echo('postbymail:error:invalidkey') . ' : ' . $params['key'];
				$mailpost_check = false;
			}
		} else {
			// Mauvais container - inexistant
			$report .= elgg_echo('postbymail:error:badcontainer', array($container_guid));
			$mailpost_check = false;
		}
	} else {
		// Pas de clef ou clef vide
		$report .= elgg_echo('postbymail:error:emptykey');
		$mailpost_check = false;
	}
	$report .= elgg_echo('postbymail:key') . ' : ' . $params['key'];
	
	// SUBTYPE CHECK : on vérifie qu'il existe, sinon on en définit un par défaut
	// Subtype par défaut : blog
	if (empty($params['subtype'])) { $params['subtype'] = 'blog'; }
	// On vérifie que le subtype est bien valide, et qu'il est activé pour ce conteneur, si c'est un groupe
	// @TODO attention aux cas particulier où le nom diffère...
	if (elgg_instanceof($container, 'group')) {
		if ($container->{$params['subtype'] . '_enable'} == 'yes') {
			$report .= "Subtype {$params['subtype']} enabled in " . $container->name;
		} else {
			$report .= "Subtype {$params['subtype']} NOT enabled in " . $container->name;
			$mailpost_check = false;
		}
	} else {
		if (!elgg_is_active_plugin($subtype)) {
			$report .= "Plugin {$params['subtype']} NOT active";
			$mailpost_check = false;
		}
	}
	$report .= elgg_echo('postbymail:subtype') . ' : ' . $params['subtype'];
	
	// ACCESS INFO : soit défini, soit par défaut si c'est un ElggUser ou ElggSite, soit réservé au groupe si c'est un ElggGroup
	// SI accès défini, on vérifie qu'il est valide
	if ($params['access'] !== false) {
		// @todo vérifier que l'access id est bien valide, pas valide => empty
		if (($params['access'] >= -2) && ($params['access'] <= 2)) {
			// OK ça existe en standard
		} else {
			$acl = get_access_collection($params['access']);
			if (empty($acl->owner_guid)) {
				$report .= "Access id {$params['access']} NOT valid";
				// Invalid : use default value
				$params['access'] = false;
			}
		}
	}
	// Use default access if not correctly defined
	if (($params['access'] === false) || (strlen($params['access']) == 0) || ($params['access'] === '')) {
		// Privé pour un membre, limité aux membres du groupe pour un groupe
		if (elgg_instanceof($container, 'user') || elgg_instanceof($container, 'site')) {
			$params['access'] = get_default_access();
		} else if (elgg_instanceof($container, 'group')) {
			$params['access'] = $container->group_acl;
		}
	}
	$report .= elgg_echo('postbymail:access', array($params['access']));
	
	// MEMBER CHECK : soit celui identifié si c'est bien un ElggUser, sinon l'ElggUser ou l'ElggGroup qui sert de container
	if (elgg_instanceof($params['member'], 'user')) {
		$report .= elgg_echo('postbymail:member:validsender');
	} else {
		$report .= elgg_echo('postbymail:member:containerinstead');
		$params['member'] = $container;
	}
	$report .= elgg_echo('postbymail:member') . ' : ' . $params['member']->name;
	
	// ANTI-DOUBLONS : Vérification supplémentaire des doublons via le hash stocké dans l'entité container de la publication 
	// (donc pas l'auteur, mais plutôt le lieu de publication)
	// Principe : on ne publie un message qu'une seule fois, sinon a priori c'est un autre message (ou l'original a été effacé)
	if ($params['hash'] && isset($container->mail_post_hash)) {
		$hash_arr = unserialize($container->mail_post_hash);
		if (in_array($params['hash'], $hash_arr)) {
			$report .= elgg_echo('postbymail:error:alreadypublished');
			$mailreply_check = false;
		}
	}
	
	return array('member' => $params['member'], 'container' => $container, 'access' => $params['access'], 'subtype' => $params['subtype'], 'check' => $mailpost_check, 'report' => $report, 'hash' => $hash_arr);
}


/* REPLY CHECK - Checks if all parameters are ok to publish a reply to a post
 * $checkhash	 false, or publication hash to use hash check (hashed message will be ignored and not published)
*/
function postbymail_checkeligible_reply($params) {
	$defaults = array('entity' => false, 'member' => false, 'post_body' => false, 'email_headers' => false, 'hash' => false);
	$params = array_merge($defaults, $params);
	
	global $sender_reply;
	global $admin_reply;
	// Vérifications préliminaires - au moindre problème, on annule la publication
	$mailreply_check = true;
	if ($params['entity'] && elgg_instanceof($params['entity'], 'object')) {
		$report .= elgg_echo('postbymail:validobject', array($params['entity']->title));
		// Container
		if ($group_entity = get_entity($params['entity']->container_guid)) {
			$report .= elgg_echo('postbymail:containerok');
			// Membre
			if (elgg_instanceof($params['member'], 'user')) {
				$report .= elgg_echo('postbymail:memberok', array($params['member']->name));
				// Check the user is a group member, or if he is the group owner, or if he is an admin
				if (elgg_instanceof($group_entity, 'group')) {
					$report .= elgg_echo('postbymail:groupok', array($group_entity->name));
					if (($group_entity->isMember($params['member']))
						|| ($group_entity->owner_guid == $params['member']->guid)
						|| $params['member']->admin || $params['member']->siteadmin ) {
							$report .= elgg_echo('postbymail:ismember', array($params['member']->name, $group_entity->name));
						} else {
							$report .= elgg_echo('postbymail:error:nogroupmember', array($params['member']->name, $group_entity->name));
							$mailreply_check = false;
						}
				} else if (elgg_instanceof($group_entity, 'user')) {
					// Member container allowed : personnal publications + messages replies
					//$report .= elgg_echo('postbymail:error:notingroup:user');
					//$mailreply_check = false;
				} else {
					$report .= elgg_echo('postbymail:error:notingroup');
					$mailreply_check = false;
				}
			} else {
				$report .= elgg_echo('postbymail:error:nomember');
				$mailreply_check = false;
			}
		} else {
			$report .= elgg_echo('postbymail:error:nocontainer', array($params['entity']->guid, $params['entity']->container_guid));
			$mailreply_check = false;
		}
	} else {
		$report .= elgg_echo('postbymail:error:badguid');
		$mailreply_check = false;
	}
	
	// Si vide inutile de publier
	if (empty($params['post_body'])) {
		$report .= elgg_echo('postbymail:error:emptymessage');
		$mailreply_check = false;
	}
	
	// Vérification supplémentaire des doublons via le hash stocké dans l'entité commentée
	// on ne publie un message qu'une seule fois, sinon a priori c'est un autre message (ou l'original a été effacé)...
	if ($params['hash'] && isset($params['entity']->mail_post_hash)) {
		$hash_arr = unserialize($params['entity']->mail_post_hash);
		if (in_array($params['hash'], $hash_arr)) {
			$report .= elgg_echo('postbymail:error:alreadypublished');
			$mailreply_check = false;
		}
	}

	// Dernier rideau : un mail acceptable peut également être une réponse automatique : cas délicat à détecter...
	// @TODO : Filter auto-responses (avoids loops !!!)
	// Only send a response if the ‘Auto-submitted’ field is absent or set to ‘no’.
	// Important : les noms des index doivent être en minuscules !
	$email_header_autosubmitted = $params['email_headers']['auto-submitted'];
	$email_header_returnpath = $params['email_headers']['return-path'];
	$email_header_from = $params['email_headers']['from'];
	//error_log("Headers : $email_header_autosubmitted / $email_header_returnpath / $email_header_from / " . print_r($params['email_headers'], true));
	if (!empty($email_header_autosubmitted) && ($email_header_autosubmitted != 'no')) {
		// Header signalant explicitement une réponse automatique => on ne publie pas !
		$report .= elgg_echo('postbymail:error:automatic_reply');
		$report .= "\n<br />TESTS HEADERS POSTBYMAIL : Auto-submitted = $email_header_autosubmitted\n<br />Return-Path = $email_header_returnpath\n<br />From = $email_header_from\n";
		$mailreply_check = false;
	}
	// Drop the response if the Return-Path or From is empty or ‘<>’ (the "null address").
	if (empty($email_header_returnpath) || empty($email_header_from) || ($email_header_returnpath == '<>') || ($email_header_from == '<>')) {
		// Présomption forte de réponse automatique => on ne publie pas !
		$report .= elgg_echo('postbymail:error:probable_automatic_reply');
		$report .= "\n<br />TESTS HEADERS POSTBYMAIL : Auto-submitted = $email_header_autosubmitted\n<br />Return-Path = $email_header_returnpath\n<br />From = $email_header_from\n";
		$mailreply_check = false;
	}
	//$report .= "Message headers array = " . print_r($message, true);
	
	return array('member' => $params['member'], 'group' => $group, 'check' => $mailreply_check, 'report' => $report, 'hash' => $hash_arr);
}



/*
 * Mail content extraction function : extracts message elements, in html or text format
 * $mailparts	 the message content, as provided by $message = Mail_mimeDecode::decode($mimeParams);
 * $html	 boolean	 get only HTML content (or text after converting line breaks, if no HTML available)
 * returns : message value, or array with more details (attachements)
*/
function mailparts_extract_content($mailparts, $html = true) {
	$msgbody = '';
	$attachment = '';
	// Note : on peut tester parts->N°->headers->content-type (par ex. text/plain; charset=UTF-8)
	// et content-transfer-encoding (par ex. quoted-printable)
	$charset = $mailparts->ctype_parameters['charset'];
	$ctype_primary = strtolower($mailparts->ctype_primary);
	if ($ctype_primary == "multipart") {
		// Multipart message : requires to process each part
		foreach ($mailparts->parts as $mailpart) {
			$mailpart_charset = $mailpart->ctype_parameters['charset'];
			$mailpart_ctype_primary = strtolower($mailpart->ctype_primary);
			$msgbody .= elgg_echo('postbymail:message:elements', array($mailpart_ctype_primary, $mailpart->ctype_secondary, $mailpart_charset));
			switch($mailpart_ctype_primary) {
				case 'text':
					$mailpart_msgbody = postbymail_convert_to_utf8($mailpart->body, $mailpart_charset);
					$msgbody .= elgg_echo('postbymail:attachment:msgcontent', array($mailpart_msgbody));
					break;
				case 'message':
				case 'multipart':
					$partcontent = mailparts_extract_content($mailpart, $html);
					$msgbody .= elgg_echo('postbymail:attachment:multipart', array($partcontent['body']));
					$attachment .= $partcontent['attachment'];
					break;
				case 'image':
					$attachment .= elgg_echo('postbymail:attachment:image', array(translateSize(mb_strlen($mailpart->body))));
					break;
				case 'audio':
				case 'video':
				case 'application':
				default: // Other cases = audio, video, application
					$attachment .= elgg_echo('postbymail:attachment:other', array(translateSize(mb_strlen($mailpart->body)))) . ' (' . $mailpart_ctype_primary . ')';
			}
		}
	} else {
		$msgbody = postbymail_convert_to_utf8($mailparts->body, $charset);
	}
	
	if (empty($attachement)) { $attachment = elgg_echo('postbymail:noattachment'); }
	return array('body' => trim($msgbody), 'attachment' => $attachment);
}

/*
 * Mail body extraction function : extracts message content, in html or text format, and ensure it's encoded as UTF-8
 * $mailparts	 the message content, as provided by $message = Mail_mimeDecode::decode($mimeParams);
 * $html	 boolean	 get only HTML content (or text after converting line breaks, if no HTML available)
 * returns : message body value, in UTF-8
*/
function mailparts_extract_body($mailparts, $html = true) {
	$charset = $mailparts->ctype_parameters['charset'];
	$ctype_primary = strtolower($mailparts->ctype_primary);
echo "Extract body : $ctype_primary $charset<br />"; // @debug
	switch($ctype_primary) {
		case 'message':
		case 'multipart':
			// We are only considering the first part, as we want the reply content only
			$mailpart = $mailparts->parts[0];
			$mailpart_charset = $mailpart->ctype_parameters['charset'];
echo 'Part 0 : ' . $mailpart_charset . '<pre>' . print_r($mailpart, true) . '</pre>'; // @debug
			switch(strtolower($mailpart->ctype_primary)) {
				case 'message':
				case 'multipart':
					$msgbody = mailparts_extract_body($mailpart, $html);
					break;
				case 'text':
echo "..before conversion : {$mailpart->body}<br />"; // @debug
					$msgbody = postbymail_convert_to_utf8($mailpart->body, $mailpart_charset);
echo "..after conversion : $msgbody<br />"; // @debug
					$msgbody = trim($msgbody);
					// Convert plain text to HTML breaks, if not already HTML
					if ($html && ($mailpart->ctype_secondary != 'html')) { $msgbody = nl2br($msgbody); }
					break;
				default: // Other cases = image, audio, video, application
			}
			break;
		
		case 'text':
echo "..before conversion : {$mailparts->body}<br />"; // @debug
			$msgbody = postbymail_convert_to_utf8($mailparts->body, $charset);
echo "..after conversion : $msgbody<br />"; // @debug
			$msgbody = trim($msgbody);
			// Convert plain text to HTML breaks, if not already HTML
			if ($html && ($mailparts->ctype_secondary != 'html')) { $msgbody = nl2br($msgbody); }
			break;
		
		default: // Other cases = image, audio, video, application
	}
	// Return result
	return $msgbody;
}


/* Convertit tout texte en UTF-8, afin de normaliser l'encodage des contenus */
/* Si le message contient des caractères invalides :
 * Par ex. message envoyé comme ISO-8859-1 mais en utilisant des caractères de Windows-1252
 * Lire les explications détaillées sur 
 *   http://forum.alsacreations.com/topic-17-6460-1-Encodage-caracteres-invalides-et-entites-HTML.html#p56012
 * Résumé : Les caractères "de contrôle" du jeu ISO-8859-1 (situés dans les intervalles 00-1F et 7F-9F) 
 *   ne sont généralement pas utilisés. Certaines entreprises ont créé d’autres jeux de caractères dans lesquels 
 *   les espaces alloués à ces caractères de contrôle (dans tous les charset ISO-*, pas seulement ISO-8859-1), 
 *   sont utilisés pour des caractères plus "utiles". L'utilisation de ces caractères invalides bloque le 
 *   fonctionnement des fonctions de traitement de PHP, notamment htmlentities, utilisé ici pour détecter cette 
 *   utilisation et utiliser le traitement approprié.
*/
function postbymail_convert_to_utf8($body = '', $charset = '') {
echo "Detect and convert : original charset=$charset // $body<br />";
echo "Quoted printable : " . quoted_printable_decode($body) . "<br />";
echo "UTF8 encode : " . utf8_encode($body) . "<br />";
	if (!empty($body)) {
		// Auto-detect charset, if needed
		if (empty($charset)) { $charset = mb_detect_encoding($body); }
		// Normalise charset name
		$charset = strtolower($charset);
		// Convert encoding if needed
		if ($charset != 'utf-8') {
			// Additional test for better handling of erroneous encoding
			if (mb_strlen(htmlentities($body, ENT_QUOTES, "UTF-8")) == 0) {
				// Cas envoi en Windows-1252 (logiciels anciens ou mal configurés, certains webmails, etc.)
				$return = mb_convert_encoding($body, "UTF-8");
			} else {
				$return = mb_convert_encoding($body, "UTF-8", $charset);
			}
		}
	} else { $return = $body; }
echo "...converted : charset=$charset // $return<hr />";
	return $return;
}


/* Extraie un email d'une adresse du type "Expéditeur <email@domain.tld>" */
function postbymail_extract_email($email_header) {
	// Check "official" email From
	if (strpos($email_header, '<') !== false) {
		$email = explode('<', $email_header);
		$email = explode('>', $email[1]);
		$email = $email[0];
	} else $email = $email_header;
	return $email;
}


/* Find a valid member from email headers
 * Expéditeur = le premier compte valide trouvé, d'abord en regardant parmi les adresses email des comptes Elgg
 * Puis via les adresses email alternatives
 */
function postbymail_find_sender($email_headers) {
	global $sender_reply;
	global $admin_reply;
	$dbprefix = elgg_get_config('dbprefix');
	
	// Check "official" email From
	$sendermail = postbymail_extract_email($email_headers['from']);
	if (!empty($sendermail)) {
		$sendermembers = get_user_by_email($sendermail);
		if ($sendermembers) {
			// Compte valide => OK on renvoie
			if (elgg_instanceof($sendermembers[0], 'user')) { return $sendermembers[0]; }
		}
	}
	
	// Si le premier compte trouvé n'est pas valide, on passe à la méthode suivante
	// Check also real sender
	$realsendermail = postbymail_extract_email($email_headers['sender']);
	if (!empty($realsendermail)) {
		$realmembers = get_user_by_email($realsendermail);
		if ($realmembers) {
			// Compte valide => OK on renvoie
			if (elgg_instanceof($realmembers[0], 'user')) { return $realmembers[0]; }
		}
	}
	
	// On regarde finalement dans les adresses email alternatives des membres, configurées via leurs paramètres personnels
	//error_log("DEBUG POSTBYMAIL : pas de mail OK, recherche parmi les alternatives");
	// @TODO : use core function ? smthg like $results = elgg_get_plugin_user_setting('alternatemail', '', 'postbymail')
	//error_log("DEBUG POSTBYMAIL : " . "SELECT * from {$dbprefix}private_settings where name = 'plugin:user_setting:postbymail:alternatemail'");
	if ($results = get_data("SELECT * from {$dbprefix}private_settings where name = 'plugin:user_setting:postbymail:alternatemail'")) {
		//error_log("DEBUG POSTBYMAIL : RESULTS = " . print_r($results, true));
		foreach ($results as $r) {
			$emails = $r->value;
			if (!empty($emails)) {
				$emails = explode(',', $emails);
				foreach ($emails as $email) {
					//$alternatemails[$r->entity_guid] = $email; // utiliserait pls clefs identiques - on évite..
					// L'important est de trouver un user valide, donc on arrête dès qu'on trouve..
					// sauf si on veut permettre des envois depuis pls adresses mais a priori on évite
					//echo ", $email";
					if (!empty($email) && in_array($email, array($sendermail, $realsendermail))) {
						$alternativemember = get_user($r->entity_guid);
						//error_log("DEBUG POSTBYMAIL : $sendermail / $realsendermail == " . $email . ' => ' . $alternativemember->username);
						if (elgg_instanceof($alternativemember, 'user')) { return $alternativemember; }
					}
				}
			}
		}
	}
	
	// No valid account found
	return false;
}


/* Render a readable date
 * $date	 timestamp
 */
function dateToFrenchFormat($date) {
	$time = strtotime($date);
	if ($time > 0) $date = date("d/m/Y à H:i:s", $time);
	return $date;
}


/* Render a readable filesize
 * $size	 size in bits
 */
function translateSize($size) {
	$units = array("octets", "Ko", "Mo", "Go", "To");
	for ($i = 0; $size >= 1024 && $i < count($units); $i++) $size /= 1024;
	return round($size, 2)." {$units[$i]}";
}


/*
// Returns true if $string is valid UTF-8 and false otherwise.
function postbymail_is_utf8($string) {
	// From http://w3.org/International/questions/qa-forms-utf-8.html
	return preg_match('%^(?:
	[\x09\x0A\x0D\x20-\x7E] # ASCII
	| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
	| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
	| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
	| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
	| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
	| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
	| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
	)*$%xs', $string);
}
*/


