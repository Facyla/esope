<?php
use Jumbojett\OpenIDConnectClient;
use Elgg\Exceptions\Configuration\RegistrationException;
use Elgg\Exceptions\Http\LoginException;

// Enable dev/debug mode
$dev = false;

$url = elgg_get_site_url();

$endpoint = elgg_get_plugin_setting('endpoint', 'openid_connect');
$client_id = elgg_get_plugin_setting('client_id', 'openid_connect');
$client_secret = elgg_get_plugin_setting('client_secret', 'openid_connect');

$title = elgg_echo('openid_connect:title');
$content = '';

//$login = get_input('login', false);
//$content .= '<p><a class="elgg-button elgg-button-action" href="?login=login">Connexion avec le SSO</a></p>';


if (!elgg_is_logged_in()) {
	if (!empty($endpoint) && !empty($client_id) && !empty($client_secret)) {
		// Déclenchement du workflow SSO
		$oidc = new OpenIDConnectClient($endpoint, $client_id, $client_secret);
		if (!$oidc) {
			error_log("DEBUG OIDC : failed creating new client");
			openid_connect_forward();
		}
		/*
		$scope = elgg_get_plugin_setting('scope', 'openid_connect');
		$scope = string_to_tag_array($scope);
		*/
		$scope = array('profile', 'email', 'uid', 'obmDomain', 'mailBox', 'homeDirectory', 'givenName', 'sn', 'displayName', 'cn');
		$oidc->addScope($scope);
		//$oidc->setCertPath('/path/to/my.cert');
		// Note : sometimes we get errors in response : whether redirect to login page, or retry a few times after a short delay?
		//$successful_auth = $oidc->authenticate(); // Fatal errors in OpenID lib can cause fatal errors here, so wrap it to handle this properly
		try {
			$successful_auth = $oidc->authenticate();
		} catch (Exception $e) {
			$successful_auth = false;
		}
		if (!$successful_auth) {
			// Classic use case is when tab was open a long time
			//register_error(elgg_echo('openid_connect:invalidgrant', [$e->getMessage()]));
			openid_connect_forward('openid_connect/login');
		}

		$name = $oidc->requestUserInfo('name');
		$email = $oidc->requestUserInfo('email');
		/* Pour ceux-là autres scopes à demander
		*/
		$username = $oidc->requestUserInfo('uid');
		$obmDomain = $oidc->requestUserInfo('obmDomain'); // linagora.com
		$mailBox = $oidc->requestUserInfo('mailBox');
		$homeDirectory = $oidc->requestUserInfo('homeDirectory'); // /home/IDENTIFIANT
		$givenName = $oidc->requestUserInfo('givenName'); // prénom
		$sn = $oidc->requestUserInfo('sn'); // nom
		$displayName = $oidc->requestUserInfo('displayName'); // nom affiché
		$cn = $oidc->requestUserInfo('cn'); // nom affiché

		// Données renvoyées via l'URL : code, session_state, state
		$ldap_data = '';
		if ($dev) { $ldap_data = "SSO data : $sn / $givenName / $name / $displayName / $cn / $username / $obmDomain / $email / $mailBox / $homeDirectory "; }

		// Connexion de l'utilisateur s'il existe et est valide dans le SSO
		//error_log("DEV SSO data : $ldap_data");
		if (!empty($email)) {
			// fetch the user (even disabled)
			// Elgg 7: get_user_by_email() is removed and elgg_get_user_by_email() returns a single ElggUser (not an array)
			$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($email) {
				return elgg_get_user_by_email($email);
			});

			if ($dev) error_log("DEV SSO user : " . print_r($user, true));
			if ($user) {
				// Connexion de l'user identifié via le SSO
				$login_message = "Connecté avec $ldap_data ";
				if ($dev) error_log("DEV SSO LOGIN : $login_message");
				// Elgg 7: login() is removed, elgg_login() throws LoginException on failure (LoginException extends HttpException)
				try {
					elgg_login($user);
				} catch (LoginException $e) {
					$content .= elgg_echo('openid_connect:cannotlogin');
				}

				if (elgg_is_logged_in()) {
					$user->login_source = "sso.linagora.com";
					$user->last_oidc_login = time();
					if ($dev) error_log("DEV SSO LOGGED IN : $login_message");
					if ($dev) elgg_register_success_message($login_message);
					// Add other data from LDAP / OIDC

					$access_token = $oidc->getAccessToken();
					$id_token = $oidc->getIdToken();
					if ($dev) error_log("DEV SSO accessToken : $access_token");
					if ($dev) error_log("DEV SSO idToken : $id_token");
					$access_token_data = explode('.', $access_token);
					// 1ère partie : entête JWT
					$token_jwt = base64_decode($access_token_data[0]);
					// 2e partie : contenu
					$token_data = json_decode(base64_decode($access_token_data[1]));
					// 3e partie : signature binaire
					$token_signature = base64_decode($access_token_data[2]);
					if ($dev) error_log("DEV SSO sid : " . print_r($token_data, true));

					// save sid token for later logout
					if (isset($token_data->oidc_sid)) {
						$user->oidc_sid = $token_data->sid;
					}
					$redirect = '';
					if (elgg_get_session()->get('sso_referer')) {
						$redirect = elgg_get_session()->get('sso_referer');
					}
					openid_connect_forward($redirect);

				}
			} else {
				// Création du compte utilisateur : similaire à la création via admin = pas besoin de valider l'email
				//$content .= "Compte utilisateur inconnu ";
				$username = openid_connect_generate_username_from_email($email);
				// Elgg 7: generate_random_cleartext_password() is removed, use elgg_generate_password()
				$password = elgg_generate_password();

				// For now, just try and register the user
				// Elgg 7: register_user() is removed, elgg_register_user() takes an array and returns an ElggUser
				try {
					$new_user = elgg_register_user([
						'username' => $username,
						'password' => $password,
						'name' => $name,
						'email' => $email,
						'validated' => true,
					]);

					$new_user->oidc_created = time();
					$new_user->created_by_guid = elgg_get_site_entity()->guid;
					$new_user->created_by_source = "sso.linagora.com";
					// Add other data from LDAP / OIDC

					// Elgg 7: notify_user() is removed; mirror core actions/useradd.php notification
					$new_user->notify('useradd', $new_user, [
						'password' => $password,
					]);

					elgg_register_success_message("Votre compte vient d'être créé, veuillez consulter votre messagerie pour l'activer.");
					openid_connect_forward();
				} catch (RegistrationException $r) {
					elgg_register_error_message($r->getMessage());
				}

			}
		} else {
			$content .= "Pas d'email";
		}
	} else {
		if (empty($endpoint)) $content .= "<p>Config manquante : endpoint</p>";
		if (empty($client_id)) $content .= "<p>Config manquante : client_id</p>";
		if (empty($client_secret)) $content .= "<p>Config manquante : client_secret</p>";
	}
} else {
	$content .= "<p>Déjà connecté.</p>";
}

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
		'class' => '',
		'sidebar' => '',
		'filter' => false,
		'filter_value' => false,
		'filter_id' => false,
		//'page_shell' => 'walled_garden',
	]
	, 'default'
	);
}