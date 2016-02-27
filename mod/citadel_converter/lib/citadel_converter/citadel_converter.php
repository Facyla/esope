<?php
//session_start();
$version = "0.2";

// Fix UTF-8 encoding
require_once(elgg_get_plugins_path() . 'citadel_converter/vendors/ForceUTF8/Encoding.php');
use \ForceUTF8\Encoding;

/* Converter lib should :
 * Take a CSV file as input
 * Use a predefined conversion settings
 * output a ready-to-use JSON file
 * cache it until original CSV has changed and/or using validity metadata
 */



// Init : create required dirs if they do not exist
$dataroot_path = elgg_get_data_path() . 'citadel_converter/';
if (!file_exists($dataroot_path)) { mkdir($dataroot_path, 0777, true); }
if (!file_exists($dataroot_path . 'samples/')) { mkdir($dataroot_path . 'samples/', 0777, true); }
if (!file_exists($dataroot_path . 'cache/')) { mkdir($dataroot_path . 'cache/', 0777, true); }
if (!file_exists($dataroot_path . 'urldata/')) { mkdir($dataroot_path . 'urldata/', 0777, true); }



/*
		$filename = $_SESSION['dataset-id'];
		if ($id == null || empty($id)) {
			$filename = 'dataset';
		}
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json; charset=UTF-8');
		header('Content-disposition: attachment;filename="'.$filename.'.json"');
		echo $_SESSION['dataset-json'];
*/


/*
function citadel_converter_getDatasetPreview($lines = 0) {
	$preview = "";
	if ($lines > 0) {
		$content = file($_SESSION['dataset']);
		
		for ($i = 0; $i < $lines && $i < count($content); $i++) {
			$preview = $preview . toUTF8($content[$i]);
		}
	}
	else {
		$content = file_get_contents($_SESSION['dataset']);
		$preview = toUTF8($content);
	}
	
	return $preview;
}
*/



/* Return Citadel-JSON from any CSV file, using a pre-defined template mapping
 * $dataset : the dataset array (as if created from a CSV file, one row per POI)
 * $skipFirstRow : whether first row is a label or not
 */
