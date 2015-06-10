<?php
// This view is an alternate launcher for group chat, better tailored to fit as a link in a menu or elsewhere

$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
if (!elgg_is_logged_in() || ($group_chat == 'no')) { return; }

$group = elgg_get_page_owner_entity();
if (!elgg_instanceof($group, 'group') || (($group_chat == 'groupoption') && ($group->group_chat_enable != 'yes'))) { return; }

$chat_id = $group->guid;
$open_group_chat_url = elgg_get_site_url() . 'chat/group/' . $chat_id;
$chat_icon = '<i class="fa fa-comments-o"></i> &nbsp; ';
$text = '<i class="fa fa-external-link"></i> &nbsp; ' . elgg_echo('groupchat:group:openlink:ownwindow:theme');

$class = 'groupchat-grouplink-theme';
$active = '';
// Mark chat as active if there are recent messages !
$chat_content = group_chat_get_chat_content($chat_id);
if ($chat_content) {
	$class .= ' chat-active-theme';
	$chat_icon = '<i class="fa fa-comments"></i> &nbsp; ';
	$active = elgg_echo('groupchat:active');
	$text .= ' ' . $chat_icon . $active;
} else {
	$text .= ' ' . $chat_icon;
}

$popup_id = 'groupchat_group_' . $chat_id;

echo '<script type="text/javascript">
var '.$popup_id.';
// Open a window only once
function window_'.$popup_id.'(url) {
	if('.$popup_id.' && !'.$popup_id.'.closed){
		'.$popup_id.'.focus();
	} else {
		'.$popup_id.' =  window.open(url, "' . elgg_echo('group_chat:group_chat') . ' ' . elgg_get_page_owner_entity()->name . '", "menubar=no, status=no, scrollbars=no, location=no, copyhistory=no, width=400, height=500");
		'.$popup_id.'.focus();
	}
}
</script>';

// Build link
$open_group_chat_newlink = '<a href="' . $open_group_chat_url . '" onclick="window_'.$popup_id.'(this.href); return false;" class="' . $class . '">' . $text . '</a>';

echo $open_group_chat_newlink;

