<?php
//require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php');
global $CONFIG;

$iconSize = '32,32';
$iconOffset = '0,-32';
//$popupSize = '200,80';
$iconUrl = $CONFIG->url . 'mod/leaflet/graphics/alerte-48.png';


$format = get_input('format', 'openlayers');
$limit = get_input('limit', 10);
$offset = get_input('offset', 0);

// Data sheet header
// OpenLayers data format
switch ($format) {
	case 'geojson':
		$geo_data = "";
		break;
	case 'openlayers':
	default:
		$geo_data = "lat	lon	icon	iconSize	iconOffset	title	description\n";
}

$members = elgg_get_entities(array('types' => 'user', 'limit' => $limit, 'offset' => $offset));

$i = 0;
foreach ($members as $ent) {
	$geo_location = elgg_geocode_location($ent->getLocation());
	$lat = (float)$geo_location['lat'];
	$lon = (float)$geo_location['long'];
	if ("$lat $lon" == '0 0') continue;
	$i++;
	
	//echo $ent->name . ' : ' . $ent->getLocation() . ' => ' . print_r($geo_location, true) . ' - ' . $lat . ' , ' . $long . ' - ' . $ent->getLatitude() . ' , ' . $ent->getLongitude() . "<br />";
	$title = $ent->name;
	$description = $ent->briefdescription . '<br />' . implode(', ', $ent->tags);
	$icon = $ent->getIconUrl('small');
	
	// Output entity geo data
	switch ($format) {
		case 'geojson':
			$style = '';
			// <img src="' . $icon . '" style="float:right; margin-left:8px;" />
			$content = '<strong>' . $title . '</strong><br />' . $description;
			$geo_data .= elgg_view('feature/point', array('id' => $i, 'content' => $content, 'coordinates' => "$lon, $lat", 'style' => $style), false, false, 'geojson');
			break;
		case 'openlayers':
		default:
			$geo_data .= "$lat	$lon	$icon	$iconSize	$iconOffset	$title	$description\n";
	}
	
}

// Data sheet content
//$geo_data .= "$lat	$lon	$iconSize	$iconOffset	$title	$description	$iconUrl";
//$geo_data .= "48.75	2.311	$iconUrl	32,32	0,-32	Test	Un autre <b>point d'intérêt</b>.\n";
//$geo_data .= "48.751	2.311	$iconUrl	48,48	0,-48	Titre 1	Légende de ce point 1\n";
//$geo_data .= "48.749	2.309	$iconUrl	16,16	0,-16	Titre 2	Légende de ce point 2\n";

// Envoi des données
switch ($format) {
	case 'geojson':
		header('Content-Type: text/javascript; charset=utf-8');
		echo 'var membersData = {"type": "FeatureCollection", "features": [ ';
		echo $geo_data;
		echo ' ] };';
		break;
	case 'openlayers':
	default:
		header('Content-Type: text/html; charset=utf-8');
		echo $geo_data;
}