function citadel_converter_renderJSON($dataset, $template) {
	global $template;
	global $array_mapping;
	$skipFirstRow = $template['skip-first-row'];
	$array_mapping = citadel_converter_setArrayMapping($dataset[0]);
	$now = new DateTime();
	
	// Build the JSON
	$json = new stdClass();
	$json->dataset = new stdClass();
	
	// Metadata fields
	$json->dataset->id = (string) $template['metadata']['dataset-id'];
	$json->dataset->updated = $now->format('c');
	$json->dataset->created = $now->format('c');
	$json->dataset->lang = $template['metadata']['dataset-lang'];
	$json->dataset->author = new stdClass();
	$json->dataset->author->id = $template['metadata']['dataset-author-id'];
	$json->dataset->author->value = $template['metadata']['dataset-author-name'];
	$json->dataset->license = new stdClass();
	$json->dataset->license->href = $template['metadata']['dataset-license-url'];
	$json->dataset->license->term = $template['metadata']['dataset-license-term'];
	$json->dataset->link = new stdClass();
	$json->dataset->link->href = $template['metadata']['dataset-source-url'];
	$json->dataset->link->term = $template['metadata']['dataset-source-term'];
	$json->dataset->updatefrequency = $template['metadata']['dataset-update-frequency'];
	
	$defaultCategories = $template['mapping']['dataset-poi-category-default'];
	$defaultCategories = explode(',', $defaultCategories);
	
	$json->dataset->poi = array();
	
	// Data content
	// @TODO : replace by a foreach loop
	//for ($i = $skipFirstRow ? 1 : 0; $i < count($dataset); $i++) {
	//	$poiArray = $dataset[$i];
	//}
	$i = 0;
	foreach ($dataset as $poiArray) {
		$i++;
		// Skip first row if set as headers row
		if (($i == 1) && $skipFirstRow) continue;
		$poiObj = new StdClass();
		$poiObj->id = (string) citadel_converter_getValue($poiArray, 'dataset-poi-id');
		// Set incremental id if no defined id in the dataset (required by apps)
		//if (empty($poiObj->id)) { $poiObj->id = $i + 1; }
		if (empty($poiObj->id)) { $poiObj->id = (string) $i; }
		$poiObj->title = citadel_converter_getValue($poiArray, 'dataset-poi-title');
		$poiObj->description = citadel_converter_getValue($poiArray, 'dataset-poi-description');
		if ($poiObj->description == null) {
			$poiObj->description = "";
		}
		// Allow to add all available data into a single field
		if ($template['mapping']['dataset-poi-description'] == 'all') {
			$poiObj->description = '';
			//echo print_r($array_mapping, true); exit;
			foreach($array_mapping as $name => $key) {
				if (!empty($poiArray[$key])) $poiObj->description .= '<strong>' . $name . '&nbsp;:</strong> ' . $poiArray[$key] . '<br />';
			}
		}
		$poiObj->category = explode(',', citadel_converter_getValue($poiArray, 'dataset-poi-category'));
		array_walk($poiObj->category, create_function('&$val', '$val = trim($val);'));
		if (count($poiObj->category) == 0 || (count($poiObj->category) == 1 && $poiObj->category[0] == '')) {
			$poiObj->category = $defaultCategories;
		}
		$location = new StdClass();
		$location->point = new StdClass();
		$location->point->term = "centroid";
		$location->point->pos = new StdClass();
		$location->point->pos->srsName = ($template['mapping']['dataset-coordinate-system'] == "WGS84") ? "http://www.opengis.net/def/crs/EPSG/0/4326" : "";
		if ($template['mapping']['dataset-poi-lat'] == $template['mapping']['dataset-poi-long']) {
			$latlong = citadel_converter_getValue($poiArray, 'dataset-poi-lat');
			$latlong = trim(str_replace(';', ' ', $latlong));
			$location->point->pos->posList = $latlong;
		} else {
			$location->point->pos->posList = trim(citadel_converter_getValue($poiArray, 'dataset-poi-lat')) . ' ' . trim(citadel_converter_getValue($poiArray, 'dataset-poi-long'));
		}
		// Invalid coordinates break the file validity, so forget about them !
		if ($location->point->pos->posList == " ") { continue; }
		$location->address = new StdClass();
		$location->address->value = citadel_converter_getValue($poiArray, 'dataset-poi-address');
		$location->address->postal = citadel_converter_getValue($poiArray, 'dataset-poi-postal');
		$location->address->city = citadel_converter_getValue($poiArray, 'dataset-poi-city');
		$poiObj->location = $location;
		$poiObj->attribute = array();

		$json->dataset->poi[] = $poiObj;
	}
	
	// Export json (handle older versions of JSON encoding functions)
	return citadel_converter_export_json($json);
}



/* Return geoJSON + Citadel JSON from any CSV file, using a pre-defined template mapping
 * Includes the Citadel JSON fields in it as well
 * $dataset : the dataset array (from a CSV file, one row per POI)
 * $skipFirstRow : whether first row is a label or not
 */
