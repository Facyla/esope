<?php
$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
if ( !elgg_is_logged_in() 
	|| !(elgg_get_page_owner_entity() instanceof ElggGroup)
	|| ($group_chat == 'no') 
	|| (($group_chat == 'groupoption') && (elgg_get_page_owner_entity()->group_chat_enable != 'yes')) 
	) { return; }


global $CONFIG;
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$open_group_chat_url = $CONFIG->url . 'chat/group/' . elgg_get_page_owner_guid();
$chat_icon = '<span class="elgg-icon elgg-icon-speech-bubble-alt"></span>';

$class = '';
$active = '';
// Mark chat as active if there are recent messages !
$chat_content = get_chat_content();
if ($chat_content) {
	$class = 'chat-active';
	$active = elgg_echo('groupchat:active');
}

// Build link
$open_group_chat_newlink = '<a href="' . $open_group_chat_url . '" onclick="window.open(this.href, \'' . elgg_echo('group_chat:group_chat') . ' ' . elgg_get_page_owner_entity()->name . '\', \'menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=500\'); return false;" id="groupchat-grouplink" class="' . $class . '">' . $chat_icon . $active . elgg_echo('groupchat:group:openlink:ownwindow') . '</a>';

/* @TODO : open chat window once - better with a function
$popup_id = 'groupchat_group_' . elgg_get_page_owner_guid();

// Build link
$open_group_chat_newlink = '<a href="' . $open_group_chat_url . '" onclick="if(' . $popup_id . '.closed()){ ' . $popup_id . ' = window.open(this.href, \'' . elgg_echo('group_chat:group_chat') . ' ' . elgg_get_page_owner_entity()->name . '\', \'menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=500\'); } else { ' . $popup_id . '.focus(); } return false;" id="groupchat-grouplink" class="' . $class . '">' . $chat_icon . $active . elgg_echo('groupchat:group:openlink:ownwindow') . '</a>';
*/

echo $open_group_chat_newlink;

