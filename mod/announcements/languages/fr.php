<?php
/**
 * Announcements plugin translations
 *
 * @package CourseWare
 * @subpackage Announcements
 * @author Evan Winslow
 */

global $CONFIG;

$french = array(
	/**
	 * New object subtype: announcement
	 */
	'announcement' => 'Annonces', 
	'item:object:announcement' => 'Annonces',
	'announcement:write' => "Faire une annonce à tous les membres",

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
	'announcements:message' => '%s<br /><br />%s (<a href="' . $CONFIG->wwwroot . 'pg/profile/%s">Profil</a>)',
	'announcements:none' => "Aucune annonce pour le moment.",
	'announcements:post' => "Publier l'annonce", 
	'announcements:subject' => '%s Annonce : %s',
	'announcements:edit' => "Modifier une annonce",

	/**
	 * Actions
	 */
	'announcements:delete:success' => "Annonce supprimée.",
	'announcements:delete:failure' => "Désolé, cette annonce n'a pas pu être supprimée.",
	'announcements:post:success' => 'Annonce publiée.',
	'announcements:post:failure:permissiondenied' => "Désolé, vous n'avez pas les droits suffisants pour publier des annonces dans ce groupe",
	'announcements:post:failure:blankbody' => "Le contenu de l'annonce est nécessaire.",

	'river:object:announcement:create' => 'a fait une annonce',
	'river:commented:object:announcement' => 'une annonce',
	/**
	 * API
	 */
	'announcements.get' => 'Récupérer les annonces du système sur la base de divers critères',
);

add_translation("fr", $french);