// @TODO : consider 2 cases
// 	1) export CSV file to geoJSON + Citadel JSON
// 	2) if we already have geoJSON, don't modify it at all, and only add the new Citadel JSON
// 	=> We need to merge export functions and add input and export parameters
function citadel_converter_renderGeoJSON($dataset, $template) {
	global $template;
	global $array_mapping;
	$skipFirstRow = $template['skip-first-row'];
	$array_mapping = setArrayMapping($dataset[0]);
	$now = new DateTime();
	
	// Build the JSON
	$json = new stdClass();
	
	// Build the Citadel JSON
	$json->dataset = new stdClass();
	
	// Metadata fields
	$json->dataset->id = (string) $template['metadata']['dataset-id'];
	$json->dataset->updated = $now->format('c');
	$json->dataset->created = $now->format('c');
	$json->dataset->lang = $template['metadata']['dataset-lang'];
	$json->dataset->author = new stdClass();
	$json->dataset->author->id = $template['metadata']['dataset-author-id'];
	$json->dataset->author->value = $template['metadata']['dataset-author-name'];
	$json->dataset->license = new stdClass();
	$json->dataset->license->href = $template['metadata']['dataset-license-url'];
	$json->dataset->license->term = $template['metadata']['dataset-license-term'];
	$json->dataset->link = new stdClass();
	$json->dataset->link->href = $template['metadata']['dataset-source-url'];
	$json->dataset->link->term = $template['metadata']['dataset-source-term'];
	$json->dataset->updatefrequency = $template['metadata']['dataset-update-frequency'];
	
	$defaultCategories = $template['mapping']['dataset-poi-category-default'];
	$defaultCategories = explode(',', $defaultCategories);
	
	$json->dataset->poi = array();
	
	// Data content
	$i = 0;
	foreach ($dataset as $poiArray) {
		$i++;
		// Skip first row if set as headers row
		if (($i == 1) && $skipFirstRow) continue;
		$poiObj = new StdClass();
		$poiObj->id = (string) citadel_converter_getValue($poiArray, 'dataset-poi-id');
		// Set incremental id if no defined id in the dataset (required by apps)
		//if (empty($poiObj->id)) { $poiObj->id = $i + 1; }
		if (empty($poiObj->id)) { $poiObj->id = (string) $i; }
		$poiObj->title = citadel_converter_getValue($poiArray, 'dataset-poi-title');
		$poiObj->description = citadel_converter_getValue($poiArray, 'dataset-poi-description');
		if ($poiObj->description == null) {
			$poiObj->description = "";
		}
		// Allow to add all available data into a single field
		if ($template['mapping']['dataset-poi-description'] == 'all') {
			$poiObj->description = '';
			foreach($array_mapping as $key => $name) {
				if (!empty($poiArray[$key])) $poiObj->description .= '<strong>' . $name . '&nbsp;:</strong> ' . $poiArray[$key] . '<br />';
			}
		}
		$poiObj->category = explode(',', citadel_converter_getValue($poiArray, 'dataset-poi-category'));
		array_walk($poiObj->category, create_function('&$val', '$val = trim($val);'));
		if (count($poiObj->category) == 0 || (count($poiObj->category) == 1 && $poiObj->category[0] == '')) {
			$poiObj->category = $defaultCategories;
		}
		$location = new StdClass();
		$location->point = new StdClass();
		$location->point->term = "centroid";
		$location->point->pos = new StdClass();
		$location->point->pos->srsName = ($template['mapping']['dataset-coordinate-system'] == "WGS84") ? "http://www.opengis.net/def/crs/EPSG/0/4326" : null;
		if ($template['mapping']['dataset-poi-lat'] == $template['mapping']['dataset-poi-long']) {
			$latlong = citadel_converter_getValue($poiArray, 'dataset-poi-lat');
			$latlong = trim(str_replace(';', ' ', $latlong));
			$location->point->pos->posList = $latlong;
		} else {
			$location->point->pos->posList = trim(getValue($poiArray, 'dataset-poi-lat')) . ' ' . trim(getValue($poiArray, 'dataset-poi-long'));
		}
		// Invalid coordinates break the file validity, so forget about them !
		if ($location->point->pos->posList == " ") { continue; }
		$location->address = new StdClass();
		$location->address->value = citadel_converter_getValue($poiArray, 'dataset-poi-address');
		$location->address->postal = citadel_converter_getValue($poiArray, 'dataset-poi-postal');
		$location->address->city = citadel_converter_getValue($poiArray, 'dataset-poi-city');
		$poiObj->location = $location;
		$poiObj->attribute = array();

		$json->dataset->poi[] = $poiObj;
	}
	
	// Build the geoJSON
	$json->type = "FeatureCollection";
	$json->generator = "Citadel on the Move PHP converter";
	$json->copyright = $template['metadata']['dataset-license-term'] . ' ' . $template['metadata']['dataset-license-url'];
	$json->timestamp = $now->format('c');
	$json->features = new stdClass();
	
	$json->features = array();
	
	// Data content
	// @TODO : replace by a foreach loop
	//for ($i = $skipFirstRow ? 1 : 0; $i < count($dataset); $i++) {
	//	$poiArray = $dataset[$i];
	//}
	$i = 0;
	foreach ($dataset as $poiArray) {
		$i++;
		// Skip first row if set as headers row
		if (($i == 1) && $skipFirstRow) continue;
		$poiObj = new StdClass();
		$poiObj->type = "Feature";
		$poiObj->id = (string) citadel_converter_getValue($poiArray, 'dataset-poi-id');
		// Set incremental id if no defined id in the dataset (required by apps)
		//if (empty($poiObj->id)) { $poiObj->id = $i + 1; }
		if (empty($poiObj->id)) { $poiObj->id = (string) $i; }
		// Build Feature properties
		$poiObj->properties = new StdClass();
		$poiObj->properties->title = citadel_converter_getValue($poiArray, 'dataset-poi-title');
		$poiObj->properties->description = citadel_converter_getValue($poiArray, 'dataset-poi-description');
		if ($poiObj->properties->description == null) {
			$poiObj->properties->description = "";
		}
		$poiObj->properties->category = explode(',', citadel_converter_getValue($poiArray, 'dataset-poi-category'));
		array_walk($poiObj->properties->category, create_function('&$val', '$val = trim($val);'));
		if (count($poiObj->properties->category) == 0 || (count($poiObj->properties->category) == 1 && $poiObj->properties->category[0] == '')) {
			$poiObj->properties->category = $defaultCategories;
		}
		$poiObj->properties->address = citadel_converter_getValue($poiArray, 'dataset-poi-address');
		$poiObj->properties->postal = citadel_converter_getValue($poiArray, 'dataset-poi-postal');
		$poiObj->properties->city = citadel_converter_getValue($poiArray, 'dataset-poi-city');
		// Build Point properties
		$location = new StdClass();
		$location->type = "Point";
		$location->coordinates = array();
		if ($template['mapping']['dataset-poi-lat'] == $template['mapping']['dataset-poi-long']) {
			$latlong = citadel_converter_getValue($poiArray, 'dataset-poi-lat');
			$latlong = trim($latlong);
			$latlong = explode(';', $latlong);
			$location->coordinates = array((float) $latlong[1], (float) $latlong[0]);
		} else {
			$latlong = array((float) trim(getValue($poiArray, 'dataset-poi-long')), (float) trim(getValue($poiArray, 'dataset-poi-lat')));
			$location->coordinates = $latlong;
		}
		$poiObj->geometry = $location;

		$json->features[] = $poiObj;
	}
	
	
	// Export json (handle older versions of JSON encoding functions)
	return citadel_converter_export_json($json);
}


