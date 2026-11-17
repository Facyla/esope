<?php
/**
 * Translation file
 *
 * Note: don't change the return array to short notation because Transifex can't handle those during `tx push -s`
 */

return array(
	'openid_connect:title' => "OpenID Connect",
	'openid_connect:settings:endpoint' => "OpenID Connect server URL",
	'openid_connect:settings:client_id' => "ClientID: client application identifier",
	'openid_connect:settings:client_secret' => "ClientSecret: client application secret",
	'openid_connect:settings:scope' => "Scope",
	'openid_connect:settings:description' => "The identity provider's endpoints are auto-discovered from its well-known configuration; fill in the base URL and the credentials of the OIDC client registered on the provider side.",
	'openid_connect:settings:endpoint:help' => "Base URL of the OpenID Connect provider (issuer). The authorization, token, userinfo and logout endpoints are auto-discovered from {endpoint}/.well-known/openid-configuration. Example: https://sso.example.com/",
	'openid_connect:settings:client_id:help' => "Client ID of the OIDC application registered with the identity provider.",
	'openid_connect:settings:client_secret:help' => "Client secret of the OIDC application registered with the identity provider.",
	'openid_connect:settings:scope:help' => "Comma or space separated list of scopes to request from the provider. Leave empty to use the default (profile, email).",
	'openid_connect:settings:redirects' => "Redirect URLs to register with the identity provider",
	'openid_connect:settings:redirects:help' => "When registering the OIDC client on the provider side, add these two callback URLs to the allowed redirect URIs:",
	'openid_connect:settings:redirect_login' => "Login callback (redirect_uri)",
	'openid_connect:settings:redirect_logout' => "Post-logout redirect (post_logout_redirect_uri)",
	'openid_connect:settings:check' => "Check the settings",

	'openid_connect:login' => "SSO Login",
	'openid_connect:login_with_sso' => "Login with SSO",
	'openid_connect:logged_with_sso' => "You are logged in with SSO.",
	'openid_connect:logout' => "SSO Logout",
	'openid_connect:logout_from_sso' => "Logout from SSO",
	'openid_connect:loggedinwith' => "Identified with ",
	'openid_connect:cannotlogin' => "Unable to log in user account",

	'openid_connect:invalidgrant' => "Invalid grant token, please retry.", // calling sprintf has the exception message as parameter #1

	'openid_connect:login:sso' => "Using your organisation's SSO",
	'openid_connect:login:local' => "OR with a local account",

	'openid_connect:logged_out' => "Logged out",
	'openid_connect:logged_out:message' => "You have been logged out of the SSO and the platform.",
	'openid_connect:logout:provider_unavailable' => "The SSO service is temporarily unavailable. You have been logged out of the platform.",
);