<?php
/**
 * leaflet plugin
 *
 */

elgg_register_event_handler('init', 'system', 'leaflet_init'); // Init


/**
 * Init adf_leaflet plugin.
 */
function leaflet_init() {
	
	elgg_extend_view('css', 'leaflet/css');
	/*
	elgg_register_simplecache_view('leaflet/js');
	$leaflet_js = elgg_get_simplecache_url('js', 'leaflet');
	elgg_register_js('leaflet', $leaflet_js, 'head');
	*/
	
	// Register PHP libraries
	elgg_register_library('leaflet', elgg_get_plugins_path() . 'leaflet/lib/leaflet/leaflet.php');
	
	// Register JS scripts and CSS
	leaflet_register_libraries();
	
	// Register leaflet page handler
	elgg_register_page_handler('leaflet','leaflet_page_handler');
	
	// Register geocoder
	elgg_register_plugin_hook_handler('geocode', 'location', 'leaflet_geocode');
	
	elgg_register_plugin_hook_handler('cron', 'daily', 'leaflet_cron_geocode_all_members');
	
}


/* Get libraries and extensions configuration
 * lib_name => array(
 *     array('type' => 'css|js', 'url' => 'lib_file_path'),
 *   )
 */
function leaflet_get_libraries_config() {
	$vendors_url = elgg_get_site_url() . 'mod/leaflet/vendors/';
	// <script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
	// <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
	
	$libraries_config = array(
			'leaflet' => array(
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet/leaflet.js'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet/leaflet.css'),
				),
			'leaflet.awesomemarkers' => array(
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet_awesome_markers/leaflet.awesome-markers.js'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet_awesome_markers/leaflet.awesome-markers.css'),
				),
			'leaflet.providers' => array(
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet_providers/leaflet-providers.js'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet_providers/css/gh-fork-ribbon.css'),
				),
			'leaflet.geosearch' => array(
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet_GeoSearch/src/js/l.control.geosearch.js'),
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet_GeoSearch/src/js/l.geosearch.provider.openstreetmap.js', 'name' => 'leaflet.geosearch.openstreetmap'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet_GeoSearch/src/css/l.geosearch.css'),
				),
			'leaflet.routing' => array(
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet_routing_machine/leaflet-routing-machine.min.js'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet_routing_machine/leaflet-routing-machine.css'),
				),
			'leaflet.markercluster' => array(
					array('type' => 'js', 'url' => $vendors_url . 'Leaflet_markercluster/leaflet.markercluster.js'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet_markercluster/MarkerCluster.css'),
					array('type' => 'css', 'url' => $vendors_url . 'Leaflet_markercluster/MarkerCluster.Default.css', 'name' => 'leaflet.markercluster.default'),
				),
		);
	return $libraries_config;
}


// Check enabled libraries and register the corresponding scripts and CSS
function leaflet_register_libraries() {
	// List available libraries
	$libraries_config = leaflet_get_libraries_config();
	
	// @TODO enable only wanted plugins
	
	global $leaflet_registered_libs;
	$leaflet_registered_libs = array('js' => array(), 'css' => array());
	
	// Register JS scripts and CSS files
	foreach ($libraries_config as $name => $lib_config) {
		foreach ($lib_config as $config) {
			switch($config['type']) {
				case 'js':
					$libname = $name;
					if (isset($config['name'])) $libname = $config['name'];
					$location = 'head';
					if (isset($config['location'])) $libname = $config['location'];
					elgg_register_js($libname, $config['url'], $location);
					$leaflet_registered_libs['js'][] = $libname;
					break;
				case 'css':
					$libname = $name;
					if (isset($config['name'])) $libname = $config['name'];
					elgg_register_css($libname, $config['url']);
					$leaflet_registered_libs['css'][] = $libname;
					break;
			}
		}
	}
	
}


// Load registered JS and CSS libraries
function leaflet_load_libraries() {
	global $leaflet_registered_libs;
	// Load registered libs
	foreach ($leaflet_registered_libs as $type => $libraries) {
		switch($type) {
			case 'js':
				foreach ($libraries as $name) { elgg_load_js($name); }
				break;
			case 'css':
				foreach ($libraries as $name) { elgg_load_css($name); }
				break;
		}
	}
}


