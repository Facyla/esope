<?php
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
	global $CONFIG;
	
	$restore_access_override = elgg_get_ignore_access();
	elgg_set_ignore_access(true);
	$debug = true;
	// @TODO : vérifier si on doit faire un check has_acces_to_entity => normalement plus besoin en 1.8
	
	$body = ''; $pub_counter = 0;

	// Paramétrage du champ d'application des publications par mail
	$mailpost = get_plugin_setting('mailpost', 'postbymail');
	$group_mailpost = false;
	$user_mailpost = false;
	switch($mailpost) {
		case 'none':
			// Pas de publication par mail du tout : on ne notifie pas non plus et on peut sortir de suite sans parcourir les messages..
			$mailpost = false;
			break;
		case 'grouponly':
			$group_mailpost = true;
			break;
		case 'useronly':
			$user_mailpost = true;
			break;
		case 'userandgroup':
			$group_mailpost = true;
			$user_mailpost = true;
			break;
	}

	// Paramétrage du champ d'application des réponses par mail
	$mailreply = elgg_get_plugin_setting('scope', 'postbymail');
	$forumonly = false;
	switch($mailreply) {
		case 'none':
			// Pas de réponse par mail du tout
			$mailreply = false;
			break;
		case 'forumonly':
			$forumonly = true;
			break;
		case 'comments':
			break;
	}
	// Si ni les réponses, ni les publications ne sont autorisées => pas de publication par mail du tout : on ne notifie pas non plus et on peut sortir de suite sans parcourir les messages..
	if (!$mailpost && !$mailreply) { return false; }
	
	// Admins à notifier
	$notifylist = elgg_get_plugin_setting('notifylist', 'postbymail');
	$body .= sprintf(elgg_echo('postbymail:notifiedadminslist'), $notifylist);
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
	
	$notify_scope = elgg_get_plugin_setting('notify_scope', 'postbymail');
	if (empty($notify_scope)) { $notify_scope = 'error'; }
	$notify_scope = explode(':', $notify_scope);
	if (in_array('error', $notify_scope)) { $notify_admin_error = true; } else { $notify_admin_error = false; }
	if (in_array('success', $notify_scope)) { $notify_admin_success = true; } else { $notify_admin_success = false; }
	if (in_array('groupadmin', $notify_scope)) { $notify_groupadmin = true; } else { $notify_groupadmin = false; }
	
	if ($conn = imap_open('{'.$server.$protocol.'}'.$mailbox, $username, $password)) {
		$body .= elgg_echo('postbymail:connectionok');
		// Création des dossiers s'ils n'existent pas
		/* @todo : marche pas..
		if (imap_createmailbox($conn, imap_utf7_encode("{".$server.$protocol."}INBOX.Published"))) { $body .= "Boîte 'Published' créée"; }
		if (imap_createmailbox($conn, imap_utf7_encode("{".$server.$protocol."}INBOX.Errors"))) { $body .= "Boîte 'Errors' créée"; }
		if (imap_createmailbox($conn, imap_utf7_encode("{".$server.$protocol."}INBOX.TESTS"))) { $body .= "Boîte 'TEST' créée"; }
		*/
		$purge = false;
		
		// See if the mailbox contains any messages.
		//$allmsgCount = imap_num_msg($conn); // Compte tous les messages de la boîte
		// On récupère les messages non lus seulement.. - nbx autres paramètres
		if ($unreadmessages = imap_search($conn,'UNSEEN')) {
			$body .= sprintf(elgg_echo('postbymail:newmessagesfound'), sizeof($unreadmessages));
			// Loop through the messages.
			// Pour chaque message à traiter : on vérifie d'abord quelques pré-requis (messages systèmes)
				// Puis on vérifie les paramètres et on poste si tout est OK
			// + prévenir l'expéditeur (dans tous les cas) 
			// + prévenir un admin (idem ?)
			foreach ($unreadmessages as $i => $msg_id) {
				$body .= sprintf(elgg_echo('postbymail:processingmsgnumber'), ($i+1), $msg_id);
				// Get the message header.
				$header = imap_fetchheader($conn, $msg_id, FT_PREFETCHTEXT);
				// Set the message as read if told to
				if ($markSeen) { $msgbody = imap_body($conn, $msg_id); } else { $msgbody = imap_body($conn, $msg_id, FT_PEEK); }
				// Send the header and body through mimeDecode.
				$mimeParams['input'] = $header.$msgbody;
				$message = Mail_mimeDecode::decode($mimeParams);
				
				// Some mail servers and clients use special messages for holding mailbox data; ignore that message if it exists.
				if ($message->headers['subject'] != "DON'T DELETE THIS MESSAGE -- FOLDER INTERNAL DATA") {
					// A partir d'ici on a un message "traitable" et on peut notifier expéditeur et admin
					
					// @TODO : si le flag \\Answered est présent, on saute direct au suivant (traité et publié) !
					// if () { continue; }
					
					// Marqueurs selon motifs de ne pas notifier
					$member = false; $post_body = false;
					$published = false; $sender_reply = ''; $admin_reply = '';
					
					// Extract the message body in html or text if not available
					$msgbody = mailparts_extract_content($message, true, true);
					// On utilise la version texte si la version html (par défaut) ne renvoie rien
					if (empty($msgbody)) { $msgbody = mailparts_extract_content($message, true, false); }
					// Si le message contient des caractères invalides (= envoyé en ISO-8859-1 mais en utilisant des caractères de Windows-1252)
					// Explications détaillées sur http://forum.alsacreations.com/topic-17-6460-1-Encodage-caracteres-invalides-et-entites-HTML.html#p56012
					// Résumé : Les caractères "de contrôle" du jeu ISO-8859-1 (situés dans les intervalles 00-1F et 7F-9F) ne sont généralement pas utilisés. Certaines entreprises ont créé d’autres jeux de caractères dans lesquels les espaces alloués à ces caractères de contrôle (dans tous les charset ISO-*, pas seulement ISO-8859-1), utilisés pour des caractères plus "utiles". L'utilisation de ces caractères invalides bloque le fonctionnement des fonctions de traitement PHP, notamment htmlentities utilisé ici pour détecter cette utilisation et utiliser le traitement approprié.
					if (!empty($msgbody) && (mb_strlen(htmlentities($msgbody, ENT_QUOTES, "UTF-8")) == 0)) {
						// Cas envoi en Windows-1252 (logiciels anciens ou mal configurés, certains webmails, etc.)
						$msgbody = mb_convert_encoding($msgbody, "UTF-8");
					} else {
						// Cas standard
						$msgbody = mb_convert_encoding($msgbody, "UTF-8", mb_detect_encoding($msgbody));
					}

					// On filtre de la même manière que depuis le site
					$msgbody = filter_tags($msgbody);
					
					// Does the message have an attachment?
					// Lecture de tout le message pour identification des pièces jointes
					// @TODO ça pourra servir à publier lesdites pièces jointes, discutable à cause des signatures et autres icônes embarquées..
					$content = mailparts_extract_content($message);
					$full_msgbody = count($message->parts) . ' : ' . $content['body'];
					$attachment = $content['attachment'];
					
					// Format the message to get the required data and content
					if ($msgbody) {
						// On ne garde que ce qu'il y a avant le marqueur de fin de réponse (la suite est inutile et potentiellement volumineuse)
						// on publie quand même si le message ne porte pas de marqueur
						$cutat = mb_strpos($msgbody, $separator);
						if ($cutat !== false) { $post_body = mb_substr($msgbody, 0, $cutat); } else { $post_body = $msgbody; }
						// On coupe aussi tout ce qu'il y a avant </head>, si présent
						$cutatbody = mb_strpos($msgbody, '</head>');
						if (($cutatbody !== false) && ($cutatbody > 0)) { $post_body = mb_substr($post_body, $cutatbody + 7); } // + longueur du texte à couper (</head>)
						// @todo	on pourrait aussi chercher le prochain > après <body et couper là puis faire un trim..
						$post_body = trim($post_body);
						//$post_body = preg_replace('`[<br />]*$`', '', $post_body); // Fin de chaîne
						// Regex : en début de chaîne (^), on prend autant de fois que possible (*) la chaîne <br> (avec 0 ou + espace (*) 
						// suivi d'un / facultatif (?)), ou les chaînes \n, \r, \t (tabulation), et les espaces
						// ou idem en fin de chaîne ($)
						$post_body = mb_eregi_replace('^(<br */?>|<p>|\n|\r| |\t|&nbsp;)*|(<br */?>|</p>| |\n|\r|\t|&nbsp;)*$', '', $post_body);
					}
					
					$post_body = trim($post_body);
					// Trim the post body to $bodyMaxLength characters if desired.
					if ($bodyMaxLength && mb_strlen($post_body) > $bodyMaxLength) { $post_body = mb_substr($post_body, 0, $bodyMaxLength).'...'; }
					
					// Expéditeur "officiel" = le premier bon trouvé via l'un des 2 mails (d'abord celui "annoncé" puis le réel)
					$sendermail = explode('<', $message->headers['from']);
					$sendermail = explode('>', $sendermail[1]);
					$sendermail = $sendermail[0];
					if (!empty($sendermail)) {
						$members = get_user_by_email($sendermail);
						$sendermember = $members[0];
						$member = $sendermember;
					}
					$realsendermail = $message->headers['sender'];
					if (!empty($realsendermail)) {
						$realmembers = get_user_by_email($realsendermail);
						$realmember = $realmembers[0];
					}
					if ($member instanceof ElggUser) {
						// Si l'auteur demandé est bon on le garde
					} else if ($realmember instanceof ElggUser) {
						// sinon on prend l'autre..
						$member = $realmember;
					} else {
						//error_log("DEBUG POSTBYMAIL : pas de mail OK, recherche parmi les alternatives");
						// Et si toujours rien, on va chercher dans les paramètres personnels des membres des adresses alternatives..
						// @TODO : $results = elgg_get_plugin_user_setting('alternatemail', '', 'postbymail')
						//error_log("DEBUG POSTBYMAIL : " . "SELECT * from {$CONFIG->dbprefix}private_settings where name = 'plugin:user_setting:postbymail:alternatemail'");
						if ($results = get_data("SELECT * from {$CONFIG->dbprefix}private_settings where name = 'plugin:user_setting:postbymail:alternatemail'")) {
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
										if (($email == $sendermail) || ($email == $realsendermail)) {
											$alternativemember = get_user($r->entity_guid);
											//error_log("DEBUG POSTBYMAIL : $sendermail / $realsendermail == " . $email . ' => ' . $alternativemember->username);
											break;
										}
									}
								}
								// On sort si on a trouvé
								if ($alternativemember) break;
							}
						}
						if ($alternativemember instanceof ElggUser) { $member = $alternativemember; }
					}
					
					// Hash unique (contenu utilisé du mail) afin d'éviter les doublons et de republier un article supprimé (qu'on suppose modéré)
					// On prend aussi la date du message (mail) : si le message est publié à une autre date ça peut poser pb de se contenter du contenu
					// par exemple avec des réponses courtes type "oui", "ok" qui peuvent être multiples sur un unique thread
					//$hash = md5($realmember->guid . $post_body);
					// @TODO : add a light time frame to mail date ? (use minute or 5-10 minutes approximation instead of timestamp)
					$hash = md5($realmember->guid . $message->headers['date'] . $post_body);
					
					// Extraction des paramètres du message : entité concernée (et autres ?)
					$mailparams = explode('@', $message->headers['to']);
					$mailparams = explode('+', $mailparams[0]);
					$parameters = '';
					if (!empty($mailparams[1])) {
						$mailparams = explode('&', $mailparams[1]);
						$guid = null; $entity = null; $post_key = null; $post_subtype = null; $post_access = null; 
						foreach($mailparams as $mailparam) {
							$mailparam = explode('=', $mailparam);
							// @TODO use new elgg_echo
							//$parameters .= sprintf(elgg_echo('postbymail:info:memberandmail'), $mailparam[0], $mailparam[1]);
							$parameters .= sprintf(elgg_echo('postbymail:info:parameters'), $mailparam[0] . ' = ' . $mailparam[1]) . '<br />';
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
						if (!empty($parameters)) $parameters = sprintf(elgg_echo('postbymail:info:paramwrap'), $parameters);
					}
					
					
					// Informations sur le contenu du message
					$body .= sprintf(elgg_echo('postbymail:info:parameters'), $parameters);
					$body .= '<br class="clearfloat" /><hr />';
					
					// Infos pour l'expéditeur
					$sender_reply .= sprintf(elgg_echo('postbymail:info:memberandmail'), $sendermember->name, $sendermail);
					$sender_reply .= sprintf(elgg_echo('postbymail:info:realmemberandmail'), $realmember->name, htmlentities($realsendermail));
					$sender_reply .= sprintf(elgg_echo('postbymail:info:alternativememberandmail'), $alternativemember->name, $alternativemail);
					$sender_reply .= sprintf(elgg_echo('postbymail:info:publicationmember'), $member->name);
					$sender_reply .= sprintf(elgg_echo('postbymail:info:postfullmail'), htmlentities($message->headers['to']));
					$sender_reply .= sprintf(elgg_echo('postbymail:info:mailtitle'), $message->headers['subject']);
					$sender_reply .= sprintf(elgg_echo('postbymail:info:maildate'), dateToFrenchFormat($message->headers['date']));
					$sender_reply .= sprintf(elgg_echo('postbymail:info:hash'), $hash);
					$sender_reply .= sprintf(elgg_echo('postbymail:info:attachment'), $attachment);
					//$sender_reply .= sprintf(elgg_echo('postbymail:info:parameters'), $parameters);
					if ($entity) {
						$sender_reply .= sprintf(elgg_echo('postbymail:info:objectok'), $entity->getURL(), $entity->title, htmlentities($guid));
					} else {
						$sender_reply .= elgg_echo('postbymail:info:badguid');
					}
					
					// Infos pour l'admin
					$admin_reply .= sprintf(elgg_echo('postbymail:info:memberandmail'), $sendermember->name, $sendermail);
					$admin_reply .= sprintf(elgg_echo('postbymail:info:realmemberandmail'), $realmember->name, htmlentities($realsendermail));
					$admin_reply .= sprintf(elgg_echo('postbymail:info:alternativememberandmail'), $alternativemember->name, $alternativemail);
					$admin_reply .= sprintf(elgg_echo('postbymail:info:publicationmember'), $member->name);
					$admin_reply .= sprintf(elgg_echo('postbymail:info:postfullmail'), htmlentities($message->headers['to']));
					$admin_reply .= sprintf(elgg_echo('postbymail:info:mailbox'), $mailbox);
					$admin_reply .= sprintf(elgg_echo('postbymail:info:mailtitle'), $message->headers['subject']);
					$admin_reply .= sprintf(elgg_echo('postbymail:info:maildate'), dateToFrenchFormat($message->headers['date']));
					$admin_reply .= sprintf(elgg_echo('postbymail:info:hash'), $hash);
					$admin_reply .= sprintf(elgg_echo('postbymail:info:attachment'), $attachment);
					if ($entity) {
						$admin_reply .= sprintf(elgg_echo('postbymail:info:objectok'), $entity->getURL(), $entity->title, htmlentities($guid));
					} else {
						$admin_reply .= elgg_echo('postbymail:info:badguid');
					}
					
					$body .= "<br class=\"clearfloat\" /><br />";
					
					
					// CHECK POST REQUISITES
					// Switch here between reply by mail and post by mail
					// We assume that 'guid' param is exclusive for replies, and 'key' is exclusive for new publications
					
					// Si les publications par mail sont activées, on vérifie qu'on a les paramètres requis
					// We need : a posting "key" (unically associated to the container group or user), and a "subtype" parameter.
					// Sender should be identified when possible, but the post is sent by the group or user itself if email can't be found.
					$mailpost_check = false;
					if ($mailpost && !empty($post_key)) {
						// string or false	false, ou $hash publication pour vérifier si déjà publié via le hash (et supprimé par exemple, ou si on a remis les messages comme non lus..)
						$post_check = postbymail_checkeligible_post($post_key, $member, $post_subtype, $post_access, $hash);
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
					
					// Si les réponses par mail sont activées, on vérifie qu'on a les paramètres requis
					$mailreply_check = false;
					if ($mailreply && !empty($guid)) {
						// string or false	false, ou $hash publication pour vérifier si déjà publié via le hash (et supprimé par exemple, ou si on a remis les messages comme non lus..)
						$reply_check = postbymail_checkeligible_reply($entity, $member, $post_body, $hash);
						$mailreply_check = $reply_check['check'];
						$member = $reply_check['member'];
						$group_entity = $reply_check['group'];
						$hash_arr = $reply_check['hash'];
						$report = $reply_check['report'];
						$body .= $report;
						//$admin_reply .= $report;
						//$sender_reply .= $report;
					}
					
					
					// PUBLICATION DU MESSAGE (nouvelle entité)
					if ($mailpost && $mailpost_check) {
						switch($post_subtype) {
							case 'bookmarks':
								$new_post = new ElggObject;
								$new_post->subtype = "bookmarks";
								$new_post->owner_guid = $post_owner->guid;
								$new_post->container_guid = $post_container->guid;
								$new_post->title = $message->headers['subject'];
								$new_post->address = $post_address;
								$new_post->description = $post_description;
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
								$new_post->description = $post_description;
								$new_post->excerpt = $post_excerpt;
								$new_post->access_id = $post_access;
								$new_post->tags = $post_tagarray;
								if ($new_post->save()) {
									$published = true;
									$body .= elgg_echo("postbymail:newpost:posted");
								}
								break;
							default:
								$new_post = new ElggObject;
								$new_post->subtype = "blog";
								$new_post->owner_guid = $post_owner->guid;
								$new_post->container_guid = $post_container->guid;
								$new_post->title = $message->headers['subject'];
								$new_post->description = $post_description;
								$new_post->access_id = $post_access;
								$new_post->tags = $post_tagarray;
								if ($new_post->save()) {
									$published = true;
									$body .= elgg_echo("postbymail:newpost:posted");
								}
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
							$admin_reply = sprintf(elgg_echo('postbymail:error:lastminutedebug'), $admin_reply);
						}
						
					} else {
						// Pas publiable
						$admin_reply .= sprintf(elgg_echo('postbymail:admin:reportmessage:error'), $cutat, $post_body, $msgbody);
						$sender_reply .= sprintf(elgg_echo('postbymail:sender:reportmessage:error'), $post_body);
					}
					$body .= '<div class="clearfloat"></div>';
					
					
					// PUBLICATION DU MESSAGE DE REPONSE
					if ($mailreply && $mailreply_check) {
						$body .= sprintf(elgg_echo('postbymail:info:usefulcontent'), $post_body);
						$sent = false;
						// Vérification du subtype, pour utiliser le bon type de publication
						if ($subtype = $entity->getSubtype()) {
							// Important pour notification_messages qui récupère cette info pour publier avec le bon auteur..
							set_input('postbymail_editor_id', $member->guid);
							set_input('topic_post', $post_body);
							// Publication effective : message de réussite, et ajout du hash pour noter que ce message a été publié
							// Ajout du hash aux publications déjà faites (peu importe de matcher hash et mail, ce qui importe c'est les doublons)
							switch($subtype) {
								case 'groupforumtopic':
									if ($entity->annotate('group_topic_post', $post_body, $entity->access_id, $member->guid)) {
										//set_input('group_topic_post', $post_body);
										$published = true;
										$body .= elgg_echo("groupspost:success");
										add_to_river('river/forum/create', 'create', $member->guid, $entity->guid);
									}
									break;
								case 'messages':
									/*
									error_log("DEBUG messages post : from = {$entity->fromId}, to = {$entity->toId}");
									error_log("DEBUG messages reply : from = {$member->guid}, to = {$entity->fromId}");
									*/
									$result = messages_send($entity->title,$post_body, $entity->fromId, $member->guid, $entity->guid, true, true); // Add to sent message (need it once)
									if ($result) {
										set_input('generic_comment', $post_body);
										$published = true;
										system_message(elgg_echo("postbymail:mailreply:success"));
									}
									break;
								default:
									//set_input('topic_post', $post_body);
									// Les commentaires sont acceptés en fonctions des paramétrages aussi
									if ($forumonly) {
										$admin_reply .= elgg_echo('postbymail:admin:error:forumonly');
										$sender_reply = sprintf(elgg_echo('postbymail:sender:error:forumonly'), $sender_reply);
										break;
									} else {
										if ($entity->annotate('generic_comment', $post_body, $entity->access_id, $member->guid)) {
											$published = true;
											$body .= elgg_echo("generic_comment:posted");
											add_to_river('annotation/annotate','comment',$member->guid,$entity->guid);
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
							$admin_reply = sprintf(elgg_echo('postbymail:error:lastminutedebug'), $admin_reply);
						}
						
					} else {
						// Pas publiable
						$admin_reply .= sprintf(elgg_echo('postbymail:admin:reportmessage:error'), $cutat, $post_body, $msgbody);
						$sender_reply .= sprintf(elgg_echo('postbymail:sender:reportmessage:error'), $post_body);
					}
					$body .= '<div class="clearfloat"></div>';
					/*
					$errorlog_message = "DEBUG POSTBYMAIL functions : editor = {$member->guid}, subtype = $subtype, guid = {$entity->guid}, check = $forum_post_check, body = " . print_r($entity, true);
					error_log($errorlog_message);
					$admin_reply .= "<hr />$errorlog_message<hr />";
					*/
					
					
					// NOTIFICATIONS - notify anyone who should be after it's posted (or not)
					// 1. Check notification conditions first
					$notify_sender = false; $notify_admin = false;
					if ($published) {
						// L'auteur n'a pas besoin de notification pour un message accepté
						// En cas de publication, l'admin doit être prévenu pour pouvoir modérer
						$admin_reply = sprintf(elgg_echo('postbymail:adminmessage:success'), $admin_reply);
						if ($notify_admin_success) { $notify_admin = true; }
					} else {
						// NOTIFICATIONS AUTEUR
						$sender_reply = sprintf(elgg_echo('postbymail:sendermessage:error'), $sender_reply);
						// On notifie dans tous les cas d'échec ? a priori oui..
						$notify_sender = true;
						
						// NOTIFICATIONS ADMIN
						if ($notify_sender) {
							// @todo à voir si on prévient quand même l'admin quand l'auteur est informé et qu'on explique pourquoi avec les infos fournies
							if ($notify_admin_error) { $notify_admin = true; }
						} else {
							// L'admin a besoin d'intervenir pour gérer du spam (blacklist) ou des membres qui ont besoin d'aide et ne sont pas prévenus
							$notify_admin = true;
						}
					}
					
					// 2. Envoi des notifications / send notifications
					// Headers communs
					$headers = "From: Publication par mail {$CONFIG->site->name} <{$CONFIG->site->email}>\n";
					$headers .= "Return-Path: <{$CONFIG->site->email}>\n";
					$headers .= "X-Sender: <{$CONFIG->site->name}>\n";
					$headers .= "X-auth-smtp-user: {$CONFIG->site->email} \n";
					$headers .= "X-abuse-contact: {$CONFIG->site->email} \n";
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
						$sender_reply = sprintf(elgg_echo('postbymail:sender:reportmessage:error'), $post_body);
						$sender_reply = sprintf(elgg_echo('postbymail:sender:debuginfo'), $sender_subject, $report, $sender_reply);
						if (($member instanceof ElggUser) &&	is_email_address($member->email)) {
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
							$admin_reply = sprintf(elgg_echo('postbymail:adminmessage:newpublication'), $member->name, $member->email, $entity->getURL(), $entity->title, $entity->getSubtype(), $post_body, $entity->getURL());
						} else {
							$admin_subject = elgg_echo('postbymail:admin:notpublished');
							$admin_reply = sprintf(elgg_echo('postbymail:admin:debuginfo'), $admin_subject, $report, $admin_reply);
						}
						//$subject = sprintf(elgg_echo('postbymail:admin:subject'));
						//$message = sprintf(elgg_echo('postbymail:admin:message'));
						//mail($admin_email, $admin_subject, $admin_reply, $headers);
						$notifylist = elgg_get_plugin_setting('notifylist', 'postbymail');
						if ($notified_users = explode(',', trim($notifylist)) ) {
							//notify_user($notified_users, $CONFIG->site->guid, $admin_subject, $admin_reply, NULL, 'email');
							foreach($notified_users as $notified_user) {
								$admin_ent = get_entity($notified_user);
								$admin_email = $admin_ent->email;
								// Envoi par mail (mieux en HTML mais expéditeur à améliorer), sinon on passe par les moyens habituels (mais en texte brut)
								if (mail($admin_email, $admin_subject, $admin_reply, $headers)) {
								} else {
									notify_user($notified_user, $CONFIG->site->guid, $admin_subject, $admin_reply, NULL, 'email');
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
								notify_user($groupowner->guid, $CONFIG->site->guid, $admin_subject, $admin_reply, NULL, 'email');
							}
						}
					}
					$body .= sprintf(elgg_echo('postbymail:report:notificationmessages'), $sender_reply, $admin_reply);
					
					// MARQUAGE DU MESSAGE
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
					
				} // </if($message->headers['subject'] != "DON'T DELETE THIS MESSAGE -- FOLDER INTERNAL DATA")>
			} // </foreach>
		} else {
			$body .= elgg_echo('postbymail:nonewmail');
		} // </if $unreadmessages>
		if ($purge) {
			imap_close($conn, CL_EXPUNGE); // Nettoie les messages effacés ou déplacés // semble effacer un peu trop ?? (si tentative de déplacement dans un dossier inexistant)
		} else {
			imap_close($conn);
		}
	} else {
		$body .= elgg_echo('postbymail:badpluginconfig');
	} // </if $conn>
	
	if ($pub_counter > 0) $body .= sprintf(elgg_echo('postbymail:numpublished'), $pub_counter);
	else $body .= elgg_echo('postbymail:nonepublished');
	
	// Rétablissement des droits originaux
	elgg_set_ignore_access($restore_access_override);
	
	return $body;
}


/* Checks if all parameters are ok to publish a new post
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
function postbymail_checkeligible_post($key, $member = false, $subtype = 'blog', $access = false, $hash = false) {
	// Vérifications préliminaires - au moindre problème, on annule la publication
	$mailpost_check = true;
	
	// Key : doit exister et correspondre à celle d'un user ou d'un group
	if (!empty($key)) {
		// pour connaître le container autorisé, on coupe sur le 1er "k" et on prend ce qui précède comme GUID
		$kpos = mb_strpos($key, 'k');
		$container_guid = mb_substr($key, 0, $kpos);
		if ($kpos && ($container = get_entity($container_guid))) {
			// Conteneur OK
			$report .= elgg_echo('postbymail:validcontainer');
			if ($container instanceof ElggUser) {
				$report .= elgg_echo('postbymail:container:isuser') . ' ' . $container->name;
			} else if ($container instanceof ElggGroup) {
				$report .= elgg_echo('postbymail:container:isgroup') . ' ' . $container->name;
			}
			// @todo : Il faut maintenant vérifier que cette clef existe pour cet user
			if (!empty($container->pubkey) && ($container->pubkey == $key)) {
				// Ok pour la clef : existe et valide
				$report .= elgg_echo('postbymail:validkey');
			} else {
				// Clef invalide ou inexistante
				$report .= elgg_echo('postbymail:error:invalidkey') . ' : ' . $key;
				$mailpost_check = false;
			}
		} else {
			// Mauvais container - inexistant
			$report .= elgg_echo('postbymail:error:badcontainer') . ' : ' . $container_guid;
			$mailpost_check = false;
		}
	} else {
		// Pas de clef ou clef vide
		$report .= elgg_echo('postbymail:error:emptykey');
		$mailpost_check = false;
	}
	$report .= elgg_echo('postbymail:key') . ' : ' . $key;
	
	// Subtype : on vérifie qu'il existe, sinon on en définit un par défaut
	if ($mailpost_check) {
		if (!empty($subtype)) {
			// @todo vérifier que le subtype est bien valide, et qu'il est activé pour ce conteneur, si c'est un groupe
			if (true) {} else { $subtype = null; }
		}
		if (empty($subtype)) {
			// Choix du subtype par défaut
			$subtype = 'blog';
		}
	}
	$report .= elgg_echo('postbymail:subtype') . ' : ' . $subtype;
	
	// Access : soit défini, soit par défaut privé si c'est un ElggUser, et réservé au groupe si c'est un ElggGroup
	if ($mailpost_check) {
		if ($access) {
			// @todo vérifier que l'access id est bien valide, pas valide => empty
			if (true) {} else { $access = false; }
		}
		if (!$access && ($access != 0)) {
			// Choix du subtype par défaut
			if ($container instanceof ElggUser) { $access = 0; } 
			else if ($container instanceof ElggGroup) { $access = $container->group_acl; }
		}
	}
	$report .= elgg_echo('postbymail:access') . ' : ' . $access;
	
	// Member : soit celui identifié si c'est bien un ElggUser, sinon l'ElggUser ou l'ElggGroup qui sert de container
	if ($member instanceof ElggUser) {
	} else {
		$report .= elgg_echo('postbymail:member:containerinstead');
		$member = $container;
	}
	$report .= elgg_echo('postbymail:member') . ' : ' . $member->name;
	
	// Vérification supplémentaire des doublons via le hash stocké dans l'entité container de la publication (pas l'auteur, mais plutôt le lieu de publication)
	// on ne publie un message qu'une seule fois, sinon a priori c'est un autre message (ou l'original a été effacé)...
	if ($hash && isset($container->mail_post_hash)) {
		$hash_arr = unserialize($container->mail_post_hash);
		if (in_array($hash, $hash_arr)) {
			$report .= elgg_echo('postbymail:error:alreadypublished');
			$mailreply_check = false;
		}
	}
	
	return array('member' => $member, 'container' => $container, 'access' => $access, 'subtype' => $subtype, 'check' => $mailpost_check, 'report' => $report, 'hash' => $hash_arr);
}


/* Checks if all parameters are ok to publish a reply to a post
 * $checkhash	 false, or publication hash to use hash check (hashed message will be ignored and not published)
*/
function postbymail_checkeligible_reply($entity, $member, $post_body, $hash = false) {
	// Vérifications préliminaires - au moindre problème, on annule la publication
	$mailreply_check = true;
	if ($entity && ($entity instanceof ElggObject)) {
		$report .= sprintf(elgg_echo('postbymail:validobject'), $entity->title);
		// Container
		if ($group_entity = get_entity($entity->container_guid)) {
			$report .= elgg_echo('postbymail:containerok');
			// Membre
			if ($member instanceof ElggUser) {
				$report .= sprintf(elgg_echo('postbymail:memberok'), $member->name);
				// Check the user is a group member, or if he is the group owner, or if he is an admin
				if ($group_entity instanceof ElggGroup) {
					$report .= sprintf(elgg_echo('postbymail:groupok'), $group_entity->name);
					if (($group_entity->isMember($member))
						|| ($group_entity->owner_guid == $member->guid)
						|| $member->admin || $member->siteadmin ) {
						$report .= sprintf(elgg_echo('postbymail:ismember'), $member->name, $group_entity->name);
						} else {
						$report .= sprintf(elgg_echo('postbymail:error:nogroupmember'), $member->name, $group_entity->name);
						$mailreply_check = false;
						}
				} else {
					$report .= elgg_echo('postbymail:error:notingroup');
					$mailreply_check = false;
				}
			} else {
				$report .= elgg_echo('postbymail:error:nomember');
				$mailreply_check = false;
			}
		} else {
			$report .= sprintf(elgg_echo('postbymail:error:nocontainer'), $entity->guid, $entity->container_guid);
			$mailreply_check = false;
		}
	} else {
		$report .= elgg_echo('postbymail:error:badguid');
		$mailreply_check = false;
	}
	
	// Si vide inutile de publier
	if (empty($post_body)) {
		$report .= elgg_echo('postbymail:error:emptymessage');
		$mailreply_check = false;
	}
	
	// Vérification supplémentaire des doublons via le hash stocké dans l'entité commentée
	// on ne publie un message qu'une seule fois, sinon a priori c'est un autre message (ou l'original a été effacé)...
	if ($hash && isset($entity->mail_post_hash)) {
		$hash_arr = unserialize($entity->mail_post_hash);
		if (in_array($hash, $hash_arr)) {
			$report .= elgg_echo('postbymail:error:alreadypublished');
			$mailreply_check = false;
		}
	}

	// Dernier rideau : un mail acceptable peut également être une réponse automatique : cas délicat à détecter...
	// @TODO : Filter auto-responses (avoids loops !!!)
	// Only send a response if the ‘Auto-submitted’ field is absent or set to ‘no’.
	// Important : les noms des index doivent être en minuscules !
	$message_header_autosubmitted = $message->headers['auto-submitted'];
	$message_header_returnpath = $message->headers['return-path'];
	$message_header_from = $message->headers['from'];
	if (!empty($message_header_autosubmitted) && ($message_header_autosubmitted != 'no')) {
		// Header signalant explicitement une réponse automatique => on ne publie pas !
		$report .= elgg_echo('postbymail:error:automatic_reply');
		$report .= "\n<br />TESTS HEADERS POSTBYMAIL : Auto-submitted = $message_header_autosubmitted\n<br />Return-Path = $message_header_returnpath\n<br />From = $message_header_from\n";
		$forum_post_check = false;
	}
	// Drop the response if the Return-Path or From is ‘<>’ (the "null address").
	if (empty($message_header_returnpath) || empty($message_header_from)) {
		// Présomption forte de réponse automatique => on ne publie pas !
		$report .= elgg_echo('postbymail:error:probable_automatic_reply');
		$report .= "\n<br />TESTS HEADERS POSTBYMAIL : Auto-submitted = $message_header_autosubmitted\n<br />Return-Path = $message_header_returnpath\n<br />From = $message_header_from\n";
		$forum_post_check = false;
	}
	//$report .= "Message headers array = " . print_r($message, true);
	
	return array('member' => $member, 'group' => $group, 'check' => $forum_post_check, 'report' => $report, 'hash' => $hash_arr);
}



/*
 * Mail content extraction function : extracts message content, and optionnaly attachements, in html or text format
 * $mailparts	 the message content, as provided by $message = Mail_mimeDecode::decode($mimeParams);
 * $firstbody	 boolean	 return only the message content (no attachment nor message parts)
 * $html	 boolean	 get only HTML content (or text after converting line breaks, if no HTML available)
 * returns : message value, or array with more details (attachements)
*/
function mailparts_extract_content($mailparts, $firstbody = false, $html = true) {
	// Note : on peut tester parts->N°->headers->content-type (par ex. text/plain; charset=UTF-8) et content-transfer-encoding (par ex. quoted-printable)
	if (strtolower($mailparts->ctype_primary) == "multipart") {
		$attachment = '';
		foreach ($mailparts->parts as $part) {
			if ($firstbody) {
				switch(strtolower($part->ctype_primary)) {
					case 'multipart': return mailparts_extract_content($part, true); break;
					case 'image': break;
					case 'text':
						if ($html) {
							if ($part->ctype_secondary == 'html') { return trim($part->body); } else break;
						} else { return nl2br(trim($part->body)); }
				}
			} else {
				$msgbody .= sprintf(elgg_echo('postbymail:message:elements'), $part->ctype_primary, $part->ctype_secondary, $part->ctype_parameters->charset);
				switch(strtolower($part->ctype_primary)) {
					case 'multipart':
						$content = mailparts_extract_content($part);
						$msgbody .= sprintf(elgg_echo('postbymail:attachment:multipart'), $content['body']);
						$attachment .= $content['attachment'];
						break;
					case 'image':
						$attachment .= sprintf(elgg_echo('postbymail:attachment:image'), translateSize(mb_strlen($part->body)));
						break;
					case 'text':
						$msgbody .= sprintf(elgg_echo('postbymail:attachment:msgcontent'), $part->body);
						break;
					default: 
						$attachment .= sprintf(elgg_echo('postbymail:attachment:other'), translateSize(mb_strlen($part->body)));
				}
			}
		}
		if (empty($attachement)) { $attachment = elgg_echo('postbymail:noattachment'); }
		if ($firstbody) { return trim($msgbody); } else { return array('body' => trim($msgbody), 'attachment' => $attachment); }
	} else {
		if ($firstbody) return trim($mailparts->body); else return array('body' => trim($mailparts->body), 'attachment' => elgg_echo('postbymail:noattachment'));
	}
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
	$units	= array("octets", "Ko", "Mo", "Go", "To");
	for($i = 0; $size >= 1024 && $i < count($units); $i++) $size /= 1024;
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


