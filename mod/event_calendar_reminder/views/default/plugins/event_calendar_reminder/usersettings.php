<?php

$reminder_days = elgg_get_plugin_setting('reminder_days', 'event_calendar_reminder');
$reminder_days = explode(',', $reminder_days);
$reminder_days = implode(', ', $reminder_days);

echo '<p>' . elgg_echo('event_calendar_reminder:usersettings:reminder_days', array($reminder_days)) . '</p>';

$enable_usersettings = elgg_get_plugin_setting('enable_usersettings', 'event_calendar_reminder');
if ($enable_usersettings == 'yes') {
	
	// Define dropdown options
	$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

	// Set default values
	if (!isset($vars['entity']->block_reminder)) { $vars['entity']->block_reminder = 'no'; }
	
	// Enable usersettings
	echo '<p><label>' . elgg_echo('event_calendar_reminder:usersettings:block_reminder') . ' ' . elgg_view('input/dropdown', array('name' => 'params[block_reminder]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->block_reminder)) . '</label></p>';
	
}

