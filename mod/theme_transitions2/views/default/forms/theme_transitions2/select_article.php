<?php
/**
 * Elgg select home page article form
 */

$value = elgg_extract('value', $vars, '');
$name = elgg_extract('name', $vars, '');
$lang = elgg_extract('lang', $vars, '');
if (empty($name)) { return; } // input name is required

// Enable support of language-specific slider content elements based on user chosen language
if ($lang != 'fr') { $name .= '_' . $lang; }

// Choix page CMS
// Puis lien d'édition correspondant
if (!empty($value) && !is_numeric($value)) {
	echo elgg_view('input/cmspages_select', array('name' => $name, 'value' => $value, 'onChange' => "javascript:$(this).siblings('.transitions-select').val('no');"));
	echo '<a href="' . elgg_get_site_url() . 'cmspages/edit/' . $value . '">' . '<i class="fa fa-edit"></i>' . '</a>';
} else {
	echo elgg_view('input/cmspages_select', array('name' => $name, 'onChange' => "javascript:$(this).siblings('.transitions-select').val('no');"));
	//echo '<a href="' . elgg_get_site_url() . 'cmspages/edit/">' . '<i class="fa fa-edit"></i>' . '</a>';
}
echo ' ';

// Choix contribution
// Puis lien d'édition si non vide
if (!empty($value) && is_numeric($value)) {
	echo elgg_view('input/transitions_select', array('name' => $name . '_2', 'value' => $value, 'onChange' => "javascript:$(this).siblings('.cmspages-select').val('no');"));
	echo '<a href="' . elgg_get_site_url() . 'transitions/edit/' . $value . '">' . '<i class="fa fa-pencil"></i>' . '</a>';
} else {
	echo elgg_view('input/transitions_select', array('name' => $name . '_2', 'onChange' => "javascript:$(this).siblings('.cmspages-select').val('no');"));
}
echo ' ';

echo elgg_view('input/hidden', array('name' => 'name', 'value' => $name));
//echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));

echo elgg_view('input/submit', array('name' => 'submit', 'value' => "OK"));
//echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('theme_transitions2:home_article:select')));


