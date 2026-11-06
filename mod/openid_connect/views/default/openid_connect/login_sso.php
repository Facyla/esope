<?php
// Auto-detects SSO, and add SSO login link if not logged in
// Usage : to add the SSO login button, add in the wanted views : elgg_view('openid_connect/login_sso');

if (elgg_is_logged_in()) { return; }

$url = elgg_get_site_url();
$html = '';

// Auto-détection SSO si déjà connecté
if (isset($_COOKIE['lemonldap'])) {
	// Don't display a message (would be displayed after the SSO redirect)
	//system_message("Connexion SSO identifiée.");
	// Keep original target URL
	$session = elgg_get_session();
	$session->set('referer', REFERRER); // default referer var
	$session->set('sso_referer', REFERRER); // custom, in case the other is overrided
	// Elgg 7: forward() is removed; openid_connect_forward() throws an HttpException
	openid_connect_forward("{$url}openid_connect/login");
}

$html .= '<h3>' . elgg_echo('openid_connect:login:sso') . '</h3>';
$html .= elgg_view('output/url', ['href' => "{$url}openid_connect/login", 'text' => elgg_echo('openid_connect:login'), 'class' => 'linagora_sso-login']);
$html .= '<hr />';
$html .= '<h3>' . elgg_echo('openid_connect:login:local') . '</h3>';

echo $html;