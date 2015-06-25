<?php
/**
 * French strings
 */

$fr = array(
	'multilingual' => "Support multilingue",
	'multilingual:prefix:todo' => "[TODO %s] ",
	
	// Menus
	'multilingual:menu:currentlocale' => "Langue : %s",
	'multilingual:menu:versions' => "Versions",
	'multilingual:menu:viewinto' => "Afficher en %s",
	'multilingual:menu:translateinto' => "Créer une version en %s",
	'multilingual:translate:confirm' => "Si vous confirmez, une nouvelle version en %s va être créée à partir de la version originale. Il vous appartiendra de la traduire.",
	
	// Settings
	'multilingual:settings:main_locale' => "Code de la langue par défaut du site",
	'multilingual:settings:main_locale:details' => "Il s'agit ici de la langue dans laquelle sont publiés les articles originaux, sauf mention contraire. Tous les articles sans paramètres précisant leur langue seront ainsi considérés comme déjà existant dans cette langue.",
	'multilingual:settings:locales' => "Codes des langues disponibles",
	'multilingual:settings:locales:details' => "Veuillez utiliser le code de la langue en 2 lettres, par ex. \"en, fr, es, de, it\". Si vous n'indiquez aucune valeur, les entités ne pourront pas bénéficier de version alternative dans une autre langue.",
	
	// Translation interface
	'multilingual:translate' => "Créer une version dans une autre langue",
	'multilingual:translate:instructions:title' => "Mode d'emploi",
	'multilingual:translate:instructions' => "Pour éditer le contenu dans la nouvelle langue, veuillez éditer le contenu affiché ci-dessous. Les textes originaux ont été repris, il s'agit donc de les adapter pour les rendre disponible dans la langue choisie.",
	'multilingual:translate:original' => "Version originale",
	'multilingual:translate:version' => "Version en %s",
	'multilingual:translate:otherversions' => "Autres versions",
	'multilingual:translate:otherlanguages' => "Autre langues (non traduites)",
	'multilingual:translate:currentediting' => "(en cours d'édition)",
	
	// Notices and errors
	'multilingual:translate:missingentity' => "Aucune entité à traduire.",
	'multilingual:translate:newcreated' => "Une nouvelle version vient d'être créée.",
	'multilingual:translate:alreadyexists' => "Une version dans cette langue existe déjà et a été chargée ci-dessous.",
	
	
	
);

add_translation('fr', $fr);

