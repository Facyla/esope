<?php
/* Display Leaflet base map
 * From an entity, or from custom lat/long or address, and description information
 */

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

/* Multiple POI */
$entities = elgg_extract('entities', $vars);
if (is_array($entities)) {
	echo "<script type=\"text/javascript\">
		var mapMarker, mapMarkers_" . $id . ";
		require(['leaflet', 'leaflet.awesomemarkers', 'leaflet.markercluster', '$id'], function(){
			// Create a custom marker for users
			mapMarker = L.AwesomeMarkers.icon({ prefix: 'fa', icon: 'home', markerColor: 'grey' });
			mapMarkers_" . $id . " = new L.MarkerClusterGroup();";
	
	foreach($entities as $entity) {
		
		// Use entity location information
		$lat = $entity->getLatitude();
		$long = $entity->getLongitude();
	
		// Geocode entity if needed
		if (!$lat || !$long) {
			$location = $entity->location;
			if (empty($location)) { $location = $entity->address; }
			$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $location), false);
			$lat = (float)$geo_location['lat'];
			$long = (float)$geo_location['long'];
			if ($lat && $long) { $entity->setLatLong($lat, $long); }
		}
		$title = $entity->title;
		if (empty($title)) { $title = $entity->name; }
		//$description = elgg_view_entity($entity, array('full_view' => false, 'view_type' => 'gallery'));
		$icon = $entity->getIconURL('small');
		if ($icon == elgg_get_site_url() . '_graphics/icons/default/small.png') { $icon = false; }
		$description = '<strong><a href="' . $entity->getURL() . '">';
		if ($icon) { $description .= '<img src="' . $icon . '" /> '; }
		$description .= $entity->title . '</a></strong>';
		
		// Render JS marker code - only if we have valid lat/long
		if ($lat && $long) {
			// Marker title and content
			$title = json_encode($title);
			$description = json_encode($description);
	
			echo "
				var marker = L.marker([$lat, $long], {icon: mapMarker, title: $title});
				marker.bindPopup($description);
				mapMarkers_" . $id . ".addLayer(marker);
				bounds.extend(marker.getLatLng());";
		}
		
	}
	
	echo "map.addLayer(mapMarkers_" . $id . ");
			map.fitBounds(bounds, {padding: [20,20]});
			//map.setView(new L.LatLng($lat, $long),10);
		});
		</script>";
	
}

/* Unique POI */
// Get marker data
$entity = elgg_extract('entity', $vars);
if (elgg_instanceof($entity)) {
	// Use entity location information
	$lat = $entity->getLatitude();
	$long = $entity->getLongitude();
	
	// Geocode entity if needed
	if (!$lat || !$long) {
		$location = $entity->location;
		if (empty($location)) { $location = $entity->address; }
		$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $location), false);
		$lat = (float)$geo_location['lat'];
		$long = (float)$geo_location['long'];
		if ($lat && $long) { $entity->setLatLong($lat, $long); }
	}
	$title = $entity->title;
	if (empty($title)) { $title = $entity->name; }
	//$description = elgg_view_entity($entity, array('full_view' => false, 'view_type' => 'gallery'));
	$icon = $entity->getIconURL('small');
	if ($icon == elgg_get_site_url() . '_graphics/icons/default/small.png') { $icon = false; }
	$description = '<strong><a href="' . $entity->getURL() . '">';
	if ($icon) { $description .= '<img src="' . $icon . '" /> '; }
	$description .= $entity->title . '</a></strong>';
	
} else {
	// No entity
	$lat = elgg_extract('lat', $vars);
	$long = elgg_extract('long', $vars);
	$address = elgg_extract('address', $vars);
	$title = elgg_extract('title', $vars);
	$description = elgg_extract('description', $vars);
	// Geocode from address if no lat/long available
	if ((!$lat || !$long) && $address) {
		$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $address), false);
		$lat = (float)$geo_location['lat'];
		$long = (float)$geo_location['long'];
		if (!$lat || !$long) { $description .= '<br />' . $address; }
	}
}

// Render JS marker code - only if we have valid lat/long
if ($lat && $long) {
	// Marker title and content
	$title = json_encode($title);
	$description = json_encode($description);
	
	echo "<script type=\"text/javascript\">
	var mapMarker, mapMarkers_" . $id . ";
	require(['leaflet', 'leaflet.awesomemarkers', 'leaflet.markercluster', '$id'], function(){
		// Create a custom marker for users
		mapMarker = L.AwesomeMarkers.icon({ prefix: 'fa', icon: 'home', markerColor: 'red' });
		mapMarkers_" . $id . " = new L.MarkerClusterGroup();
		
		var marker = L.marker([$lat, $long], {icon: mapMarker, title: $title});
		marker.bindPopup($description);
		mapMarkers_" . $id . ".addLayer(marker);
		bounds.extend(marker.getLatLng());
		
		map.addLayer(mapMarkers_" . $id . ");
		map.fitBounds(bounds, {padding: [20,20]});
		map.setView(new L.LatLng($lat, $long),10);
	});
	</script>";
}


