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
	global $CONFIG;
	
	elgg_extend_view('css', 'leaflet/css');
	elgg_extend_view("js/elgg", "leaflet/js");
	
	elgg_extend_view("page/elements/head", "leaflet/extend_head");
	
	/* @TODO : intégrer ces scripts sous forme de JS lib
	elgg_register_js('togetherjs', 'https://togetherjs.com/togetherjs.js', 'head');
	global $CONFIG;
	$vendors_url = $CONFIG->url . 'mod/leaflet/vendors/';
	$awesomefont = $vendors_url . 'Leaflet_awesome_markers/';
	$providers = $vendors_url . 'Leaflet_providers/';
	$geosearch = $vendors_url . 'Leaflet_GeoSearch/';
	$routing = $vendors_url . 'Leaflet_routing_machine/';
	$markercluster = $vendors_url . 'Leaflet_markercluster/';

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
	*/
	
	// Register a page handler
	elgg_register_page_handler('leaflet','leaflet_page_handler');
	
	// Register geocoder
	elgg_register_plugin_hook_handler('geocode', 'location', 'leaflet_geocode');
	
}



/** leaflet page handler
 * home | index | null => home page
 * geocode/ => geocoding tool
 * search/ => search page
 * world/ => global admin page
 */
function leaflet_page_handler($page) {
	global $CONFIG;
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
		/* 
		// GOOGLE API
		$google_api = get_plugin_setting('google_api', 'googlegeocoder');
		// Desired address
		$address = "http://maps.google.com/maps/geo?q=".urlencode($params['location'])."&output=json&key=" . $google_api;
		// Retrieve the URL contents
		$result = file_get_contents($address);
		$obj = json_decode($result);
		$obj = $obj->Placemark[0]->Point->coordinates;
		*/
		
		// Mapquest API
		$api_key = elgg_get_plugin_setting('osm_api_key', 'leaflet');
		if (empty($api_key)) $api_key = elgg_get_plugin_setting('api_key', 'osm_maps');
		if (empty($api_key)) {
			error_log("LEAFLET : missing API key. Cannot geocode.");
			return false;
		}
		//$callback = get_input('callback', 'renderOptions');
		$inFormat = get_input('inFormat', 'kvp');
		$outFormat = get_input('outFormat', 'json');
		$maxResults = get_input('maxResults', '1');
		$location = urlencode($params['location']);

		// Desired address
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
	
	// Don't save geocoded address if wrong result
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




