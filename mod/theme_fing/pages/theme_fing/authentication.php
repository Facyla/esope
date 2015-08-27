<?php
/**
 * Elgg external login action
 *
 */

// Accepts username/password params and logins from remote site + returns a validity response

$username = get_input('username');
$password = get_input('password', null, false);
$persistent = (bool) get_input("persistent");
$result = false;
$message = '';

if (empty($username) || empty($password)) {
	$message = elgg_echo('login:empty');
	echo json_encode(array('result' => 0, 'message' => $message));
	exit;
}

// check if logging in with email address
if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
	$username = $users[0]->username;
}

$result = elgg_authenticate($username, $password);
if ($result !== true) {
	$message = $result;
	echo json_encode(array('result' => 0, 'message' => $message));
	exit;
}

$user = get_user_by_username($username);
if (!$user) {
	$message = elgg_echo('login:baduser');
	echo json_encode(array('result' => 0, 'message' => $message));
	exit;
}

try {
	//login($user, $persistent);
	// re-register at least the core language file for users with language other than site default
	register_translations(dirname(dirname(__FILE__)) . "/languages/");
} catch (LoginException $e) {
	$message = $e->getMessage();
	echo json_encode(array('result' => 0, 'message' => $message));
	exit;
}

// elgg_echo() caches the language and does not provide a way to change the language.
// @todo we need to use the config object to store this so that the current language
// can be changed. Refs #4171
if ($user->language) {
	$message = elgg_echo('loginok', array(), $user->language);
} else {
	$message = elgg_echo('loginok');
}

if (isset($_SESSION['last_forward_from'])) {
	unset($_SESSION['last_forward_from']);
}


echo json_encode(array(
		'result' => 1, 
		'message' => $message,
		'user' => print_r($user),
	));
exit;


