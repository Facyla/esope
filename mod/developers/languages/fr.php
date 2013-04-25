<?php
/**
 * Elgg developer tools English language file.
 *
 */

$french = array(
	// menu
	'admin:develop_tools' => 'Outils',
	'admin:develop_tools:preview' => 'Prévisualisation des thèmes',
	'admin:develop_tools:inspect' => 'Inspecter',
	'admin:develop_tools:unit_tests' => 'Tests unitaires',
	'admin:developers' => "Outils pour développeurs",
	'admin:developers:settings' => "Paramètres de développement",

	// settings
	'elgg_dev_tools:settings:explanation' => "Contrôlez vos paramètres de développement et de débuggage ci-dessous. Certains de ces paramètres sony également disponibles sur d'autres pages d'administration.",
	'developers:label:simple_cache' => "Utiliser le cache simple",
	'developers:help:simple_cache' => "Désactiver le cache lors du développement. Autrement, les modifications des CSS et JavaScript seront ignorées.",
	'developers:label:system_cache' => 'Utiliser le cache système',
	'developers:help:system_cache' => 'Désactivez cette option lorsque vous développez, sinon les modifications de vos plugins ne seront pas prises en compte.',
	'developers:label:debug_level' => "Niveau de journalisation",
	'developers:help:debug_level' => "Contrôle la quantité d'informations enregistrées. Voir elgg_log() pour plus d'informations.",
	'developers:label:display_errors' => 'Affichage des erreurs PHP fatales',
	'developers:help:display_errors' => "Par défaut, le fichier .htaccess d'Elgg suprime l'affichage des erreurs fatales.",
	'developers:label:screen_log' => "Afficher à l'écran",
	'developers:help:screen_log' => "Ceci affiche les sorties d'elgg_log() et d'elgg_dump() directement sur la page web.",
	'developers:label:show_strings' => "Afficher les clefs de traductions",
	'developers:help:show_strings' => "Ceci affiche les clefs de traduction utilisées par elgg_echo().",
	'developers:label:wrap_views' => "Envelopper les vues",
	'developers:help:wrap_views' => "Ceci enveloppe pratiquement chaque vue avec des commentaires HTML. Pratique pour identifier la vue responsable de la création d'un code HTML particulier.",
	'developers:label:log_events' => "Journaliser les événements et les hooks des plugins",
	'developers:help:log_events' => "Ajoute les événements et les hooks des plugins dans le journal des erreurs. Attention : il y a en beaucoup pour chaque page !",
	
	'developers:debug:off' => "Off",
	'developers:debug:error' => "Erreur",
	'developers:debug:warning' => "Avertissement",
	'developers:debug:notice' => "Avis",
	
	// inspection
	'developers:inspect:help' => 'Inspecter la configuration du framework Elgg.',

	// event logging
	'developers:event_log_msg' => "%s: '%s, %s' dans %s",


	
	// theme preview
	'theme_preview:general' => 'Introduction',
	'theme_preview:breakout' => "Passer en plein écran( sortir de l'iframe)",
	'theme_preview:buttons' => "Boutons",
	'theme_preview:components' => "Composants",
	'theme_preview:forms' => "Formulaires",
	'theme_preview:grid' => "Grille",
	'theme_preview:icons' => "Icônes",
	'theme_preview:modules' => "Modules",
	'theme_preview:navigation' => "Navigation",
	'theme_preview:typography' => "Typographie",
	'theme_preview:miscellaneous' => 'Divers',
	
	// unit tests
	'developers:unit_tests:description' => "Elgg dispose de tests unitaires et d'intégration pour détecter les bugs dans ses fonctions et classes proncipales (du core).",
	'developers:unit_tests:warning' => "Attention ! N'exécutez pas ces tests sur un site en production : ils peuvent corrompre votre base de données.",
	'developers:unit_tests:run' => 'Exécuter',
	
	// status messages
	'developers:settings:success' => 'Paramètres enregistrés',
	
);

add_translation("fr", $french);
