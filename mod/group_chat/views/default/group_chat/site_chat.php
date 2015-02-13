<?php
// Checks access and embeds the site chat on the page (JS + chat itself)

// Check that site chat is enabled and available
$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
if (!elgg_is_logged_in() || ($site_chat != 'yes')) {
	//echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:joinsitetochat') . '</div>';
	return;
}
global $CONFIG;
$site = $CONFIG->site;
?>

<div id="sitechat-container">
	<?php
	// Force container entity and chat id, in case we' haven't defined it yet
	$vars['entity'] = $site;
	$vars['chat_id'] = $site->guid;
	// Embeds the chat content and interface
	echo elgg_view('group_chat/js_scrolldown', array());
	echo elgg_view('group_chat/chat_process_engine', $vars);
	echo elgg_view('group_chat/chat_window', $vars);
	?>
</div>

