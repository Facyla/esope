<?php
/**
 * Elgg registration action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */

elgg_make_sticky_form('register');

if (elgg_get_config('allow_registration')) {
	// Get variables
	// Require email
	$email = get_input('email');
	$send_email = false;

	// Get or compute other fields
	$username = get_input('username');
	$name = get_input('name');
	if (strlen(trim($username)) < 4) {
		system_message('theme_transitions2:register:usernametooshort');
		$username = profile_manager_generate_username_from_email($email);
		$send_email = true;
	}
	if (empty($name)) { $name = $username; }

	// Get or compute password
	$password = get_input('password', null, false);
	if (strlen(trim($password) < 8)) {
		$password = generate_random_cleartext_password();
		$send_email = true;
	}

	$friend_guid = (int) get_input('friend_guid', 0);
	$invitecode = get_input('invitecode');
	
	try {
		$guid = register_user($username, $password, $name, $email);

		if ($guid) {
			$new_user = get_entity($guid);

			// allow plugins to respond to self registration
			// note: To catch all new users, even those created by an admin,
			// register for the create, user event instead.
			// only passing vars that aren't in ElggUser.
			$params = array(
				'user' => $new_user,
				'password' => $password,
				'friend_guid' => $friend_guid,
				'invitecode' => $invitecode
			);

			// @todo should registration be allowed no matter what the plugins return?
			if (!elgg_trigger_plugin_hook('register', 'user', $params, TRUE)) {
				$ia = elgg_set_ignore_access(true);
				$new_user->delete();
				elgg_set_ignore_access($ia);
				// @todo this is a generic messages. We could have plugins
				// throw a RegistrationException, but that is very odd
				// for the plugin hooks system.
				throw new RegistrationException(elgg_echo('registerbad'));
			}
			
			// @TODO Send password and other useful information
			if ($send_email) {
				$subject = elgg_echo('theme_transitions2:register:subject', array(), $new_user->language);
				$body = elgg_echo('theme_transitions2:register:body', array(
					$name,
					elgg_get_site_entity()->name,
					elgg_get_site_entity()->url,
					$username,
					$password,
				), $new_user->language);
				notify_user($new_user->guid, elgg_get_site_entity()->guid, $subject, $body);
			}
			elgg_clear_sticky_form('register');

			if ($new_user->enabled == "yes") {
				system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));

				// if exception thrown, this probably means there is a validation
				// plugin that has disabled the user
				try {
					login($new_user);
				} catch (LoginException $e) {
					// do nothing
				}
			}

			// Forward on success, assume everything else is an error...
			forward();
		} else {
			register_error(elgg_echo("registerbad"));
		}
	} catch (RegistrationException $r) {
		register_error($r->getMessage());
	}
} else {
	register_error(elgg_echo('registerdisabled'));
}

forward(REFERER);

