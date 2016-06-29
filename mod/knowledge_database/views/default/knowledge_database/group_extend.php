<?php
/**
 * Adds the KDB information to the group layout
 *
 * @uses $vars['entity']
 */

$group = elgg_extract('entity', $vars);
$is_kdb_group = knowledge_database_is_kdb_group($group->guid);

if ($is_kdb_group) {
	// Addition for KDB group
	echo '<br />';
	echo '<blockquote><strong>' . elgg_echo('knowledge_database:kdb_group') . '</strong></blockquote>';
	//echo elgg_view('knowledge_database/group_profile_extend', $vars);
}

