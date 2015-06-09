<?php
/* Code source basé sur http://www.vulgarisation-informatique.com/mail.php */

admin_gatekeeper();
elgg_set_context('admin');

global $CONFIG;
$t1 = microtime(true);

$subject = get_input('emailsubject', null);
$message = get_input('emailmessage', null);
$recipient = get_input('emailto', null);
$sender = get_input('emailsender', null);
$replyto = get_input('emailreply', null);
$send = true;

// Conserve la conf du mail si envoi impossible
$_SESSION['mailing']['subject'] = $subject;
$_SESSION['mailing']['message'] = $message;
$_SESSION['mailing']['recipient'] = $recipient;
$_SESSION['mailing']['sender'] = $sender;
$_SESSION['mailing']['replyto'] = $replyto;


//-----------------------------------------------
//DECLARE LES VARIABLES INITIALES
//-----------------------------------------------
if(empty($subject)) {
	$send = false;
	system_message(elgg_echo('mailing:send:error:subject') . ' : SUBJECT');
}
if(empty($recipient)) {
	$send = false;
	system_message(elgg_echo('mailing:send:error:recipient') . ' : RECIPIENT');
} else {
	// cible : mails séparés par des virgules, points-virgules ou retours à la ligne, sans espace ou autre
	$recipient = str_replace('\n', ',', $recipient); // pour prendre une liste séparées par un retour à la ligne
	$recipient = str_replace(' ', ',', $recipient); // pour prendre une liste séparées par un espace
	$recipient = str_replace('\r', ',', $recipient); // pour prendre une liste séparées par un retour à la ligne
	$recipient = str_replace(';', ',', $recipient); // points-virgules aussi : full-csv compliant !
	if (strpos($recipient, ',') !== false) $recipients = explode(',', $recipient);
	else $recipients[] = trim($recipient);
	$recipients = array_unique($recipients); // Retire les doublons et ne laisse qu'une seule valeur vide
}
if(empty($message)) {
	$send = false;
	system_message(elgg_echo('mailing:send:error:message') . ' : MESSAGE');
}
if(empty($sender)) {
	$send = false;
	system_message(elgg_echo('mailing:send:error:sender') . ' : SENDER');
}

if (is_email_address($sender) && is_email_address($replyto)) {} else {
	$send = false;
	system_message(elgg_echo('mailing:send:error:recipient') . ' : SENDER/REPLYTO EMAIL ADDRESSES');
}

//-----------------------------------------------
//HEADERS DU MAIL
//-----------------------------------------------
$eol = "\r\n";
// For some mail servers
$use_eol = elgg_get_plugin_setting('use_eol', 'mailing');
if ($use_eol == 'n') $eol = "\n";
$headers = "From: $sender".$eol;
$headers .= "Reply-To: $replyto".$eol;
// $headers .= "CC:: ".$eol;
// $headers .= "X-Priority:: ".$eol; // De 1(max) à 5(min)
//$headers .= "BCC: $recipient ".$eol; // Accepte une liste de destinataires importante mais ne pas abuser : mieux vaut découper en lots, même en BCC
$headers .= "Return-Path: <$sender>".$eol;
$headers .= "MIME-Version: 1.0".$eol;
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$headers .= "Content-Transfer-Encoding: 8bit".$eol;



