<?php
use Jumbojett\OpenIDConnectClient;

elgg_push_context('login');
$url = elgg_get_site_url();

$endpoint = elgg_get_plugin_setting('endpoint', 'openid_connect');
$client_id = elgg_get_plugin_setting('client_id', 'openid_connect');
$client_secret = elgg_get_plugin_setting('client_secret', 'openid_connect');

$title = elgg_echo('openid_connect:title');
$content = '';

// URL endpoint OpenID Connect
if (elgg_is_admin_logged_in()) {
	$content .= '<ul>';
		$content .= '<li>' . elgg_echo('openid_connect:settings:endpoint') . '&nbsp;: ' . $endpoint . '</li>';
		$content .= '<li>' . elgg_echo('openid_connect:settings:client_id') . '&nbsp;: ' . $client_id . '</li>';
		$content .= '<li>' . elgg_echo('openid_connect:settings:client_secret') . '&nbsp;: ' . $client_secret . '</li>';
	$content .= '</ul>';
}

if (elgg_is_logged_in()) {
	//$content .= '<p><a class="elgg-button elgg-button-action" href="' . $url . 'openid_connect/logout">' . elgg_echo('openid_connect:logout_from_sso') . '</a></p>';
	$content .= '<p>' . elgg_echo('openid_connect:logged_with_sso') . '</p>';
} else {
	$content .= '<p><a class="elgg-button elgg-button-action" href="' . $url . 'openid_connect/login">' . elgg_echo('openid_connect:login_with_sso') . '</a></p>';
}

// DEV / TESTS ONLY !!

// Basic registration
/*
$oidc = new OpenIDConnectClient($endpoint, $client_id, $client_secret);
$oidc->addScope(array('profile', 'email'));
//$oidc->setCertPath('/path/to/my.cert');
$oidc->authenticate();
$email = $oidc->requestUserInfo('email');
$name = $oidc->requestUserInfo('name');
$content .= "Connecté avec $name / $email ! ";
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