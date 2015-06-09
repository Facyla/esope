<?php
/**
 * Bookmarks English language file
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	'bookmarks' => "Liens web",
	'bookmarks:add' => "Créer un nouveau lien web",
	'bookmarks:edit' => "Modifier le lien web",
	'bookmarks:owner' => "Les liens web de %s",
	'bookmarks:friends' => "Liens web des contacts",
	'bookmarks:everyone' => "Tous les liens web du site",
	'bookmarks:this' => "Mettre cette page en lien web",
	'bookmarks:this:group' => "Mettre en lien web dans %s",
	'bookmarks:bookmarklet' => "Récupérer le 'bookmarklet'",
	'bookmarks:bookmarklet:group' => "Récupérer le 'bookmarklet' du groupe",
	'bookmarks:inbox' => "Boîte de réception des liens web",
	'bookmarks:morebookmarks' => "plus",
	'bookmarks:more' => "Plus de liens web",
	'bookmarks:with' => "Partager avec",
	'bookmarks:new' => "Un nouveau lien web",
	'bookmarks:via' => "via les liens web",
	'bookmarks:address' => "Adresse de la page/ressource à ajouter à vos liens web",
	'bookmarks:none' => "Aucun lien web",

	'bookmarks:delete:confirm' => "Etes-vous sûr(e) de vouloir supprimer ce lien web ?",

	'bookmarks:numbertodisplay' => "Nombre de liens web à afficher",

	'bookmarks:shared' => "Mis en lien web",
	'bookmarks:visit' => "Voir la page",
	'bookmarks:recent' => "Liens web récents",


	'river:create:object:bookmarks' => '%s a mis en lien web %s',
	'river:comment:object:bookmarks' => '%s a commenté le lien web %s',
	'bookmarks:river:created' => "%s mis en lien web",
	'bookmarks:river:annotate' => "a commenté ce lien web",
	'bookmarks:river:item' => "une page",
	'river:commented:object:bookmarks' => "un lien web",

	'item:object:bookmarks' => "Liens web",

	'bookmarks:group' => "Liens web",
	'bookmarks:enablebookmarks' => "Activer les liens web",
	'bookmarks:nogroup' => "Ce groupe n'a pas encore de lien web",
	'bookmarks:more' => "Plus de liens web",

	'bookmarks:no_title' => "Pas de titre",

	/**
	 * Widget and bookmarklet
	 */
	'bookmarks:widget:description' => "Ce module affiche vos derniers liens web.",

	'bookmarks:bookmarklet:description' => "Le bookmarklet vous permez de partager ce que vous trouvez sur le web avec vos contacts, ou pour vous-même. Pour l'utiliser, glissez simplement le boutton ci-dessous dans la barre de liens de votre navigateur.",

	'bookmarks:bookmarklet:descriptionie' =>
			"Si vous utilisez Internet Explorer, faites un clic droit sur le bouton et ajoutez-le dans vos favoris, puis dans votre barre de liens.",

	'bookmarks:bookmarklet:description:conclusion' =>
			"Vous pouvez mettre en lien web n'importe quelle page web à tout moment en cliquant sur le bookmarklet.",

	/**
	 * Status messages
	 */

	'bookmarks:save:success' => "Votre page a bien été mise en lien web.",
	'bookmarks:delete:success' => "Votre lien web a bien été supprimé.",

	/**
	 * Error messages
	 */

	'bookmarks:save:failed' => "Votre page n'a pu être correctement mise en lien web. Vérifiez que le titre et le lien sont corrects et réessayez.",
	'bookmarks:delete:failed' => "Votre lien web n'a pu être supprimé. Merci de réessayer.",
	
	'bookmarks:notification' => "%s a ajouté un nouveau lien web :

%s - %s

%s

Afficher et commenter le nouveau lien web :
%s",
  'bookmarks:save:invalid' => "L'adresse de ce lien web est invalide et n'a pas pu être sauvegardée.",
	
);

add_translation("fr", $french);

