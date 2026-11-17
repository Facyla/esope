<?php
/**
 * Translation file
 *
 * Note: don't change the return array to short notation because Transifex can't handle those during `tx push -s`
 */

return array(
	'openid_connect:title' => "OpenID Connect",
	'openid_connect:settings:endpoint' => "URL du serveur OpenID Connect",
	'openid_connect:settings:client_id' => "ClientID : Identifiant de l'application cliente",
	'openid_connect:settings:client_secret' => "ClientSecret : Secret de l'application cliente",
	'openid_connect:settings:scope' => "Scope",
	'openid_connect:settings:description' => "Les endpoints du fournisseur d'identité sont découverts automatiquement depuis sa configuration bien connue ; renseignez l'URL de base et les identifiants du client OIDC enregistré côté fournisseur.",
	'openid_connect:settings:endpoint:help' => "URL de base du fournisseur OpenID Connect (issuer). Les endpoints d'autorisation, de jeton, d'userinfo et de déconnexion sont découverts automatiquement depuis {endpoint}/.well-known/openid-configuration. Exemple : https://sso.exemple.com/",
	'openid_connect:settings:client_id:help' => "Identifiant du client de l'application OIDC enregistrée auprès du fournisseur d'identité.",
	'openid_connect:settings:client_secret:help' => "Secret du client de l'application OIDC enregistrée auprès du fournisseur d'identité.",
	'openid_connect:settings:scope:help' => "Liste de scopes séparés par des virgules ou des espaces à demander au fournisseur. Laisser vide pour utiliser la valeur par défaut (profile, email).",
	'openid_connect:settings:redirects' => "URLs de redirection à enregistrer auprès du fournisseur d'identité",
	'openid_connect:settings:redirects:help' => "Lors de l'enregistrement du client OIDC côté fournisseur, ajoutez ces deux URLs de rappel (callback) à la liste des URLs de redirection autorisées :",
	'openid_connect:settings:redirect_login' => "Callback de connexion (redirect_uri)",
	'openid_connect:settings:redirect_logout' => "Redirection après déconnexion (post_logout_redirect_uri)",
	'openid_connect:settings:check' => "Vérifier les paramètres",

	'openid_connect:login' => "Connexion SSO",
	'openid_connect:login_with_sso' => "Connexion avec le SSO",
	'openid_connect:logged_with_sso' => "Vous êtes déjà connecté avec le SSO.",
	'openid_connect:logout' => "Déconnexion SSO",
	'openid_connect:logout_from_sso' => "Déconnexion du SSO",
	'openid_connect:loggedinwith' => "Connecté avec ",
	'openid_connect:cannotlogin' => "Impossible de connecter le compte utilisateur",

	'openid_connect:invalidgrant' => "Jeton de connexion invalide, veuillez réessayer.", // calling sprintf has the exception message as parameter #1

	'openid_connect:login:sso' => "Avec le SSO de votre organisation",
	'openid_connect:login:local' => "OU avec un compte local",

	'openid_connect:logged_out' => "Déconnecté",
	'openid_connect:logged_out:message' => "Vous avez été déconnecté du SSO et de la plateforme.",
	'openid_connect:logout:provider_unavailable' => "Le service SSO est temporairement indisponible. Vous avez été déconnecté de la plateforme.",
);