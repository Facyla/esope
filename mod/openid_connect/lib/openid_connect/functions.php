<?php
/**
 * OpenID Connect helper functions.
 */

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
		$username = str_pad($username, $min_length, 0);
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