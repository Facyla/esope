<?php

echo '<a href="https://www.google.com/recaptcha/admin#createsite">' . elgg_echo('recaptcha:settings:createapikey'). '</a>';

// API public key
echo '<p><label>' . elgg_echo('recaptcha:settings:publickey'). ' ' . elgg_view('input/text', array('name' => 'params[publickey]', 'value' => $vars['entity']->publickey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:publickey:details'). '</em></p>';

// API secret key
echo '<p><label>' . elgg_echo('recaptcha:settings:secretkey'). ' ' . elgg_view('input/text', array('name' => 'params[secretkey]', 'value' => $vars['entity']->secretkey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:secretkey:details'). '</em></p>';


// Optional parameters
// Theme: light|dark
echo '<p><label>' . elgg_echo('recaptcha:settings:theme'). ' ' . elgg_view('input/text', array('name' => 'params[theme]', 'value' => $vars['entity']->theme)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:theme:details'). '</em></p>';

// Size: light|dark
echo '<p><label>' . elgg_echo('recaptcha:settings:size'). ' ' . elgg_view('input/text', array('name' => 'params[size]', 'value' => $vars['entity']->size)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:size:details'). '</em></p>';

// Challenge type: image|audio
echo '<p><label>' . elgg_echo('recaptcha:settings:challenge_type'). ' ' . elgg_view('input/text', array('name' => 'params[challenge_type]', 'value' => $vars['entity']->challenge_type)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:challenge_type:details'). '</em></p>';


// Advanced option: optional source domain
$recaptcha_urls_opts = recaptcha_get_valid_urls();
echo '<p><label>' . elgg_echo('recaptcha:settings:recaptcha_url'). ' ' . elgg_view('input/select', array('name' => 'params[recaptcha_url]', 'value' => $vars['entity']->recaptcha_url, 'options_values' => $recaptcha_urls_opts)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:recaptcha_url:details'). '</em></p>';


