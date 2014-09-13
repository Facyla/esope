<?php
/* Routing machine integration */

$guid = get_input('id', false);
if ($guid) $marker = 'marker'.$guid; else $marker = 'markerRV';
?>

<script type="text/javascript">
var route;
var routeinited = 'no';
function onLocationFoundInitRouting(e) {
	if (routeinited != 'yes') {
		if (usermarker && <?php echo $marker; ?>) {
			route = L.Routing.control({
				waypoints: [
					usermarker.getLatLng(),
					<?php echo $marker; ?>.getLatLng(),
				],
				instructions: false,
				// @TODO Options doesn't work yet
				/*
				options: {
					dragStyles: [
						{color: 'red', opacity: 0.8, weight: 1},
					],
					draggableWaypoints: false,
					addWaypoints: false,
				}
				*/
			});
			route.addTo(map);
			routeinited = 'yes';
			// Move directions into Infos block
			$('.leaflet-routing-container').appendTo('#leaflet-details .routing');
			//console.log(route);
			//alert("Route ajoutée : " + usermarker.getLatLng() + " à " + <?php echo $marker; ?>.getLatLng());
		} else {
			// Retry after some time
			setTimeout("onLocationFoundInitRouting(e)", 2000);
		}
	}
}

map.on('locationfound', onLocationFoundInitRouting);
</script>

