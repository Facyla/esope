<?php

namespace ColdTrick\LoginByEmail\Menus;

use Elgg\Menu\MenuItems;

/**
 * Make changes to the login menu
 */
class Login {
	
	/**
	 * Remove the password reset item from the menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:login'
	 *
	 * @return null|MenuItems
	 */
	public static function removePasswordReset(\Elgg\Event $event): ?MenuItems {
		if (!(bool) elgg_get_plugin_setting('disable_classic_login', 'login_by_email')) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result->remove('forgotpassword');
		
		return $result;
	}
	
	/**
	 * Register menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:login'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (str_starts_with(elgg_get_current_route_name(), 'default:login_by_email')) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'request_link',
			'text' => elgg_echo('login_by_email:menu:login:new_request'),
			'href' => elgg_generate_url('default:login_by_email:request_link'),
		]);
		
		return $result;
	}
}
