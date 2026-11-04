<?php

namespace ColdTrick\LoginByEmail\Middleware;

use Elgg\Exceptions\Http\PageNotFoundException;
use Elgg\Request;

/**
 * Middleware to prevent classic login
 */
class PreventClassicLogin {
	
	/**
	 * @param Request $request Request
	 *
	 * @return void
	 * @throws PageNotFoundException
	 */
	public function __invoke(Request $request): void {
		if (!(bool) elgg_get_plugin_setting('disable_classic_login', 'login_by_email')) {
			return;
		}
		
		throw new PageNotFoundException();
	}
}
