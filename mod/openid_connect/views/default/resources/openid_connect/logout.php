<?php
use Jumbojett\OpenIDConnectClient;

$url = elgg_get_site_url();

$endpoint = elgg_get_plugin_setting('endpoint', 'openid_connect');
$client_id = elgg_get_plugin_setting('client_id', 'openid_connect');
$client_secret = elgg_get_plugin_setting('client_secret', 'openid_connect');

$title = elgg_echo('openid_connect:title');
$content = '';
$content .= '<p><a class="elgg-button elgg-button-action" href="?logout=logout">Déconnexion du SSO</a></p>';

// URL endpoint OpenID Connect

// @TODO : logout
/*
$oidc = new OpenIDConnectClient($endpoint, $client_id, $client_secret);
$oidc->addScope(array('profile', 'email'));
//$oidc->setCertPath('/path/to/my.cert');
$oidc->authenticate();
$email = $oidc->requestUserInfo('email');
$name = $oidc->requestUserInfo('name');
echo "Connecté avec $name / $email ! ";
*/

if (elgg_is_logged_in()) {
	echo elgg_view_page($title, [
		'title' => $title,
		'content' => $content,
		'sidebar' => '',
		'filter' => false,
		'filter_value' => false,
		'filter_id' => false,
	]);
} else {
	echo elgg_view_page($title, [
		'title' => $title,
		'content' => $content,
		'class' => 'elgg-page-walled-garden',
		'sidebar' => '',
		'filter' => false,
		'filter_value' => false,
		'filter_id' => false,
		'page_shell' => 'maintenance',
	], 'walled_garden');
}