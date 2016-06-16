<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

$plugin = elgg_extract("entity", $vars);

$settingname = $plugin->getUserSetting("settingname", elgg_get_page_owner_guid());


// Set default value


// Example yes/no setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


// Example text setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'value' => $settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


