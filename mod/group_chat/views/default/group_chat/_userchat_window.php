<?php 
global $CONFIG;
$guid = elgg_get_logged_in_user_guid();
	$user = elgg_get_logged_in_user_entity();
// @TODO Support for user chat
if (false) {
	echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:joinsitetochat') . '</div>';
	return;
}

$chat_id = get_input('guid');
echo elgg_view('group_chat/chat_window', array('chat_id' => $chat_id));

