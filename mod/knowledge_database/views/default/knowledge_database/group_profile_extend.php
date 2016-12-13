<?php
/**
 * Adds the KDB search interface to the group layout
 *
 * @uses $vars['entity']
 */


$group = elgg_extract('entity', $vars);

$is_kdb_group = knowledge_database_is_kdb_group($group->guid);

if ($is_kdb_group) {
	echo elgg_view('knowledge_database/search_kdb', $vars);
}