/* Gets the value of the specified (semantic) key in a data line
 * $poiArray : an array representing a row of CSV data
 * $key : the name of the wanted key in the Citadel-JSON schema
 */
function citadel_converter_getValue($poiArray, $key) {
	// Get the semantic => CSV name mapping
	global $template;
	// Get the CSV name => array key mapping
	global $array_mapping;
	if (empty($template) || empty($array_mapping)) {
		register_error("ERROR : empty template or array_mapping");
		return false;
	}
	// Return value only if mapping defined
	if ($template['mapping']["$key"] !== "") {
		// Find CSV name from semantic JSON name mapping
		$map_key = $template['mapping']["$key"];
		// Find array index from CSV name mapping
		if (isset($array_mapping["$map_key"])) {
			$array_key = $array_mapping["$map_key"];
		} else {
			register_error("DEBUG : missing key : key=$key => map_key=$map_key does not exist in array_mapping");
		}
		//echo "$key => $map_key => $array_key = {$poiArray[$array_key]}<br />";
		//echo print_r($poiArray, true) . '<hr />';
		//if ($key == "dataset-poi-title") register_error("DEBUG : $key => " . $map_key . " / " . $array_key . " / " . $poiArray["$array_key"]);
		// Return the extracted value
		if ($array_key !== null) {
			return $poiArray["$array_key"];
		} else {
			register_error("DEBUG : empty array_key for key=$key, map_key=$map_key");
			return "";
		}
	}
	return "";
}


/* Translates the labels from the CSV file into a key mapping
 * The resulting array is used to process the CSV lines arrays
 * This is required because the dataset array from CSV does not have named keys
 * 
 * $labels : the actual labels OR the first line of data, in array form 
 *           (we need to count columns even if there is no label)
 * 
 * Note : is there is no label (data starts at line 1), this function citadel_converter_will use 
 *        array index numbers instead of named keys.
 * Important : array index numbers start at 0 and not 1 (1 less than column number) :
 *             so column 1 becomes index 0, column 2 becomes index 1, etc.
 */
function citadel_converter_setArrayMapping($labels) {
	global $template;
	if ($template['skip-first-row']) {
		$labels = array_map("\ForceUTF8\Encoding::toUTF8", $labels);
		$array_mapping = array_flip($labels);
	} else {
		for ($i = 0; $i < count($labels); $i++) {
			$array_mapping["$i"] = "$i";
		}
	}
	//echo "ARRAY MAPPING => " . print_r($array_mapping, true) . '<hr />';
	return $array_mapping;
}


