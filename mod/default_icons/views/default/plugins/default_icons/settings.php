<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

$algorithm_opt = default_icons_get_algorithms();
$num_opt = ['2' => '2', '3' => '3', '4' => '4', '5' => '5'];


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Replace default user icons ?
echo '<p><label>' . elgg_echo('default_icons:settings:default_user'). ' ' . elgg_view('input/select', array('name' => 'params[default_user]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->default_user)) . '</label><br /><em>' . elgg_echo('default_icons:settings:default_user:details'). '</em></p>';

// Algorithm for default user entities
echo '<p><label>' . elgg_echo('default_icons:settings:default_user_alg'). ' ' . elgg_view('input/select', array('name' => 'params[default_user_alg]', 'options_values' => $algorithm_opt, 'value' => $vars['entity']->default_user_alg)) . '</label><br /><em>' . elgg_echo('default_icons:settings:default_user_alg:details'). '</em></p>';


