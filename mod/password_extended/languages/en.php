<?php

$english = [

    // Plugin settings password
    'password_extended' => 'profile extended',
    'password_extended:settings' => 'Password policy',
    'password_extended:settings:use_symbols' => 'Include Symbols:',
    'password_extended:settings:use_symbols_value' => 'Contains a minimum of symbols:',
    'password_extended:settings:use_numbers' => 'Include Numbers:',
    'password_extended:settings:use_numbers_value' => 'Contains a minimum of numbers:',
    'password_extended:settings:use_lowercase' => 'Include Lowercase Characters:',
    'password_extended:settings:use_lowercase_value' => 'Contains a minimum of lowercase chars:',
    'password_extended:settings:use_uppercase' => 'Include Uppercase Characters:',
    'password_extended:settings:use_uppercase_value' => 'Contains a minimum of uppercase chars:',
    'password_extended:settings:password_min_lenght' => 'Password minimum length enabled:',
    'password_extended:settings:password_min_lenght_value' => 'Default value:',
    'password_extended:settings:password_max_lenght' => 'Password maximum length enabled:',
    'password_extended:settings:password_max_lenght_value' => '',
    'password_extended:settings:password_expired' => 'Enable password expired date',

    'password_extended:login:strict' => 'Please renew your current password',
    'password_extended:password1:failed' => 'Failure on new password: %s',
    'password_extended:password2:failed' => 'Failure on retyped password: %s',

    'password_extended:password:compare' => 'Mismatch passwords.',
    'password_extended:password1:failed' => 'failed on new password.',
    'password_extended:password2:failed' => 'failed on retyped password.',

    /* register user */

    'password_extended:register:password' => '[Wachtwoord]',
    'password_extended:register:password_retype' => '[Wachtwoord (nogmaals, voor de zekerheid)]',

    /* Requirements */
    'password_extended:requirements' => 'Password must meet the following requirements:',
    'password_extended:require:long' => '%s characters long.',
    'password_extended:require:numbers' => 'Minimun %s number.',
    'password_extended:require:symbols' => 'Minimun %s symbols.',
    'password_extended:require:lowercase' => 'Minimun %s chars lowercase.',
    'password_extended:require:uppercase' => 'Minimun %s chars uppcarcase.',

    // Plugin extended view settings/user
    'password_extended:renew_password' => 'Password renew',
    'password_extended:renew' => 'Renew',
    'password_extended:password_header' => '[Account wachtwoord]',
    'password_extended:current_password' => '[Huidige wachtwoord]',
    'password_extended:new_password' => '[Je nieuwe wachtwoord]',
    'password_extended:retype_password' => '[Nogmaals je nieuwe wachtwoord]',
    'password_extended:finished' => 'Password had been changed.',
    'password:finished_message' => 'Hello %s you have renewed your password thanks',
    'password_extended:successfully' => 'Succesfully changed.',
    'password_extended:failed' => 'Failed to change password.',
    /* scripts */
    'script:short'=>'Very Weak! (Must be %s or more chars)',
    'script:strong:very'=>'Very Strong! (Awesome, please don\'t forget your pass now!)',
    'script:strong'=>'Strong! (Enter special chars to make even stronger',
    'script:good'=>'Good! (Enter uppercase letter to make strong)',
    'script:weak'=>'Still Weak! (Enter digits to make good password',

    'script:mismatch'=> 'Passwords do not match!',
    'script:matched'=> 'Passwords match!',




];


add_translation("en",$english);