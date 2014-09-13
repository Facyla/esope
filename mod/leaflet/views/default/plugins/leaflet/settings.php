<?php
$yesno_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

/*
echo '<p><label>' . elgg_echo("mobile_apps:settings:comment") . ' ' . elgg_view('input/pulldown', array('internalname' => 'params[comment]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->comment)) . '</label></p>';
*/

// OSM API key
echo '<p><label>' . elgg_echo('leaflet:settings:osm:api_key') . ' ' . elgg_view('input/text', array('internalname' => 'params[osm_api_key]', 'value' => $vars['entity']->osm_api_key)) . '</label></p>';

