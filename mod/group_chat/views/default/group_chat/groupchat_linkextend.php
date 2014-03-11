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
$chat_icon = '<i class="fa fa-comments-o"></i> &nbsp; ';
$text = '<i class="fa fa-external-link"></i> &nbsp; ' . elgg_echo('groupchat:group:openlink:ownwindow:theme');

$class = 'groupchat-grouplink-theme';
$active = '';
// Mark chat as active if there are recent messages !
$chat_content = get_chat_content();
if ($chat_content) {
	$class .= ' chat-active-theme';
	$chat_icon = '<i class="fa fa-comments"></i> &nbsp; ';
	$active = elgg_echo('groupchat:active');
	$text .= ' ' . $chat_icon . $active;
} else {
	$text .= ' ' . $chat_icon;
}

$popup_id = 'groupchat_group_' . elgg_get_page_owner_guid();

echo '<script type="text/javascript">
var '.$popup_id.';
// Open a window only once
function window_'.$popup_id.'(url) {
	if('.$popup_id.' && !'.$popup_id.'.closed){
		'.$popup_id.'.focus();
	} else {
		'.$popup_id.' =  window.open(url, "' . elgg_echo('group_chat:group_chat') . ' ' . elgg_get_page_owner_entity()->name . '", "menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500");
		'.$popup_id.'.focus();
	}
}
</script>';

// Build link
$open_group_chat_newlink = '<a href="' . $open_group_chat_url . '" onclick="window_'.$popup_id.'(this.href); return false;" class="' . $class . '">' . $text . '</a>';

echo $open_group_chat_newlink;

