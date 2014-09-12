<?php
/** Elgg leaflet plugin language
 * @author Florian DANIEL - Facyla
 * @copyright Florian DANIEL - Facyla 2014
 * @link http://id.facyla.net/
 */
global $CONFIG;
$url = $CONFIG->url. 'leaflet/';

$fr = array(
	'leaflet' => "Cartographie",
	
	'leaflet:settings:osm:api_key' => "Clef d'API OSM",
	
	'leaflet:lat' => "Latitude",
	'leaflet:lng' => "Longitude",
	
	
	
	// Messages pour JS : attention aux guillemets (doubles interdits dans le texte) et aux variables JS à passer !
	'leaflet:locationerror' => "Impossible d'accéder à votre position !",
	'leaflet:popup:locationfound:popup' => '<h3>Vous êtes ici !</h3>(à " + radius + " mètres près)',
	'leaflet:popup:clickonmap' => '<h3><a href=\"' . $url . 'edit/?lat=" + e.latlng.lat + "&lng=" + e.latlng.lng + "\"><i class=\"fa fa-plus\"></i> Créer un Rendez-Vous ici</a></h3>',
	'leaflet:centermap' => "Centrer la carte",
	'leaflet:navlink' => "Lancer la navigation",
	'leaflet:navlink:details' => "<em>Ce lien vous propose d'utiliser votre application de guidage préférée pour accéder à votre lieu de rendez-vous</em>",
	
);

add_translation("fr", $fr);

