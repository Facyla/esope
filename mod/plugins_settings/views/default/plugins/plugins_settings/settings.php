<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));


echo '<p>Pour exporter la configuration de tous les plugins, utilisez la page suivante :</p>';
echo '<p><a href="' . elgg_get_site_url() . 'plugins_settings">' . elgg_get_site_url() . 'plugins_settings</a></p>';

// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


// Example text setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/text', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


