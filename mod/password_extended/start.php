<?php
elgg_register_event_handler('init', 'system', 'password_extended_init');

/**
 * password_extended_init
 */
function password_extended_init(){
    resetUserSettingsPage();

    elgg_extend_view('css/elgg', 'password_extended/css');

    $js_url = elgg_get_site_url() . 'mod/password_extended/views/default/js/passchecker.js';
    elgg_register_js('elgg.password_extended', $js_url);

    elgg_register_library('elgg:blog', elgg_get_plugins_path() . 'blog/lib/blog.php');

    elgg_register_library('elgg:functions', elgg_get_plugins_path() . 'password_extended/lib/functions.php');
    elgg_register_library('elgg:validation', elgg_get_plugins_path() . 'password_extended/lib/validation.php');
    elgg_register_library('elgg:stringhelper', elgg_get_plugins_path() . 'password_extended/lib/stringhelper.php');

    elgg_register_page_handler('password_extended', 'password_extended_handler');
    elgg_register_entity_type('object', 'password_extended');

    //elgg_register_page_handler('register', 'password_extended_handler');

    elgg_extend_view('register/extend', 'mod/register_new', 100);

    /* load actions before hooks */
    $action_url = elgg_get_plugins_path() . 'password_extended/actions/';
    elgg_register_action('renew_password', $action_url . 'renew_password.php');

    /* Hook settings */
    elgg_extend_view('forms/account/settings', 'mod/form_password', 100);
    elgg_register_plugin_hook_handler('usersettings:save', 'all', 'password_extended_check_passwords');

    /* Hook login */
    elgg_register_plugin_hook_handler("action", "login", "password_extended_check_passwords",200);

    /* Hook register */
    elgg_register_plugin_hook_handler("action", "register", "password_extended_check_passwords");
}

/**
 * @param $hook
 * @param $type
 * @param $value
 * @param $params
 * @return bool
 */
function password_extended_check_passwords($hook, $type, $value, $params)
{
    $setting = [];
    elgg_load_js('elgg.password_extended');
    elgg_load_library('elgg:functions');
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

    $password = get_input('password');
    $password2 = get_input('password2');

    if ($type == 'user') {
        if ( $password !== $password2 ) {
            register_error(elgg_echo('password_extended:password:compare'));
            return false;
        }

        if($password =='') {
            return false;
        }else{
            if (!$validator->isValid($password)) {
                register_error(elgg_echo('password_extended:password1:failed'));
                forward(REFERER);
            }
        }

        if($password2 =='') {
            return false;
        }else{
            if (!$validator->isValid($password2)) {
                register_error(elgg_echo('password_extended:password2:failed'));
                forward(REFERER);
            }
        }
        /* Old password should be valid case of currently invalid password
        if ( !$validator->isValid($current_password) ) {
            register_error(elgg_echo('password_extended:current_password:failed'));
            forward(REFERER);
        }
        */
        return true;
    }

    if ($type == 'register') {
        if ( $password !== $password2 ) {
            register_error(elgg_echo('password_extended:password:compare'));
            return false;
        }
        if ( !$validator->isValid($password) ) {
            register_error(elgg_echo('password_extended:password1:failed1'));
            return false;
        }
        if ( !$validator->isValid($password2) ) {
            register_error(elgg_echo('password_extended:password2:failed2'));
            return false;
        }
        return true;
    }

    if ($type == 'login') {
        if ( ! $validator->isValid($password) ) {
            if(!user_login(get_input('username'), get_input('password'))){
                return false;
            }else {
                register_error(elgg_echo('password_extended:login:strict'));
                $pages = __DIR__ . '/pages/password_extended';
                include $pages . '/password.php';
                exit();
            }
        }
        return true;
    }

    // always return false;
    return false;
}

/**
 * Reset view settings/user
 */
function resetUserSettingsPage(){
    //elgg_unextend_view('forms/account/settings', 'core/settings/account/name', 100);  //Display name
    //elgg_unextend_view('forms/account/settings', 'core/settings/account/email', 100);   //Email
    //elgg_unextend_view('forms/account/settings', 'core/settings/account/language', 100);  //Language

    elgg_unextend_view('forms/account/settings', 'core/settings/account/password', 100);  //Password

}

/**
 * Event: page setup system
 * Register a new admin menu for appearance
 * @param $page
 * @return bool
 */
function password_extended_handler($page) {
    $pages = __DIR__ . '/pages/password_extended';

    switch ($page[0]) {
        case 'completed':
            include $pages . '/completed.php';
            break;
        case 'register':
            include $pages . '/register.php';
            break;
        default:
            include $pages . '/register.php';
            break;
    }
    return true;
}
