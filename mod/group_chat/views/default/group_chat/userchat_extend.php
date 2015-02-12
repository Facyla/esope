<?php
// Adds a link to user chat on the page
// This is not really useful as we create user chats more directly
// We might go to a new chat launcher page instead, but not launche the chat itself from here
return;

$user_chat = elgg_get_plugin_setting('user_chat', 'group_chat');
if (!elgg_is_logged_in() || ($user_chat != 'yes')) { return; }



$open_user_chat_url = $CONFIG->url . 'chat/user';
$chat_icon = '<i class="fa fa-comments-o"></i> &nbsp; ';

// Build link
$open_user_chat_newlink = '<a href="' . $open_user_chat_url . '" onclick="window_'.$popup_id.'(this.href); return false;" id="groupchat-userlink">' . $chat_icon . elgg_echo('groupchat:user:openlink:ownwindow') . '</a>';

echo $open_user_chat_newlink;

