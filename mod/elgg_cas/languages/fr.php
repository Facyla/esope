<?php
/**
 * French strings
 */

$fr = array(
	'elgg_cas:title' => "Connexion avec CAS",
	
	'elgg_cas:loginbutton' => "Connexion CAS",
	'elgg_cas:casdetected' => "Identification CAS détectée.",
	'elgg_cas:login:success' => "Connexion avec CAS réussie",
	'elgg_cas:login:validcas' => "Authentification CAS valide",
	'elgg_cas:noaccountyet' => "Pas encore de compte créé",
	'elgg_cas:login:details' => "Personnel Inria, veuillez utiliser la connexion CAS. Si votre compte Iris n'existe pas encore, il sera créé lors de votre première connexion.<br />Si vous ne disposez pas de compte Inria ou si celui-ci n'est plus actif, veuillez utiliser la connexion par identifiant / mot de passe",
	'elgg_cas:user:clicktoregister' => "Cliquez ici pour créer votre compte",
	
	'elgg_cas:settings:autologin' => "Login CAS automatique.",
	'elgg_cas:settings:autologin:details' => "Si l'identification automatique via CAS est activée, les membres seront connectés au réseau s'ils ont une authentification CAS active. Si elle n'est pas activée, il faut cliquer sur la connexion via CAS pour se connecter.",
	'elgg_cas:settings:casregister' => "Création de compte via CAS",
	'elgg_cas:settings:casregister:details' => "Si la création de comptes via CAS est activée, tout compte valide dans CAS et n'existant pas encore sur la plateforme sera automatiquement créé à la première tentative de connexion. En mode Auto il sera créé depuis n'importe quelle page, sinon une confirmation sera demandée.",
	'elgg_cas:settings:enable_webservice' => "Activer l'authentification CAS auth pour les webservices",
	'elgg_cas:settings:cas_library' => "Choix de la bibliothèque CAS",
	
	'elgg_cas:cas_host' => "URL de l'hôte CAS, par ex: cas.example.com",
	'elgg_cas:cas_context' => "CAS context, par ex: /cas",
	'elgg_cas:cas_port' => "Port, par ex: 443",
	'elgg_cas:ca_cert_path' => "(facultatif) Chemin du certificat PEM sur le serveur, par ex: /path/to/cachain.pem",
	
	// Errors
	'elgg_cas:missingparams' => "Paramètres du plugin CAS manquants. Veuillez les renseigner pour utiliser CAS.",
	'elgg_cas:user:banned' => "Compte désactivé",
	'elgg_cas:user:notexist' => "Votre compte Iris n'existe pas encore. Pour le créer, veuillez vous connecter avec CAS.",
	'elgg_cas:loginfailed' => "Echec de la connexion",
	'elgg_cas:logged:nocas' => "Vous êtes actuellement connecté sans utiliser CAS.",
	'elgg_cas:logged:cas' => "Vous êtes actuellement connecté via CAS avec le compte <b>%s</b>.",
	'elgg_cas:confirmcaslogin' => 'Vous utilisez sur ce site le compte <b>%1$s</b> (%2$s). <br />Pour vous connecter avec votre compte CAS, veuillez d\'abord <a href="' . elgg_get_site_url() . 'action/logout">vous déconnecter</a>, puis vous identifier avec CAS.',
	'elgg_cas:confirmchangecaslogin' => 'Vous utilisez sur ce site le compte <b>%1$s</b> (%2$s). <br />Pour vous connecter avec un autre compte CAS, veuillez d\'abord <a href="' . elgg_get_site_url() . 'action/logout">vous déconnecter du compte que vous utilisez</a>, puis vous identifier avec CAS.',
	'elgg_cas:alreadylogged' => 'Vous utilisez actuellement le compte <b>%3$s</b> (%4$s), et tentez de vous connecter avec le compte CAS <b>%1$s</b> (%2$s). <br />Pour vous connecter avec votre compte CAS <b>%1$s</b>, veuillez d\'abord <a href="' . elgg_get_site_url() . 'action/logout">vous déconnecter du compte que vous utilisez</a>.',

	
);

add_translation('fr', $fr);

