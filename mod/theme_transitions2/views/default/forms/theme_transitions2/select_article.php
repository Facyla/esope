<?php
/**
 * Elgg select home page article form
 */

$value = elgg_extract('value', $vars, '');
$name = elgg_extract('name', $vars, '');
if (empty($name)) { return; } // input name is required


echo elgg_view('input/cmspages_select', array('name' => $name, 'value' => $value));
echo elgg_view('input/hidden', array('name' => 'name', 'value' => $name));
//echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => "OK"));
//echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('theme_transitions2:home_article:select')));
if (!empty($value)) {
	echo '<a href="' . elgg_get_site_url() . 'cmspages/edit/' . $value . '">' . '<i class="fa fa-edit"></i>' . '</a>';
} else {
	echo '<a href="' . elgg_get_site_url() . 'cmspages/edit/">' . '<i class="fa fa-edit"></i>' . '</a>';
}