/*
Appel via : <script src="sample-geojson.js" type="text/javascript"></script>

Puis dans le JS :
		L.geoJson(freeBus, {
			filter: function (feature, layer) {
				if (feature.properties) {
					// If the property "underConstruction" exists and is true, return false (don't render features under construction)
					return feature.properties.underConstruction !== undefined ? !feature.properties.underConstruction : true;
				}
				return false;
			},

			onEachFeature: onEachFeature
		}).addTo(map);


Avec contenu de sample-geojson.js :

var freeBus = {
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": [
                    [-105.00341892242432, 39.75383843460583],
                    [-105.0008225440979, 39.751891803969535]
                ]
            },
            "properties": {
                "popupContent": "This is free bus that will take you across downtown.",
                "underConstruction": false
            },
            "id": 1
        },
        {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": [
                    [-105.0008225440979, 39.751891803969535],
                    [-104.99820470809937, 39.74979664004068]
                ]
            },
            "properties": {
                "popupContent": "This is free bus that will take you across downtown.",
                "underConstruction": true
            },
            "id": 2
        },
        {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": [
                    [-104.99820470809937, 39.74979664004068],
                    [-104.98689651489258, 39.741052354709055]
                ]
            },
            "properties": {
                "popupContent": "This is free bus that will take you across downtown.",
                "underConstruction": false
            },
            "id": 3
        }
    ]
};

var lightRailStop = {
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {
                "popupContent": "18th & California Light Rail Stop"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [-104.98999178409576, 39.74683938093904]
            }
        },{
            "type": "Feature",
            "properties": {
                "popupContent": "20th & Welton Light Rail Stop"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [-104.98689115047453, 39.747924136466565]
            }
        }
    ]
};

var bicycleRental = {
    "type": "FeatureCollection",
    "features": [
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9998241,
                    39.7471494
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 51
        },
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9983545,
                    39.7502833
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 52
        },
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9963919,
                    39.7444271
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 54
        },
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9960754,
                    39.7498956
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 55
        },
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9933717,
                    39.7477264
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 57
        },
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9913392,
                    39.7432392
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 58
        },
        {
            "geometry": {
                "type": "Point",
                "coordinates": [
                    -104.9788452,
                    39.6933755
                ]
            },
            "type": "Feature",
            "properties": {
                "popupContent": "This is a B-Cycle Station. Come pick up a bike and pay by the hour. What a deal!"
            },
            "id": 74
        }
    ]
};

var campus = {
    "type": "Feature",
    "properties": {
        "popupContent": "This is the Auraria West Campus",
        "style": {
            weight: 2,
            color: "#999",
            opacity: 1,
            fillColor: "#B0DE5C",
            fillOpacity: 0.8
        }
    },
    "geometry": {
        "type": "MultiPolygon",
        "coordinates": [
            [
                [
                    [-105.00432014465332, 39.74732195489861],
                    [-105.00715255737305, 39.74620006835170],
                    [-105.00921249389647, 39.74468219277038],
                    [-105.01067161560059, 39.74362625960105],
                    [-105.01195907592773, 39.74290029616054],
                    [-105.00989913940431, 39.74078835902781],
                    [-105.00758171081543, 39.74059036160317],
                    [-105.00346183776855, 39.74059036160317],
                    [-105.00097274780272, 39.74059036160317],
                    [-105.00062942504881, 39.74072235994946],
                    [-105.00020027160645, 39.74191033368865],
                    [-105.00071525573731, 39.74276830198601],
                    [-105.00097274780272, 39.74369225589818],
                    [-105.00097274780272, 39.74461619742136],
                    [-105.00123023986816, 39.74534214278395],
                    [-105.00183105468751, 39.74613407445653],
                    [-105.00432014465332, 39.74732195489861]
                ],[
                    [-105.00361204147337, 39.74354376414072],
                    [-105.00301122665405, 39.74278480127163],
                    [-105.00221729278564, 39.74316428375108],
                    [-105.00283956527711, 39.74390674342741],
                    [-105.00361204147337, 39.74354376414072]
                ]
            ],[
                [
                    [-105.00942707061768, 39.73989736613708],
                    [-105.00942707061768, 39.73910536278566],
                    [-105.00685214996338, 39.73923736397631],
                    [-105.00384807586671, 39.73910536278566],
                    [-105.00174522399902, 39.73903936209552],
                    [-105.00041484832764, 39.73910536278566],
                    [-105.00041484832764, 39.73979836621592],
                    [-105.00535011291504, 39.73986436617916],
                    [-105.00942707061768, 39.73989736613708]
                ]
            ]
        ]
    }
};

var coorsField = {
    "type": "Feature",
    "properties": {
        "popupContent": "Coors Field"
    },
    "geometry": {
        "type": "Point",
        "coordinates": [-104.99404191970824, 39.756213909328125]
    }
};
*/

