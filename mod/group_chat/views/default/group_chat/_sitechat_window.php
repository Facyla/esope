<?php 
global $CONFIG;
$guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();
// Support for site chat
if (!elgg_instanceof($vars['entity'], 'site')) {
	echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:joinsitetochat') . '</div>';
	return;
}

$chat_id = elgg_get_page_owner_guid();
echo elgg_view('group_chat/chat_window', array('chat_id' => $chat_id));

