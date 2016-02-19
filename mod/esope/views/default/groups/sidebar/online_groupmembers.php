<?php
if (!elgg_is_logged_in()) { return; }

$users = find_active_users(array('seconds' => 600, 'limit' => 10, 'count' => false));
$group = elgg_get_page_owner_entity();
if ($users) {
	foreach ($users as $ent) {
		if ($group->isMember($ent)) $online_groupmembers[] = $ent;
	}
	$count = sizeof($online_groupmembers);
	$body = elgg_view_entity_list($online_groupmembers, array('count' => $count, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
}

echo elgg_view_module('aside', elgg_echo('groups:onlinenow'), $body);

