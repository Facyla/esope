<?php
$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
if ( !elgg_is_logged_in() || ($site_chat != 'yes') ) { return; }

global $CONFIG;
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$open_site_chat_url = $CONFIG->url . 'chat/site';
$chat_icon = '<i class="fa fa-comments-o"></i> &nbsp; ';

$popup_id = 'groupchat_site';

// Check content - uncomment to use, but can cause much calls
/*
$guid = elgg_get_page_owner_guid();
elgg_set_page_owner_guid($CONFIG->site->guid);
$chat_content = get_chat_content();
if ($chat_content) {
	$class .= ' chat-active-theme';
	$chat_icon = '<i class="fa fa-comments"></i> &nbsp; ';
	$active = elgg_echo('groupchat:active');
}
elgg_set_page_owner_guid($guid);
*/

echo '<script type="text/javascript">
var '.$popup_id.';
// Open a window only once
function window_'.$popup_id.'(url) {
	if('.$popup_id.' && !'.$popup_id.'.closed){
		'.$popup_id.'.focus();
	} else {
		'.$popup_id.' =  window.open(url, "' . elgg_echo('group_chat:site_chat') . ' ' . elgg_get_page_owner_entity()->name . '", "menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500");
		'.$popup_id.'.focus();
	}
}
</script>';

// Build link
$open_site_chat_newlink = '<a href="' . $open_site_chat_url . '" onclick="window_'.$popup_id.'(this.href); return false;" id="groupchat-sitelink">' . $chat_icon . $active . elgg_echo('groupchat:site:openlink:ownwindow') . '</a>';

echo $open_site_chat_newlink;

