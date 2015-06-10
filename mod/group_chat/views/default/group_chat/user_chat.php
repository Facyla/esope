<?php
// Checks access and embeds the user chat on the page (JS + chat itself)
// requires the viewer to have his guid in guid chat list

$user_chat = elgg_get_plugin_setting('user_chat', 'group_chat');
if (!elgg_is_logged_in() || ($user_chat != 'yes')) {
	//echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:joinsitetochat') . '</div>';
	return;
}

// Get chat in case we' haven't defined it yet
if (empty($vars['chat_id'])) { $vars['chat_id'] = get_input('chat_id'); }
// Stop here if there is no valid chat
if (empty($vars['chat_id'])) {
	echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:invalidchatid') . '</div>';
	return;
}
?>

<div id="userchat-container">
	<?php
	// Check access to chat content
	$own = elgg_get_logged_in_user_entity();
	$vars['chat_id'] = group_chat_normalise_chat_id($vars['chat_id']);
	$guids = explode('-', $vars['chat_id']);
	if (in_array($own->guid, $guids)) {
		// Embeds the chat content and interface
		echo elgg_view('group_chat/js_scrolldown', array());
		echo elgg_view('group_chat/chat_process_engine', $vars);
		echo elgg_view('group_chat/chat_window', $vars);
	} else {
		echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:noaccesstoprivatechat') . '</div>';
	}
	?>
</div>

