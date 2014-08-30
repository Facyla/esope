<?php

$fr = array(
	
	'hybridauth:settings:title' => "Paramètres et clefs d'API",
	
	'hybridauth:available:twitter' => "Activer l'intégration Twitter",
	'hybridauth:apikey:twitter' => "ID/clef de l'application",
	'hybridauth:secret:twitter' => "Secret de l'application",
	
	'hybridauth:available:linkedin' => "Activer l'intégration Linkedin",
	'hybridauth:apikey:linkedin' => "ID/clef de l'application",
	'hybridauth:secret:linkedin' => "Secret de l'application",
	
	'hybridauth:available:google' => "Activer l'intégration Google",
	'hybridauth:apikey:google' => "ID/clef de l'application",
	'hybridauth:secret:google' => "Secret de l'application",
	
	'hybridauth:available:facebook' => "Activer l'intégration Facebook",
	'hybridauth:apikey:facebook' => "ID/clef de l'application",
	'hybridauth:secret:facebook' => "Secret de l'application",
	
	// Linkedin
	'hybridauth:linkedin:title' => "Linkedin",
	'hybridauth:linkedin:login' => "Connecter le compte %s",
	'hybridauth:linkedin:logged' => "Vous êtes maintenant connecté avec <b>%s</b> en tant que <b>%s</b>",
	'hybridauth:linkedin:logout' => "Couper la connexion à Linkedin",
	'hybridauth:linkedin:loggedout' => "Déconnecté de Linkedin.",
	'hybridauth:linkedin:import' => "Importer les champs sélectionnés !",
	'hybridauth:linkedin:import:done' => "IMPORT DES CHAMPS DEPUIS LINKEDIN FAIT :",
	'hybridauth:linkedin:import:after' => "Import terminé, veuillez %s, %s et %s.",
	'hybridauth:linkedin:editprofile' => "compléter ou modifier votre profil",
	'hybridauth:linkedin:editavatar' => "recadrer votre avatar",
	'hybridauth:linkedin:viewprofile' => "vérifier votre profil mis à jour",
	
	'hybridauth:linkedin:import:title' => "Importer des informations depuis votre profil LinkedIn",
	'hybridauth:linkedin:import:details' => "<p>Vous pouvez récupérer certaines informations à partir de votre profil LinkedIn pour démarrer ou compléter votre profil.</p><p>Vous pouvez prévisualiser les informations disponibles ci-dessous, et choisir pour chacune si vous sugaitez l'importer ou non. Certaines informations sont ajoutées à votre profil (afin de ne pas perdre les informations existantes).</p><p>Une fois l'import terminé, il est conseillé de poursuivre l'édition de votre profil via les liens proposés.",
	'hybridauth:linkedin:import:profile_url' => "Importer l'URL du profil public (remplace : Profil LinkedIn)",
	'hybridauth:linkedin:import:photo' => "Importer la photo (remplace votre photo actuelle)",
	'hybridauth:linkedin:import:industry' => "Importer le secteur (remplace : Secteur professionnel)",
	'hybridauth:linkedin:import:headline' => "Importer le titre (ajouté à : Brève description)",
	'hybridauth:linkedin:import:status' => "Importer le statut (ajouté à : Brève description)",
	'hybridauth:linkedin:import:summary' => "Importer le résumé (ajouté à : A propos de moi)",
	'hybridauth:linkedin:import:positions' => "Importer les postes actuels (ajoutés à : A propos de moi)",
	'hybridauth:linkedin:import:educations' => "Importer vos études (ajoutées à : Etudes)",
	'hybridauth:linkedin:import:skills' => "Importer vos compétences (ajoutées à : Compétences)",
	
	// Login and registration
	'hybridauth:connectedwith' => "You are now connected with <b>%s</b> as <b>%s</b>",
	'hybridauth:noacccount' => "There is no account associated yet. You have 2 options :",
	'hybridauth:existingacccount' => "<strong>There is an existing account using the same username %s.</strong><br />If you own this account, we suggest you prefer option 1 and login to associate it with your Twitter account. If you don't, please use another username to register.",
	'hybridauth:availableusername' => "The username $twitter_username is available on this site.<br />If you do not have any account yet, you may use this username to register.</strong>",
	'hybridauth:logintoassociate' => "Login to associate your account with %s",
	'hybridauth:logintoassociate:details' => "Use this option if you already have an account and wish to associate it with your %s account %s.<br />Please use the form below to login, and get back to this page to confirm the association with your %s account.<br />You'll be then able to login directly with %s.",
	'hybridauth:loginnow' => "Login now",
	'hybridauth:registertoassociate' => "Or create an account on this site",
	'hybridauth:registertoassociate:details' => "Prefer this option if you do not have any account on this site, or wish to associate your %s account %s with a new account.<br />Please complete the registration form with a valid email address, and confirm the registration.<br />Once your account is created, it will be associated with your %s account so we will be able to login with %s.",
	'hybridauth:registernow' => "Create an account now",
	'hybridauth:association:success' => "No account was associated with this Twitter account yet. Association successful : you can now login with your Twitter account.",
	'hybridauth:otheraccountassociated' => "Another account is already associated with this %s account : sorry but cannot continue with association.<br />Logging out from %s.",
	'hybridauth:revokeassociation:details' => "Do you want to revoke access with %s ? If you do this, you won't be able to connect with Twitter anymore.<br /><em>Note : you will be able to enable a new %s association at any time.</em>",
	'hybridauth:' => "Account %s (%s) is associated with your account %s.</strong> You can login with %s.",
	'hybridauth:association:link' => "set up a new %s association",
	'hybridauth:revokeassociation:success' => "%s association removed. You can %s or keep browsing the site.",
	'hybridauth:revokeassociation' => "Revoke %s association",
	
);

add_translation("fr",$fr);

