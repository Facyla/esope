<?php


/* Batch function - Outputs members markers
 */
function leaflet_batch_all_members_markers($user, $getter, $options) {
	// Geocode only members locations that are set...
	if (empty($user->location)) return;
	
	$forceupdate = false;
	
	/* Retro-convert tags to text content, if location was previously set as tags...
	 * If location field was set to "tags", please change it first to "text"
	 * Then move next line out of comment block and display the map once to convert, then move it back here
	$location = implode(', ', $user->location); $user->location = $location;
	*/
	
	// Get coordinates
	$lat = $user->getLatitude();
	$long = $user->getLongitude();
	
	// Add geolocation update check (using previous valid location)
	if ($user->prev_location && ($user->location != $user->prev_location)) { $forceupdate = true; }
	
	// Geocoding, if needed or required
	if (!$lat || !$long || $forceupdate) {
		//error_log("Geocoding location... for $user->username"); // debug
		$geo_location = elgg_geocode_location($user->getLocation());
		if ($geo_location) {
			$lat = (float)$geo_location['lat'];
			$long = (float)$geo_location['long'];
			
			// Remember latest geocoding (to avoid geocoding it again if it didn't change, wether it succeeded or failed)
			$user->prev_location = $user->location;
			
			// Save successfully geocoded location
			if ($lat && $long) { $user->setLatLong($lat, $long); }
		}
	}
	
	// Render JS marker code
	if ($lat && $long) {
		$name = $user->name;
		$name = json_encode($name);
		
		$description = elgg_view_entity($user, array('full_view' => false));
		$description = json_encode($description);
		
		echo "
			marker = L.marker([$lat, $long], {icon: onlineUsersMarker, title: $name});
			marker.bindPopup($description);
			onlineUsersMarkers.addLayer(marker);
			bounds.extend(marker.getLatLng());
			";
	}
}

