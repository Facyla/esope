<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('owncloud:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('owncloud:settings:settingname:details'). '</em></p>';


// Owncloud API URL
echo '<p><label>' . elgg_echo('owncloud:settings:api_url'). ' ' . elgg_view('input/text', array('name' => 'params[api_url]', 'value' => $vars['entity']->api_url)) . '</label><br /><em>' . elgg_echo('owncloud:settings:api_url:details'). '</em></p>';

// API shares path
echo '<p><label>' . elgg_echo('owncloud:settings:api_shares'). ' ' . elgg_view('input/text', array('name' => 'params[api_shares]', 'value' => $vars['entity']->api_shares)) . '</label><br /><em>' . elgg_echo('owncloud:settings:api_shares:details'). '</em></p>';

https://nas.sfprojex.net/owncloud/ocs/v1.php/apps/files_sharing/api/v1/shares

// Owncloud admin username
echo '<p><label>' . elgg_echo('owncloud:settings:username'). ' ' . elgg_view('input/text', array('name' => 'params[username]', 'value' => $vars['entity']->username)) . '</label><br /><em>' . elgg_echo('owncloud:settings:username:details'). '</em></p>';

// Admin password
echo '<p><label>' . elgg_echo('owncloud:settings:password'). ' ' . elgg_view('input/text', array('name' => 'params[password]', 'value' => $vars['entity']->password)) . '</label><br /><em>' . elgg_echo('owncloud:settings:password:details'). '</em></p>';


