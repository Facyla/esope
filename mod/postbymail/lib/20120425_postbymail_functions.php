<?php
/* Post by mail functions */

/* postbymail_checkandpost   Vérifie la présence de nouveaux messages dans une boîte IMAP (ou POP, marche moins bien) et publie les messages s'ils sont valides (publiés par un auteur valide à un endroit où il en a le droit)
 * 
 * $server = "localhost:143";   POP3/IMAP/NNTP server to connect to, with optional port.
 * $protocol = "/notls";   Protocol specification (optional)
 * $mailbox = "INBOX";   Name of the mailbox to open. - Boîte de réception = toujours INBOX mais on peut récupérer les messages d'un dossier particulier également..
 * $username = "user@domain.tld";   Mailbox username.
 * $password = "********";   Mailbox password.
 * $markSeen = false;   Whether or not to mark retrieved messages as seen.
 * $bodyMaxLength = 65536; //$bodyMaxLength = 0; //$bodyMaxLength = 4096;   If the message body is longer than this number of bytes, it will be trimmed.
  - Set to 0 for no limit.
  - 65536 is actually default MySQL configuration for Elgg's description fields
  - set appropriate field to longtext in your database if you want to ovveride that limit
 * $separator = elgg_echo('postbymail:default:separator');   Séparateur du message (pour retirer la signature, les messages joints intégrés dans la réponse..)
  *
*/
function postbymail_checkandpost($server, $protocol, $mailbox, $username, $password, $markSeen, $bodyMaxLength, $separator, $mimeParams) {
  global $CONFIG;
  global $is_admin;
  $is_admin = true;
  // @TODO : vérifier si on doit faire un check has_acces_to_entity
  
  $body = ''; $pub_counter = 0;
  
  // Paramétrage
  $scope = get_plugin_setting('scope', 'postbymail');
  $forumonly = false;
  switch($scope) {
    case 'none':
      // Pas de publication par mail du tout : on ne notifie pas non plus et on peut sortir de suite sans parcourir les messages..
      return false;
      break;
    case 'forumonly':
      $forumonly = true;
      break;
    case 'comments':
      break;
  }
  
  if (!function_exists('imap_open')) {
    //error_log("Les fonctions IMAP de PHP doivent être disponibles pour que le plugin de publication par mail fonctionne !");
    return "Les fonctions IMAP de PHP doivent être disponibles pour que le plugin de publication par mail fonctionne !";
  }
  
  if ($conn = @imap_open('{'.$server.$protocol.'}'.$mailbox, $username, $password)) {
    $body .= "Connexion à la messagerie réussi<br />";
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
      $body .= sizeof($unreadmessages) . " messages non lus trouvés<br />";
      // Loop through the messages.
      // Pour chaque message à traiter : on vérifie d'abord quelques pré-requis (messages systèmes)
      // Puis on vérifie et poste si tout est OK 
      // + prévenir l'expéditeur (dans tous les cas) 
      // + prévenir un admin (idem ?)
      foreach ($unreadmessages as $i => $msg_id) {
        $body .= "Traitement du message n°$i (ID: $msg_id)<br />";
        $header = imap_fetchheader($conn, $msg_id, FT_PREFETCHTEXT); // Get the message header.
        // Set the message as read if told to
        if ($markSeen) { $msgbody = imap_body($conn, $msg_id); } else { $msgbody = imap_body($conn, $msg_id, FT_PEEK); }
        // Send the header and body through mimeDecode.
        $mimeParams['input'] = $header.$msgbody;
        $message = Mail_mimeDecode::decode($mimeParams);
        
        // Some mail servers and clients use special messages for holding mailbox data; ignore that message if it exists.
        if ($message->headers['subject'] != "DON'T DELETE THIS MESSAGE -- FOLDER INTERNAL DATA") {
          // A partir d'ici on peut notifier expéditeur et admin
          
          // @TODO : si le flag \\Answered est présent, on saute direct au suivant (traité et publié) !
          // if () { continue; }
          
          $member = false; $post_body = false;
          // Marqueurs selon motifs de ne pas notifier
          $published = false; $sender_reply = ''; $admin_reply = '';
          
          // Extract the message body in html or text if not available
          $msgbody = mailparts_extract_content($message, true, true);
          // On utilise la version texte si la version html (par défaut) ne renvoie rien
          if (empty($msgbody)) { $msgbody = mailparts_extract_content($message, true, false); }
          // Does the message have an attachment?
          // Lecture de tout le message pour identification des pièces jointes
          // @todo ça pourra servir à publier lesdites pièces jointes, discutable à cause des signatures et autres icônes embarquées..
          $content = mailparts_extract_content($message);
          $full_msgbody = count($message->parts) . ' : ' . $content['body'];
          $attachment = $content['attachment'];
          
          // Format the message to get the required data and content
          if ($msgbody) {
            // On ne garde que ce qu'il y a avant le marqueur de fin de réponse (la suite est inutile et potentiellement volumineuse)
            $cutat = strpos($msgbody, $separator);
            // @todo signaler que le message ne porte pas de marqueur ou on le publie quand même ?
            // @todo prévenir l'auteur et/ou l'admin pour qu'il puisse vérifier modérer ?
            if ($cutat) { $post_body = substr($msgbody, 0, $cutat); } else { $post_body = $msgbody; }
          }
          $post_body = trim($post_body);
          
          // Trim the post body to $bodyMaxLength characters if desired.
          if ($bodyMaxLength && strlen($post_body) > $bodyMaxLength) { $post_body = substr($post_body, 0, $bodyMaxLength).'...'; }

          // Expéditeur "officiel" = le premier bon trouvé via l'un des 2 mails (d'abord celui "annoncé" puis le réel)
          $sendermail = explode('<', $message->headers['from']);
          $sendermail = explode('>', $sendermail[1]);
          $sendermail = $sendermail[0];
          if (!empty($sendermail)) {
            $members = get_user_by_email($sendermail);
            $member = $members[0];
          }
          if (!empty($message->headers['sender'])) {
            $realmembers = get_user_by_email($message->headers['sender']);
            $realmember = $realmembers[0];
          }
          // Si l'auteur demandé est bon on le garde, sinon on prend l'autre..
          if ($member instanceof ElggUser) {} else if ($realmember instanceof ElggUser) { $member = $realmember; }
          
          // Hash unique (contenu utilisé du mail) afin d'éviter les doublons et de republier un article supprimé (qu'on suppose modéré)
          // On prend aussi la date du message : si le message est publié à une autre date ça peut poser pb de se contenter du contenu
          // par exemple avec des réponses courtes type "oui", "ok" qui peuvent être multiples sur un unique thread
          //$hash = md5($realmember->guid . $post_body);
          $hash = md5($realmember->guid . $message->headers['date'] . $post_body);
          
          // Extraction des paramètres du message : entité concernée (et autres ?)
          $mailparams = explode('@', $message->headers['to']);
          $mailparams = explode('+', $mailparams[0]);
          $parameters = '';
          if (!empty($mailparams[1])) {
            $mailparams = explode('&', $mailparams[1]);
            foreach($mailparams as $mailparam) {
              $mailparam = explode('=', $mailparam);
              $parameters .= '<li><strong>' . $mailparam[0] . ' :</strong> ' . $mailparam[1] . '</li>';
              $guid = null; $entity = null;
              // Switch pour gérer d'autres params plus tard
              switch($mailparam[0]) {
                case 'guid':
                  $guid = (int) $mailparam[1];
                  if ($entity = get_entity($guid)) {} else {
                    $sender_reply .= "<b>GUID invalide</b><br /><br />";
                    $admin_reply .= "<b>GUID invalide</b><br /><br />";
                  }
                  break;
              }
            }
            if (!empty($parameters)) $parameters = "<ul>$parameters</ul>";
          }
          
          
          // Informations sur le contenu du message
          $body .= "<br class=\"clearfloat\" /><hr />";
          
          // Infos pour l'expéditeur
          $sender_reply .= "<strong>Compte de membre associé à l'expéditeur du message : </strong> " . $member->name . "<br />";
          $sender_reply .= "<strong>Email de réponse :</strong> " . $sendermail . "<br />";
          $sender_reply .= "<strong>Email d'envoi réel utilisé :</strong> " . $message->headers['sender'] . "<br />";
          $sender_reply .= "<strong>Email destinataire utilisé :</strong> " . $message->headers['to'] . "<br />";
          $sender_reply .= "<strong>Pièces jointes :</strong> " . $attachment . "<br />";
          $sender_reply .= "<strong>Titre :</strong> " . $message->headers['subject'];
          $sender_reply .= "<br /><strong>Date :</strong> " . dateToFrenchFormat($message->headers['date']);
          $sender_reply .= "<br /><strong>Paramètres associés au message : </strong> " . $parameters;
          if ($entity) {
            $sender_reply .= "<br /><strong>Publication associée au message : </strong> &laquo;&nbsp;<a href=\"".$entity->getURL()."\">".$entity->title."</a>&nbsp;&raquo; (".htmlentities($guid).")";
          } else {
            $sender_reply .= "<br /><strong>Pas de GUID fourni ou la publication associée n'est pas valide ou accessible !</strong>";
          }
          $sender_reply .= "<br /><strong>Contenu du message :</strong> ";
          $sender_reply .= '<a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#mailbody_'.$hash.'\').toggle();">Afficher/masquer le contenu</a><br />';
          if (function_exists('autoclose')) $sender_reply .= '<div id="mailbody_'.$hash.'" style="display:none;">' . autoclose($msgbody) . "</div>";
          else $sender_reply .= '<div id="mailbody_'.$hash.'" style="display:none;">' . $msgbody . "</div>";
          
          // Infos pour l'admin
          $admin_reply .= "<strong>Membre associé à l'expéditeur \"officiel\" / réel : </strong> ".$member->name." ($sendermail) / ".$realmember->name." (" . htmlentities($message->headers['sender']) . ")<br />";
          $admin_reply .= "<strong>Compte de membre associé à l'expéditeur \"officiel\" : </strong> " . $member->name . "<br />";
          $admin_reply .= "<strong>Compte de membre associé à l'expéditeur réel : </strong> " . $realmember->name . "<br />";

          $admin_reply .= "<strong>Auteur :</strong> " . htmlentities($message->headers['from']) . " (" . htmlentities($message->headers['sender']) . ")<br />";
          $admin_reply .= "<strong>Email de réponse :</strong> " . $sendermail . "<br />";
          $admin_reply .= "<strong>Email d'envoi réel utilisé :</strong> " . htmlentities($message->headers['sender']) . "<br />";
          $admin_reply .= "<strong>Destinataire utilisé :</strong> " . htmlentities($message->headers['to']) . "<br />";
          $admin_reply .= "<strong>Boîte mail :</strong> " . $mailbox . "<br />";
          $admin_reply .= "<strong>Pièces jointes :</strong> " . $attachment . "<br />";
          $admin_reply .= "<strong>Hash MD5 :</strong> " . $hash . "<br />";
          $admin_reply .= "<strong>Titre :</strong> " . $message->headers['subject'];
          $admin_reply .= "<br /><strong>Date :</strong> " . dateToFrenchFormat($message->headers['date']);
          $admin_reply .= "<br /><strong>Paramètres associés au message : </strong> " . $parameters;
          if ($entity) {
            $admin_reply .= "<br /><strong>Publication associée au message : </strong> &laquo;&nbsp;<a href=\"".$entity->getURL()."\">".$entity->title."</a>&nbsp;&raquo; (".htmlentities($guid).")";
          } else {
            $admin_reply .= "<br /><strong>Pas de GUID fourni ou la publication associée n'est pas valide ou accessible !</strong>";
          }
          $admin_reply .= "<br /><strong>Contenu du message :</strong> ";
          $admin_reply .= '<a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#mailbody_'.$hash.'\').toggle();">Afficher/masquer le contenu</a><br />';
          if (function_exists('autoclose')) $admin_reply .= '<div id="mailbody_'.$hash.'" style="display:none;">' . autoclose($msgbody) . "</div>";
          else $admin_reply .= '<div id="mailbody_'.$hash.'" style="display:none;">' . $msgbody . "</div>";
          $admin_reply .= "<strong>Headers :</strong> ".'<a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#mail_'.$hash.'\').toggle();">Afficher/masquer le paragraphe</a></p>
            <div id="mail_'.$hash.'" style="display:none;">' . str_replace('  ', '&nbsp; ', nl2br(print_r($message, true))) . '</div>';
          
          $body .= "<br class=\"clearfloat\" /><br />";
          
          // Check post and notify anyone who should be after it's posted (or not)
          // bool $checkhash pour vérifier si déjà publié via le hash (et supprimé par exemple, ou si on a remis les messages comme non lus..)
          $post_check = postbymail_checkeligible($entity, $member, $post_body, true);
          $forum_post_check = $post_check['check'];
          $member = $post_check['member'];
          $group_entity = $post_check['group'];
          $hash_arr = $post_check['hash'];
          $body .= $post_check['report'];
          
          // PUBLICATION DU MESSAGE
          if ($forum_post_check) {
            $body .= "Contenu utile : &laquo;&nbsp;$post_body&nbsp;&raquo;";
            $sent = false;
            // Vérification du subtype, pour utiliser le bon type de publication
            if ($subtype = $entity->getSubtype()) {
              // Publication effective : message de réussite, et ajout du hash pour noter que ce message a été publié
              // Ajout du hash aux publications déjà faites (peu importe de matcher hash et mail, ce qui importe c'est les doublons)
              switch($subtype) {
                case 'groupforumtopic':
                  if ($entity->annotate('group_topic_post', $post_body, $entity->access_id, $member->guid)) {
                    $published = true;
                    system_message(elgg_echo("groupspost:success"));
                    add_to_river('river/forum/create', 'create', $member->guid, $entity->guid);
                  }
                  break;
                default:
                  // Les commentaires sont acceptés en fonctions des paramétrages aussi
                  if ($forumonly) {
                    $admin_reply .= "<br />Les réglages choisis ne permettent pas de répondre par mail hors des forums.";
                    $sender_reply = "Les paramètres du site ne permettent de répondre par mail qu'aux sujets des forums.<br />" . $sender_reply;
                    break;
                  }
                  if ($entity->annotate('generic_comment', $post_body, $entity->access_id, $member->guid)) {
                    $published = true;
                    system_message(elgg_echo("generic_comment:posted"));
				            add_to_river('annotation/annotate','comment',$_SESSION['user']->guid,$entity->guid);
                  }
              }
            } else {
              // Subtype invalide
            }
            
            // Gestion des erreurs de publication lorsque a priori tout était bon
            if ($published) {
              $pub_counter++;
              $body .= '<h3 style="color:red";>MESSAGE PUBLIÉ</h3>';
              // Enregistrement du hash dans l'objet pour éviter un message exactement identique de la même personne..
              // @todo voir si le message est publié à une autre date ça pose pb ou pas - par exemple des réponse courtes type "oui", "ok"
              $hash_arr[] = $hash;
              $entity->mail_post_hash = serialize($hash_arr);
            } else {
              // Le commentaire n'a pas pu être publié alors qu'il était a priori valide : à vérifier par un admin
              $notify_admin = true;
              $admin_reply = "Publication impossible alors qu'a priori tout semblait OK : à vérifier pour débuggage\n\n".$admin_reply;
            }
            
          } else {
            // Pas publiable
            $admin_reply .= "<br />Publication impossible : soit pour l'une des raisons précédentes, soit car le message est vide...
              <br />Coupure à $cutat caractères
              <br /><b>EXTRAIT PUBLIABLE :</b> &laquo;&nbsp;$post_body&nbsp;&raquo;
              <br /><b>Message complet :</b>&laquo;&nbsp;$msgbody&nbsp;&raquo;";
            $sender_reply .= "<br />Publication impossible : soit pour l'une des raisons précédentes, soit car le message est vide...
              <br />Coupure à $cutat caractères
              <br /><b>EXTRAIT PUBLIABLE :</b> &laquo;&nbsp;$post_body&nbsp;&raquo;
              <br /><b>Message complet :</b>&laquo;&nbsp;$msgbody&nbsp;&raquo;";
          }
          $body .= '<div class="clearfloat"></div>';
          
          
          // NOTIFICATIONS
          $notify_sender = false; $notify_admin = false;
          if ($published) {
            // L'auteur n'a pas besoin de notification pour un message accepté
            // En cas de publication, l'admin doit être prévenu pour pouvoir modérer
            $admin_reply = "Publication par mail réussie : nouveau commentaire à vérifier\n\n" . $admin_reply;
            $notify_admin = true;
          } else {
            // NOTIFICATIONS AUTEUR
            $sender_reply = "Le message n'a pu être publié :\n\n" . $sender_reply;
            // On notifie dans tous les cas ?
            $notify_sender = true;
            
            // NOTIFICATIONS ADMIN
            if ($notify_sender) {
              // @todo à voir si on prévient quand même l'admin quand l'auteur est informé et qu'on explique pourquoi avec les infos fournies
              $notify_admin = true;
            } else {
              // L'admin a besoin d'intervenir pour gérer du spam (blacklist) ou des membres qui ont besoin d'aide et ne sont pas prévenus
              $notify_admin = true;
            }
          }
          
          // Envoi des notifications
          // On vérifie aussi s'il n'y a pas eu une raison autre de ne pas notifier
          if ($notify_sender) {
            $sender_subject = "Votre message n'a pas pu être envoyé";
            if (($member instanceof ElggUser) &&  is_email_address($member->email)) {
              // Si c'est le membre, on le prévient (son compte peut avoir été piraté donc on le prévient de préférence)
              mail($member->email, $sender_subject, $sender_reply, "Content-type: text/html; charset=utf-8\r\n");
            } else if (is_email_address($sendermail)) {
              // Sinon on prend de préférence l'adresse email annoncée
              mail($sendermail, $sender_subject, $sender_reply, "Content-type: text/html; charset=utf-8\r\n");
            } else if (is_email_address($message->headers['sender'])) {
              // En dernier recours celle réellement utilisée
              mail($message->headers['sender'], $sender_subject, $sender_reply, "Content-type: text/html; charset=utf-8\r\n");
            } else {
              // et si on ne peut pas le prévenir, on prévient l'admin !
              $notify_admin = true;
            }
            $body .= "<br /><b>EXPEDITEUR NOTIFIÉ (sauf si aucune adresse valide)</b>";
          } else {
            $body .= "<br /><b>EXPEDITEUR NON NOTIFIÉ</b>";
          }
          if ($notify_admin) {
            if ($published) {
              $admin_subject = "Nouvelle publication par mail à vérifier";
              $admin_reply = "Commentaire sur : <a href=\"".$entity->getURL()."\">{$entity->title}</a><br />Auteur : {$member->name}<br />Email : {$member->email}<br />Contenu du commentaire publié : $post_body";
            } else {
              $admin_subject = "Echec d'une publication par mail";
              $admin_reply = $admin_subject . ' : informations associées<br /><br />' . $admin_reply;
            }
            //$subject = sprintf(elgg_echo('postbymail:admin:subject'));
            //$message = sprintf(elgg_echo('postbymail:admin:message'));
            //mail($admin_email, $admin_subject, $admin_reply, "Content-type: text/html; charset=utf-8\r\n");
            $notifylist = get_plugin_setting('notifylist', 'postbymail');
            if ($notified_users = explode(',', trim($notifylist)) ) {
              //notify_user($notified_users, $CONFIG->site->guid, $admin_subject, $admin_reply, NULL, 'email');
              foreach($notified_users as $notified_user) {
                $admin_email = get_entity($notified_user)->email;
                // Envoi par mail (mieux en HTML mais expéditeur à améliorer), sinon on passe par les moyens habituels (mais en texte brut)
                if (mail($admin_email, $admin_subject, $admin_reply, "Content-type: text/html; charset=utf-8\r\n")) {
                } else {
                  notify_user($notified_user, $CONFIG->site->guid, $admin_subject, $admin_reply, NULL, 'email');
                }
              }
            }
            $body .= "<br /><b>ADMIN NOTIFIÉ</b>";
          } else {
            $body .= "<br /><b>ADMIN NON NOTIFIÉ</b>";
          }
          $body .= "<br /><br /><b>MAIL EXPEDITEUR :</b><br />$sender_reply<br /><br /><b>MAIL ADMIN :</b><br />$admin_reply<hr />";
          
          // MARQUAGE DU MESSAGE
          // Que le message soit publié ou pas il est traité, donc on le marque comme lu : sauf re-marquage comme non lu, on ne le traitera plus
          //imap_setflag_full($conn, $msg_id, "\\Seen \\Deleted");   Marquage comme lu, Params : Seen, Answered, Flagged (= urgent), Deleted (sera effacé), Draft, Recent
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
      $body .= "Aucun nouveau message<br />";
    } // </if $unreadmessages>
    if ($purge) {
      imap_close($conn, CL_EXPUNGE); // Nettoie les messages effacés ou déplacés // semble effacer un peu trop ??
    } else {
      imap_close($conn);
    }
  } else {
    register_error("Plugin mal configuré : paramètres manquants ou non fonctionnels");
  } // </if $conn>
  
  if ($pub_counter > 0) $body .= "<hr />$pub_counter commentaires publiés";
  else $body .= "<hr />Aucun commentaire à publier";
  
  return $body;
}


/*
 * $checkhash   bool   true if hash check (hashed message will be ignored)
*/
function postbymail_checkeligible($entity, $member, $post_body, $checkhash = true) {
  // Vérifications préliminaires - au moindre problème, on annule la publication
  $forum_post_check = true;
  if ($entity && ($entity instanceof ElggObject)) {
    $report .= '<br />Entité OK : objet - ';
    // Container
    if ($group_entity = get_entity($entity->container_guid)) {
      $report .= "Groupe OK - ";
      // Membre
      if ($member instanceof ElggUser) {
        $report .= "Membre trouvé OK - ";
      } else {
        $report .= 'Erreur membre - ';
        $forum_post_check = false;
      }
      // Check the user is a group member
      if ($group_entity instanceof ElggGroup) {
        if ($group_entity->isMember($member)) {
          $report .= "Groupe et appartenance OK - ";
        } else { $report .= 'Erreur membre groupe'; $forum_post_check = false; }
      } else {
        $report .= 'Erreur groupe - ';
        $forum_post_check = false;
      }
    } else { $report .= 'Erreur container - '; $forum_post_check = false; }
  } else { $report .= 'Erreur entité - '; $forum_post_check = false; }
  // Si vide inutile de publier
  if (empty($post_body)) {
    $report .= 'Message vide (vérifier le message complet et la présence du séparateur) - ';
    $forum_post_check = false;
  }
  // Vérification supplémentaire des doublons via le hash stocké dans l'entité commentée
  // on ne publie un message qu'une seule fois, sinon a priori c'est un autre message (ou l'original a été effacé)...
  if ($checkhash && isset($entity->mail_post_hash)) {
    $hash_arr = unserialize($entity->mail_post_hash);
    if (in_array($hash, $hash_arr)) {
      $report .= 'Déjà publié - ';
      $forum_post_check = false;
    }
  }
  return array('member' => $member, 'group' => $group, 'check' => $forum_post_check, 'report' => $report, 'hash' => $hash_arr);
}



/*
 * Mail content extraction function
 * $mailparts   
 * $firstbody   boolean   return only the message content (no attachment nor message parts)
 * $html   boolean   get only HTML content (or text after converting line breaks, if no HTML available)
 * returns : message value, or array with more details (attachements)
*/
function mailparts_extract_content($mailparts, $firstbody = false, $html = true) {
  // @todo : tester parts->N°->headers->content-type (par ex. text/plain; charset=UTF-8) et content-transfer-encoding (par ex. quoted-printable)
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
        $msgbody .= '<br /><strong>Elément du message : ' . $part->ctype_primary . '/' . $part->ctype_secondary . ' ' . $part->ctype_parameters->charset . '</strong>';
        switch(strtolower($part->ctype_primary)) {
          case 'multipart':
            $content = mailparts_extract_content($part);
            $msgbody .= '<br />MESSAGE JOINT : ' . $content['body'];
            $attachment .= $content['attachment'];
            break;
          case 'image':
            $attachment .= '[image jointe : '.translateSize(strlen($part->body)).']<br />';
            break;
          case 'text':
            $msgbody .= '<br />Contenu du message : ' . $part->body . '<hr />';
            break;
          default: 
            $attachment .= '[autre type de contenu joint : '.translateSize(strlen($part->body)).']<br />';
        }
      }
    }
    if (empty($attachement)) { $attachment = 'Le message ne contient pas de pièce jointe.'; }
    if ($firstbody) { return trim($msgbody); } else { return array('body' => trim($msgbody), 'attachment' => $attachment); }
  } else {
    if ($firstbody) return trim($mailparts->body); else return array('body' => trim($mailparts->body), 'attachment' => 'Le message ne contient pas de pièce jointe.');
  }
  return false;
}


/* Render a readable date
 * $date   timestamp
 */
function dateToFrenchFormat($date) {
  $time = strtotime($date);
  if ($time > 0) $date = date("d/m/Y à H:i:s", $time);
  return $date;
}


/* Render a readable filesize
 * $size   size in bits
 */
function translateSize($size) {
  $units    = array("octets", "Ko", "Mo", "Go", "To");
  for($i = 0; $size >= 1024 && $i < count($units); $i++) $size /= 1024;
  return round($size, 2)." {$units[$i]}";
}


