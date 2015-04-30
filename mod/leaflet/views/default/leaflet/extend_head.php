<?php
/* Leaflet requisites and plugins */

$vendors_url = elgg_get_site_url() . 'mod/leaflet/vendors/';
$awesomefont = $vendors_url . 'Leaflet_awesome_markers/';
$providers = $vendors_url . 'Leaflet_providers/';
$geosearch = $vendors_url . 'Leaflet_GeoSearch/';
$routing = $vendors_url . 'Leaflet_routing_machine/';
$markercluster = $vendors_url . 'Leaflet_markercluster/';
?>

<!--
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
//-->
<link rel="stylesheet" href="<?php echo $vendors_url; ?>Leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo $awesomefont; ?>leaflet.awesome-markers.css">
<link rel="stylesheet" href="<?php echo $providers; ?>css/gh-fork-ribbon.css">
<link rel="stylesheet" href="<?php echo $geosearch; ?>src/css/l.geosearch.css">
<link rel="stylesheet" href="<?php echo $routing; ?>leaflet-routing-machine.css" />
<link rel="stylesheet" href="<?php echo $markercluster; ?>MarkerCluster.css" />
<link rel="stylesheet" href="<?php echo $markercluster; ?>MarkerCluster.Default.css" />

<!--
<script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
//-->
<script src="<?php echo $vendors_url; ?>Leaflet/leaflet.js"></script>
<script src="<?php echo $awesomefont; ?>leaflet.awesome-markers.js"></script>
<script src="<?php echo $providers; ?>leaflet-providers.js"></script>
<script src="<?php echo $geosearch; ?>src/js/l.control.geosearch.js"></script>
<script src="<?php echo $geosearch; ?>src/js/l.geosearch.provider.openstreetmap.js"></script>
<script src="<?php echo $routing; ?>leaflet-routing-machine.min.js"></script>
<script src="<?php echo $markercluster; ?>leaflet.markercluster.js"></script>

