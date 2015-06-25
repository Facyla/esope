<?php
// Define dropdown options
$yes_no_opt = array('none' => elgg_echo('prevent_notifications:none'), 'yes' => elgg_echo('prevent_notifications:yes'), 'no' => elgg_echo('prevent_notifications:no'));

// Set default value for notifications
echo '<p><label>' . elgg_echo('prevent_notifications:settings:notification_default'). ' ' . elgg_view('input/dropdown', array('name' => 'params[notification_default]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->notification_default)) . '</label><br /><em>' . elgg_echo('prevent_notifications:settings:notification_default:details'). '</em></p>';

