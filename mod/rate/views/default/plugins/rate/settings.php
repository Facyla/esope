<?php 

// Set defaults
$object_subtypes_default = 'blog, bookmarks, file, page, page_top, thewire';
if (!isset($vars['entity']->object_subtypes)) { $vars['entity']->object_subtypes = $object_subtypes_default; }

$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

// Subtypes to be extended with rating
echo '<p><label>' . elgg_echo('rate:settings:object_subtypes') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'params[object_subtypes]', 'value' => $vars['entity']->object_subtypes, 'placeholder' => $object_subtypes_default)) . '</label><br /><em>' . elgg_echo('rate:settings:object_subtypes:details') . ' ' . $object_subtypes_default . '</em></p>';

// Other views to extend
echo '<p><label>' . elgg_echo('rate:settings:extend_views') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'params[extend_views]', 'value' => $vars['entity']->extend_views, 'placeholder' => 'profile/owner_block')) . '</label><br /><em>' . elgg_echo('rate:settings:extend_views:details') . '</em></p>';

// Allow self-rating (for users)
echo '<p><label>' . elgg_echo('rate:settings:self_rate') . '&nbsp;: ' . elgg_view('input/select', array('name' => 'params[self_rate]', 'value' => $vars['entity']->self_rate, 'options_values' => $ny_opt)) . '</label><br /><em>' . elgg_echo('rate:settings:self_rate:details') . '</em></p>';

// @TODO add text evaluation (comment) ?
//echo '<p><label>' . elgg_echo('rate:settings:rate_comment') . '&nbsp;: ' . elgg_view('input/select', array('name' => 'params[rate_comment]', 'value' => $vars['entity']->rate_comment, 'options_values' => $ny_opt)) . '</label><br /><em>' . elgg_echo('rate:settings:rate_comment:details') . '</em></p>';


