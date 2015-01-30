<?php
// Lists all existing profile types and allows a multi select in the list
$values = elgg_get_plugin_setting("etablissements", 'theme_cocon');

// Recursive array : split on \n, then ;
$etablissements = esope_get_input_recursive_array($values, array(array("|", "\r", "\t"), ';'), true);
//echo '<pre>' . print_r($etablissements, true) . '</pre>';

// Build options from 
$vars['options_values'] = array('' => '');
foreach ($etablissements as $etablissement) {
	// Structure : Nom (0) ; Académie (1) ; UAI (2) ; Département (3) ; Adresse (4) ; mail (5)
	$vars['options_values']["{$etablissement[2]}"] = "{$etablissement[0]} ({$etablissement[1]}, {$etablissement[3]})";
}

if (!empty($vars["name"])) $vars["name"] = 'cocon_etablissement';

if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/dropdown', $vars);
}


