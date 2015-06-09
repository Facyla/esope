<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );


// Define defaults and allow resetting the config
if (empty($vars['entity']->safe)) $vars['entity']->safe = 'no';
if (empty($vars['entity']->elements)) $vars['entity']->elements = "";
if (empty($vars['entity']->deny_attribute)) $vars['entity']->deny_attribute = 'on*';


// Settings form

echo '<p><label>' . elgg_echo('esope:htmlawed:safe') . elgg_view('input/dropdown', array('name' => 'params[safe]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->safe)) . '</label><br /><em>' . elgg_echo('esope:htmlawed:safe:details') . '</em></p>';

echo '<p><label>' . elgg_echo('esope:htmlawed:elements') . elgg_view('input/plaintext', array( 'name' => 'params[elements]', 'value' => $vars['entity']->elements )) . '</label><br /><em>' . elgg_echo('esope:htmlawed:elements:details') . '</em></label></p>';

echo '<p><label>' . elgg_echo('esope:htmlawed:deny_attribute') . elgg_view('input/plaintext', array( 'name' => 'params[deny_attribute]', 'value' => $vars['entity']->deny_attribute )) . '</label><br /><em>' . elgg_echo('esope:htmlawed:deny_attribute:details') . '</em></label></p>';


