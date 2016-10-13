<?php
/**
 * Elgg Market Plugin
 * @package market
 */

return array(
	
	// Menu items and titles
	'market' => "Offres",
	'market:posts' => "Offres",
	'market:title' => "Place de marché",
	'market:user:title' => "%s's offres sur la Place de Marché",
	'market:user' => "Offres de %s",
	'market:user:friends' => "Offres des contacts de %s",
	'market:user:friends:title' => "Offres des contacts de %s sur la Place de Marché",
	'market:mine' => "Mes offres",
	'market:mine:title' => "Mes offres sur la Place de Marché",
	'market:posttitle' => "Offre de %s : %s",
	'market:friends' => "Offres des contacts",
	'market:friends:title' => "Offres de mes contacts sur la Place de Marché",
	'market:everyone:title' => "Toues les offres sur la Place de Marché",
	'market:everyone' => "Toutes les offres",
	'market:read' => "Afficher l'offre",
	'market:add' => "Créer une nouvelle offre",
	'market:add:title' => "Créer une nouvelle offre sur la Place de Marché",
	'market:edit' => "Modifier l'offre",
	'market:imagelimitation' => "(doit être de type JPG, GIF ou PNG)",
	'market:text' => "Ajoutez une brève description de l'offre",
	'market:uploadimages' => "Ajouter des images à votre offre.",
	'market:uploadimage1' => "Image 1 (image de couverture)",
	'market:uploadimage2' => "Image 2",
	'market:uploadimage3' => "Image 3",
	'market:uploadimage4' => "Image 4",
	'market:image' => "Image de l'offre",
	'market:delete:image' => "Supprimer cette image",
	'market:imagelater' => "",
	'market:strapline' => "Créée",
	'item:object:market' => 'Offres',
	'market:none:found' => 'Aucune offre trouvée',
	'market:pmbuttontext' => "Envoyer un message privé",
	'market:price' => "Prix",
	'market:price:help' => "(en %s)",
	'market:text:help' => "(pas de HTML, max. 250 charactères)",
	'market:title:help' => "(1-3 mots)",
	'market:location' => "Localisation",
	'market:location:help' => "(où cette offre est localisée)",
	'market:tags' => "Mots-clefs",
	'market:tags:help' => "(séparés par des virgules)",
	'market:access:help' => "(qui peut voir cette offre)",
	'market:replies' => "Réponses",
	'market:created:gallery' => "Créée par %s <br>%s",
	'market:created:listing' => "Créée par %s %s",
	'market:showbig' => "Afficher une image plus grande",
	'market:type' => "Type",
	'market:type:choose' => "Choisir le type d'offre",
	'market:choose' => "Choisir...",
	'market:charleft' => "caractères restant(s)",
	'market:accept:terms' => "J'ai lu et accepté les %s",
	'market:terms' => "conditions",
	'market:terms:title' => "Conditions d'utilisation",
	'market:terms' => "<li class='elgg-divide-bottom'>La Place de Marché permet de proposer des biens et services entre membres.</li>
			<li class='elgg-divide-bottom'>Une seule offre est autorisée par bien ou service.</li>

			<li class='elgg-divide-bottom'>Une offre ne peut contenir qu'un seul bien ou service, sauf si elle fait partie d'un ensemble.</li>
			<li class='elgg-divide-bottom'>La Place de Marché est réservée à des biens et services individuels exclusivement.</li>
			<li class='elgg-divide-bottom'>Vous devez supprimer vos offres lorsqu'elles ne sont plus pertinentes.</li>
			<li class='elgg-divide-bottom'>Les offres seront supprimées après %s mois.</li>
			<li class='elgg-divide-bottom'>Les annonces commerciales sont réservées aux membres premium et à nos partenaires.</li>
			<li class='elgg-divide-bottom'>Nous nous réservons le droit de supprimer toute offre qui contrevient à ces conditions d'utilisation.</li>
			<li class='elgg-divide-bottom'>Les conditions d'utilisation sont susceptibles d'évoluer dans le temps.</li>
			",
	'market:new:post' => "Nouvelle offre",
	'market:notification' =>"%s a publié une nouvelle offre sur la Place de Marché&nbsp;:

%s - %s
%s

Afficher l'offre&nbsp;:
%s
",
	// market widget
	'market:widget' => "Ma Place de Marché",
	'market:widget:description' => "Présentez vos offres sur la Place de Marché",
	'market:widget:viewall' => "Afficher toutes mes offres sur la Place de Marché",
	'market:num_display' => "Nombre d'offres à afficher",
	'market:icon_size' => "Taille de l'icône",
	'market:small' => "petite",
	'market:tiny' => "très petite",
		
	// market river
	'river:create:object:market' => "%s a publié une nouvelle offre sur la Place de Marché %s",
	'river:update:object:market' => "%s a mis à jour l'offre %s dans la Place de Marché",
	'river:comment:object:market' => "%s a commenté l'offre",

	// Status messages
	'market:posted' => "Votre offre a bien été publiée.",
	'market:deleted' => "Votre offre a bien été supprimée.",
	'market:uploaded' => "Votre image a bien été ajoutée.",
	'market:image:deleted' => "Votre image a bien été supprimée.",

	// Error messages	
	'market:save:failure' => "Vottre offre n'a pas pu être enregistré. Veuillez réessayer.",
	'market:error:missing:title' => "Erreur : Titre manquant !",
	'market:error:missing:description' => "Erreur : Description manquante !",
	'market:error:missing:category' => "Erreur : Catégorie manquante !",
	'market:error:missing:price' => "Erreur : Prix manquant !",
	'market:error:missing:market_type' => "Erreur : Type d'offre manquant !",
	'market:tobig' => "Désolé, votre fichier est trop lourd, veuillez charger un fichier plus petit.",
	'market:notjpg' => "Veuillez vérifier que le fichier joint est de type .jpg, .png ou .gif.",
	'market:notuploaded' => "Désolé, votre fichier ne semble pas avoir été chargé.",
	'market:notfound' => "Désolé, l'offre demandée n'a pas pu être trouvée.",
	'market:notdeleted' => "Désolé, cette offre n'a pas pu être supprimée.",
	'market:image:notdeleted' => "Désolé, cette image n'a pas pu être supprimée !",
	'market:tomany' => "Erreur : Trop d'offres",
	'market:tomany:text' => "Vous avez atteint la limite maximum d'offres sur la Place de Marché. Veuillez supprimer quelques offres avant de réessayer !",
	'market:accept:terms:error' => "Vous devez accepterles conditions d'utilisation !",
	'market:error' => "Erreur : l'offre n'a pas pu être enregistrée !",
	'market:error:cannot_write_to_container' => "Erreur : Impossible d'écrire dans le conteneur !",

	// Settings
	'market:settings:status' => "Statut",
	'market:settings:desc' => "Description",
	'market:max:posts' => "Nombre maximum d'offres par utilisateur",
	'market:unlimited' => "Illimité",
	'market:currency' => "Devise ($, €, DKK ou autre)",
	'market:allowhtml' => "Permettre d'utiliser le HTML dans les offres",
	'market:numchars' => "Nombre de caractères maximum dans une offre (valide seulement sans HTML)",
	'market:pmbutton' => "Activer le bouton d'envoi d'un message privé",
	'market:location:field' => "Activer la localisation",
	'market:adminonly' => "Seuls les administrateurs peuvent créer des offres",
	'market:comments' => "Permettre les commentaires",
	'market:custom' => "Champ personnalisé",
	'market:settings:type' => "Activer les types d'offres (achat/vente/échange/don)",
	'market:type:all' => "Tout",
	'market:type:buy' => "Achat",
	'market:type:sell' => "Vente",
	'market:type:swap' => "Echange",
	'market:type:free' => "Don",
	'market:expire' => "Supprimer automatiquement les offres de plus de",
	'market:expire:month' => "mois",
	'market:expire:months' => "mois",
	'market:expire:subject' => "Votre offre a expiré",
	'market:expire:body' => "Bonjour %s

L'offre '%s' que vous aviez créée %s a été supprimée.

Cette suppression est automatique lorsque les offres ont plus de %s mois.",

	// market categories
	'market:categories' => 'Catégories de la Place de Marché',
	'market:categories:choose' => 'Choisir une categorie',
	'market:categories:settings' => 'Catégories de la Place de Marché&nbsp;:',
	'market:categories:explanation' => "Définissez quelques catégories prédéfinies pour la publicaiton des offres.<br>Les catégories peuvent être par exemple \"clothes, furniture, other, etc.\", les catégories doivent être séparées par des virgules - veuillez ne pas utiliser de caractère spécial dans les catégories et les inclure dans votre fichier de traduction sous la forme  market:category:<i>nomdelacategorie</i>",
	'market:categories:save:success' => "Les catégories de la Place de Marché ont bien été enregistrées",
	'market:categories:settings:categories' => 'Catégories de la Place de Marché',
	'market:category:all' => "Toutes",
	'market:category' => "Catégorie",
	'market:category:title' => "Catégorie : %s",

	// Categories
	'market:category:clothes' => "Vêtements/chaussures",
	'market:category:furniture' => "Mobilier",
	'market:category:other' => "Autre",

	// Custom select
	'market:custom:select' => "Etat du bien",
	'market:custom:text' => "Etat",
	'market:custom:activate' => "Permettre la sélection personnalisée&nbsp;:",
	'market:custom:settings' => "Choix de sélection personnalisés",
	'market:custom:choices' => "Définissez quelques choix prédéfinis pour la liste de sélection personnalisée.<br>Les choix peuvent être \"market:custom:new,market:custom:used...etc\", en séparant les éléments par des virgules - n'oubliez pas de les ajouter dans vos fichiers de traduction",

	// Custom choises
	 'market:custom:na' => "Pas d'information",
	 'market:custom:new' => "Nouveau",
	 'market:custom:unused' => "Non utilisé",
	 'market:custom:used' => "Utilisé",
	 'market:custom:good' => "Bon",
	 'market:custom:fair' => "Correct",
	 'market:custom:poor' => "Mauvais",
);

