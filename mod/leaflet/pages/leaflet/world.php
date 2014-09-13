<?php
/**
 * Elgg mobile_apps global browser
 * 
 * @package Elggmobile_apps
 * @author Facyla ~ Florian DANIEL
 * @copyright Datawyz 2014
 * @link http://datawyz.com/
 */

/* Notes :
 * Started by a Leaflet map
 * Added controls, markers, basic interaction
 * Added awesome markers
 * 
 */

/* TODO : 
	load markers from external/generated file
	provide map URL (with access code)
*/

global $CONFIG;

$guid = get_input('id', false);


// Add cache manifest without bothering dynamic pages
$body = '<iframe src="' . $CONFIG->url . 'appcache" style="width:0; height:0; position:absolute; left:-1000px;"></iframe>';

$body .= '<div id="map"></div>
	
	<script type="text/javascript">
		
		// Base map
		var map = L.map(\'map\');
		
		// Tile layer
		L.tileLayer(\'http://{s}.tile.cloudmade.com/869bb03572004980b599159bd1195ef0/997/256/{z}/{x}/{y}.png\', {
			attribution: \'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>\',
			maxZoom: 18
		}).addTo(map);
		
		// Location found alert
		function onLocationFound(e) {
			var radius = e.accuracy / 2;
			L.marker(e.latlng).addTo(map)
				//.bindPopup("Vous êtes à environ " + radius + " mètres de ce point").openPopup(); // Ouverture auto
				.bindPopup("Vous êtes à environ " + radius + " mètres de ce point"); // Sans ouverture auto
			L.circle(e.latlng, radius).addTo(map);
		}
		
		// Location error alert
		function onLocationError(e) {
			alert(e.message);
		}
		
		map.on(\'locationfound\', onLocationFound);
		map.on(\'locationerror\', onLocationError);
		map.locate({setView: true, maxZoom: 16});
		
		
		// MARKERS
		// Add markers to map - basic marker
		var marker = L.marker([48.86023, 2.36818]).addTo(map);
		// Add popup to marker
		marker.bindPopup("<b>Lieu de réunion</b><br>C\'est au bureau !").openPopup();
		
		// Creates a red marker with the coffee icon
		var redMarker = L.AwesomeMarkers.icon({
			prefix: \'fa\',
			icon: \'beer\',
			markerColor: \'red\'
		});
		var marker2 = L.marker([48.86049, 2.3678], {icon: redMarker}).addTo(map);
		marker2.bindPopup("<b>Réunion au sommet</b><br>RV au <a href=\'https://plus.google.com/112043742075244775705/about\'>Zéro Zéro</a> !!<br />Ici aussi on expérimente...").openPopup();
		
		
		// Add geoJSON data layer
		// Useful function
		function onEachFeature(feature, layer) {
			if (feature.properties && feature.properties.popupContent) {
				var popupContent = feature.properties.popupContent;
			}
			layer.bindPopup(popupContent);
		}
		
		// Add actual data
		/*
		var cartoLayer = L.geoJson().addTo(map);
		cartoLayer.addData(cartodata);
		*/
		//L.geoJson([cartodata, otherdata], {
		var cartoLayer = L.geoJson(membersData, {
			style: function (feature) {
				return feature.properties && feature.properties.style;
			},
			onEachFeature: onEachFeature,
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, {
					radius: 12,
					fillColor: "#00f",
					color: "#000",
					weight: 1,
					opacity: 1,
					fillOpacity: 0.8
				});
			}
		}).addTo(map);
		
		
		
		// ACTIONS
		// Click on map interception - basic version (alert)
		/*
		function onMapClick(e) {
			alert("Ici les coordonnées sont " + e.latlng);
		}
		map.on(\'click\', onMapClick);
		*/
		
		// Click on map interception - popup version
		var popup = L.popup();
		function onMapClick(e) {
			popup
				.setLatLng(e.latlng)
				.setContent("Coordonnées : " + e.latlng.toString() + "<br />Voulez-vous créer un Rendez-Vous à cette adresse ?<br /><a href=\"\">Créer un Rendez-Vous</a>")
				.openOn(map);
		}
		map.on(\'click\', onMapClick);
		
	</script>
';


echo elgg_view('pageshell', array('head' => $head, 'body' => $body));


