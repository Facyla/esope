<?php
// Adds a new chat messages notifier
// Note : does not add link in interface, as these are added through profile dropdown menu

/*
$user_chat = elgg_get_plugin_setting('user_chat', 'group_chat');
if (!elgg_is_logged_in() || ($user_chat != 'yes')) { return; }
*/
if (!elgg_is_logged_in()) { return; }
$own = elgg_get_logged_in_user_entity();

// Check enabled notifications
$group_notification = elgg_get_plugin_setting('group_notification', 'group_chat');
$site_notification = elgg_get_plugin_setting('site_notification', 'group_chat');
$user_notification = elgg_get_plugin_setting('user_notification', 'group_chat');

// Break if we don't use any
if (($group_notification != 'yes') && ($site_notification != 'yes') && ($user_notification != 'yes')) return;
?>

<script type="text/javascript">
$(document).ready(function() {
	group_chat_notifier();
	var refresh_rate = 10000;
	setInterval('group_chat_notifier()', refresh_rate);
});


// Open a window only once
function group_chat_notifier() {
	$.ajax({
		type: "POST",
		url: "<?php echo elgg_get_site_url();?>chat/notifier",
		data: {
			'site': '<?php echo $site_notification; ?>',
			'group': '<?php echo $group_notification; ?>',
			'user': '<?php echo $user_notification; ?>',
		},
		dataType: "json",
		success: function(data){
			// Clear content and hide
			$('#group_chat-notification-content').html('');
			$('#group_chat-notification').hide();
			if(data.notification.site){
				//elgg.system_message(data.notification.site);
				$('#group_chat-notification').show();
				$('#group_chat-notification-content').append($(data.notification.site));
			}
			if(data.notification.group){
				//elgg.system_message(data.notification.group);
				$('#group_chat-notification').show();
				$('#group_chat-notification-content').append($(data.notification.group));
			}
			if(data.notification.user){
				//elgg.system_message(data.notification.user);
				$('#group_chat-notification').show();
				$('#group_chat-notification-content').append($(data.notification.user));
			}
		},
	});
}
</script>

<div id="group_chat-notification" class="elgg-messages" style="display:none;">
	<!-- FA icons : bell, bell-o, comments-o //-->
	<div class="group_chat-notification-alert group_chat-wobble"><i class="fa fa-bell"></i></div>
	<div id="group_chat-notification-content"></div>
	</div>

