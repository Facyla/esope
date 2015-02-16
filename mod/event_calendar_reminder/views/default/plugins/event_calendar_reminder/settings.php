<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

// Set default values
if (!isset($vars['entity']->usersettings)) { $vars['entity']->enable_usersettings = 'no'; }
if (!isset($vars['entity']->reminder_days)) { $vars['entity']->reminder_days = '1,3,7'; }


// Enable usersettings
echo '<p><label>' . elgg_echo('event_calendar_reminder:setting:usersettings') . ' ' . elgg_view('input/dropdown', array('name' => 'params[enable_usersettings]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->enable_usersettings)) . '</label></p>';

// Reminders days : 1, 3, 7
echo '<p><label>' . elgg_echo('event_calendar_reminder:setting:reminder_days') . ' ' . elgg_view('input/text', array('name' => 'params[reminder_days]', 'value' => $vars['entity']->reminder_days)) . '</label></p>';