/* CODE A ADAPTER POUR ENVOI HTML + TEXT

  //-----------------------------------------------
  // CONFIG DU MAIL
  //-----------------------------------------------
  $recipient = implode(',', $valid_emails);
  $email_reply = $CONFIG->site->email;
  // Si mail du site non renseigné, l'envoi est fait par le premier admin du site (GUID 2)
  if (empty($email_reply)) $email_reply = get_entity(2)->email;
  if (!empty($editor)) {
    $sender = sprintf(elgg_echo('notification_messages:sendermail:fullwrapper'), $CONFIG->site->name, $email_reply, $editor);
  } else {
    $sender = sprintf(elgg_echo('notification_messages:sendermail:wrapper'), $CONFIG->site->name, $email_reply);
  }
  //$replyto = "Contact " . $CONFIG->site->name . " <$email_reply>";
  $replyto = sprintf(elgg_echo('notification_messages:replytomail:wrapper'), $email_reply);
  // Si une adresse de réponse par mail est fournie, on l'utilise
  // Très risqué car on peut trop facilement diffuser des infos persos comme ça
  // et en plus les erreurs ne sont pas interceptées par les admins donc difficile à gérer
  // if (!empty($postbymail_replyaddress)) { $replyto = $postbymail_replyaddress; }
  $method_message .= '<span style="color:transparent; font-size:0px;">' . "\n<br />\n<br />notification envoyée le " . date("Y-m-d G:i") . ' µs=' . microtime(true). '</span>';
  //-----------------------------------------------
  //GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML
  //-----------------------------------------------
  $boundary = '----=_' . md5(uniqid(mt_rand()));
//                $boundary_alt = "-----=" . md5(uniqid(mt_rand())); // Pour les pièces jointes
  
  // Note mails en html+text :
  // - on a remplacé les \r\n par \n    (cf. http://www.siteduzero.com/tutoriel-3-35146-e-mail-envoyer-un-e-mail-en-php.html)
  // - changement du 
  
  //-----------------------------------------------
  // HEADERS DU MAIL
  //-----------------------------------------------
  $headers = "From: $sender\n";
  $headers .= "Reply-To: $replyto\n";
  // $headers .= "CC:: \r\n";
  // $headers .= "X-Priority:: \r\n"; // De 1(max) à 5(min)
  $headers .= "BCC: $recipient\n";
  $headers .= "Return-Path: <$email_reply>\n";
  $headers .= "X-Sender: <".$sitename.">\n";
  $headers .= "X-Mailer: PHP\n";
  $headers .= "X-auth-smtp-user: ".$sender." \n";
  $headers .= "X-abuse-contact: ".$sender." \n";
  // @TODO - HEADERS EN TEST POUR CONVERSATIONS :
  // Message-ID : le message courant
  // $headers .= "Message-ID: <>\n"; // Doit être unique et construit à partir du premier sujet (GUID de l'entité actuelle)
  // In-Reply-To : le message précédent, celui auquel on répond
  // $headers .= "In-Reply-To: <>\n"; // Ssi réponse : construit à partir du premier sujet ()ou précédent sujet si possible)
  // References : liste tous les messages auxquels on répond, et en tous cas le premier
  // $headers .= "References: <>\n"; // Ssi réponse : construit à partir du premier sujet ()+ autres réponses si possible)
  
  // Si on a les infos pour construire un ID, on le fait : ça permettra aux messageries de suivre la conversation
  if ($object_guid) {
    // ID pour la conversation : doit être unique et donc construit à partir du premier sujet (GUID de l'entité actuelle)
    $first_mail_msg_id = $object_guid . '@' . $CONFIG->site->url;
    // Ssi réponse : construit à partir du premier sujet ()ou précédent sujet si possible)
    $site_domain = str_replace('http://', '', $CONFIG->site->url);
    $site_domain = str_replace('https://', '', $site_domain);
    $this_mail_msg_id = time() . '.' . $object_guid . '@' . $site_domain;
    if (($event = 'create') || ($event = 'update')) {
      $headers .= "Message-ID: <$first_mail_msg_id>\n";
    } else {
      $headers .= "Message-ID: <$this_mail_msg_id>\n";
    }
    $headers .= "In-Reply-To: <$first_mail_msg_id>\n";
    $headers .= "References: <$first_mail_msg_id>\n";
  }
  // FIN HEADERS EN TEST POUR CONVERSATIONS
  $headers .= "Date: ".date("D, j M Y G:i:s O")."\n";
  $headers .= "MIME-Version: 1.0\n";
  //$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
  // MAIL TEXTE SEULEMENT
  // MAIL HTML SEULEMENT
//                $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
//                $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  // MAIL HTML+TEXTE
  $headers .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
  // MAIL HTML+TEXTE + PIECE JOINTE
//                $header .= "Content-Type: multipart/mixed;"."\n"." boundary=\"$boundary\""."\n";
  
  //-----------------------------------------------
  // MESSAGE TEXTE
  //-----------------------------------------------
  $message = "--" . $boundary . "\n";
  $message .= 'Content-Type: text/plain; charset="utf-8"' . "\n";
  //$message .= "Content-Transfer-Encoding: 8bit\n";
  $message .= "Content-Transfer-Encoding: quoted-printable\n\n";
  //$message .= "\n" . strip_tags($method_message) . "\n"; 
  //$message .= strip_tags($method_message); 
  $message .= quoted_printable_encode(strip_tags($method_message)); 

  //-----------------------------------------------
  // MESSAGE HTML
  //-----------------------------------------------
  // A utiliser seulement pour un message TEXTE+HTML
  $message .= "\n\n--" . $boundary . "\n";
  $message .= 'Content-Type: text/html; charset="utf-8"' . "\n";
  //$message .= 'Content-Transfer-Encoding: 8bit'."\r\n"; 
  $message .= "Content-Transfer-Encoding: quoted-printable\n\n"; 
  //$message .= "\n" . $method_message . "\n";
  //$message .= $method_message;
  $message .= quoted_printable_encode($method_message);
  // FIN pour un message TEXTE+HTML
  
  $message .= "\n\n" . "--" . $boundary . "--";
  //$message .= "\n" . "--" . $boundary . "--" . "\n";
  
  //-----------------------------------------------
  //PIECE JOINTE
  //-----------------------------------------------
  // $message .= 'Content-Type: image/jpeg; name="nom_du_fichier.jpg"'."\n";
  // $message .= 'Content-Transfer-Encoding: base64'."\n";
  // $message .= 'Content-Disposition:attachement; filename="nom_du_fichier.jpg"'."\n";
  // $message .= chunk_split(base64_encode(file_get_contents('nom_du_fichier.jpg')))."\n"; 
  
  // Remplacement des destinataires réels par une adresse $replyto de type no-reply (tous mis plus haut en copie cachée BCC)
  //$recipient = $email_reply;
  // Facyla 20110731 : attention car on n'a pas à notifier à une adresse collective, d'où :
  // Remplacement des destinataires réels par une adresse vide (destinataires réels en copie cachée BCC), ssi plus d'un seul (OK en direct)
  // Note : doit être soit une adresse valide soit une chaine vide :
  // "<>" ou "test <>" ne marchent pas, et "undisclosed" devient undisclosed@server_real_address (mail inexistant)
  
  if ($count_valid_emails > 1) { $recipient = ""; }
  //-----------------------------------------------
  // ENVOI DU MESSAGE
  //-----------------------------------------------
  // METHODE D'ENVOI AVEC html_mails - deprecated as we format the mail content directly in here
  // foreach ($interested_users as $to) { html_mails_notify_handler($container, $to, $subject, $method_message); }
  // Facyla : Permet d'avoir des retours à la ligne corrects
  $subject = preg_replace("/(\r\n|\r|\n)/", "", $subject); // Strip line endings
  if (mail($recipient, $subject, $message, $headers)) {
    $status = sprintf(elgg_echo('notification_messages:send:success'), $count_valid_emails, $count_valid_notifiedusers);
  } else {
    $status = elgg_echo('notification_messages:send:error');
  }
  // Tells the user if notifications were effectively sent
  system_message($status);

*/




