<?php
// This view provides the JS logic that will update the notification system when a new chat is started

if (!elgg_is_logged_in()) { return; }
$group_notification = elgg_get_plugin_setting('group_notification', 'group_chat');
$site_notification = elgg_get_plugin_setting('site_notification', 'group_chat');
$user_notification = elgg_get_plugin_setting('user_notification', 'group_chat');
//if (($group_notification != 'yes') || ($site_notification != 'yes') || ($user_notification != 'yes')) { return; }

global $CONFIG;


return;
?>
<script type="text/javascript">

elgg.provide('elgg.group_chat');

elgg.group_chat.init = function() {
	if (elgg.is_logged_in()) {
		elgg.group_chat.getMessages();
		setInterval(elgg.group_chat.getMessages, 10000);
	}
};

/**
 * Change the color of new messages.
 */
elgg.group_chat.markMessageRead = function() {
	var activeMessages = $('.elgg-chat-messages .elgg-chat-unread');
	var message = $(activeMessages[0]);
	message.animate({backgroundColor: '#ffffff'}, 1000).removeClass('elgg-chat-unread');
};

/**
 * Get messages via AJAX.
 * 
 * Get both the number of unread messages and a preview list
 * of the latest messages. Then populate the topbar menu item
 * and popup module with the data.
 */
elgg.group_chat.getMessages = function() {
	var url = elgg.normalize_url("group_chat/notifier.php");
	var messages = elgg.getJSON(
		url,
		{
			success: function(data) {
				/*
				// Add notifier to topbar menu item
				var counter = $('#chat-preview-link > .messages-new');
				
				counter.text(data.count)
				if (data.count > 0) {
					counter.removeClass('hidden');
				} else {
					counter.addClass('hidden');
				}

				// Add content to popup module
				$('#chat-messages-preview > .elgg-body > ul').replaceWith(data.preview);
				*/
			}
		}
	);
}

</script>


