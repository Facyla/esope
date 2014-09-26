<?php
$group = elgg_get_page_owner_entity();
$kdb_group_guid = elgg_get_plugin_setting('kdb_group', 'maghrenov_kdb');

if ($group->guid == $kdb_group_guid) {
	// Addition for KDB group
	echo '<br /><br />';
}


