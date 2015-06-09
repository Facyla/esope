<?php
/**
 * Elgg mobile_apps global browser
 * 
 * @package Elggmobile_apps
 * @author Facyla ~ Florian DANIEL
 * @copyright Datawyz 2014
 * @link http://datawyz.com/
 */

/* Notes :
 * Started by a Leaflet map
 * Added controls, markers, basic interaction
 * Added awesome markers
 * 
 */

/* TODO : 
	load markers from external/generated file
	provide map URL (with access code)
*/

$title = elgg_echo('leaflet:map');

// BUILD MAP
$body .= elgg_view('leaflet/basemap', array('map_id' => 'map'));
$body .= elgg_view('leaflet/locateonmap');
$body .= elgg_view('leaflet/clickonmap');
$body .= elgg_view('leaflet/searchonmap');



// Compose page content
echo elgg_view('pageshell', array('head' => $head, 'body' => $body, 'title' => $title));


