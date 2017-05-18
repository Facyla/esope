<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

$algorithm_opt = default_icons_get_algorithms();
$num_opt = ['2' => '2', '3' => '3', '4' => '4', '5' => '5'];


// Set to default values
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }
if (!isset($vars['entity']->default_user_alg)) { $vars['entity']->default_group_alg = 'ringicon'; }
if (!isset($vars['entity']->default_group_alg)) { $vars['entity']->default_group_alg = 'ideinticon'; }


echo '<fieldset><legend>' . elgg_echo('main') . '</legend>';
	// Background color
	echo '<p><label>' . elgg_echo('default_icons:settings:background'). ' ' . elgg_view('input/text', array('name' => 'params[background]', 'value' => $vars['entity']->background)) . '</label><br /><em>' . elgg_echo('default_icons:settings:background:details'). '</em></p>';
echo '</fieldset>';


echo '<fieldset><legend>' . elgg_echo('user') . '</legend>';
	// Replace default user icons ?
	echo '<p><label>' . elgg_echo('default_icons:settings:default_user'). ' ' . elgg_view('input/select', array('name' => 'params[default_user]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->default_user)) . '</label><br /><em>' . elgg_echo('default_icons:settings:default_user:details'). '</em></p>';

	// Algorithm for default user entities
	echo '<p><label>' . elgg_echo('default_icons:settings:default_user_alg'). ' ' . elgg_view('input/select', array('name' => 'params[default_user_alg]', 'options_values' => $algorithm_opt, 'value' => $vars['entity']->default_user_alg)) . '</label><br /><em>' . elgg_echo('default_icons:settings:default_user_alg:details'). '</em></p>';
echo '</fieldset>';



echo '<fieldset><legend>' . elgg_echo('group') . '</legend>';
	// Replace default group icons ?
	echo '<p><label>' . elgg_echo('default_icons:settings:default_group'). ' ' . elgg_view('input/select', array('name' => 'params[default_group]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->default_group)) . '</label><br /><em>' . elgg_echo('default_icons:settings:default_group:details'). '</em></p>';

	// Algorithm for default group entities
	echo '<p><label>' . elgg_echo('default_icons:settings:default_group_alg'). ' ' . elgg_view('input/select', array('name' => 'params[default_group_alg]', 'options_values' => $algorithm_opt, 'value' => $vars['entity']->default_group_alg)) . '</label><br /><em>' . elgg_echo('default_icons:settings:default_group_alg:details'). '</em></p>';
echo '</fieldset>';

