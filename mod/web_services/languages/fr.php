<?php
/**
 * Elgg Web Services language pack.
 * 
 * @package Webservice
 * @author Florian Daniel - Facyla
 */

$french = array(
	'web_services:user' => "Utilisateur", 
	'web_services:blog' => "Blog", 
	'web_services:wire' => "Le Fil", 
	'web_services:core' => "Core", 
	'web_services:group' => "Groupes",
	'web_services:file' => "Fichiers",
	'web_services:messages' => "Messages",
	'web_services:settings_description' => "Sélectionnez ci-dessous les web services que vous souhaitez activer :",
	'web_services:selectfeatures' => "Sélectionnez les fonctionnalités à activer",
	'friends:alreadyadded' => "%s a déjà été ajouté comme contact",
	'friends:remove:notfriend' => "%s n'est pas en contact avec vous",
	'blog:message:notauthorized' => "Non autorisé à accomplir cette requête",
	'blog:message:noposts' => "Aucun article de blog par utilisateur",

	'admin:utilities:web_services' => 'Tests des Web Services',
	'web_services:tests:instructions' => 'Lancer les tests unitaires pour le plugin des web services',
	'web_services:tests:run' => 'Lancer les tests',
	'web_services:likes' => 'Likes',
	'likes:notallowed' => 'Non autorisé à "liker"',
	
	//A resolution to json convertion error (for river)
	'river:update:user:default' => ' a mis à jour son profil ',
);

add_translation("fr", $french);
