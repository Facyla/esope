<?php

use Elgg\Exceptions\Http\LoginException;

$code = (int) get_input('code');
$persistent = (bool) get_input('persistent');
if (empty($code)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$session = elgg_get_session();
if (!$session->has('login_by_email_code') || !$session->has('login_by_email_user_guid')) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function () use ($session) {
	return get_user($session->get('login_by_email_user_guid'));
});
if (!$user instanceof \ElggUser) {
	return elgg_error_response(elgg_echo('login:baduser'));
}

if (elgg_is_authentication_failure_limit_reached($user)) {
	return elgg_error_response(elgg_echo('LoginException:AccountLocked'));
}

$code = str_pad((string) $code, 6, '0', STR_PAD_LEFT);
if ($code !== $session->get('login_by_email_code')) {
	elgg_register_authentication_failure($user);
	return elgg_error_response(elgg_echo('login_by_email:action:code:error:code'));
}

if ((int) $session->get('login_by_email_code_expires') < time()) {
	elgg_register_authentication_failure($user);
	return elgg_error_response(elgg_echo('login_by_email:action:code:error:code_expired'), elgg_generate_url('account:login'));
}

$forward = '';
if ($session->has('login_by_email_referer')) {
	$forward = (string) $session->get('login_by_email_referer');
}

try {
	elgg_login($user, $persistent);
} catch (LoginException $e) {
	return elgg_error_response($e->getMessage());
}

$message = elgg_echo('loginok', [], $user->getLanguage(elgg_get_current_language()));
return elgg_ok_response('', $message, $forward);
