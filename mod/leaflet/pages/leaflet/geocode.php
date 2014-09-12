<?php
global $CONFIG;

echo "Le geocoding est implémenté directement via le hook du core, voir dans le start.php (ou lib/) du plugin. Décommenter cette ligne pour des tests."; exit;

$content = '';

$api_key = elgg_get_plugin_setting('osm_api_key', 'leaflet');
if (empty($api_key)) $api_key = elgg_get_plugin_setting('api_key', 'osm_maps');

$inFormat = get_input('inFormat', 'kvp');
$outFormat = get_input('outFormat', 'json');
$location = get_input('location', 'France');
$maxResults = get_input('maxResults', '3');

$geocode_url = "http://open.mapquestapi.com/geocoding/v1/address?key=$api_key&callback=$callback&inFormat=$inFormat&outFormat=$outFormat&location=$location&maxResults=$maxResults";

// Retrieve the URL contents
$result = file_get_contents($geocode_url);
$obj = json_decode($result); // true returns array[][] instead of object->->
$latlong = $obj->results[0]->locations[0]->latLng;
$lat = $latlong->lat;
$long = $latlong->lng;
$content .= $lat . ',' . $long;

/* JSON respone data structure
[results]
  [0]
    [locations] => Array
      [0] => Array
        [latLng] => Array
          [lng] => 2.295942
          [lat] => 48.753554
        [adminArea4] => Antony
        [adminArea5Type] => City
        [adminArea4Type] => County
        [adminArea5] => Antony
        [street] => 
        [adminArea1] => France
        [adminArea3] => Île-de-France
        [type] => s
        [displayLatLng] => Array
          [lng] => 2.295942
          [lat] => 48.753554
        [linkId] => 0
        [postalCode] => 92160
        [sideOfStreet] => N
        [dragPoint] => 
        [adminArea1Type] => Country
        [geocodeQuality] => ZIP
        [geocodeQualityCode] => Z1XAX
        [mapUrl] => http://open.mapquestapi.com/staticmap/v4/getmap?key=Fmjtd|luub2q02nh,7g=o5-9u7l56&type=map&size=225,160&pois=purple-1,48.753554,2.2959423,0,0|&center=48.753554,2.2959423&zoom=12&rand=-321780040
        [adminArea3Type] => State
      [1] => idem...
    [providedLocation]
      [location] => Antony,France
      [options] => Array
        [ignoreLatLngInput] => 
        [maxResults] => 3
        [thumbMaps] => 1
    [info] => Array
      [copyright] => Array
        [text] => © 2013 MapQuest, Inc.
        [imageUrl] => http://api.mqcdn.com/res/mqlogo.gif
        [imageAltText] => © 2013 MapQuest, Inc.
      [statuscode] => 0
      [messages] => Array
*/
//$response = file_get_contents($geocode_url);
//$response = str_replace(array('renderOptions(', ');'), '', $response);
//$geocoded_data = json_decode($response);


// Envoi des données
header('Content-Type: text/html; charset=utf-8');
echo $content;

