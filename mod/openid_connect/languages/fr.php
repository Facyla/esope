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

);