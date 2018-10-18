<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));


// Convert Unicode to HTML entity
echo '<p><label>Convert UTF-8 emojis to html entities ' . elgg_view('input/select', array('name' => 'params[convert_emojis]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->emojis_to_html)) . '</label></p>';

// Filter Unicode non-characters (or sync with convert_emojis ?)
echo '<p><label>Filter Unicode non-characters ' . elgg_view('input/select', array('name' => 'params[filter_nonchars]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->filter_nonchars)) . '</label></p>';



/*
// Set default value
if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name == 'default'; }


// Example yes/no setting
echo '<p><label>Test select setting "setting_name"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->setting_name)) . '</p>';


// Example text setting
echo '<p><label>Text setting "setting_name2"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</p>';
*/