// Get the dataset as an array : one array entry per "row" or POI
// The first row should be the dataset column labels (for easier mapping)
function citadel_converter_getCSVDataset($dataset, $delimiter = ';', $enclosure = '"', $escape = '\\') {
	$result = array();
	$content = file($dataset);
	if ($content) {
		foreach ($content as $line) {
			$result[] = str_getcsv(\ForceUTF8\Encoding::toUTF8($line), $delimiter, $enclosure, $escape);
		}
		return $result;
	} else return false;
}


// See http://stackoverflow.com/questions/10290849/how-to-remove-multiple-utf-8-bom-sequences-before-doctype
// BOM and other binary characters break json_decode...
function citadel_converter_remove_utf8_bom($text) {
	$bom = pack('H*','EFBBBF');
	$text = preg_replace("/^$bom/", '', $text);
	return $text;
}

/* Gets a file from an URL */
function citadel_converter_get_file($url) {
	// File retrieval can fail on timeout or redirects, so make it more failsafe
	$context = stream_context_create(array('http' => array('max_redirects' => 5, 'timeout' => 60)));
	// using timestamp and URL hash for quick retrieval based on time and URL source unicity
	return file_get_contents($url, false, $context);
}


// Get the geoJSON dataset
function citadel_converter_getGeoJSON($dataset) {
	$result = array();
	$file_content = citadel_converter_get_cached_file($dataset);
	
	// Give a try
	$json_obj = json_decode($file_content);
	if (!is_null($json_obj)) return $json_obj;
	
	// If not good yet, try to do some sanitize
	$geojson = utf8_encode($file_content);
	$geojson = str_replace(array("\n","\r"),"",$geojson); 
	$geojson = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$geojson); 
	$geojson = preg_replace('/(,)\s*}$/','}',$geojson);
	$geojson = remove_utf8_bom($geojson);
	$geojson = preg_replace_callback('/([\x{0000}-\x{0008}]|[\x{000b}-\x{000c}]|[\x{000E}-\x{001F}])/u', function($sub_match){return '\u00' . dechex(ord($sub_match[1]));},$geojson);
	//echo $geojson . '<hr />';
	
	// This will remove unwanted characters.
	// Check http://www.php.net/chr for details
	for ($i = 0; $i <= 31; ++$i) { 
		$geojson = str_replace(chr($i), "", $geojson); 
	}
	$geojson = str_replace(chr(127), "", $geojson);
	// This is the most common part
	// Some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
	// here we detect it and we remove it, basically it's the first 3 characters 
	if (0 === strpos(bin2hex($geojson), 'efbbbf')) { $geojson = substr($geojson, 3); }
	
	//$geojson = json_decode($geojson, false, 512, JSON_BIGINT_AS_STRING);
	$json_obj = json_decode($geojson, false, 512);
	
	if ($json_obj === null) {
		echo json_last_error();
		// Définie les erreurs
		$constants = get_defined_constants(true);
		$json_errors = array();
		foreach ($constants["json"] as $name => $value) {
			if (!strncmp($name, "JSON_ERROR_", 11)) {
				$json_errors[$value] = $name;
			}
		}
		register_error('Dernière erreur : ' . $json_errors[json_last_error()]);
		// Affiche les erreurs pour les différentes profondeurs.
		foreach (range(12, 1, -1) as $depth) {
			var_dump(json_decode($geojson, true, $depth));
			register_error('Niveau ' . $depth . ' : erreur : ' . $json_errors[json_last_error()]);
		}
	}
	
		//echo print_r($json_obj, true); // debug
		return $json_obj;
	}

// Transform the geoJSON dataset into an array : one array entry per "row" == POI
// The first row should be the dataset column labels (for easier mapping)
function citadel_converter_getGeoJSONDataset($geojson) {
	$result = array();
	if ($geojson) {
		switch($geojson->type) {
			case "FeatureCollection":
				// Build coordinates keys first
				$keys = array('longitude', 'latitude');
				// Build properties keys and use them as we would with "first CSV line"
				foreach($geojson->features[0]->properties as $key => $val) { $keys[] = $key; }
				//echo print_r($keys, true) . '<hr />';
				$result[] = $keys;
				foreach($geojson->features as $element) {
					$poi = array($element->geometry->coordinates[0], $element->geometry->coordinates[1]);
					// Add POI data
					foreach($keys as $key) {
						if (in_array($key, array('longitude', 'latitude'))) continue;
						$poi[] = (string) $element->properties->$key;
					}
					$result[] = $poi;
					//echo print_r($poi, true) . '<hr />';
				}
				break;
			case "Feature":
				// Only one feature in this file ??
			case "Point":
			default:
				// Valid geoJSON but pointless
				return false;
		}
		return $result;
	} else return false;
}


