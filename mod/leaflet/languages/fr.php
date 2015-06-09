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
	
	// Errors and warnings
	'leaflet:error:missingapikey' => "Clef d'API manquante pour le géocodage. Impossible de géocoder.",
	'leaflet:warning:cacheddata' => "Pour des raisons de performance, les données représentées ne sont actualisées que périodiquement : il se peut que des changements récents ne soient pas affichés.",
	'leaflet:warning:cache:daily' => "Dernière mise à jour il y a moins d'un jour.",
	'leaflet:warning:cache:hourly' => "Dernière mise à jour il y a moins d'une heure.",
	
	// Cron
	'leaflet:cron:geocode:allmembers:done' => "Leaflet CRON geocoding : done",
	'leaflet:cron:done' => "Leaflet CRON : done",
	
	'leaflet:lat' => "Latitude",
	'leaflet:lng' => "Longitude",
	
	// Pages
	'leaflet:index' => "Accueil cartographique",
	'leaflet:world' => "Carte globale",
	'leaflet:map' => "Carte",
	'leaflet:search' => "Recherche cartographique",
	
	
	// Messages pour JS : attention aux guillemets (doubles interdits dans le texte) et aux variables JS à passer !
	'leaflet:locationerror' => "Impossible d'accéder à votre position !",
	'leaflet:popup:locationfound:popup' => '<h3>Vous êtes ici !</h3>(à " + radius + " mètres près)',
	'leaflet:popup:clickonmap' => '<h3><a href=\"' . $url . 'edit/?lat=" + e.latlng.lat + "&lng=" + e.latlng.lng + "\"><i class=\"fa fa-plus\"></i> Créer un Rendez-Vous ici</a></h3>',
	'leaflet:centermap' => "Centrer la carte",
	'leaflet:navlink' => "Lancer la navigation",
	'leaflet:navlink:details' => "<em>Ce lien vous propose d'utiliser votre application de guidage préférée pour accéder à votre lieu de rendez-vous</em>",
	
);

add_translation("fr", $fr);

