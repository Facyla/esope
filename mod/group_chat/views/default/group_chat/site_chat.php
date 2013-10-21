<?php
$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
if ( !elgg_is_logged_in() || ($site_chat != 'yes') ) { return; }
?>

<script>
$(document).ready(function(){
	var wh = $(window).height();
	var dH = wh -385;
	$('#gCMd').offset({top:dH});
	$(window).resize(function(){
		var wh = $(window).height();
		var dH = wh - 390;
		if(dH < 0) $('#gCMd').offset({top:0});
		else $('#gCMd').offset({top:dH});
	});
	
	// Go to end of div content
	$('#chat-area').scrollTop($('#chat-area')[0].scrollHeight);
});
</script>
<div id="sitechat-container">
		<?php
		echo elgg_view('group_chat/chat_process_engine', array());
		echo elgg_view('group_chat/sitechat_window', $vars);
		?>
</div>

