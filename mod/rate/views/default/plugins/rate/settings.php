<?php 

// Set defaults
$object_subtypes_default = 'blog, bookmarks, file, page, page_top, thewire';
if (!isset($vars['entity']->object_subtypes)) { $vars['entity']->object_subtypes = $object_subtypes_default; }


// Subtypes to be extended with rating
echo '<p><label>' . elgg_echo('rate:settings:object_subtypes') . '&nbsp;: ' . elgg_view('input/text', array( 'name' => 'params[object_subtypes]', 'value' => $vars['entity']->object_subtypes, 'placeholder' => $object_subtypes_default)) . '</label><br /><em>' . elgg_echo('rate:settings:object_subtypes:details') . ' ' . $object_subtypes_default . '</em></p>';

// Other views to extend
echo '<p><label>' . elgg_echo('rate:settings:extend_views') . '&nbsp;: ' . elgg_view('input/text', array( 'name' => 'params[extend_views]', 'value' => $vars['entity']->extend_views, 'placeholder' => 'profile/owner_block')) . '</label><br /><em>' . elgg_echo('rate:settings:extend_views:details') . '</em></p>';


