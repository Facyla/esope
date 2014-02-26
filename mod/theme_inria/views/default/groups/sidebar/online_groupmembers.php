<?php
$count = find_active_users(600, 10, 0, true);
$users = find_active_users(600, $count);
$group = elgg_get_page_owner_entity();
if ($users) {
	foreach ($users as $ent) {
		if ($group->isMember($ent)) $online_groupmembers[] = $ent;
	}
	$count = sizeof($online_groupmembers);
	$body = elgg_view_entity_list($online_groupmembers, array('count' => $count, 'limit' => $count, 'list_type' => 'gallery', 'gallery_class' => 'elgg-gallery-users'));
}

if (elgg_is_active_plugin('group_chat')) {
	elgg_unextend_view('adf_platform/adf_header', 'group_chat/groupchat_extend');
	$body .= '<div class="clearfloat"></div><p>' . elgg_view('group_chat/groupchat_linkextend', $vars) . '</p>';
}

echo elgg_view_module('aside', elgg_echo('groups:onlinenow'), $body);

