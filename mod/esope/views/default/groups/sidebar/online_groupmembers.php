<?php
if (!elgg_is_logged_in()) { return; }

//$time = elgg_extract('seconds', $vars, 600);
$seconds = elgg_extract('seconds', $vars, 600); // 10 minutes
$time = time() - $seconds;
// No limit (0) is fine for small sites but have to limit displayed results on big ones
$limit = elgg_extract('limit', $vars, 14);
$group = elgg_get_page_owner_entity();

// Get group members who where active in a specific timeframe
// Note: when processing huge sites this is much more efficient than the other method (get active users then filter by group membership)
$dbprefix = elgg_get_config('dbprefix');
$options = array(
	'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
	'joins' => array("join {$dbprefix}users_entity u on e.guid = u.guid"),
	'wheres' => array("u.last_action >= {$time}"),
	'order_by' => "u.last_action desc",
	'limit' => $limit,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'pagination' => false,
);
$body = elgg_list_entities_from_relationship($options, 'find_active_users');

/* Avoid this method : might lead to memory overflow on big sites
// Limit : will be filtered, but do not set to high (or better use a custom direct query)
$users = find_active_users(array('seconds' => 601, 'limit' => 0, 'count' => false));
if ($users) {
	foreach ($users as $ent) {
		if ($group->isMember($ent)) { $guids[] = $ent->guid; }
	}
	$count = sizeof($guids);
	//$body = elgg_view_entity_list($guids, array('count' => $count, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
	$body = elgg_list_entities(array('type' => 'user', 'guids' => $guids, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
}
*/

echo elgg_view_module('aside', elgg_echo('groups:onlinenow'), $body);

