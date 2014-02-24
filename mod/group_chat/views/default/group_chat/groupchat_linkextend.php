<?php
// This view is an alternate launcher for group chat, better tailored to fit as a link in a menu or elsewhere

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
$chat_icon = '<i class="fa fa-comments-o"></i>';
$text = '<i class="fa fa-external-link"></i> ' . elgg_echo('groupchat:group:openlink:ownwindow:theme');

$class = 'groupchat-grouplink-theme';
$active = '';
// Mark chat as active if there are recent messages !
$chat_content = get_chat_content();
if ($chat_content) {
	$class .= ' chat-active-theme';
	$chat_icon = '<i class="fa fa-comments"></i>';
	$active = elgg_echo('groupchat:active');
	$text .= ' ' . $chat_icon . $active;
} else {
	$text .= ' ' . $chat_icon;
}

$popup_id = 'groupchat_group_' . elgg_get_page_owner_guid();

// Build link
$open_group_chat_newlink = '<a href="' . $open_group_chat_url . '" onclick="var ' . $popup_id . '; if(!' . $popup_id . ' || ' . $popup_id . '.closed){ ' . $popup_id . ' = window.open(this.href, \'' . elgg_echo('group_chat:group_chat') . ' ' . elgg_get_page_owner_entity()->name . '\', \'menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=500\'); return false; } else { ' . $popup_id . '.focus(); return false; }" class="' . $class . '">' . $text . '</a>';

echo $open_group_chat_newlink;

