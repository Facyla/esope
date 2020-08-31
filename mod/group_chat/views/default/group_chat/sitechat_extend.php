<?php
// Adds a link to site chat on the page

$popup_id = 'groupchat_site';
$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');

if (!elgg_is_logged_in() || ($site_chat != 'yes')) {
	// Close open window
	echo '<script type="text/javascript">
	var '.$popup_id.';
	if('.$popup_id.' && !'.$popup_id.'.closed){ groupchat_site.close(); }
	</script>';
	return;
}

$open_site_chat_url = elgg_get_site_url() . 'chat/site';
$chat_icon = '<i class="fa fa-comments-o"></i> &nbsp; ';

$active = '';
// Check if we have some recent content - uncomment to use
/*
$site = elgg_get_site_entity();
$guid = elgg_get_page_owner_guid();
elgg_set_page_owner_guid($site->guid);
$chat_content = group_chat_get_chat_content($site->guid);
if ($chat_content) {
	$class .= ' chat-active-theme';
	$chat_icon = '<i class="fa fa-comments"></i> &nbsp; ';
	$active = elgg_echo('groupchat:active');
}
elgg_set_page_owner_guid($guid);
*/

// Note : IE doesn't like space nor hyphens - in window title, consider it is an id and don't use them...
echo '<script type="text/javascript">
var '.$popup_id.';
// Open a window only once
function window_'.$popup_id.'(url) {
	if('.$popup_id.' && !'.$popup_id.'.closed){
		'.$popup_id.'.focus();
	} else {
		'.$popup_id.' =  window.open(url, "site_chat", "menubar=no, status=no, scrollbars=no, location=no, copyhistory=no, width=400, height=500");
		'.$popup_id.'.focus();
	}
}
</script>';

// Build link
$open_site_chat_newlink = '<a href="' . $open_site_chat_url . '" onclick="window_'.$popup_id.'(this.href); return false;" id="groupchat-sitelink">' . $chat_icon . $active . elgg_echo('groupchat:site:openlink:ownwindow') . '</a>';

echo $open_site_chat_newlink;

