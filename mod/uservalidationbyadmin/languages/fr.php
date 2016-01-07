<?php

return array(
	'uservalidationbyadmin' => "Validation des inscriptions par administrateur",
	
	// general stuff
	'uservalidationbyadmin:validate' => "Valider",
	'uservalidationbyadmin:validate:confirm' => "Voulez-vous valider ce compte ?",
	
	// plugin settings
	'uservalidationbyadmin:settings:admin_notify' => "Quand souhaitez-vous que les administrateurs reçoivent des notifications à propos des demandes d'inscription à examiner",
	'uservalidationbyadmin:settings:admin_notify:direct' => "A chaque fois qu'un utilisateur s'inscrit",
	'uservalidationbyadmin:settings:admin_notify:daily' => "Quotidien",
	'uservalidationbyadmin:settings:admin_notify:weekly' => "Hebdomadaire",
	'uservalidationbyadmin:settings:admin_notify:none' => "Pas de notification",
	
	// user settings
	'uservalidationbyadmin:usersettings:nonadmin' => "Seuls les administrateurs du site sont autorisés à valider les demandes.",
	'uservalidationbyadmin:usersettings:notify' => "Je souhaite recevoir des notifications à propos des demandes d'inscription en attente",
	
	// login
	'uservalidationbyadmin_pam_handler:failed' => "Votre demande d'inscription doit être validée manuellement, vous recevrez un message lorsque ce sera fait",
	'uservalidationbyadmin:login:error' => "Votre demande d'inscription doit être validée manuellement, vous recevrez un message lorsque ce sera fait",
	
	// listing
	'admin:users:pending_approval' => "Inscriptions en attente",
	
	'uservalidationbyadmin:pending_approval:description' => "Vous trouverez ci-dessous la liste des demandes d'inscription en attente. Ces comptes utilisateurs sont inactifs et nécessitent d'être validés pour que les personnes qui ont fait ces demandes puissent se connecter au site.",
	'uservalidationbyadmin:pending_approval:title' => "Compte en attente d'approbation",
	
	'uservalidationbyadmin:bulk_action:select' => "Veuillez sélectionner au moins un utilisateur pour effectuer cete action",
	
	// notification
	'uservalidationbyadmin:notify:validate:subject' => "Votre demande d'inscription sur %s a été validée",
	'uservalidationbyadmin:notify:validate:message' => "Bonjour %s,

Votre demande d'inscription sur %s a été validée, vous pouvez utiliser le site dès à présent.

Veuillez vous rendre sur %s pour commencer.",

		'uservalildationbyadmin:notify:admin:subject' => "Des demandes d'inscription nécessitent votre attention",
		'uservalildationbyadmin:notify:admin:message' => "Bonjour %s,

Il y a %s demandes d'inscription en attente sur %s.

Veuillez vous connecter sur %s pour approuver/supprimer les demandes d'inscription.",
	
	// actions
	// validate
	'uservalidationbyadmin:actions:validate:error:save' => "Une erreur inconnue s'est produite lors de la validation de %s",
	'uservalidationbyadmin:actions:validate:success' => "%s a été validé",
	
	// bulk action
	'uservalidationbyadmin:actions:bulk_action:error:invalid_action' => "L'action choisie n'est pas valide",
	'uservalidationbyadmin:actions:bulk_action:success:delete' => "Demande(s) d'inscription supprimée(s)",
	'uservalidationbyadmin:actions:bulk_action:success:validate' => "Compte(s) utilisateur(s) validé(s)",
	
	
	'uservalidationbyadmin:admin:listnotified' => "Liste des administrateurs et de leurs préférences de notification",
	'uservalidationbyadmin:admin:usersettings' => "modifier les paramètres",
	'uservalidationbyadmin:settings:emailvalidation' => "Permettre aux administrateurs de valider directement via un lien dans l'email",
	'uservalidationbyadmin:settings:admin:additionalinfo' => "Ajouter des informations complémentaires pour l'admin dans l'email de validation",
	'uservalidationbyadmin:settings:user:additionalinfo' => "Ajouter des informations complémentaires pour l'utilisateur dans l'email de confirmation après validation",
	'uservalidationbyadmin:noipinfo' => "pas d'information sur l'IP d'inscription",
	'uservalidationbyadmin:geoinfo' => "IP %s, géolocalisation estimée&nbsp;: %s",
	'uservalidationbyadmin:userinfo' => "Demande de %s&nbsp;: username %s, email %s",
	'uservalidationbyadmin:userinfo:geo' => "Demande de %s&nbsp;: username %s, email %s, %s",
	'uservalidationbyadmin:user_validation_link' => "Lien de confirmation immédiate du compte de %s : %s",
	
	'uservalidationbyadmin:notify:admin:message:alternate' => "Bonjour %s,

Il y a %s demandes d'inscription en attente sur %s :
%s

Veuillez vous connecter sur %s pour approuver/supprimer les demandes d'inscription.",
	
	'uservalidationbyadmin:notify:validate:message:alternate' => "Bonjour %s,

Votre demande d'inscription sur %s a été validée, vous pouvez utiliser le site dès à présent.

Nom d'utilisateur : %s
Email d'inscription : %s
Mot de passe : celui que vous avez choisi lors de votre demande d'inscription

Veuillez vous rendre sur %s pour commencer.",
	
	'uservalidationbyadmin:actions:validate:error:code' => "Code de validation incorrect",
	
);