/** leaflet page handler
 * home | index | null => home page
 * geocode/ => geocoding tool
 * search/ => search page
 * world/ => global admin page
 */
function leaflet_page_handler($page) {
	// Load registered libraries
	leaflet_load_libraries();
	elgg_load_library('leaflet');
	
	$leaflet_root = dirname(__FILE__) . '/pages/leaflet/';
	
	if (empty($page[0])) $page[0] = 'index';
	switch($page[0]) {
		
		// All these have same name than script
		case "geocode":
		case "search":
		case 'world': // Admin global view
			require($leaflet_root . $page[0] . ".php");
			break;
		
		// Map home page
		case "index":
		default:
			require($leaflet_root . "index.php");
	}
	
	return true;
}


/* Geocoding service */
function leaflet_geocode($hook, $entity_type, $returnvalue, $params) { 
	if (isset($params['location'])) {
		/* GOOGLE API */
		/* 
		$google_api = get_plugin_setting('google_api', 'googlegeocoder');
		// Desired address
		$address = "http://maps.google.com/maps/geo?q=".urlencode($params['location'])."&output=json&key=" . $google_api;
		// Retrieve the URL contents
		$result = file_get_contents($address);
		$obj = json_decode($result);
		$obj = $obj->Placemark[0]->Point->coordinates;
		*/
		
		/* Mapquest API */
		$api_key = elgg_get_plugin_setting('osm_api_key', 'leaflet');
		if (empty($api_key)) $api_key = elgg_get_plugin_setting('api_key', 'osm_maps');
		if (empty($api_key)) {
			error_log(elgg_echo('leaflet:error:missingapikey'));
			return false;
		}
		//$callback = get_input('callback', 'renderOptions');
		$inFormat = get_input('inFormat', 'kvp');
		$outFormat = get_input('outFormat', 'json');
		$maxResults = get_input('maxResults', '1');
		$location = urlencode($params['location']);

		// Desired address
		// Documentation : http://open.mapquestapi.com/geocoding/
		//$address = "http://open.mapquestapi.com/geocoding/v1/address?key=$api_key&callback=$callback&inFormat=$inFormat&outFormat=$outFormat&location=$location&maxResults=$maxResults";
		$address = "http://open.mapquestapi.com/geocoding/v1/address?key=$api_key&inFormat=$inFormat&outFormat=$outFormat&location=$location&maxResults=$maxResults";
		// Retrieve the URL contents
		$result = file_get_contents($address);
		$obj = json_decode($result); // true returns array[][] instead of object->props[0]->prop
		$latlong = $obj->results[0]->locations[0]->latLng;
		$lat = $latlong->lat;
		$long = $latlong->lng;
		//error_log("GEOCODING start : {$params['location']} => $lat,$long  using URL $address");
		
		// Return geocoded address if it is valid
		if (!empty($lat) && !empty($long)) {
			return array('lat' => $lat, 'long' => $long);
		}
	}
	
	// Don't save geocoded address if wrong result or no location
	return false;
}


/* Renvoie un tableau avec les coordonnées des personnes positionnées sur la carte
 * $filePath = chemin du fichier
 * $tslimit = intervale de temps valide en secondes
 * Line data structure : "$name|$lat|$lng|$radius|$timestamp|$timeout"
 */
function leaflet_read_positions_from_file($filePath = '', $tslimit = false) {
	if (file_exists($filePath)) {
		$currentts = time();
		$lines = file($filePath);
		foreach ($lines as $line_num => $line) {
			$line = trim($line);
			if (empty($line) || ($line == "\n")) continue;
			$position_data = explode('|', $line);
			$unique_key = $position_data[0]; // name
			// Exclude old data : 
			//  - user per-line timeout if $tslimit is only enabled
			// - or use custom value if $tslimit is set to a custom timeframe
			if ($tslimit === true) {
				if (($currentts - $position_data[4]) > $position_data[5]) { continue; }
			} else if ($tslimit) {
				if (($currentts - $position_data[4]) > $tslimit) { continue; }
			}
			// If all tests have passed, keep the data
			if (!empty($unique_key) && !empty($line)) $positions[$unique_key] = $line;
		}
	}
	return $positions;
}




