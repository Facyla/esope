<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );


// Set default value
if (!isset($vars['entity']->user_plugin_setting)) { $vars['entity']->user_plugin_setting == 'default'; }


// Example yes/no setting
echo '<p><label>Test select setting "user_plugin_setting"</label> ' . elgg_view('input/dropdown', array('name' => 'params[user_plugin_setting]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->user_plugin_setting)) . '</p>';


// Example text setting
echo '<p><label>Text setting "user_plugin_setting2"</label> ' . elgg_view('input/dropdown', array('name' => 'params[user_plugin_setting2]', 'value' => $vars['entity']->user_plugin_setting2)) . '</p>';


