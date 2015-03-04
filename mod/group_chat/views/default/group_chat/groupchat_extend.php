<?php
// Adds a link to group chat on the page

$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
if ( !elgg_is_logged_in() 
	|| !(elgg_get_page_owner_entity() instanceof ElggGroup)
	|| ($group_chat == 'no') 
	|| (($group_chat == 'groupoption') && (elgg_get_page_owner_entity()->group_chat_enable != 'yes')) 
	) { return; }


$group = elgg_get_page_owner_entity();
$open_group_chat_url = elgg_get_site_url() . 'chat/group/' . $group->guid;
//$chat_icon = '<span class="elgg-icon elgg-icon-speech-bubble-alt"></span>';
$chat_icon = '<i class="fa fa-comments-o"></i> &nbsp; ';

$class = '';
$active = '';
// Mark chat as active if there are recent messages (today) !
$chat_content = group_chat_get_chat_content($group->guid, 1);
if ($chat_content) {
	$class = 'chat-active';
	$chat_icon = '<i class="fa fa-comments"></i> &nbsp; ';
	$active = elgg_echo('groupchat:active');
}

$popup_id = 'groupchat_group_' . elgg_get_page_owner_guid();

echo '<script type="text/javascript">
var '.$popup_id.';
// Open a window only once
function window_'.$popup_id.'(url) {
	if('.$popup_id.' && !'.$popup_id.'.closed){
		'.$popup_id.'.focus();
	} else {
		'.$popup_id.' =  window.open(url, "group_chat_' . $group->guid . '", "menubar=no, status=no, scrollbars=no, location=no, copyhistory=no, width=400, height=500");
		'.$popup_id.'.focus();
	}
}
</script>';

// Build link
$open_group_chat_newlink = '<a href="' . $open_group_chat_url . '" onclick="window_'.$popup_id.'(this.href); return false;" id="groupchat-grouplink" class="' . $class . '">' . $chat_icon . $active . elgg_echo('groupchat:group:openlink:ownwindow') . '</a>';

echo $open_group_chat_newlink;

