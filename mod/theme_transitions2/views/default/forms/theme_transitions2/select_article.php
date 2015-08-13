<?php
/**
 * Elgg select home page article form
 */

$value = elgg_extract('value', $vars, '');
$name = elgg_extract('name', $vars, '');
if (empty($name)) { return; } // input name is required


echo elgg_view('input/cmspages_select', array('name' => $name, 'value' => $value));
echo elgg_view('input/hidden', array('name' => 'name', 'value' => $name));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));
//echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('theme_transitions2:home_article:select')));

