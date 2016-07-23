<?php

echo '<a href="https://www.google.com/recaptcha/admin#createsite">' . elgg_echo('recaptcha:settings:createapikey'). '</a>';

// API public key
echo '<p><label>' . elgg_echo('recaptcha:settings:publickey'). ' ' . elgg_view('input/text', array('name' => 'params[publickey]', 'value' => $vars['entity']->publickey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:publickey:details'). '</em></p>';

// API secret key
echo '<p><label>' . elgg_echo('recaptcha:settings:secretkey'). ' ' . elgg_view('input/text', array('name' => 'params[secretkey]', 'value' => $vars['entity']->secretkey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:secretkey:details'). '</em></p>';


