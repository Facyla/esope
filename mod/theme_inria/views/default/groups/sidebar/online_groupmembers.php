<?php
$users = find_active_users(array('seconds' => 600, 'limit' => 10, 'count' => false));
$group = elgg_get_page_owner_entity();
if ($users) {
	foreach ($users as $ent) {
		if ($group->isMember($ent)) $online_groupmembers[] = $ent;
	}
	$count = sizeof($online_groupmembers);
	$body = elgg_list_entities(array('entities' => $online_groupmembers, 'count' => $count, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
}

if (elgg_is_active_plugin('group_chat')) {
	elgg_unextend_view('page/elements/header', 'group_chat/groupchat_extend');
	$body .= '<div class="clearfloat"></div><p>' . elgg_view('group_chat/groupchat_linkextend', $vars) . '</p>';
}

echo elgg_view_module('aside', elgg_echo('groups:onlinenow'), $body);

