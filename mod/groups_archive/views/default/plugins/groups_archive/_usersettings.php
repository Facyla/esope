<?php

$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );


// Set default value
//if (!isset($vars['entity']->settingname)) { $vars['entity']->settingname == 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


// Example text setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


