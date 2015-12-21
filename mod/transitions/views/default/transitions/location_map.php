<?php
/* Display Leaflet base map */
if (!elgg_is_active_plugin('leaflet')) { return; }

leaflet_load_libraries();

// TODO Add box size + separate markers from map

$id = leaflet_id('leaflet_map_'); // Ensure unicity (required because can be displayed several times on same page)
$map_id = elgg_extract('map_id', $vars, 'leaflet-main-map');
$width = elgg_extract('width', $vars, '300px;');
$height = elgg_extract('height', $vars, '200px;');
$map_css = elgg_extract('css', $vars, "width:$width; height:$height;");

echo '<div id="' . $id . '" class="' . $map_id . '" style="' . $map_css . '"></div>';
?>

<script type="text/javascript">
// We need to define some vars globally to be able to use them in other scripts
var map, bounds, baseMap;
//require(['leaflet', 'leaflet.providers'], function(){
define('<?php echo $id; ?>', ['leaflet', 'leaflet.providers'], function(){
// CREATE A MAP on chosen map id
	map = L.map('<?php echo $id; ?>');

// CHOOSE TILE LAYER
// Pure OSM
/*
var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 12, attribution: osmAttrib});
// start the map in South-East England
//map.setView(new L.LatLng(51.3, 0.7),9);
map.addLayer(osm);
*/

// Leaflet providers plugin
	baseMap = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(map);
// Add layer switch and overlays
/*
var baseLayers = ['OpenStreetMap.Mapnik'];
var layerControl = L.control.layers.provided(baseLayers).addTo(map);
*/

// Init bounds to init map centering on markers
	bounds = new L.LatLngBounds();
});
</script>

<?php

// Add marker
$entity = elgg_extract('entity', $vars);

$lat = $entity->getLatitude();
$long = $entity->getLongitude();

	// Geocode entity if needed
if (!$lat || !$long) {
	$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $entity->territory), false);
	$lat = (float)$geo_location['lat'];
	$long = (float)$geo_location['long'];
	if ($lat && $long) { $entity->setLatLong($lat, $long); }
}

// Render JS marker code
if ($lat && $long) {
	echo '<script type="text/javascript">
	var mapMarker, mapMarkers
	require(["leaflet", "leaflet.awesomemarkers", "leaflet.markercluster", "' . $id . '"], function(){
		// Create a custom marker for users
		//var onlineUsersMarker = L.AwesomeMarkers.icon({ prefix: \'fa\', icon: \'user\', markerColor: \'grey\' });
		//var onlineUsersMarkers = new L.MarkerClusterGroup();
		';

		$title = $user->title;
		$title = json_encode($title);
	
		echo "
			var marker = L.marker([$lat, $long], {title: $title}).addTo(map);
			";

		echo '
		map.setView(new L.LatLng(' . $lat . ', ' . $long . '),6);
	});
	</script>';
}

echo '<div id="onlineUsers"></div>';

