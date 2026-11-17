<?php
/**
 * Réglages du plugin OpenID Connect (SSO)
 *
 * Le plugin lit ses réglages (endpoint, client_id, client_secret, scope)
 * sous son propre identifiant de plugin ; le formulaire générique
 * plugins/settings/save sauvegarde donc directement les champs params[*].
 *
 * @uses ElggPlugin $vars['entity'] Le plugin dont on affiche les réglages
 */

use Jumbojett\OpenIDConnectClient;

$plugin = elgg_extract('entity', $vars);
if (!$plugin instanceof \ElggPlugin) {
	return;
}

$test_mode = get_input('test', false);

echo '<p>RTFM : <a href="https://github.com/jumbojett/OpenID-Connect-PHP" target="_blank">https://github.com/jumbojett/OpenID-Connect-PHP</a></p>';

echo '<fieldset><legend>' . elgg_echo('openid_connect:title') . '</legend>';
echo '<p><em>' . elgg_echo('openid_connect:settings:description') . '</em></p>';

// URL de base du fournisseur d'identité
// (découverte : {endpoint}/.well-known/openid-configuration ;
// déconnexion : {endpoint}/oauth2/logout)
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('openid_connect:settings:endpoint'),
	'#help' => elgg_echo('openid_connect:settings:endpoint:help'),
	'name' => 'params[endpoint]',
	'value' => $plugin->endpoint,
]);

// Client ID
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('openid_connect:settings:client_id'),
	'#help' => elgg_echo('openid_connect:settings:client_id:help'),
	'name' => 'params[client_id]',
	'value' => $plugin->client_id,
]);

// Client Secret (afficher le secret courant pour ne pas le perdre à la sauvegarde)
echo elgg_view_field([
	'#type' => 'password',
	'always_empty' => false,
	'#label' => elgg_echo('openid_connect:settings:client_secret'),
	'#help' => elgg_echo('openid_connect:settings:client_secret:help'),
	'name' => 'params[client_secret]',
	'value' => $plugin->client_secret,
]);

// Scope
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('openid_connect:settings:scope'),
	'#help' => elgg_echo('openid_connect:settings:scope:help'),
	'name' => 'params[scope]',
	'value' => $plugin->scope,
]);

// URLs de redirection à enregistrer côté fournisseur
// (issues des routes du plugin : views/default/resources/openid_connect/login.php
// et openid_connect_build_end_session_url())
echo '<div class="elgg-section-header"><strong>' . elgg_echo('openid_connect:settings:redirects') . '</strong></div>';
echo '<p><em>' . elgg_echo('openid_connect:settings:redirects:help') . '</em></p>';
$site_url = elgg_get_site_url();
echo '<ul>';
echo '<li>' . elgg_echo('openid_connect:settings:redirect_login') . ' : <code>' . htmlspecialchars($site_url . 'openid_connect/login', ENT_QUOTES) . '</code></li>';
echo '<li>' . elgg_echo('openid_connect:settings:redirect_logout') . ' : <code>' . htmlspecialchars($site_url . 'openid_connect/logged_out', ENT_QUOTES) . '</code></li>';
echo '</ul>';
echo '</fieldset>';

echo '<p><a class="elgg-button elgg-button-action" href="?test=yes">' . elgg_echo('openid_connect:settings:check') . '</a></p>';

// DEV / TESTS ONLY !!
// @TODO This should be exposed as a public resource
if ($test_mode == 'yes' && !empty($plugin->endpoint) && !empty($plugin->client_id) && !empty($plugin->client_secret)) {

	$oidc_action = 'basic';

	switch ($oidc_action) {
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
