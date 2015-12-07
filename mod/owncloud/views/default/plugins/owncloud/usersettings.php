<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

$plugin = elgg_extract("entity", $vars);

$username = $plugin->getUserSetting("username", elgg_get_page_owner_guid());
$password = $plugin->getUserSetting("password", elgg_get_page_owner_guid());


// Set default value
//if (!isset($vars['entity']->settingname)) { $vars['entity']->settingname == 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';

// Owncloud username
echo '<p><label>' . elgg_echo('owncloud:settings:username'). ' ' . elgg_view('input/text', array('name' => 'params[username]', 'value' => $username)) . '</label><br /><em>' . elgg_echo('owncloud:settings:username:details'). '</em></p>';

// Password
echo '<p><label>' . elgg_echo('owncloud:settings:password'). ' ' . elgg_view('input/text', array('name' => 'params[password]', 'value' => $password)) . '</label><br /><em>' . elgg_echo('owncloud:settings:password:details'). '</em></p>';


