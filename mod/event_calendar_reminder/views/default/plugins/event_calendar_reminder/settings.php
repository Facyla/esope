<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

// Set default values
if (!isset($vars['entity']->usersettings)) { $vars['entity']->usersettings = 'no'; }
if (!isset($vars['entity']->reminder_days)) { $vars['entity']->reminder_days = '1,3,7'; }


// Enable usersettings
echo '<p><label>Enable user settings (disable reminders) ' . elgg_view('input/dropdown', array('name' => 'params[usersettings]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->usersettings)) . '</label></p>';

// Reminders days : 1, 3, 7
echo '<p><label>Reminders (eg. 1,3,7) ' . elgg_view('input/text', array('name' => 'params[reminder_days]', 'value' => $vars['entity']->reminder_days)) . '</label></p>';


