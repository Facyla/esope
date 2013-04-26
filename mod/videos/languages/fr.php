<?php
/**
 * videos English language file
 *	Author : Sarath C | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : webgalli@gmail.com
 *	Web	: http://webgalli.com | http://plugingalaxy.com
 *	Skype : 'team.webgalli' or 'drsanupmoideen'
 *	@package Elgg-videos
 * 	Plugin info : Upload/ Embed videos. Save uploaded videos in youtube and save your bandwidth and server space
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	'videos' => "Vidéos",
	'videos:add' => "Ajouter une vidéo",
	'videos:embed' => "Embarquer une vidéo",
	'videos:embedurl' => "Adresse (URL) de la vidéo",
	'videos:edit' => "Modifier la vidéo",
	'videos:owner' => "Vidéos de %s",
	'videos:friends' => "Vidéos des contacts",
	'videos:everyone' => "Toutes les vidéos du site",
	'videos:this:group' => "Vidéos dans %s",
	'videos:morevideos' => "Plus de vidéos",
	'videos:more' => "Plus",
	'videos:with' => "Partager avec",
	'videos:new' => "Une nouvelle vidéo",
	'videos:via' => "via les vidéos",
	'videos:none' => "Aucune vidéo",

	'videos:delete:confirm' => "Etes-vous sûr de vouloir supprimer cette vidéo ?",

	'videos:numbertodisplay' => "Nombre de vidéos à afficher",

	'videos:shared' => "vidéos partagées",
	'videos:recent' => "Vidéos récentes",

	'videos:river:created' => "a ajouté une vidéo %s",
	'videos:river:annotate' => "un commetnaire sur cette vidéo",
	'videos:river:item' => "un élément",
	'river:commented:object:videos' => "une vidéo",

	'river:create:object:videos' =>  "%s a ajouté la vidéo %s",
	'river:comment:object:videos' => "%s a commenté la vidéo %s",
	'videos:river:annotate' => "un commentaire sur cette vidéo",
	'videos:river:item' => "un élément",
	
	
	
	'item:object:videos' => "Vidéos",

	'videos:group' => "Vidéos du groupe",
	'videos:enablevideos' => "Activer les vidéos du groupe",
	'videos:nogroup' => "Ce groupe n'a pas encore de vidéo",
	'videos:more' => "Plus de vidéos",

	'videos:no_title' => "Pas de titre",
	'videos:file' => "Sélectionnez le fichier vidéo à envoyer",

	/**
	 * Widget
	 */
	'videos:widget:description' => "Affiche vos dernières vidéos.",

	/**
	 * Status messages
	 */

	'videos:save:success' => "Votre vidéo a bien été enregistrée.",
	'videos:delete:success' => "Votre vidéo a bien été supprimée.",

	/**
	 * Error messages
	 */

	'videos:save:failed' => "Votre vidéo n'a pas pu être enregistrée. Vérifiez que vous avez bien écrit un titre et une description puis réessayez.",
	'videos:delete:failed' => "Votre vidéo n'a pas pu être supprimée. Veuillez réessayer.",
	'videos:noembedurl' => "URL de la vidéo vide",
	 /**
	  * Temporary loading of Cash's Video languages
	  */
	  'embedvideo:novideo' => "Pas de vidéo",
	  'embedvideo:unrecognized' => "Vidéo non reconnue",
	  'embedvideo:parseerror' => "Erreur lors du traitement de la vidéo",
);

add_translation('fr', $french);

