<?php
/**
 * French strings
 */

return [
	'account_lifecycle' => "Filtre d'inscription",
	'account_lifecycle:index' => "Contrôle du cycle de vie des comptes utilisateurs",
	'account_lifecycle:statistics' => "Statistiques liées au cycle de vie des comptes utilisateurs",
	'account_lifecycle:noresult' => "Aucune règle de gestion du cycle de vie des comptes.",
	
	// Plugin settings
	// Direct mode
	'account_lifecycle:settings:direct_mode' => "Mode simple",
	'account_lifecycle:settings:direct_mode:description' => "Permet de définir un type de gestion de cycle de vie des comptes utilisateurs. ",
	'account_lifecycle:settings:direct_mode:details' => "Sélection des comptes, action à effectuer, date de début, délai d'exécution",
	'account_lifecycle:settings:direct_mode:enable' => "Activer le Mode simple",
	'account_lifecycle:settings:direct_include_admin' => "Appliquer aussi aux compte admin",
	'account_lifecycle:settings:direct_metadata_name' => "Nom de la métadonnée ou propriété",
	'account_lifecycle:settings:direct_metadata_value' => "Valeur",
	'account_lifecycle:settings:direct_start_date' => "Date de première échéance",
	'account_lifecycle:settings:direct_interval' => "Intervale de vérification (jours)",
	'account_lifecycle:settings:direct_rule' => "Action à effectuer à l'échéance",
	'account_lifecycle:settings:direct_reminders' => "Notifications de rappel",
	'account_lifecycle:settings:adminlink' => "Page de contrôle et d'exécution",
	'account_lifecycle:settings:anonymizelink' => "Page d'anonymisation",
	'account_lifecycle:settings:statslink' => "Page de statistiques",
	
	// Full mode
	'account_lifecycle:settings:full_mode' => "Mode complet",
	'account_lifecycle:settings:full_mode:description' => "Création de batches de gestion du cycle de vie = sélection de comptes + règles de gestion<br />
		- sélection : comptes admin non/oui, série de metadata => comparaison (==, !=, IN, NOT IN, >, <, <=, >=...), valeur<br />
		- règles : exiger une nouvelle validation par email / sur le site, archiver, désactiver (ban)<br />
		- fréquence : X mois après dernière connexion, tous les X mois<br />
		<br />account_lifecycle:remove_email
account_lifecycle:remove_profile_data
account_lifecycle:remove_messages
account_lifecycle:anonymize:remove_publications
		Date limite : si pas d'action avant, on désactive le compte (ou autre action de type changement d'une ou plusieurs métadonnée'). <br />
		Doit permettre des rappels avant une date limite : <br />
		<br />
		Mode d'exécution immédiate : demande re-validation des comptes",
	'account_lifecycle:settings:full_mode:enable' => "Activer le Mode simple",
	'account_lifecycle:settings:full_mode:details' => "Pour définir plusieurs jeux de critères de sélection et de règles d'action.",
	
	
	// Direct mode form
	'account_lifecycle:parameters' => "Paramètres de configuration qui seront utilisés",
	'account_lifecycle:force_run' => "Forcer l'exécution (ré-applique l'action sans tenir dompte des dates)",
	'account_lifecycle:force_run:details' => "ATTENTION : NE PAS FORCER L'EXECUTION EN PRODUCTION !!  cela générerait des envois successifs à chaque nouveau chargement de page en cas de timeout, car cette option bypasse la date de dernière vérification.<br />L'utilité de cette option est de permettre de tester les fonctionnalités à plusieurs reprises sans devoir supprimer les métadonnées de contrôle à chaque test, ou de forcer ponctuellement - et une seule fois - une nouvelle validation.",
	'account_lifecycle:simulation' => "Simulation (aucune action ne sera effectuée)",
	'account_lifecycle:simulation:details' => "Utilisez la simulation pour déterminer quelles actions seront effectuées pour chaque compte.",
	'account_lifecycle:verbose' => "Mode bavard",
	'account_lifecycle:verbose:details' => "Affiche les informations sur les actions effectuées pour chaque compte utilisateur",
	'account_lifecycle:run_now' => "Exécuter maintenant",
	'account_lifecycle:mode_direct' => "MODE DIRECT : vérification simple des comptes",
	'account_lifecycle:mode_direct:details' => "Permet la mise en place initiale de la vérification des comptes : pour effectuer une simulation, activer le mode simulation et le mode bavard. <br />Pour une première mise en place, activer le mode simple dans les paramètres du plugin, puis exécuter avec simulation = non, bavard = oui, et forcer = non.<br />En cas de timeout, recharger la page jusqu'à la fin du script.",
	'account_lifecycle:mode_full' => "MODE COMPLET : règles multiples de gestion des cycles de vie des comptes",
	
	// Cherrypicking mode
	'account_lifecycle:cherrypicking' => "Mode manuel",
	'account_lifecycle:cherrypicking:description' => "Permet de choisir quels comptes utilisateurs re-valider",
	'account_lifecycle:select_users' => "Sélectionner les comptes utilisateurs",
	
	// Anonymize mode
	'account_lifecycle:anonymize' => "Anonymisation de comptes utilisateurs",
	'account_lifecycle:anonymize:description' => "Permet de supprimer les données personnelles de comptes utilisateurs",
	'account_lifecycle:remove_email' => "Supprimer l'adresse email du compte",
	'account_lifecycle:remove_profile_data' => "Supprimer les données du profil",
	'account_lifecycle:remove_messages' => "Supprimer les messages privés",
	'account_lifecycle:anonymize:remove_publications' => "Supprimer les publications",
	
	// Full mode form
	'account_lifecycle:field:title' => "Titre",
	'account_lifecycle:field:status' => "Statut",
	'account_lifecycle:field:include_admin' => "Appliquer aussi aux compte admin",
	'account_lifecycle:field:select_criteria' => "Critères de sélections des comptes",
	'account_lifecycle:field:metadata_name' => "Nom de la métadonnée ou propriété",
	'account_lifecycle:field:metadata_operator' => "Opérateur de comparaison",
	'account_lifecycle:field:metadata_value' => "Valeur",
	'account_lifecycle:field:start_date' => "Date de début",
	'account_lifecycle:field:start_date:details' => "Date de première exécution, à laquelle l'action prévue sera effectuée",
	'account_lifecycle:field:interval' => "Intervale de vérification",
	'account_lifecycle:field:interval:details' => "Délai entre 2 vérifications (à ajouter à la date de vérification)",
	'account_lifecycle:field:reminders' => "Notifications de rappel",
	'account_lifecycle:field:reminders:details' => "Liste de nombres de jours avant la date limite auxquels des notifications par email sont envoyés aux comptes concernés. Par. ex.: 1,3,7,30,60",
	
	
	
	'account_lifecycle:rule:email_validation' => "Re-valider l'adresse email (bloque l'accès au compte et envoie un lien de réactivation par email)",
	'account_lifecycle:rule:confirm_button' => "Affiche un interstitiel de confirmation à valider impérativement avant de pouvoir se connecter",
	'account_lifecycle:rule:archive' => "Archiver le compte",
	'account_lifecycle:rule:ban' => "Désactiver le compte (ban)",
	'account_lifecycle:criteria:all' => "Tous les comptes correspondant aux critères",
	'account_lifecycle:criteria:inactive' => "Seulement les comptes inactifs depuis X jours (date de dernière connexion)",
	
	// Front-end texts for unvalidated users
	'account_lifecycle:uservalidation:disabled' => "[Compte désactivé, en attente de vérification]",
	'account_lifecycle:uservalidation:disabled:notice' => "Ce compte a été temporairement désactivé. Il sera réactivé si son propriétaire confirme à nouveau son accès, ou archivé à l'issue d'une période d'inactivité prolongée.",
	
	// Email
	'account_lifecycle:email_validation:email:sent' => " => Mail envoyé",
	'account_lifecycle:email_validation:email:sent' => " => ERREUR mail non envoyé",
	'account_lifecycle:email_validation:email:validate:subject' => "Action requise : validation de votre compte %s sur %s",
	'account_lifecycle:email_validation:email:validate:body' => "Bonjour %s,

Une vérification périodique de votre compte utilisateur est effectuée tous les %s jours. 

Afin de pouvoir continuer à utiliser %s, vous devez confirmer votre adresse email. 

Veuillez confirmer votre adresse email en cliquant sur le lien ci-dessous :
%s

Si vous ne pouvez pas cliquer sur le lien, copiez-le et collez -le manuellement dans votre navigateur.

Si le lien n'est plus valide, un nouveau lien vous sera envoyé si vous essayez de vous connecter. 

%s
%s",
	
	
	// Cron log
	'account_lifecycle:cron:never_ran' => " jamais exécuté ", // " never ran"
	'account_lifecycle:cron:latest_run' => " dernière vérification le ", // " latest "
	'account_lifecycle:cron:skip_admin' => " => aucune action car compte admin", // " => skip (admin)"
	'account_lifecycle:cron:skip_notyet' => " => aucune action car trop tôt : prochaine vérification le %s, dans %s jours", // " => skip (not time yet), next run on %s (%s days)",
	'account_lifecycle:cron:require_validation' => " => Validation par email requise", // " => Requires validation",
	'account_lifecycle:cron:simulation' => " <u>/!\</u> SIMULATION <u>/!\</u>",
	'account_lifecycle:cron:error:missing_uservalidationbyemail' => "Exécution impossible : veuillez activer le plugin uservalidationbyemail avant d'exécuter la demande de nouvelle validaiton par email.", // 'Cannot run : please enable plugin uservalidationbyemail before running user re-validation.',
	'account_lifecycle:cron:confirm_button' => " => Exige une nouvelle confirmation sur le site", // " => Ask for confirmation"
	'account_lifecycle:cron:archive' => " => Compte archivé", // " => Account archived"
	'account_lifecycle:cron:ban' => " => Compte banni", // " => Account banned"
	'account_lifecycle:cron:saved_lastrun' => " &nbsp; MAJ date de dernière exécution : %s", // " | saved last run date : %s"
	
	// Overrides
	
];