// Transform the osmJSON dataset into an array : one array entry per "row" == POI
// The first row should be the dataset column labels (for easier mapping)
// Note that OSM JSON data can be exported directly by Overpass API
function citadel_converter_getOsmJSONDataset($osmjson) {
	$result = array();
	//$main_keys = array('id', 'longitude', 'latitude');
	$main_keys = array('id', 'longitude', 'latitude');
	$title_keys = $main_keys;
	if ($osmjson) {
		
		// Build label keys first
		foreach($osmjson->elements as $element) {
			if ($element->type != "node") continue;
			foreach($element->tags as $key => $tag) {
				if (!in_array($key, $title_keys)) $title_keys[] = (string) $key;
			}
		}
		$result[] = $title_keys;
		
		// Build properties keys and use them as we would with "first CSV line"
		//echo print_r($keys, true) . '<hr />';
		foreach($osmjson->elements as $element) {
			// We currently only accept nodes (= POI), and not way, etc.
			if ($element->type != "node") continue;
			$poi = array((string) $element->id, (string) $element->lon, (string) $element->lat);
			//echo "TEST $element->id, (string) $element->lon, (string) $element->lat<br />";
			// Add POI data - like in csv so use always the same order
			foreach($title_keys as $key) {
				if (in_array($key, $main_keys)) continue;
				$poi[] = (string) $element->tags->{$key};
			}
			$result[] = $poi;
			//echo print_r($poi, true) . '<hr />';
		}
		return $result;
	} else return false;
}


// Converts anything to UTF-8
function citadel_converter_toUTF8($str) {
	// Make the conversion
	$encoding = \ForceUTF8\Encoding::getEncoding($str);
	if ($encoding == 'UTF-8') {
		return \ForceUTF8\Encoding::toUTF8($str);
	} else {
		return \ForceUTF8\Encoding::fixUTF8($str);
	}
}

// Gets the current encoding
function citadel_converter_getEncoding($str) {
	$enc_order = array('ASCII', 'JIS', 'UTF-8', 'ISO-8859-1', 'WINDOWS-1521');
	//$enc_order = array('UTF-8', 'ASCII', 'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 'Windows-1251', 'Windows-1252', 'Windows-1254');
	$enc_order = implode(', ', $enc_order);
	// Note : function citadel_converter_accepts array or comma-separated list
	return mb_detect_encoding($str, $enc_order);
}


// Encode an PHP Object into JSON
function citadel_converter_export_json($json) {
	// Handle older versions of JSON encoding functions
	if (version_compare(phpversion(), '5.4', '<')) {
		// PHP < 5.4 doesn't excape unicode (you end up with \u00 characters)
		// So we need to convert it before returning the content
		$json = json_encode($json);
		return preg_replace_callback(
			'/\\\\u([0-9a-f]{4})/i',
			function ($matches) {
				$sym = mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
				return $sym;
			}, 
			$json
		);
	} else {
		return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	}
}


// Write file to disk
function citadel_converter_write_file($target_file = "", $content = '') {
	if ($fp = fopen($target_file, 'w')) {
		fwrite($fp, $content);
		fclose($fp);
		return true;
	}
	return false;
}


/* Returns a (locally) cached file, or get the file from its live source if not recent enough
 * $url : source URL to be fetched
 * $range = date string mask to be used for caching updates, or false to force update
   eg. 'Ymd' for daily update, YmdHis for every second...
 */
function citadel_converter_get_cached_file($url = '', $range = 'Ymd') {
	// Return file is no cache wanted
	if (!$range) { return citadel_converter_get_file($url); }
	// Use cache : get the cached file, or retrieve and cache it
	if ($range) {
		// Use date first so we can rotate it if needed...
		$dataroot_path = elgg_get_data_path() . 'citadel_converter/';
		$cached_filename = $dataroot_path . 'cache/' . date($range) . '_' . md5($url);
		// Return cached file
		if (file_exists($cached_filename)) { return citadel_converter_get_file($cached_filename); }
		// Or create a new one
		$file_content = citadel_converter_get_file($url);
		citadel_converter_write_file($cached_filename, $file_content);
		return $file_content;
	}
	// Should not get there...
	return false;
}




