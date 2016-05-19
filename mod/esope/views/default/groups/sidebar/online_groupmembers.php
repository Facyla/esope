<?php
if (!elgg_is_logged_in()) { return; }

// Limit : will be filtered, but do not set to high (or better use a custom direct query)
$users = find_active_users(array('seconds' => 600, 'limit' => 20, 'count' => false));

$group = elgg_get_page_owner_entity();
if ($users) {
	foreach ($users as $ent) {
		if ($group->isMember($ent)) { $guids[] = $ent->guid; }
	}
	$count = sizeof($guids);
	//$body = elgg_view_entity_list($guids, array('count' => $count, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
	$body = elgg_list_entities(array('type' => 'user', 'guids' => $guids, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
}

echo elgg_view_module('aside', elgg_echo('groups:onlinenow'), $body);

