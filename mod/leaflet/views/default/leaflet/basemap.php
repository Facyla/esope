<?php
/* Display Leaflet base map */

elgg_load_library('leaflet');
leaflet_load_libraries();

//if (empty($vars['map_id'])) { $vars['map_id'] = 'leaflet-main-map'; }
$id = elgg_extract('map_id', $vars, 'leaflet-main-map');

?>

<script type="text/javascript">
var map, bounds;
var baseMap, baseLayers, overlays, layerControl;
require(['leaflet', 'leaflet.providers'], function(){
	// CREATE A MAP on chosen map id
	map = L.map('<?php echo $id; ?>');

	// CHOOSE TILE LAYER
	// Pure OSM
	/*
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 12, attribution: osmAttrib});
	// start the map in South-East England
	//map.setView(new L.LatLng(51.3, 0.7),9);
	map.addLayer(osm);
	*/

	// Using Leaflet providers plugin
	// Add a single layer
	baseMap = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(map);
	/* @TODO : debug as this syntax doesn't weem to work after latest upgrades (1.7.5 and plugin update)
	// Add switch between multiple layers and overlays
	baseLayers = ['OpenStreetMap.Mapnik', 'OpenCycleMap', 'Stamen.Watercolor'];
	overlays = ['OpenWeatherMap.Clouds'];
	layerControl = L.control.layers.provided(baseLayers, overlays).addTo(map);
	*/

	// Init bounds to init map centering on markers
	bounds = new L.LatLngBounds();
});
</script>

<div id="<?php echo $id; ?>"></div>

