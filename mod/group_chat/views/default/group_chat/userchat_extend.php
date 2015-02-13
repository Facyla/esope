<?php
// Adds a new chat messages notifier
// Note : does not add link in interface, as these are added through profile dropdown menu

$user_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
if (!elgg_is_logged_in() || ($user_chat != 'yes')) { return; }
$own = elgg_get_logged_in_user_entity();

global $CONFIG;

// Check if we have some recent content - uncomment to use
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

?>
<script type="text/javascript">
$(document).ready(function() {
	var refresh_rate = 5000;
	setInterval('group_chat_notifier()', refresh_rate);
});


// Open a window only once
function group_chat_notifier() {
	$.ajax({
		type: "POST",
		url: "<?php echo elgg_get_site_url();?>chat/notifier",
		data: {
			//'container': chat_id
		},
		dataType: "json",
		success: function(data){
			console.dir(data);
			if(data.notification.site || data.notification.group || data.notification.user){
				if(data.notification.site){
					elgg.system_message(data.notification.site);
				}
				if(data.notification.group){
					elgg.system_message(data.notification.group);
				}
				if(data.notification.user){
					elgg.system_message(data.notification.user);
				}
				/*
				for (var i = 0; i < data.output.text.length; i++) {
					$('#group_chat-notification').html('');
					$('#group_chat-notification').append($(data.notification[i]));
				}
				*/
			} else {
				$('#group_chat-notification').html('');
			}
		},
	});
}
</script>

<div id="group_chat-notification"></div>

