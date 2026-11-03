<?php

namespace ColdTrick\LoginByEmail\Controllers;

use Elgg\Exceptions\Http\LoginException;
use Elgg\Http\ResponseBuilder;

/**
 * Handle requests to the login_by_email/confirm URL
 */
class Confirm {
	
	/**
	 * Handle the HTTP request
	 *
	 * @param \Elgg\Request $request the HTTP request
	 *
	 * @return ResponseBuilder
	 */
	public function __invoke(\Elgg\Request $request): ResponseBuilder {
		$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($request) {
			return $request->getEntityParam();
		});
		if (!$user instanceof \ElggUser) {
			return elgg_error_response(elgg_echo('login:baduser'));
		}
		
		if (elgg_is_authentication_failure_limit_reached($user)) {
			return elgg_error_response(elgg_echo('LoginException:AccountLocked'));
		}
		
		try {
			elgg_login($user);
		} catch (LoginException $e) {
			return elgg_error_response($e->getMessage());
		}
		
		$message = elgg_echo('loginok', [], $user->getLanguage(elgg_get_current_language()));
		return elgg_ok_response('', $message, (string) $request->getParam('r'));
	}
}
