<?php
/**
 * OpenID Connect helper functions.
 */

use Psr\Log\LogLevel;

// Generate username from email - based on Coldtrick's ProfileManager's Users class
function openid_connect_generate_username_from_email($email) {
	if (empty($email) || !elgg()->accounts->isValidEmail($email)) {
		return false;
	}

	list($username) = explode('@', $email);

	// strip unsupported chars from the username
	// using same blacklist as in validate_username() function
	// not using a preg_replace as otherwise the hook can not be used (as the syntax is different)
	$blacklist = '\'/\\"*& ?#%^(){}[]~?<>;|¬`@+=';
	// Elgg 7: elgg_trigger_plugin_hook() is removed, use the events service instead
	$blacklist = elgg()->events->triggerResults('username:character_blacklist', 'user', ['blacklist' => $blacklist], $blacklist);
	$blacklist = str_split($blacklist);

	foreach ($blacklist as $unwanted_character) {
		$username = str_replace($unwanted_character, '', $username);
	}

	// check if minimal length is matched
	$min_length = elgg_get_config('minusername') ?: 4;
	if ($min_length) {
		$username = str_pad($username, (int) $min_length, '0');
	}

	// show hidden entities (unvalidated users)
	// Elgg 7: access_show_hidden_entities() is removed, use elgg_call() with ELGG_SHOW_DISABLED_ENTITIES
	$original_username = $username;

	$i = 1;
	elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use (&$username, $original_username, &$i) {
		while (elgg_get_user_by_username($username)) {
			$username = $original_username . $i;
			$i++;
		}
	});

	return $username;
}

/**
 * Redirect the current request to the given URL.
 *
 * Elgg 7 removed the global forward() function. This helper restores the
 * behaviour by throwing an HttpException with a redirect URL, which the Elgg
 * router turns into a redirect response. Throwing (rather than returning)
 * guarantees that no code runs after the redirect, matching the historical
 * forward() + exit semantics.
 *
 * @param string $url Target URL. Empty string redirects to the site root.
 */
function openid_connect_forward($url = '') {
	if ($url === '' || $url === REFERRER) {
		$url = elgg_get_site_url();
	}

	$ex = new \Elgg\Exceptions\HttpException();
	$ex->setRedirectUrl($url);
	throw $ex;
}

/**
 * Build the end_session endpoint URL for OIDC logout.
 *
 * L'end-point de déconnexion est lu dans la configuration découverte du
 * fournisseur ({endpoint}/.well-known/openid-configuration) conformément à la
 * spécification OIDC (RP-initiated logout, §4.2.1) ; à défaut (découverte
 * indisponible), repli sur le chemin standard du SSO {endpoint}/oauth2/logout.
 *
 * @param string $id_token The id_token to use as hint
 * @return string The complete end_session URL with query parameters
 */
function openid_connect_build_end_session_url(string $id_token): string {
	$endpoint = elgg_get_plugin_setting('endpoint', 'openid_connect');
	
	if (empty($endpoint)) {
		throw new \Exception('OpenID Connect endpoint not configured');
	}

	// End-point de déconnexion : l'extraire de la découverte du fournisseur si possible
	$end_session_url = '';
	try {
		$discovery = json_decode(@file_get_contents(rtrim($endpoint, '/') . '/.well-known/openid-configuration'), true);
		if (is_array($discovery) && !empty($discovery['end_session_endpoint'])) {
			$end_session_url = (string) $discovery['end_session_endpoint'];
		}
	} catch (\Exception $e) {
		$end_session_url = '';
	}

	// Repli : le chemin standard du SSO
	if ($end_session_url === '') {
		$end_session_url = rtrim($endpoint, '/') . '/oauth2/logout';
	}

	// Build post_logout_redirect_uri
	$post_logout_redirect_uri = elgg_get_site_url() . 'openid_connect/logged_out';

	// Build the complete URL with query parameters
	// Utiliser rawurlencode() pour préserver les points dans le JWT (RFC 3986)
	$query = 'id_token_hint=' . rawurlencode($id_token)
	       . '&post_logout_redirect_uri=' . rawurlencode($post_logout_redirect_uri);

	return $end_session_url . '?' . $query;
}

/**
 * Handler for the 'logout:after' event.
 * Implements RP-initiated logout for OpenID Connect users.
 *
 * @param \Elgg\Event $event The logout event
 * @return void
 */
function openid_connect_on_logout_after(\Elgg\Event $event): void {
	$user = $event->getObject();

	// Tolerance null : si pas d'utilisateur, on return (cas limite E10)
	if (!$user) {
		return;
	}

	// Vérifier que l'utilisateur est un utilisateur SSO
	// (marqueur posé dans login.php au moment du login OIDC)
	if ($user->login_source !== 'oidc_login') {
		// Logout local, pas d'OIDC à gérer
		return;
	}

	// Récupérer l'id_token stocké en metadata
	$id_token = $user->oidc_id_token;

	// Cas limite E1 : pas d'id_token stocké
	if (empty($id_token)) {
		elgg_log('OIDC logout: SSO user without stored id_token, skipping provider logout', LogLevel::NOTICE);
		return;
	}

	// Phase 4 : Révocation best-effort de l'access_token
	// + purge des metadata : ces opérations sont faillibles, on les wrappe
	$access_token = $user->oidc_access_token;
	$endpoint = elgg_get_plugin_setting('endpoint', 'openid_connect');
	$client_id = elgg_get_plugin_setting('client_id', 'openid_connect');
	$client_secret = elgg_get_plugin_setting('client_secret', 'openid_connect');

	try {
		if (!empty($access_token) && !empty($endpoint) && !empty($client_id) && !empty($client_secret)) {
			try {
				$oidc = new \Jumbojett\OpenIDConnectClient($endpoint, $client_id, $client_secret);
				$oidc->revokeToken($access_token, 'access_token');
			} catch (\Exception $e) {
				elgg_log('OIDC logout: revokeToken failed - ' . $e->getMessage(), LogLevel::NOTICE);
			}
		}

		// Purger les metadata OIDC avant la redirection
		$user->oidc_id_token = null;
		$user->oidc_sid = null;
		$user->oidc_access_token = null;
	} catch (\Exception $e) {
		elgg_log('OIDC logout: error during token revocation/metadata purge - ' . $e->getMessage(), LogLevel::ERROR);
		// On continue quand même vers la redirection provider (best-effort)
	}

	// Construire l'URL de logout provider
	// Cette ligne peut échouer si l'endpoint est mal configuré
	try {
		$end_session_url = openid_connect_build_end_session_url($id_token);
	} catch (\Exception $e) {
		elgg_log('OIDC logout: failed to build end_session URL - ' . $e->getMessage(), LogLevel::ERROR);
		return; // Ne pas rediriger si on ne peut pas construire l'URL
	}

	// Rediriger vers le provider.
	// openid_connect_forward() throw HttpException qui est converti en HTTP 302 par Elgg.
	// CET APPEL DOIT ÊTRE HORS DU TRY/CATCH pour que l'exception ne soit pas avalée.
	openid_connect_forward($end_session_url);
}
