<?php 
// Embeds the group chat on the page

global $CONFIG;
$guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();
// Support for group chat
if (!elgg_instanceof($vars['entity'], 'group') || !$vars['entity']->isMember($user) ) {
	echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:joingrouptochat') . '</div>';
	return;
}

$chat_id = elgg_get_page_owner_guid();
echo elgg_view('group_chat/chat_window', array('chat_id' => $chat_id));

