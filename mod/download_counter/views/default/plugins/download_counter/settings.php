<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Set default value
if (!isset($vars['entity']->display_counter)) { $vars['entity']->display_counter = 'no'; }


// @TODO Display counter ?
echo '<p><label>' . elgg_echo('download_counter:setting:display_counter') . ' ' . elgg_view('input/dropdown', array('name' => 'params[display_counter]', 'options_values' => $ny_opt, 'value' => $vars['entity']->display_counter)) . '</label></p>';


