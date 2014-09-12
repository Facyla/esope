<?php
/* Display & update other users location on map */
/* Required data :
 - user name (or anonymous)
 - user position
 - user radius
 - user position timestamp
 - user position timeout
*/

// We should not disclose session id, so hash it first, and use something reasonnably short
if (!elgg_is_logged_in()) {
	forward();
}

$user = elgg_get_logged_in_user_entity();
$username = $user->username . '_' . $user->guid;

$members_map = '';
$users = elgg_get_entities(array('types' => 'user', 'limit' => 0));
foreach ($users as $ent) {
	if (empty($ent->location)) continue;
	$lat = $ent->getLatitude();
	$long = $ent->getLongitude();
	if (!$lat || !$long) {
		$geo_location = elgg_geocode_location($ent->getLocation());
		if ($geo_location) {
			$lat = (float)$geo_location['lat'];
			$long = (float)$geo_location['long'];
		}
	}
	if ($lat && $long) {
		$name = $ent->name;
		$description = elgg_view_entity($ent, array('full_view' => false));
		$description = json_encode($description);
		
		$members_map .= "
			marker = L.marker([$lat, $long], {icon: onlineUsersMarker, title: '$name'});
			marker.bindPopup($description);
			onlineUsersMarkers.addLayer(marker);
			";
	}
}


?>
<script type="text/javascript">
// Create a custom marker for users
var onlineUsersMarker = L.AwesomeMarkers.icon({ prefix: 'fa', icon: 'user', markerColor: 'grey' });
var onlineUsersMarkers = new L.MarkerClusterGroup();

// Process positions
<?php echo $members_map; ?>

map.addLayer(onlineUsersMarkers);
</script>

<div id="onlineUsers"></div>

