# Publication par email
Ce plugin permet de répondre par email à des notifications du réseau.
Il peut également permettre de publier sur le réseau via une adresse email spécifique.


# Installation
1. Ce plugin nécessite l'utilisation d'un compte email accessible en IMAP, et acceptant les paramètres dans l'adresse email, par exemple : username+param=truc@domain.tld
2. Créer dans cette boîte mail deux dossiers : Published et Errors. Note : si ces dossiers ne sont pas créés, seul le statut "non lu" des messages permettra de déterminer s'ils ont été traités par el plugin."
3. Configurer le plugin dans avec les paramètres mail. Note : si vous ne souhaitez pas que ces informations soient "en clair" dans l'interface d'administration, vous pouvez également définir directement ces paramètres dans le fichier pages/checkandpost.php


# Intégration
TODO : modifier notification_messages pour inclure l'URL de réponse
  $replyent_guid = '';
  $replyemail = 'posttoformavia+guid=' . $replyent_guid . '@domain.tld'; // +guid=nnn&access=aaaa, etc.
  $replysubject = urlencode();
  $separator = 'VEUILLEZ REPONDRE AU-DESSUS DE CETTE LIGNE';
  $reply_separator = urlencode($separator);
  $reply_instructions = urlencode(elgg_echo('postbymail:default:separatordetails'));
  // #: %23, <: %3C, <: %3E, saut de ligne: %0D%0A
  echo '<a href="mailto:' . $replyemail . '?subject=' . $replysubject . '&body=%0D%0A%0D%0A%0D%0A' . $reply_separator . '%0D%0A' . $reply_instructions . '">Répondre par mail</a>


# NOTES de développement
Hash unique (contenu utilisé du mail) afin d'éviter les doublons et de republier un article supprimé (qu'on suppose modéré)

Dans le cas d'une nouvelle publication, on veut vérifier plus en détail qu'il s'agit vraiment du bon auteur
Donc hash unique avec plus de détails afin de "matcher" les mails avec un identifiant unique dans Elgg.
- Identifiant unique pour tout email => doit s'appuyer sur le contenu importé dans Elgg de manière fiable et unique, en autorisant des envois par des expéditeurs différents (pas de raison d'interdire des doublons si l'auteur n'est pas le même) : donc un hash qui s'appuie sur expéditeur (email) + titre + contenu
Autre piste : expéditeur (email) + titre + message-id
Attention  : email peut changer, username a priori moins, mais pas le GUID
1. On identifie un mail de manière unique (contenu utilisable du mail)
$hash = md5($realmember->guid . $post_body);
//$hash = md5($sendermail.$message->headers['date'].$message->headers['subject'].$post_body);
2. On associe ce contenu à un user dans Elgg de manière unique : correspondance email envoyeur <> email en BDD
3. On va avoir besoin de contrôler que l'expéditeur est valide et non usurpé :  validation par mail => on vérifie que le mail existe bien, et on lui envoie un lien de confirmation
Confirmation validée par mail sur la base d'infos de hash issues de la BDD + du message (pas seulement des infos de l'un ou de l'autre)
VOIR si on valide par mail ou web (plutôt mail du coup ?)



// Note : si pas de param, on renvoie un message à l'expéditeur seulement (si son compte existe) en lui signalant que son message ne peut pas être envoyé - une seule fois seulement donc à faire selon des critères stricts !
// mail valide seulement ? (on prévient s'il manque : GUID, MESSAGE (brut), ou si on n'a pas les DROITS)
// Si contenu non éligible, selon les causes on répond et on marque ou non comme lu
// Envoi mail à l'auteur avec le contenu de son message joint
//imap_setflag_full($conn, $msg_id, "\\Seen \\Flagged");   Marquage comme lu, Params : Seen, Answered, Flagged (= urgent), Deleted (sera effacé), Draft, Recent
// IMPORTANT : pour les réponses, c'est plus simple de se servir du titre du message !  ?
// Envoi mail à l'auteur avec son message joint
// @todo
// Marquage comme lu
//imap_setflag_full($conn, $msg_id, "\\Seen \\Flagged");
/*
\Seen       Message has been read
\Answered   Message has been answered
\Flagged    Message is "flagged" for urgent/special attention
\Deleted    Message is "deleted" for removal by later EXPUNGE
\Draft      Message has not completed composition (marked as a
draft).
\Recent     Message is "recently" arrived in this mailbox.
*/


NOTIFICATIONS
On notifie l'auteur seulement s'il est valide ou même si aucune de ses adresses n'est reconnue ?
On notifie l'admin dans tous les cas ou seulement dans certains cas ?
et si oui, pour les messages refusés ou au contraire les messages publiés ?


