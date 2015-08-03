<?php
/* Display Leaflet base map */

elgg_load_library('leaflet');
leaflet_load_libraries();

// TODO Add box size + separate markers from map

if (empty($vars['map_id'])) { $vars['map_id'] = 'leaflet-main-map'; }
$width = elgg_extract('width', $vars, '300px;');
$height = elgg_extract('height', $vars, '200px;');

$mapstyle = "width:$width; height:$height;";
echo '<div id="' . $vars['map_id'] . '" style="' . $mapstyle . '"></div>';
?>

<script type="text/javascript">
// CREATE A MAP on chosen map id
var map = L.map('<?php echo $vars['map_id']; ?>');

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
var baseMap = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(map);
// Add layer switch and overlays
/*
var baseLayers = ['OpenStreetMap.Mapnik'];
var layerControl = L.control.layers.provided(baseLayers).addTo(map);
*/

// Init bounds to init map centering on markers
var bounds = new L.LatLngBounds();
</script>

<?php

// Add marker
$entity = elgg_extract('entity', $vars);

$lat = $entity->getLatitude();
$long = $entity->getLongitude();

if (!$lat || !$long) {
	$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $entity->territory), false);
	$lat = (float)$geo_location['lat'];
	$long = (float)$geo_location['long'];
	if ($lat && $long) { $entity->setLatLong($lat, $long); }
}

// Render JS marker code
if ($lat && $long) {
	echo '<script type="text/javascript">
	// Create a custom marker for users
	var onlineUsersMarker = L.AwesomeMarkers.icon({ prefix: \'fa\', icon: \'user\', markerColor: \'grey\' });
	var onlineUsersMarkers = new L.MarkerClusterGroup();
	';

	$title = $user->title;
	$title = json_encode($title);
	
	//$description = elgg_view_entity($entity, array('full_view' => false, 'view_type' => 'gallery'));
	$description = '<strong><a href="' . $entity->getURL() . '"><img src="' . $entity->getIconURL('small') . '" /> ' . $entity->title . '</a></strong>';
	$description = json_encode($description);
	
	echo "
		marker = L.marker([$lat, $long], {icon: onlineUsersMarker, title: $title});
		marker.bindPopup($description);
		onlineUsersMarkers.addLayer(marker);
		bounds.extend(marker.getLatLng());
		";

	echo 'map.addLayer(onlineUsersMarkers);
	map.fitBounds(bounds, {padding: [20,20]});
	map.setView(new L.LatLng(' . $lat . ', ' . $long . '),10);
	</script>';
}

echo '<div id="onlineUsers"></div>';

