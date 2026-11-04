<?php

namespace ColdTrick\LoginByEmail;

/**
 * Listen to login events
 */
class Login {
	
	/**
	 * Cleanup session params on successful login
	 *
	 * @param \Elgg\Event $event 'login:after', 'user'
	 *
	 * @return void
	 */
	public static function cleanUp(\Elgg\Event $event): void {
		$session = elgg_get_session();
		
		$session->remove('login_by_email_code');
		$session->remove('login_by_email_code_expires');
		$session->remove('login_by_email_referer');
		$session->remove('login_by_email_user_guid');
	}
}
