<?php
$url = elgg_get_site_url();

// Define dropdown options
//$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('recaptcha:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';

echo '<a href="https://www.google.com/recaptcha/admin#createsite">' . elgg_echo('recaptcha:settings:createapikey'). '</a>';

// API public key
echo '<p><label>' . elgg_echo('recaptcha:settings:publickey'). ' ' . elgg_view('input/text', array('name' => 'params[publickey]', 'value' => $vars['entity']->publickey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:publickey:details'). '</em></p>';

// API secret key
echo '<p><label>' . elgg_echo('recaptcha:settings:secretkey'). ' ' . elgg_view('input/text', array('name' => 'params[secretkey]', 'value' => $vars['entity']->secretkey)) . '</label><br /><em>' . elgg_echo('recaptcha:settings:secretkey:details'). '</em></p>';