//-----------------------------------------------
//MESSAGE HTML
//-----------------------------------------------
$message .= "".$eol;
//$recipient = $email_reply;	// Masquage des destinataires (utile ssi en copie cachée BCC)
//$recipient = $_SESSION['user']->email;	// Masquage des destinataires (utile ssi en copie cachée BCC)

// Si tout semble OK pour envoi.. (ssi rien ne manque)
if ($send) {

	// Make headers readable + create headers for report
	$mailingheaders = str_replace($eol, "<br />", $headers);
	$reportheaders = "From: " . $sender . "".$eol."Reply-To: $replyto".$eol."Return-Path: <$sender>".$eol."MIME-Version: 1.0".$eol."Content-Type: text/html; charset=\"iso-8859-1\"".$eol."Content-Transfer-Encoding: 8bit".$eol;
	
	$t2 = microtime(true);
	// Note : avec l'envoi via une boucle, plus besoin de BCC
		set_time_limit(5); // Définit, mais surtout réinitialise la durée maximale d'éxécution du script (secondes)
	foreach ($recipients as $dest) {
		if (!empty($dest)) {
			if ( mail($dest, $subject, $message, $headers) ) {
				$reportok[] = "$dest, ";
			} else {
				$reporterr[] = "$dest, ";
				$err = true;
			}
		}
	}
	if ($err) $status = elgg_echo('mailing:send:error'); else $status = elgg_echo('mailing:send:success');
	
	$delta = '<br />Temps de calcul de la page : ' . (microtime(true) - $t1) . " secondes (" . (microtime(true) - $t2) . ")";
	
	// Messages et rapports
	system_message("$status<br /><br />$delta<br /><br />Rapport d'envoi :<br />OK : " . count($reportok) . "<br />Erreurs : " . count($reporterr));
	if (is_array($reportok)) $reportok = count($reportok) . " envois = " . implode(',', $reportok);
	else $reportok = count($reportok) . " envois = $reportok";
	if (is_array($reporterr)) $reporterr = count($reporterr) . " envois = " . implode(',', $reporterr);
	$reporterr = count($reporterr) . " envois = $reporterr";
	$reportmessage = "Sujet : $subject<br />Headers : $mailingheaders<br /><br />Rapport d'envoi :<br />Envoyé par " . $_SESSION['user']->name . "<br />Erreurs : $reporterr<br /><br />Envois réussis : $reportok<br /><br />$delta<br /><br />Message : $message";

	// Send report to sender (site + user)
	if (mail($_SESSION['user']->email, elgg_echo('mailing:report') . " : $status", $reportmessage, $reportheaders)) system_message("Rapport envoyé à ". $_SESSION['user']->email); else system_message("Echec de l'envoi du rapport à l'expéditeur");
	
	unset($_SESSION['mailing']['recipient']); // Vide les destinataires du mail (évite un double envoi)
	//unset($_SESSION['mailing']); // Vide la conf du mail
}

forward($_SERVER['HTTP_REFERER']);

