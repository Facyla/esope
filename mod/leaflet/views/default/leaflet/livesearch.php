<?php
/* Display & update other users location on map */
/* Required data :
 - user name (or anonymous)
 - user position
 - user radius
 - user position timestamp
 - user position timeout
*/

session_start();
$positionsId = get_input('positionsId', 'leaflet');
$action_url = elgg_get_site_url() . 'action/leaflet/';
$ts = time();
$token = generate_action_token($ts);

// We should not disclose session id, so hash it first, and use something reasonnably short
if (elgg_is_logged_in()) {
	$user = elgg_get_logged_in_user_entity();
	$username = $user->username . '_' . $user->guid;
} else {
	$sess_id = $_SESSION['__elgg_session'];
	$sess_id = md5($sess_id);
	$username = 'public_' . substr($sess_id, 0, 6);
}

?>
<script type="text/javascript">
var onlineUsersMarker, onlineUsersMarkers;
//require(['leaflet', 'leaflet.awesomemarkers', 'leaflet.markercluster'], function(){
require(['leaflet', 'leaflet_basemap', 'leaflet.awesomemarkers', 'leaflet.markercluster'], function(){
	// Save own position
	var lastupdate;
	var timestamp = Math.round(new Date().getTime() / 1000);
	var username = '<?php echo $username; ?>';
	var timeout = 3600;
	var positionsId = '<?php echo $positionsId; ?>';
	var last_userlat;
	var last_userlng;

	// Creates a custom marker
	onlineUsersMarker = L.AwesomeMarkers.icon({ prefix: 'fa', icon: 'user', markerColor: 'grey' });
	onlineUsersMarkers = new L.MarkerClusterGroup();

	// CALL URL : <?php echo $action_url . 'positionprocess?__elgg_ts=' . $ts . '&__elgg_token=' . $token; ?>
	elgg.leaflet.getUsersPosition();
});

// Save others positions
function elgg.leaflet.getUsersPosition() {
	$.ajax({
		type: "GET",
		url: "<?php echo $action_url; ?>",
		data: {
			'action': 'rendezvous/positionprocess',
			'function': 'readPositions',
			'positionsId': positionsId,
			'__elgg_ts':'<?php echo $ts;?>',
			'__elgg_token':'<?php echo $token; ?>',
		},
		dataType: "json",
		success: function(data){
			if(data.output.text){
				var userPositions = data.output.text.split('\n');
				// Reset online users layer
				map.removeLayer(onlineUsersMarkers);
				onlineUsersMarkers = new L.MarkerClusterGroup();
				// Process latest positions
				$.each(userPositions, function(index, value) {
					var userPosition = value.split('|');
					if (userPosition[0] != username) {
						var varUserName = 'online_' + userPosition[0];
						var date = new Date(userPosition[4]*1000);
						var userOnlineDate = 'à ' + date.getHours() + 'h' + date.getMinutes() + ' et ' + date.getSeconds() + 's (le '+date.getDate() + '/' + (date.getMonth() + 1) + '/' + (date.getYear() + 1900) + ')';
						/*
						varUserName.value = L.marker([userPosition[1],userPosition[2]], {icon: onlineUsersMarker}).bindPopup('Position de ' + userPosition[0] + ' ' + userOnlineDate + ' (à ' + userPosition[3] + ' m près)');
						onlineUsersMarkers.addLayer(varUserName.value);
						*/
						marker = L.marker([userPosition[1],userPosition[2]], {icon: onlineUsersMarker, title: userPosition[0]});
						title = '<strong>' + userPosition[0] + '</strong><br />' + userOnlineDate + '<br />Précision à ' + userPosition[3] + ' m près<br />Timeout : ' + userPosition[5];
						marker.bindPopup(title);
						onlineUsersMarkers.addLayer(marker);
					}
				});
				map.addLayer(onlineUsersMarkers);
			};
		},
		error: function(data){
			//alert('Position reading failed');
		},
	});
	setTimeout("getUsersPosition()",5000);
}
</script>

<div id="onlineUsers"></div>

