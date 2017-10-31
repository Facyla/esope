<?php

$dutch = [

    // Plugin settings password
    'password_extended' => 'Wachtwoord extentie',
    'password_extended:settings' => 'Wachtwoord policy',
    'password_extended:settings:use_symbols' => 'Inclusief speciale tekens:',
    'password_extended:settings:use_symbols_value' => 'Bevat speciale tekens:',
    'password_extended:settings:use_numbers' => 'Inclusief nummers:',
    'password_extended:settings:use_numbers_value' => 'Bevat aantal nummers:',
    'password_extended:settings:use_lowercase' => 'Inclusief kleine letters:',
    'password_extended:settings:use_lowercase_value' => 'Bevat aantal kleine letters:',
    'password_extended:settings:use_uppercase' => 'Inclusief hoofdletters:',
    'password_extended:settings:use_uppercase_value' => 'Bevat aantal hoofdletters:',
    'password_extended:settings:password_min_lenght' => 'Wachtwoord lengte aanzetten:',
    'password_extended:settings:password_min_lenght_value' => 'Standaardwaarde:',
    'password_extended:settings:password_max_lenght' => 'Wachtwoord maximale lengte aanzetten:',
    'password_extended:settings:password_max_lenght_value' => '',
    'password_extended:settings:password_expired' => 'Aanzetten wachtwoord verlopen datum',

    'password_extended:login:strict' => 'Alstublief vernieuw uw huidige wachtwoord',
    'password_extended:password1:failed' => 'Fout in nieuwe wachtwoord: %s',
    'password_extended:password2:failed' => 'Fout in herhaald wachtwoord: %s',

    'password_extended:password:compare' => 'Ongelijke wachtworden.',
    'password_extended:password1:failed' => 'Fout in nieuwe wachtwoord.',
    'password_extended:password2:failed' => 'Fout in herhaald wachtwoord.',

    /* register user */

    'password_extended:register:password' => 'Wachtwoord',
    'password_extended:register:password_retype' => 'Wachtwoord (nogmaals, voor de zekerheid)',

    /* Requirements */
    'password_extended:requirements' => 'Voldoe aan deze criteria:',
    'password_extended:require:long' => '<b>%s</b> karakters lang.',
    'password_extended:require:numbers' => 'Minimaal <b>%s</b> nummer.',
    'password_extended:require:symbols' => 'Minimaal <b>%s</b> symbool.',
    'password_extended:require:lowercase' => 'Minimaal <b>%s</b> letter.',
    'password_extended:require:uppercase' => 'Minimaal <b>%s</b> hoofdletter.',

    // Plugin extended view settings/user
    'password_extended:renew_password' => 'Wachtwoord vernieuwen',
    'password_extended:renew' => 'Nieuwe wachtwoord opslaan',
    'password_extended:password_header' => 'Account wachtwoord *',
    'password_extended:current_password' => 'Huidige wachtwoord *',
    'password_extended:new_password' => 'Uw nieuwe wachtwoord *',
    'password_extended:retype_password' => 'Voer nogmaals uw nieuwe wachtwoord in *',
    'password_extended:finished' => 'Uw wachtwoord is aangepast.',
    'password:finished_message' => 'Beste %s, uw wachtwoord is succesvol aangepast.',
    'password_extended:successfully' => 'Succesvol vernieuwd.',
    'password_extended:failed' => 'Mislukt wachtwoord te wijzigen.',
    /* scripts */
    'script:short'=>'Zwak! (Minimaal %s of meer chars)',
    'script:strong:very'=>'Zeer goed!',
    'script:strong'=>'Beter! Voeg speciale tekens om het nog sterker te maken',
    'script:good'=>'Goed! Voeg een hoofdletter toe om je wachtwoord nog sterker te maken)',
    'script:weak'=>'Nog steeds zwak! (Voer cijfers om een goed wachtwoord te maken',

    'script:mismatch'=> 'Wachtwoorden komen niet overeen!',
    'script:matched'=> 'Wachtwoorden komen overeen!',

    /* Fixes */
    'email:settings' => "E-mailinstellingen",
    'user:set:language' => "Taalinstelling",
    'email' => "E-mailadres",

];


add_translation("nl",$dutch);
