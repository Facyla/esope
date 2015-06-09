<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

$trigger_opt = array('hover' => elgg_echo('link_preview:trigger:hover'), 'click' => elgg_echo('link_preview:trigger:click'));
$scale_opt = array('1' => "1 (original)", '0.75' => "0.75", '0.5' => "0.5", '0.3' => "0.3 (default)", '0.2' => "0.2", '0.1' => "0.1");
$position_opt = array('right' => elgg_echo('link_preview:position:right'), 'left' => elgg_echo('link_preview:position:left'));

// Set default value
if (!isset($vars['entity']->trigger)) { $vars['entity']->trigger = 'hover'; }
if (!isset($vars['entity']->scale)) { $vars['entity']->scale = '0.3'; }
if (!isset($vars['entity']->targetwidth)) { $vars['entity']->targetwidth = '1200'; }
if (!isset($vars['entity']->targetheight)) { $vars['entity']->targetheight = '800'; }
if (!isset($vars['entity']->offset)) { $vars['entity']->offset = '50'; }
if (!isset($vars['entity']->position)) { $vars['entity']->position = 'right'; }



// Preview mode : hover / click
echo '<p><label>' . elgg_echo('link_preview:setting:trigger'). ' ' . elgg_view('input/dropdown', array('name' => 'params[trigger]', 'options_values' => $trigger_opt, 'value' => $vars['entity']->trigger)) . '</label><br /><em>' . elgg_echo('link_preview:setting:trigger:details'). '</em></p>';

// Scale ratio
echo '<p><label>' . elgg_echo('link_preview:setting:scale'). ' ' . elgg_view('input/dropdown', array('name' => 'params[scale]', 'options_values' => $scale_opt, 'value' => $vars['entity']->scale)) . '</label><br /><em>' . elgg_echo('link_preview:setting:scale:details'). '</em></p>';

// Target height
echo '<p><label>' . elgg_echo('link_preview:setting:targetheight'). ' ' . elgg_view('input/text', array('name' => 'params[targetheight]', 'value' => $vars['entity']->targetheight)) . '</label><br /><em>' . elgg_echo('link_preview:setting:targetheight:details'). '</em></p>';

// Target width
echo '<p><label>' . elgg_echo('link_preview:setting:targetwidth'). ' ' . elgg_view('input/text', array('name' => 'params[targetwidth]', 'value' => $vars['entity']->targetwidth)) . '</label><br /><em>' . elgg_echo('link_preview:setting:targetwidth:details'). '</em></p>';

// Offset
echo '<p><label>' . elgg_echo('link_preview:setting:offset'). ' ' . elgg_view('input/text', array('name' => 'params[offset]', 'value' => $vars['entity']->offset)) . '</label><br /><em>' . elgg_echo('link_preview:setting:offset:details'). '</em></p>';

// Position
echo '<p><label>' . elgg_echo('link_preview:setting:position'). ' ' . elgg_view('input/dropdown', array('name' => 'params[position]', 'value' => $vars['entity']->position, 'options_values' => $position_opt)) . '</label><br /><em>' . elgg_echo('link_preview:setting:position:details'). '</em></p>';


// @TODO : allow to set selectors on which to apply livePreview


