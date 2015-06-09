<?php
/** Elgg notification_messages plugin language
 * @author Florian DANIEL - Facyla
 * @copyright Florian DANIEL - Facyla 2014
 * @link http://id.facyla.net/
 */

$french = array(

	'notification_messages' => "Message de notification",
	
	// Actions
	'notification_messages:create' => "a publié",
	'notification_messages:delete' => "a supprimé",
	'notification_messages:update' => "a mis à jour",
	
	// Settings
	'notification_messages:settings:objects' => "Sujet des nouvelles publications (objets)",
	'notification_messages:settings:details' => "En activant les messages de notification détaillés pour chacun des types de contenus suivants, vous pouvez remplacer le titre du mail par défaut par un titre explicite composé sous la forme : [Type de publication Nom du groupe ou du membre] Titre du contenu<br />Cette forme facilite également l'identification de conversations par les messageries.",
	'notification_messages:object:subtype' => "Type d'objet",
	'notification_messages:setting' => "Réglage",
	'notification_messages:subject:default' => "Sujet par défaut",
	'notification_messages:subject:allow' => "Sujet amélioré",
	'notification_messages:subject:deny' => "Bloqué (pas de notification)",
	'notification_messages:message:default' => "Message par défaut",
	'notification_messages:message:allow' => "Message amélioré",
	'notification_messages:settings:group_topic_post' => "Activer pour les réponses dans les forums",
	'notification_messages:settings:comments' => "Sujet des commentaires",
	'notification_messages:settings:messages' => "Messages",
	'notification_messages:settings:comments:details' => "Si vous avez activé ce plugin, vous souhaitez probablement activer ce réglage, de manière à utiliser le même titre pour les commentaires que pour les nouvelles publications.",
	'notification_messages:settings:generic_comment' => "Activer pour les commentaires génériques",
	'notification_messages:settings:notify_user' => "Notifier également l'auteur des commentaires ?",
	'notification_messages:settings:notify_user:details' => "Par défaut l'auteur d'un commentaire n'est pas notifié. Vous pouvez choisir de le notifier également, ce qui est particulièrement utile si vous utilisez des réponses par email.",
	'notification_messages:settings:notify_user:comment_tracker' => "Lorsque le plugin comment_tracker est utilisé, un réglage identique est proposé, ce réglage n'est pas disponible et doit être modifié directement dans la configuration de comment_tracker.",
	'notification_messages:settings:expert' => "Expert",
	
	// Notification message content
	'notification_messages:settings:objects:message' => "Contenu des messages de notification",
	'notification_messages:message:default:blog' => "Par défaut les messages de notification des blogs ne contiennent que l'extrait.",
	
	// Notification subject
	'notification_messages:objects:subject' => "[%s | %s] %s",
	'notification_messages:objects:subject:nocontainer' => "[%s] %s",
	'notification_messages:untitled' => "(sans titre)",
	// Messages
	'notification_messages:email:subject' => "[%s] Message de %s : %s",
	
	
	// Object:notifications hook control
	'notification_messages:settings:object_notifications_hook' => "Activer le hook sur object:notifications",
	'notification_messages:settings:object_notifications_hook:subtext' => "Ce hook permet à d'autres plugins d'ajouter facilement des pièces jointes aux emails envoyés, de la même manière qu'ils peuvent modifier le contenu des messages. Attention car il peut causer des problèmes de compatibilité dans certains cas, en bloquant l'utilisation du hook par d'autres plugins -notamment advanced_notifications- car il prend en charge le processus d'envoi et répond donc \"true\" au hook.<br />Si vous ne savez pas quoi faire, laissez le réglage par défaut.",
	
	'notification_messages:settings:messages_send' => "Envoyer les messages directs en HTML",
	'notification_messages:settings:messages_send:subtext' => "Par défaut, les messages direct envoyés par la messagerie interne sont envoyés par email en texte seulement. Ce réglage permet de conserver la mise en forme HTML de ces messages.",
	
);

add_translation("fr", $french);

