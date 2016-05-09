<?php
$group = elgg_get_page_owner_entity();
$is_kdb_group = knowledge_database_is_kdb_group($group->guid);

if ($is_kdb_group) {
	// Addition for KDB group
	echo '<br />';
	echo '<blockquote><strong>' . elgg_echo('knowledge_database:kdb_group') . '</strong></blockquote>';
}


