<?php
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));
$yn_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

// OSM API key
echo '<p><label>' . elgg_echo('leaflet:settings:osm:api_key') . ' ' . elgg_view('input/text', array('internalname' => 'params[osm_api_key]', 'value' => $vars['entity']->osm_api_key)) . '</label><br /><a href="http://developer.mapquest.com/" target="_blank">' . elgg_echo('leaflet:settings:osm:api_key:get') . '</a></p>';

// Enable CRON batch geocoding
echo '<p><label>' . elgg_echo("leaflet:settings:cron_enable") . ' ' . elgg_view('input/select', array('internalname' => 'params[cron_enable]', 'options_values' => $yn_opt, 'value' => $vars['entity']->cron_enable)) . '</label></p>';


