<?php
/**
 * Adds the KDB search interface to the group layout
 *
 * @uses $vars['entity']
 */


$group = elgg_extract('entity', $vars);
$kdb_group_guid = elgg_get_plugin_setting('kdb_group', 'knowledge_database');

if ($group->guid == $kdb_group_guid) {
	echo elgg_view('knowledge_database/search_kdb', $vars);
}

