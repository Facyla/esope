<?php
/**
 * Announcements plugin translations
 *
 * @package CourseWare
 * @subpackage Announcements
 * @author Evan Winslow
 */

$url = elgg_get_site_url();

return array(
	/**
	 * New object subtype: announcement
	 */
	'announcement' => 'Annonces', 
	'item:object:announcement' => 'Annonces',
	'announcement:write' => "Faire une annonce à tous les membres",
	
	/**
		* Settings
		*/
	'announcements:settings:group_recipients' => "Destinataires des annonces des groupes",
	'announcements:group_recipients:default' => "Par défaut (paramètres des membres)",
	'announcements:group_recipients:email_members' => "Email à tous les membres du groupe",
	'announcements:settings:hide_groupmodule' => "Masquer le module du groupe",
	'announcements:hide_groupmodule:no' => "Non (par défaut)",
	'announcements:hide_groupmodule:nonadmin' => "Non-admins (visible seulement des admins du groupe)",
	'announcements:hide_groupmodule:yes' => "Oui (n'apparaît pas dans les modules des groupes)",
	'announcements:settings:can_comment' => "Permettre de commenter les annonces",
	
	/**
	 * Plugin-specific
	 */
	'announcements:announcements' => 'Annonces',
	'announcements:inbox' => 'Annonces',
	'announcements:user' => "Annonces de %s",
	'announcements:owner' => "Annonces de %s",
	'announcements:enableannouncements' => "Activer les annonces",
	'announcements:group' => 'Annonces', 
	'announcements:add' => 'Faire une annonce',
	'announcements:date' => 'Publié %s par %s.',
	'announcements:error' => "Erreur lors de la publication de l'annonce.",
	'announcements:message' => '%s<br /><br />%s (<a href="' . $url . 'profile/%s">Profil</a>)',
	'announcements:none' => "Aucune annonce pour le moment.",
	'announcements:post' => "Publier l'annonce", 
	'announcements:subject' => '%s Annonce : %s',
	'announcements:edit' => "Modifier une annonce",
	'announcements:new' => 'Nouvelle annonce', 
	'announcement:new' => 'Nouvelle annonce', 
	'announcements:everyone' => "Toutes les annonces",
	
	/**
	 * Actions
	 */
	'announcements:delete:success' => "Annonce supprimée.",
	'announcements:delete:failure' => "Désolé, cette annonce n'a pas pu être supprimée.",
	'announcements:post:success' => 'Annonce publiée.',
	'announcements:post:failure:permissiondenied' => "Désolé, vous n'avez pas les droits suffisants pour publier des annonces dans ce groupe",
	'announcements:post:failure:blankbody' => "Le contenu de l'annonce est nécessaire.",

	'river:object:announcement:create' => 'a fait une annonce',
	'river:create:object:announcement' => '%s a fait une annonce %s',
	'river:commented:object:announcement' => 'une annonce',
	'announcements:river:togroup' => "aux membres de %s",
	
	// Errors
	'announcements:error:cannotsave' => "Erreur : impossible de créer l'annonce. Vous n'avez probablement pas les droits suffisants pour cela.",
	'announcements:error:invaliduser' => "Identifiant du membre invalide. Redirection vers toutes les annonces.",
	
	/**
	 * API
	 */
	'announcements.get' => 'Récupérer les annonces du système sur la base de divers critères',
	
	// Notifications
	'announcements:notify:subject' => "[%2\$s] %1\$s",
	'announcements:notify:body' => "%s a fait une annonce dans le groupe %s :
	
	<h3>%s</h3>
	
	%s
	
	
	Voir en ligne : %s
	",
	'announcements:notify:summary' => "Nouvelle annonce : %s",
	
);

