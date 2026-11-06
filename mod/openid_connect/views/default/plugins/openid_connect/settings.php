<?php
use Jumbojett\OpenIDConnectClient;
$plugin = elgg_extract('entity', $vars);

$url = elgg_get_site_url();

$test_mode = get_input('test', false);

// Define select options
$yn_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

//echo "Configuration OpenID Connect";

echo '<p>RTFM : <a href="https://github.com/jumbojett/OpenID-Connect-PHP" target="_blank">https://github.com/jumbojett/OpenID-Connect-PHP</a></p>';

// URL endpoint OpenID Connect
echo '<div><label>' . elgg_echo('openid_connect:settings:endpoint') . ' ' . elgg_view('input/text', ['name' => 'params[endpoint]', 'value' => $plugin->endpoint]) . '</label></div>';

// Client ID
echo '<div><label>' . elgg_echo('openid_connect:settings:client_id') . ' ' . elgg_view('input/text', ['name' => 'params[client_id]', 'value' => $plugin->client_id]) . '</label></div>';

// Client Secret
echo '<div><label>' . elgg_echo('openid_connect:settings:client_secret') . ' ' . elgg_view('input/text', ['name' => 'params[client_secret]', 'value' => $plugin->client_secret]) . '</label></div>';

// Scope
echo '<div><label>' . elgg_echo('openid_connect:settings:scope') . ' ' . elgg_view('input/text', ['name' => 'params[scope]', 'value' => $plugin->scope]) . '</label></div>';

$test = get_input('test', false);

echo '<p><a class="elgg-button elgg-button-action" href="?test=yes">Vérifier les paramètres</a></p>';

// DEV / TESTS ONLY !! 
// @TODO This should be exposed as a public resource
if ($test_mode == 'yes' && !empty($plugin->endpoint) && !empty($plugin->client_id) && !empty($plugin->client_secret)) {

	$oidc_action = 'basic';
	
	switch($oidc_action) {
		case 'basic':
			// Basic registration
			$oidc = new OpenIDConnectClient($plugin->endpoint, $plugin->client_id, $plugin->client_secret);
			$oidc->addScope(array('profile', 'email'));
			//$oidc->setCertPath('/path/to/my.cert');
			$oidc->authenticate();
			$given_name = $oidc->requestUserInfo('given_name');
			$email = $oidc->requestUserInfo('email');
			$name = $oidc->requestUserInfo('name');
			echo "Connecté avec $name / $email ! ";
			break;
		
		case 'dynamic':
			// Dynamic registration
			$oidc = new OpenIDConnectClient($plugin->endpoint);
			$oidc->register();
			$client_id = $oidc->getClientID();
			$client_secret = $oidc->getClientSecret();
			echo "Client ID : $client_id<br />Client secret : $client_secret";
			// Be sure to add logic to store the client id and client secret
			break;
			
		default: 
			
	}

}

