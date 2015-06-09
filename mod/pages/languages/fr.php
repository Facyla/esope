<?php
/**
 * Pages languages
 *
 * @package ElggPages
 */

$french = array(

	/**
	 * Menu items and titles
	 */

	'page' => "Page wiki",
	'page_top' => "Wiki",
	'pages' => "Pages wiki",
	'pages:owner' => "Wiki de %s",
	'pages:friends' => "Pages wiki de vos contacts ",
	'pages:all' => "Toutes les pages wiki du site",
	'pages:add' => "Ajouter une page au wiki",

	'pages:group' => "Wiki",
	'groups:enablepages' => "Activer le wiki (pages collaboratives) du groupe",

	'pages:edit' => "Editer cette page",
	'pages:delete' => "Effacer cette page",
	'pages:history' => "Historique",
	'pages:view' => "Voir la page",
	'pages:revision' => "Version",

	'pages:navigation' => "Navigation",
	'pages:via' => "via les pages",
	'item:object:page_top' => "Wiki",
	'item:object:page' => "Page wiki",
	'pages:nogroup' => "Aucun wiki pour le moment",
	'pages:more' => "Plus de pages wiki",
	'pages:none' => "Aucune page wiki créé pour l'instant",

	/**
	* River
	**/

	'pages:river:create' => "La page wiki créée",
	'pages:river:created' => "%s a écrit",
	'pages:river:updated' => "%s a mis à jour",
	'pages:river:posted' => "%s a publié",
	'pages:river:update' => "la page wiki",
	'river:commented:object:page' => "la page wiki",
	'river:commented:object:page_top' => "la page wiki",
	
	'river:create:object:page' => '%s a créé la sous-page wiki %s',
	'river:create:object:page_top' => '%s a créé la page wiki %s',
	'river:update:object:page' => '%s a mis à jour la page wiki  %s',
	'river:update:object:page_top' => '%s a mis à jour la page wiki %s',
	'river:comment:object:page' => '%s a commenté la page wiki %s',
	'river:comment:object:page_top' => '%s a commenté la page wiki %s',
	

	/**
	 * Form fields
	 */

	'pages:title' => "Titre de la page wiki",
	'pages:description' => "Contenu de la page wiki",
	'pages:tags' => "Tags",
	'pages:access_id' => "Accès en lecture",
	'pages:write_access_id' => "Accès en écriture",

	/**
	 * Status and error messages
	 */
	'pages:noaccess' => "Pas d'accès à cette page",
	'pages:cantedit' => "Vous ne pouvez pas modifier cette page wiki",
	'pages:saved' => "Pages wiki enregistrées",
	'pages:notsaved' => "La page wiki n'a pu être enregistrée",
	'pages:error:no_title' => "Vous devez spécifier un titre pour cette page wiki.",
	'pages:delete:success' => "Votre page wiki a bien été effacée.",
	'pages:delete:failure' => "Votre page wiki n'a pas pu être effacée.",

	/**
	 * Page
	 */
	'pages:strapline' => "Dernière mise à jour le %s par %s",

	/**
	 * History
	 */
	'pages:revision:subtitle' => "Révision de la page wiki %s par %s",

	/**
	 * Widget
	 **/

	'pages:num' => "Nombre de pages wiki à afficher",
	'pages:widget:description' => "Voici la liste des vos pages wiki.",

	/**
	 * Submenu items
	 */
	'pages:label:view' => "Afficher la page",
	'pages:label:edit' => "Editer la page du wiki",
	'pages:label:history' => "Historique de la page",

	/**
	 * Sidebar items
	 */
	'pages:sidebar:this' => "Cette page wiki",
	'pages:sidebar:children' => "Sous-pages du wiki",
	'pages:sidebar:parent' => "Parent",

	'pages:newchild' => "Créer une sous-page dans ce wiki",
	'pages:backtoparent' => "Retour à '%s'",
	
	/* Notifications */
	'pages:new' => "Nouvelle page wiki",
	
	'pages:notification' => "%s a créé une nouvelle page :

%s
%s

Afficher et commenter cette page en ligne :
%s",
	'pages:parent_guid' => "Page parente",
	
	// Added in 1.8.16
	'pages:current_revision' => "Version actuelle",
	'pages:revert' => "Revenir à cette version",
	'pages:revision:delete:success' => "La version de la page a bien été supprimée.",
	'pages:revision:delete:failure' => "la version de la page n'a pas pu être supprimée.",
	'pages:revision:not_found' => "Impossible de trouver cette version de la page.",
	
	
);

add_translation("fr", $french);
