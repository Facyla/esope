<?php 
$french = array(
	'digest' => "Résumés",

	// digest intervals
	'digest:interval:none' => "Désactivé",
	'digest:interval:default' => "Utiliser les paramètres du groupe (actuellement : %s)",
	'digest:interval:daily' => "Quotidien",
	'digest:interval:weekly' => "Hebdomadaire",
	'digest:interval:fortnightly' => "Bimensuel",
	'digest:interval:monthly' => "Mensuel",

	'digest:interval:error' => "Intervale invalide",

	// readable time
	'digest:readable:time:seconds' => "sec",
	'digest:readable:time:minutes' => "min",
	'digest:readable:time:hours' => "h",
	
	// menu items
	'digest:page_menu:settings' => "Paramètres des Résumés",
	'digest:page_menu:theme_preview' => "Prévisualisation des Résumés",
	'digest:submenu:groupsettings' => "Paramètres des Résumés",
	'admin:statistics:digest' => "Analyse des Résumés",
	
	// admin settings
	'digest:settings:production:title' => "Paramètres de production des Résumés",
	'digest:settings:production:description' => "L'utilisation des Résumés peut générer l'envoi de beaucoup de mails aux membres du site, en fonction des réglages. Pour être sûr qu'aucun mail ne sera envoyé aux membres avant que vous soyez prêt, ce réglage vus permet de tester le système. Quand vous serez prêt, passez le système en production.",
	'digest:settings:production:option' => "Activer l'envoi de mails de Résumé d'activité",
	'digest:settings:production:group_option' => "Activer les mails de Résumé d'activité des groupes",

	'digest:settings:interval:title' => "Paramétrage de l'intervale par défaut",
	'digest:settings:interval:site_default' => "Intervale par défaut pour le Résumé du Site",
	'digest:settings:interval:group_default' => "Intervale par défaut pour le Résumé de Groupe",
	'digest:settings:interval:description' => "Définir un intervale par défaut va envoyer des résumés à cet intervale à tous les membres qui n'ont pas configuré leurs propres réglages.<br /><br /><b>ATTENTION&nbsp;:</b> Cela peut générer l'envoi de beaucoup de messages.",
	
	'digest:settings:never:title' => "Membres jamais connectés",
	'digest:settings:never:include' => "Les membres qui ne se sont jamais connectés doivent-ils recevoir les Résumés ?",
	
	// usersettings
	'digest:usersettings:title' => "Paramètres personnels des Résumés",
	'digest:usersettings:error:user' => "Vous n'avez pas accès aux paramètres des Résumés de ce membre",
	
	'digest:usersettings:site:title' => "Paramètres des Résumés du site",
	'digest:usersettings:site:description' => "Le Résumé du Site vous informe de l'activité récente du site dans différentes catégries : blogs, groupes, nouveaux membres.",
	'digest:usersettings:site:setting' => "A quelle fréquence souhaitez-vous recevoir le Résumé du site ?",
	
	'digest:usersettings:groups:title' => "Paramètres des Résumés de groupe",
	'digest:usersettings:groups:description' => "Le Résumé de Groupe vous informe de l'activité récente dans le groupe sélectionné. Ceci peut comprendre les nouveaux memmbres, les dernières discussions et publications, et plus encore.",
	'digest:usersettings:groups:group_header' => "Nom du groupe",
	'digest:usersettings:groups:setting_header' => "Intervale",
	
	// user group setting
	'digest:usersettings:group:setting' => "Votre intervale actuel pour les Résumés de ce groupe est",
	'digest:usersettings:group:more' => "Paramètres des Résumés",
	
	// group settings
	'digest:groupsettings:title' => "Paramètres d'envoi du groupe",
	'digest:groupsettings:description' => "A quel intervale souhaitez-vous que les membres du groupe reçoivent un mail récapitulatif de l'activité du groupe ? Ce réglage sera utilisé comme valeur par défaut, chaque membre peut choisir son propre réglage.",
	'digest:groupsettings:setting' => "Paramètres des Résumés du groupe",
	
	// layout
	'digest:elements:unsubscribe:info' => "Ce mail vous a été envoyé par %s car vous êtes inscrit à ces résumés d'activité périodiques.",
	'digest:elements:unsubscribe:settings' => "Modifier vos %sparamètres de résumés périodiques%s.",	
	'digest:elements:unsubscribe:unsubscribe' => "Pour vous désinscrire directement de ce résumé périodique, %scliquez ici%s.",	

	// show a digest online
	'digest:show:error:input' => "Paramètres incorrects pour afficher le Résumé",
	'digest:show:no_data' => "Aucune activité trouvée dans l'intervale choisi",

	// message body
	'digest:message:title:site' => "[%s] Résumé %s de l'activité",
	'digest:message:title:group' => "[%2\$s / %1\$s] : Résumé %s de l'activité du groupe",

	'digest:elements:online' => "Si vous ne pouvez pas visualiser ce mail, affichez-le %sen ligne%s",
	
	// admin analysis
	'digest:analysis:title' => "Analyse du serveur d'envoi des résumés",
	
	'digest:analysis:last_run' => "Dernière exécution",
	'digest:analysis:current' => "Actuellement",
	'digest_analysis:predict' => "Prévisions",
	
	'digest:analysis:site:title' => "Résumé du site",
	'digest:analysis:site:members' => "Membres",
	'digest:analysis:site:avg_memory' => "Mémoire moyenne",
	'digest:analysis:site:total_memory' => "Mémoire totale",
	'digest:analysis:site:avg_run_time' => "Durée d'exécution moyenne",
	'digest:analysis:site:run_time' => "Durée totale d'exécution",
	'digest:analysis:site:send' => "Résumés envoyés",
	
	'digest:analysis:group:title' => "Résumé du groupe",
	'digest:analysis:group:count' => "Groupes du site",
	'digest:analysis:group:total_members' => "Nombre de membres du groupe",
	'digest:analysis:group:avg_members' => "Nombre moyen de membres par groupe",
	'digest:analysis:group:avg_members_memory' => "Mémoire moyenne par membre",
	'digest:analysis:group:total_members_memory' => "Mémoire totale pour les membres",
	'digest:analysis:group:avg_memory' => "Mémoire moyenne par groupe",
	'digest:analysis:group:total_memory' => "Mémoire totale",
	'digest:analysis:group:avg_run_time' => "Durée d'exécution moyenne par groupe",
	'digest:analysis:group:run_time' => "Durée d'exécution totale",
	'digest:analysis:group:send' => "Résumés envoyés",

	// register 
	'digest:register:enable' => "Je souhaite recevoir un résumé des activités du site",
	
	// unsubscribe
	'digest:unsubscribe:error:input' => "Incorrect input to unsubscribe from digest",
	'digest:unsubscribe:error:code' => "Le code de validaiton fourni est incorrect",
	'digest:unsubscribe:error:save' => "Une erreur inconnue est survenue lors de votre désinscription de ce Résumé",
	'digest:unsubscribe:success' => "Vous vous êtes bien désinscrit de ce Résumé",
	
	// actions
	// update usersettings
	'digest:action:update:usersettings:error:unknown' => "Une erreur inconnue est survenue lors de l'enregistrement de vos paramètres des Résumés",
	'digest:action:update:usersettings:success' => "Vos paramètres de résumés périodiques ont bien été enregistrés",
	
	// update groupsettings
	'digest:action:update:groupsettings:error:save' => "Une erreur inconnue est survenue lors de l'enregistrement des paramètres, veuillez réessayer",
	'digest:action:update:groupsettings:success' => "Vos paramètres de résumés périodiques du groupe ont bien été enregistrés",
	
	// send digest mail
	'digest:mail:plaintext:description' => "Votre messagerie doit accepter les mails au format HTML pour visualiser les Résumés d'activité. 

Vous pouvez également visualiser ce résumé en utilisant le lien suivant : %s.",
	
);

add_translation("fr", $french);

