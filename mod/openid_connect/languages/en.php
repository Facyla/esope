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

);