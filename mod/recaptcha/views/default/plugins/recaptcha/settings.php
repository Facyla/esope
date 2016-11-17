<?php

echo '<a href="https://www.google.com/recaptcha/admin#createsite">' . elgg_echo('recaptcha:settings:createapikey'). '</a>';

// API public key
echo '<p><label>' . elgg_echo('recaptcha:settings:publickey'). ' ' . elgg_view('input/text', array('name' => 'params[publickey]', 'value' => $vars['entity']->publickey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:publickey:details'). '</em></p>';

// API secret key
echo '<p><label>' . elgg_echo('recaptcha:settings:secretkey'). ' ' . elgg_view('input/text', array('name' => 'params[secretkey]', 'value' => $vars['entity']->secretkey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:secretkey:details'). '</em></p>';


// Optional parameters
// Theme : light|dark
echo '<p><label>' . elgg_echo('recaptcha:settings:theme'). ' ' . elgg_view('input/text', array('name' => 'params[theme]', 'value' => $vars['entity']->theme)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:theme:details'). '</em></p>';

// Size : light|dark
echo '<p><label>' . elgg_echo('recaptcha:settings:size'). ' ' . elgg_view('input/text', array('name' => 'params[size]', 'value' => $vars['entity']->size)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:size:details'). '</em></p>';

// Type : light|dark
echo '<p><label>' . elgg_echo('recaptcha:settings:type'). ' ' . elgg_view('input/text', array('name' => 'params[type]', 'value' => $vars['entity']->type)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:type:details'). '</em></p>';


