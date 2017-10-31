<?php
/**
 * Elgg login action
 *
 * @package Elgg.Core
 * @subpackage User.Authentication
 */
/**
 * @param $username
 * @param $password
 * @return bool
 */
function user_login($username = null , $password = null)
{

    $persistent = (bool)get_input("persistent");
    $result = false;
    if ( empty($username) || empty($password) ) {
        register_error(elgg_echo('login:empty'));
        forward();
    }
// check if logging in with email address
    if ( strpos($username, '@') !== false && ($users = get_user_by_email($username)) ) {
        $username = $users[0]->username;
    }
    $result = elgg_authenticate($username, $password);
    if ( $result !== true ) {
        register_error($result);
        forward(REFERER);
    }
    $user = get_user_by_username($username);
    if ( !$user ) {
        register_error(elgg_echo('login:baduser'));
        forward(REFERER);
    }
    try {
        login($user, $persistent);
        // re-register at least the core language file for users with language other than site default
        register_translations(dirname(dirname(__FILE__)) . "/languages/");
    }
    catch (LoginException $e) {
        register_error($e->getMessage());
        forward(REFERER);
    }
// elgg_echo() caches the language and does not provide a way to change the language.
// @todo we need to use the config object to store this so that the current language
// can be changed. Refs #4171
    if ( $user->language ) {
        $message = elgg_echo('loginok', array(), $user->language);
    }
    else {
        $message = elgg_echo('loginok');
    }

    return true;
}
