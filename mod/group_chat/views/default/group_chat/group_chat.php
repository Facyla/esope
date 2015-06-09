<?php
// Checks access and embeds the group chat on the page (JS + chat itself)
// requires a valid ElggGroup entity

// Check that group chat is enabled and available
$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
if ( !elgg_is_logged_in() 
	|| !(elgg_instanceof($vars['entity'], 'group'))
	|| ($group_chat == 'no') 
	|| (($group_chat == 'groupoption') && ($vars['entity']->group_chat_enable != 'yes')) 
	) { return; }

?>

<div id="group-sitechat-container">
	<?php
	// Check access to chat content
	if ($vars['entity']->isMember()) {
		// Embeds the chat content and interface
		echo elgg_view('group_chat/js_scrolldown', array());
		echo elgg_view('group_chat/chat_process_engine', $vars);
		// Force chat id to the wanted group, in case we' haven't defined it yet
		$vars['chat_id'] = $vars['entity']->guid;
		echo elgg_view('group_chat/chat_window', $vars);
	} else {
		echo '<div class="floatLeft joinGroup">' . elgg_echo('group_chat:joingrouptochat') . '</div>';
	}
	?>
</div>

