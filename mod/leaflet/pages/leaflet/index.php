<?php
/**
 * Wrapper page : contains not much
 * 
 * @package ElggLeaflet
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

$title = elgg_echo('leaflet:index');
$content = '';

set_time_limit(300);

// BUILD MAP
$content .= '<div id="leaflet-container">';
$content .= elgg_view('leaflet/basemap', array('map_id' => 'leaflet-main-map'));
$content .= elgg_view('leaflet/locateonmap');
$content .= elgg_view('leaflet/membersonmap');
//$content .= elgg_view('leaflet/clickonmap');
$content .= elgg_view('leaflet/searchonmap');
$content .= '</div>';


$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));


// Compose page content
echo elgg_view_page($title, $body);


