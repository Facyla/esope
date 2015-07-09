<?php



/* Batch function - Geocodes member coordinates
 */
function leaflet_batch_geocode_member($user, $getter, $options) {
	$location = $user->getLocation();
	if (is_array($location)) $location = implode(', ', $location);
	$location = trim($location);
	$forceupdate = false;
	
	// Geocode only members locations that are set...
	if (!empty($location)) {
		/* Retro-convert tags to text content, if location was previously set as tags...
		 * If location field was set to "tags", please change it first to "text"
		 * Then move next line out of comment block and display the map once to convert, then move it back here
		$location = implode(', ', $user->location); $user->location = $location;
		*/
		
		// Get coordinates
		$lat = $user->getLatitude();
		$long = $user->getLongitude();
		
		// Add geolocation update check (using previous valid location)
		if (!(empty($user->prev_location) && ($location != $user->prev_location))) { $forceupdate = true; }
		
		// Geocoding, if needed or required
		if (!$lat || !$long || $forceupdate) {
			// Remember latest geocoded location (to avoid geocoding it again if it didn't change
			// ..whether it succeeded or failed it would be useless to do it again
			$user->prev_location = $location;
			
			//error_log("Geocoding location... for $user->username : $user->location"); // debug
			//$geo_location = elgg_geocode_location($location);
			$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $location), false);
			if (!$geo_location) $geo_location = elgg_geocode_location($location);
			if ($geo_location) {
				$lat = (float)$geo_location['lat'];
				$long = (float)$geo_location['long'];
				// Save successfully geocoded location
				if ($lat && $long) { $user->setLatLong($lat, $long); }
			}
		}
	}
}



/* Batch function - Outputs members markers
 */
function leaflet_batch_add_member_marker($user, $getter, $options) {
	$location = $user->location;
	// Geocode only members locations that are set...
	if (empty($location)) { return; }
	
	
	// Get coordinates
	$lat = $user->getLatitude();
	$long = $user->getLongitude();
	
	/* Note : is using geolocation, one should retro-convert tags to text content, if location was previously set as tags...
	 * If location field was set to "tags", please change it first to "text"
	 * Then move next line out of comment block and display the map once to convert, then move it back here
	*/
	if (is_array($location)) {
		$location = implode(', ', $location);
		//$user->location = $location;
	}
	$location = trim($location);
	
	// Note : assume we cannot update all these data at any display, 
	// so we need to compute it asynchronously, cache it, and update on a hourly or daily basis
	$forceupdate = false;
	// Add geolocation update check (using previous valid location)
	if (!(empty($user->prev_location) && ($location != $user->prev_location))) { $forceupdate = true; }
	
	// Geocoding, if needed or required
	if (!$lat || !$long || $forceupdate) {
		leaflet_batch_geocode_member($user, '', array());
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

