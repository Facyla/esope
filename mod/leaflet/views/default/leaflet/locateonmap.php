<?php
/* Display & update user location on map */
?>
<script type="text/javascript">
function onLocationFound(e) {
	$("#location-error").hide();
	radius = e.accuracy / 2;
	if (usermarker != undefined) map.removeLayer(usermarker);
	if (userradius != undefined) map.removeLayer(userradius);
	usermarker = L.marker(e.latlng, {icon: ownMarker, title: username}).addTo(map)
		//.bindPopup("<?php echo elgg_echo('leaflet:popup:locationfound:popup'); ?>").openPopup(); // Ouverture auto
		.bindPopup("<?php echo elgg_echo('leaflet:popup:locationfound:popup'); ?>");
	userradius = L.circle(e.latlng, radius).addTo(map);
	// Center only once, when location detected
	if (centeredmap == 0) {
		bounds.extend(usermarker.getLatLng());
		bounds.extend(userradius.getLatLng());
		map.fitBounds(bounds, {padding: [20,20]});
		centeredmap = 1;
	}
}

// Location error alert
function onLocationError(e) {
	$("#location-error").show();
}

var usermarker, ownMarker, radius, userradius, centeredmap, username;
//require(['leaflet', 'leaflet.awesomemarkers'], function(){
require(['leaflet', 'leaflet_basemap', 'leaflet.awesomemarkers'], function(){
	// Location found alert
	centeredmap = 0;
	if (!username) username = '';

	// Creates a red marker with the coffee icon
	ownMarker = L.AwesomeMarkers.icon({ prefix: 'fa', icon: 'crosshairs', markerColor: 'red' });
	
	// Actions on location detection/loss
	map.on('locationfound', onLocationFound);
	map.on('locationerror', onLocationError);

	// Launch user location
	map.locate({setView: false, watch:true, enableHighAccuracy:true, maxZoom: Infinity, maximumAge: 1000});
	
	$(".centermap-toggle").click(function() {
		map.fitBounds(bounds, {padding: [20,20]});
	});
});
</script>

<div id="location-error"><?php echo elgg_echo('leaflet:locationerror'); ?></div>
<div id="centermap"><a href="#" class="centermap-toggle" title="<?php echo elgg_echo('leaflet:centermap'); ?>"><i class="fa fa-crosshairs"></i></a></div>

