<?php
/**
 * Layout of the groups profile page
 *
 * @uses $vars['entity']
 */

// Note : Check latest loaded plugin : theme_maghrenov overrides this view but has same logic, 
// other theme plugins may not so you might need to tweak them

$group = $vars['entity'];
$kdb_group_guid = elgg_get_plugin_setting('kdb_group', 'knowledge_database');

if ($group->guid == $kdb_group_guid) {
	// Changes for KDB group
	echo elgg_view('groups/profile/summary', $vars);
	echo elgg_view('knowledge_database/search_kdb', $vars);
	
} else {
	// Original view
	echo elgg_view('groups/profile/summary', $vars);
	if (group_gatekeeper(false)) {
		echo elgg_view('groups/profile/widgets', $vars);
	} else {
		echo elgg_view('groups/profile/closed_membership');
	}
}

