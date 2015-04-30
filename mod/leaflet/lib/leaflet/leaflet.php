<?php

/* Cron (daily) tasks
 * Geocode all registered members locations
 */
function leaflet_cron_geocode_all_members($hook, $entity_type, $returnvalue, $params) {
	// Block cron task if we do not have the required parameters
	$api_key = elgg_get_plugin_setting('osm_api_key', 'leaflet');
	if (empty($api_key)) $api_key = elgg_get_plugin_setting('api_key', 'osm_maps');
	if (empty($api_key)) {
		error_log(elgg_echo('leaflet:error:missingapikey'));
		return false;
	}
	
	// Ensure that we have this required parameter before going into a long task
	if (!empty($api_key)) {
		elgg_set_context('cron');
	
		// Avoid any time limit while processing
		set_time_limit(0);
		access_show_hidden_entities(true);
		$ia = elgg_set_ignore_access(true);
	
		// Geocoding batch
		error_log("LEAFLET GEOCODE BATCH : started at " . date('Ymd H:i:s'));
		$debug_0 = microtime(TRUE);
		$users_options = array('types' => 'user', 'limit' => 0);
		$batch = new ElggBatch('elgg_get_entities', $users_options, 'leaflet_batch_geocode_member', 10);
		$debug_1 = microtime(TRUE);
		error_log("LEAFLET GEOCODE BATCH : Finished at " . date('Ymd H:i:s') . " => ran in " . round($debug_1-$debug_0, 4) . " seconds");
		echo '<p>' . elgg_echo('leaflet:cron:geocode:allmembers:done') . '</p>';
	
		elgg_set_ignore_access($ia);
		echo '<p>' . elgg_echo('leaflet:cron:done') . '</p>';
	}
}



/* Batch function - Geocodes member coordinates
 */
function leaflet_batch_geocode_member($user, $getter, $options) {
	$location = $user->getLocation();
	$forceupdate = false;
	
	// Geocode only members locations that are set...
	if (!empty(trim($location))) {
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
			$geo_location = elgg_geocode_location($location);
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
	$location = $user->getLocation();
	$forceupdate = false;
	
	// Geocode only members locations that are set...
	if (!empty(trim($location))) {
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
			$geo_location = elgg_geocode_location($location);
			if ($geo_location) {
				$lat = (float)$geo_location['lat'];
				$long = (float)$geo_location['long'];
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
}

