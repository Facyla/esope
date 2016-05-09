<?php
/* ESOPE translation version */

return array(
	// menu
	'admin:develop_tools' => 'Outils',
	'admin:develop_tools:sandbox' => 'Thème bac à sable',
	'admin:develop_tools:inspect' => 'Inspecter',
	'admin:inspect' => 'Inspecter',
	'admin:develop_tools:unit_tests' => 'Tests unitaires',
	'admin:developers' => 'Les développeurs',
	'admin:developers:settings' => 'Paramètres développeurs',

	// settings
	'elgg_dev_tools:settings:explanation' => 'Contrôlez vos paramètres de dévelopement et de déboguage ci-dessous. Certains de ces paramètres sont aussi disponibles sur d\'autres pages d\'administration.',
	'developers:label:simple_cache' => 'Utiliser le cache simple',
	'developers:help:simple_cache' => 'Désactivez ce cache lors des développements, sinon les modifications des fichiers CSS et JavaScript seront ignorées.',
	'developers:label:system_cache' => 'Utiliser le cache système',
	'developers:help:system_cache' => 'Désactivez ce cache lors des développements, sinon les modifications de vos plugins ne seront pas prises en compte.',
	'developers:label:debug_level' => "Niveau journalisation",
	'developers:help:debug_level' => "Contrôle la quantité d'informations journalisées. Voir elgg_log() pour plus d'informations.",
	'developers:label:display_errors' => 'Affichage les erreurs PHP fatales',
	'developers:help:display_errors' => "Par défaut, le fichier .htaccess d'Elgg désactive l'affichage des erreurs fatales.",
	'developers:label:screen_log' => "Afficher le journal à l'écran",
	'developers:help:screen_log' => "Ceci affiche les sorties de elgg_log() et de elgg_dump() ainsi que le nombre de requêtes sur la BD",
	'developers:label:show_strings' => "Montrer les chaînes de traduction brutes",
	'developers:help:show_strings' => "Affiche les chaînes de traduction utilisées par elgg_echo().",
	'developers:label:show_modules' => "Montrer les modules AMD chargés dans la console",
	'developers:help:show_modules' => "Affiche les modules chargés et les valeurs dans votre console JavaScript.",
	'developers:label:wrap_views' => "Envelopper les Vues",
	'developers:help:wrap_views' => "Ceci enveloppe presque toutes les vues avec des commentaires en HTML. Pratique pour identifier la vue qui génère un code HTML particulier. 
	Cela peut casser les vues non HTML de l'affichage principal. Voir developers_wrap_views() pour plus de détails. ",
	'developers:label:log_events' => "Journaliser les événements et les interceptions (hooks) des plugins.",
	'developers:help:log_events' => "Ecrit les événements et les interceptions (hooks) des plugins dans le journal. Attention : cela représente beaucoup d'entrées par page.",
	'developers:label:show_gear' => "Utiliser %s hors de la zone d'administration",
	'developers:help:show_gear' => "Une icône en bas à droite de l'affichage qui offre aux administrateurs un accès aux paramètres et liens pour développeurs.",
	'developers:label:submit' => "Enregistrer et vider les caches",


	'developers:debug:off' => 'Désactivé',
	'developers:debug:error' => 'Erreur',
	'developers:debug:warning' => 'Avertissement',
	'developers:debug:notice' => 'Avis',
	'developers:debug:info' => 'Information',
	
	// inspection
	'developers:inspect:help' => 'Inspecter la configuration système d\'Elgg.',
	'developers:inspect:actions' => 'Actions',
	'developers:inspect:events' => 'Evénements',
	'developers:inspect:menus' => 'Menus',
	'developers:inspect:pluginhooks' => 'Hooks des plugins',
	'developers:inspect:priority' => 'Priorité',
	'developers:inspect:simplecache' => 'Cache simple',
	'developers:inspect:views' => 'Vues',
	'developers:inspect:views:all_filtered' => "<b>Note !</b> Toutes les sorties des vues sont filtrées par les hooks de plugins suivants :",
	'developers:inspect:views:filtered' => "(filtré par le hook de plugin : %s)",
	'developers:inspect:widgets' => 'Widget',
	'developers:inspect:webservices' => 'Services web',
	'developers:inspect:widgets:context' => 'Contexte',
	'developers:inspect:functions' => 'Fonctions',
	'developers:inspect:file_location' => 'Chemin à partir de la racine Elgg',

	// event logging
	'developers:event_log_msg' => "%s : '%s, %s' dans %s",
	'developers:log_queries' => "%s requêtes sur la BD (n'inclue pas l'événement shutdown)",

	// theme sandbox
	'theme_sandbox:intro' => 'Introduction',
	'theme_sandbox:breakout' => 'Sortir de l\'iframe',
	'theme_sandbox:buttons' => 'Boutons',
	'theme_sandbox:components' => 'Composants',
	'theme_sandbox:forms' => 'Formulaires',
	'theme_sandbox:grid' => 'Grille',
	'theme_sandbox:icons' => 'Icônes',
	'theme_sandbox:javascript' => 'JavaScript',
	'theme_sandbox:layouts' => 'Mises en page',
	'theme_sandbox:modules' => 'Modules',
	'theme_sandbox:navigation' => 'Navigation',
	'theme_sandbox:typography' => 'Typographie',

	'theme_sandbox:icons:blurb' => 'Utiliser <em>elgg_view_icon($name)</em> ou la classe elgg-icon-$name pour afficher les icônes. ',

	// unit tests
	'developers:unit_tests:description' => 'Elgg dispose de tests unitaires et de tests d\'intégration pour détecter des bugs dans les classes et fonctions de son coeur.',
	'developers:unit_tests:warning' => 'Attention : N\'exécutez pas ces tests sur un site en production. Ils peuvent corrompre votre base de données.',
	'developers:unit_tests:run' => 'Exécuter',

	// status messages
	'developers:settings:success' => 'Paramètres enregistrés et caches vidés',
	
	'developers:amd' => 'AMD',
);
