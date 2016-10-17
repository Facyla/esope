<?php
/**
 *	5 STAR AJAX RATE PLUGIN
 *	@package rate
 *	@author Team Webgalli
 *	@license GNU General Public License (GPL) version 2
 *	@link http://www.webgalli.com/
 *	@Adapted from the rate plugin for Elgg 1.7 
 *	 from Miguel Montes http://community.elgg.org/profile/mmontesp
 *	 http://community.elgg.org/pg/plugins/mmontesp/read/384429/rate-plugin 
 **/

return array(
	'rate:rates' => "Notes",
	'rate:ratesingular' => "Note",
	'rate:rateit' => "Noter",
	'rate:text' => "Comment l'évaluez-vous ?",
	'rate:rated' => "Vous avez déjà donné une note.",
	'rate:badguid' => "Erreur, impossible de trouver l'entité à noter.",
	'rate:badrate' => "La note doit être entre 0 et 5.",
	'rate:saved' => "Votre note a bien été enregistrée.",
	'rate:error' => "Votre note n'a pas pu être enregistré. Veuillez réessayer.",
	'rate:0' => "0 - Nul",
	'rate:1' => "1 - Mauvais",
	'rate:2' => "2 - Correct",
	'rate:3' => "3 - Plutôt bon",
	'rate:4' => "4 - Très bon",
	'rate:5' => "5 - Excellent",
	/*
	'rate:0' => '0<i class="fa fa-star"></i>',
	'rate:1' => '1<i class="fa fa-star"></i>',
	'rate:2' => '2<i class="fa fa-star"></i>',
	'rate:3' => '3<i class="fa fa-star"></i>',
	'rate:4' => '4<i class="fa fa-star"></i>',
	'rate:5' => '5<i class="fa fa-star"></i>',
	*/
	
	// Settings
	'rate:settings:object_subtypes' => "Types d'objets",
	'rate:settings:object_subtypes:details' => "Lister les types d'objets (subtypes) auxquels ajouter le système de notation. Séparer les vues par des virgules, par ex.:",
	'rate:settings:extend_views' => "Vues auxquelles ajouter la notation",
	'rate:settings:extend_views:details' => "Autres vues à étendre avec le système de notation. Il est cependant conseillé d'étendre ou de surcharger les vues concernées via un plugin de thème. Séparer les vues par des virgules.",
	'rate:settings:self_rate' => "Permettre de se noter soi-même",
	'rate:settings:self_rate:details' => "Activez cette option pour permettre aux membres du site de se donner une note à eux-même.",
	'rate:settings:rate_comment' => "Ajouter un commentaire",
	'rate:settings:rate_comment:details' => "Ajoutez un commentaire avec votre note.",
	
	
);

