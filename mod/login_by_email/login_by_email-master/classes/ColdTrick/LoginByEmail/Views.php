<?php

namespace ColdTrick\LoginByEmail;

use Elgg\ViewsService;

/**
 * Changes to views
 */
class Views {
	
	/**
	 * Prevent the contents of the classic login form
	 *
	 * @param \Elgg\Event $event 'view_vars', 'forms/login'
	 *
	 * @return array|null
	 */
	public static function preventClassicLoginForm(\Elgg\Event $event): ?array {
		if (!(bool) elgg_get_plugin_setting('disable_classic_login', 'login_by_email')) {
			return null;
		}
		
		$vars = $event->getValue();
		
		$vars[ViewsService::OUTPUT_KEY] = elgg_view_menu('login');
		
		return $vars;
	}
}
