<?php
/* Display Leaflet base map */

if (empty($vars['map_id'])) { $vars['map_id'] = 'leaflet-main-map'; }

echo '<div id="' . $vars['map_id'] . '"></div>';
?>

<script type="text/javascript">
// CREATE A MAP on chosen map id
var map = L.map('<?php echo $vars['map_id']; ?>');

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

// Leaflet providers plugin
//var baseMap = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(map);
// Add layer switch and overlays
var baseLayers = ['OpenStreetMap.Mapnik', 'OpenCycleMap', 'Stamen.Watercolor', ], overlays = ['OpenWeatherMap.Clouds'];
var layerControl = L.control.layers.provided(baseLayers, overlays).addTo(map);


// Init bounds to init map centering on markers
var bounds = new L.LatLngBounds();
</script>
