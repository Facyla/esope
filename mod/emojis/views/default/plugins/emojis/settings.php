<?php
/**
 * The wire plugin settings
 */

$plugin = $vars['entity'];

$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Input hook (validate,input)
echo '<div><label>' . elgg_echo('emojis:settings:input_hook') . ' ' . elgg_view('input/select', array('name' => 'params[enable_input_hook]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->enable_input_hook)) . '</label><br /><em>' . elgg_echo('emojis:settings:input_hook:details') . '</em></div>';

// TheWire action
echo '<div><label>' . elgg_echo('emojis:settings:thewire') . ' ' . elgg_view('input/select', array('name' => 'params[enable_thewire]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->enable_thewire)) . '</label><br /><em>' . elgg_echo('emojis:settings:thewire:details') . '</em></div>';

// Output hook (output/longtext)
echo '<div><label>' . elgg_echo('emojis:settings:output_hook') . ' ' . elgg_view('input/select', array('name' => 'params[enable_output_hook]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->enable_output_hook)) . '</label><br /><em>' . elgg_echo('emojis:settings:output_hook:details') . '</em></div>';

// Debug mode
echo '<div><label>' . elgg_echo('emojis:settings:debug') . ' ' . elgg_view('input/select', array('name' => 'params[debug]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->debug)) . '</label><br /><em>' . elgg_echo('emojis:settings:debug:details') . '</em></div>';

