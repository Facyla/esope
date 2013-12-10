<?php
$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
if ( !elgg_is_logged_in() || ($site_chat != 'yes') ) { return; }

global $CONFIG;
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$open_site_chat_url = $CONFIG->url . 'chat/site';
$chat_icon = '<span class="elgg-icon elgg-icon-speech-bubble-alt"></span>';

// Build link
$open_site_chat_newlink = '<a href="' . $open_site_chat_url . '" onclick="window.open(this.href, \'' . elgg_echo('group_chat:site_chat') . ' ' . $CONGIG->site->name . '\', \'menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=500\'); return false;" id="groupchat-sitelink">' . $chat_icon . elgg_echo('groupchat:site:openlink:ownwindow') . '</a>';

echo $open_site_chat_newlink;

