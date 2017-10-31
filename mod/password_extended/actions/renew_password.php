<?php

gatekeeper();
$guid = get_input('guid');

$entity = get_entity($guid);
$user = get_user($entity->getGUID());

if (elgg_instanceof($user, 'object', 'user')) {
    register_error($result);
    forward('password_extended');
}

$password_current = get_input('oldpassword');
$password_new = get_input('password');
$password_retype = get_input('password2');

$result = elgg_authenticate($user->username, $password_current);
if ( $result !== true ) {
    register_error($result);
    forward('password_extended');
}

if($password_new !== $password_retype){
    register_error($result);
    forward('password_extended');
}

elgg_load_library('elgg:validation');
elgg_load_library('elgg:stringhelper');

$validator = new Validator(new StringHelper);
$use_symbols_value = elgg_get_plugin_setting('use_symbols_value','password_extended');
$use_numbers_value = elgg_get_plugin_setting('use_numbers_value','password_extended');
$use_lowercase_value = elgg_get_plugin_setting('use_lowercase_value','password_extended');
$use_uppercase_value = elgg_get_plugin_setting('use_uppercase_value','password_extended');
$password_min_lenght_value = elgg_get_plugin_setting('password_min_lenght_value','password_extended');
$password_max_lenght_value = elgg_get_plugin_setting('password_max_lenght_value','password_extended');

$setting['minSymbols'] = elgg_get_plugin_setting('use_symbols','password_extended');
$setting['minNumbers'] = elgg_get_plugin_setting('use_numbers','password_extended');
$setting['minLowerCaseLetters'] = elgg_get_plugin_setting('use_lowercase','password_extended');
$setting['minUpperCaseLetters'] = elgg_get_plugin_setting('use_uppercase','password_extended');
$setting['minLength'] = elgg_get_plugin_setting('password_lenght_min','password_extended');
$setting['maxLength'] = elgg_get_plugin_setting('max_lenght_password','password_extended');
$setting['expired'] = elgg_get_plugin_setting('expired_password');

$validator->setSettings($setting);
$validator->setMinLength($password_min_lenght_value);
$validator->setMaxLength($password_max_lenght_value);
$validator->setMinLowerCaseLetters($use_lowercase_value);
$validator->setMinUpperCaseLetters($use_uppercase_value);
$validator->setMinNumbers($use_numbers_value);
$validator->setMinSymbols($use_symbols_value);

if ( !$validator->isValid($password_new) ) {
    register_error(elgg_echo('password_extended:password:failed'));
    forward('password_extended');
}

if ( ($entity instanceof ElggUser) && ($entity->canEdit()) ) {
// Rehash the password etc and set it
//execute_new_password_request();
    if ( force_user_password_reset($entity->guid, $password_new) ) {
        system_message(elgg_echo('password_extended:successfully'));
    }
    else {
        system_message(elgg_echo('password_extended:failed'));
    }
}

// Send to completed page
forward('password_extended/completed');
