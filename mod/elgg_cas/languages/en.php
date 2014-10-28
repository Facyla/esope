<?php
/**
 * English strings
 */
global $CONFIG;

$en = array(
	'elgg_cas:title' => "Login with CAS",
	
	'elgg_cas:loginbutton' => "CAS login",
	'elgg_cas:casdetected' => "CAS login detected.",
	'elgg_cas:login:success' => "Successfully logged in with CAS",
	'elgg_cas:noaccountyet' => "No account created yet",
	'elgg_cas:login:validcas' => "Valid CAS authentification",
	'elgg_cas:login:details' => "If you have a valid Inria access, please use CAS connection. If your Iris account doesn't exist yet, it will be created at your first login attempt.<br />If you don't have any Inria account or if it isn't valid anymore, please use login/pass regular login below.",
	
	'elgg_cas:settings:autologin' => "CAS autologin.",
	'elgg_cas:settings:autologin:details' => "If activated, a valid CAS authentication will log the user in. If disabled, members need to connect through a login page.",
	'elgg_cas:settings:casregister' => "Automatic account creation",
	'elgg_cas:settings:casregister:details' => "If CAS account creation is enabled, an Elgg account will be created for any valid CAS account, as soon as the corresponding user tries to connect.",
	'elgg_cas:settings:enable_webservice' => "Enable CAS auth for webservices",
	'elgg_cas:settings:cas_library' => "Choose CAS library",
	
	'elgg_cas:cas_host' => "CAS host, eg: cas.example.com",
	'elgg_cas:cas_context' => "CAS context, eg: /cas",
	'elgg_cas:cas_port' => "Port, eg: 443",
	'elgg_cas:ca_cert_path' => "(optional) Path to PEM certificate, eg: /path/to/cachain.pem",
	
	// Errors
	'elgg_cas:missingparams' => "Missing CAS parameters. Please set up the plugin settings to use CAS.",
	'elgg_cas:user:banned' => "Disabled account",
	'elgg_cas:user:notexist' => "This account doesn't exist yet. Please create it by login through CAS.",
	'elgg_cas:loginfailed' => "Login failed",
	'elgg_cas:logged:nocas' => "You're now logged in without CAS.",
	'elgg_cas:logged:cas' => "You're now logged in with CAS account <b>%s</b>.",
	'elgg_cas:confirmcaslogin' => 'You are logged in on this site with <b>%1$s</b> (%2$s). <br />To login with your CAS account, please <a href="' . $CONFIG->url . 'action/logout">logout first</a>, then connect again with CAS.',
	'elgg_cas:confirmchangecaslogin' => 'You are logged in on this site with <b>%1$s</b> (%2$s). <br />To login with an other CAS account, please <a href="' . $CONFIG->url . 'action/logout">logout first</a>, then connect again with CAS.',
	'elgg_cas:alreadylogged' => 'You are logged in on this site with <b>%3$s</b> (%4$s), and trying to login with CAS account <b>%1$s</b> (%2$s). <br />To login with your CAS account <b>%1$s</b>, please <a href="' . $CONFIG->url . 'action/logout">logout first</a>.',

	
);

add_translation('en', $en);

