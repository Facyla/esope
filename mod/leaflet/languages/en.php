<?php
/** Elgg leaflet plugin language
 * @author Florian DANIEL - Facyla
 * @copyright Florian DANIEL - Facyla 2014-2015
 * @link http://id.facyla.net/
 */

$url = elgg_get_site_url() . 'leaflet/';

return array(
	'leaflet' => "Cartography",
	
	'leaflet:settings:osm:api_key' => "OSM API key",
	
	// Errors and warnings
	'leaflet:error:missingapikey' => "Missing API key for geocoding. Cannot geocode.",
	'leaflet:warning:cacheddata' => "For performance reasons, the data is updated regularly: the latest changes may not be displayed.",
	'leaflet:warning:cache:daily' => "Last update less than an day ago.",
	'leaflet:warning:cache:hourly' => "Last update less than an hour ago.",
	
	// Cron
	'leaflet:cron:geocode:allmembers:done' => "Leaflet CRON geocoding : done",
	'leaflet:cron:done' => "Leaflet CRON : done",
	
	'leaflet:lat' => "Latitude",
	'leaflet:lng' => "Longitude",
	
	// Pages
	'leaflet:index' => "Cartographic home",
	'leaflet:world' => "Global map",
	'leaflet:map' => "Map",
	'leaflet:search' => "Cartographis search",
	
	
	// Messages pour JS : attention aux guillemets (doubles interdits dans le texte) et aux variables JS à passer !
	'leaflet:locationerror' => "Cannot access to your position!",
	'leaflet:popup:locationfound:popup' => '<h3>You are here!</h3>(at about " + radius + " meters)',
	'leaflet:popup:clickonmap' => '<h3><a href=\"' . $url . 'edit/?lat=" + e.latlng.lat + "&lng=" + e.latlng.lng + "\"><i class=\"fa fa-plus\"></i> Create a point of interest here</a></h3>',
	'leaflet:centermap' => "Center the map",
	'leaflet:navlink' => "Launch routing",
	'leaflet:navlink:details' => "<em>This links opens your prefered routing application to access your destination</em>",
	
);

