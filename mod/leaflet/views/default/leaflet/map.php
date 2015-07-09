<?php
/* Display Leaflet base map */

elgg_load_library('leaflet');
leaflet_load_libraries();

// TODO Add box size + separate markers from map

echo elgg_view('leaflet/basemap', $vars);

// Add marker
$entity = elgg_extract('entity', $vars);

$lat = $entity->getLatitude();
$long = $entity->getLongitude();

if (!$lat || !$long) {
	$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $entity->territory), false);
	$lat = (float)$geo_location['lat'];
	$long = (float)$geo_location['long'];
	if ($lat && $long) {
		$entity->setLatLong($lat, $long);
	}
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
	
	$description = elgg_view_entity($entity, array('full_view' => false, 'view_type' => 'gallery'));
	$description = json_encode($description);
	
	echo "
		marker = L.marker([$lat, $long], {icon: onlineUsersMarker, title: $title});
		marker.bindPopup($description);
		onlineUsersMarkers.addLayer(marker);
		bounds.extend(marker.getLatLng());
		";

	echo 'map.addLayer(onlineUsersMarkers);
	map.fitBounds(bounds, {padding: [20,20]});
	</script>';
}

echo '<div id="onlineUsers"></div>';

