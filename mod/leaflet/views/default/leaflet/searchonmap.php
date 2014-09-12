<?php
/* Search a locaiton on map */
// See doc : https://github.com/smeijer/L.GeoSearch

// See also https://github.com/perliedman/leaflet-control-geocoder for more geocoding tools and options
?>

<script type="text/javascript">
new L.Control.GeoSearch({
	provider: new L.GeoSearch.Provider.OpenStreetMap(),
	showMarker: false
}).addTo(map);
// Also : L.GeoSearch.Provider.Esri and L.GeoSearch.Provider.Google
</script>

