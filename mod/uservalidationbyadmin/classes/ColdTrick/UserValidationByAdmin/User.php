<?php

namespace ColdTrick\UserValidationByAdmin;

class User {
	
	/**
	 * Prevent the enabling of users from uservaildationbyemail
	 *
	 * @param string    $event the name of the event
	 * @param string    $type  the type of the event
	 * @param \ElggUser $user  the user being enabled
	 *
	 * @return void|false
	 */
	public static function enableUser($event, $type, $user) {
		
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		if (!elgg_in_context('uservalidationbyemail_validate_user')) {
			// not uservalidation by email
			return;
		}
		
		if (!isset($user->admin_validated)) {
			// user registered before this plugin was active
			return;
		}
		
		if ($user->admin_validated) {
			// user is validated
			return;
		}
		
		return false;
	}
}