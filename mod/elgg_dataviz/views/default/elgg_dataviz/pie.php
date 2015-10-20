<?php
// Pie chart - Diagramme en secteurs ou "camembert"

// Available libraries
$libraries = array('chartjs');
// Default visualisation library
$default_lib = 'chartjs';

// Choose custom visualisation library
$lib = elgg_extract('lib', $vars, $default_lib);
if (!in_array($lib, $libraries)) { $lib = $default_lib; }
unset($vars['lib']);

echo elgg_view("elgg_dataviz/$lib/pie", $vars);

