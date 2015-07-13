<?php

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

echo '<p><label>' . elgg_echo('theme_transitions2:usersettings:public_profile') . ' ' . elgg_view('input/dropdown', array('name' => 'params[public_profile]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->public_profile)) . '</label></p>';

echo '<p><label>' . elgg_echo('theme_transitions2:usersettings:block_messages') . ' ' . elgg_view('input/dropdown', array('name' => 'params[block_messages]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->block_messages)) . '</label></em></p>';


