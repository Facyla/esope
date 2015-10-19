<?php
/* Open action popup when clicking on map */
?>

<script type="text/javascript">
require(['leaflet'], function(){
	// ACTIONS
	// Click on map interception - popup version - display only if no active popup
	var popupToggle = 0;
	var popup = L.popup();
	function onMapClick(e) {
		if (popupToggle == 0) {
			popup.setLatLng(e.latlng)
			.setContent("<?php echo elgg_echo('leaflet:popup:clickonmap'); ?>")
			.openOn(map);
			popupToggle = 1;
		} else {
			popupToggle = 0;
		}
	}
	map.on('click', onMapClick);
});
</script>

