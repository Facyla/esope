<?php
/* Display & update other users location on map */
/* Required data :
 - user name (or anonymous)
 - user position
 - user radius
 - user position timestamp
 - user position timeout
*/

gatekeeper();

$user = elgg_get_logged_in_user_entity();
$username = $user->username . '_' . $user->guid;

$members_map = '';

// Use batch
// @TODO use cron to avoid waiting time
// @TODO also add some caching for huge results

echo '<script type="text/javascript">
// Create a custom marker for users
var onlineUsersMarker = L.AwesomeMarkers.icon({ prefix: \'fa\', icon: \'user\', markerColor: \'grey\' });
var onlineUsersMarkers = new L.MarkerClusterGroup();

// Process positions
';

// Geocoding batch
$debug_0 = microtime(TRUE);
$users_options = array('types' => 'user', 'limit' => 0);
$batch = new ElggBatch('elgg_get_entities', $users_options, 'leaflet_batch_all_members_markers', 10);
$debug_1 = microtime(TRUE);
error_log("LEAFLET BATCH : Finished at " . date('Ymd H:i:s') . " => ran in " . round($debug_1-$debug_0, 4) . " seconds");


echo 'map.addLayer(onlineUsersMarkers);
map.fitBounds(bounds, {padding: [20,20]});
</script>';

echo '<div id="onlineUsers"></div>';

