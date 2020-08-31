<?php
$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
if ( !elgg_is_logged_in() 
	|| !(elgg_get_page_owner_entity() instanceof ElggGroup)
	|| ($group_chat == 'no') 
	|| (($group_chat == 'groupoption') && ($vars['entity']->group_chat_enable != 'yes')) 
	) { return; }
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
	
	// Go to end of div content + hide at startup if empty - @todo : make this a plugin setting ?
	$('#chat-area').scrollTop($('#chat-area')[0].scrollHeight);
	$(".chatWrapper").hide(); $(".miniMize").hide(); $(".maxMize").show();
});

jQuery(function( $ ){
	var container = $( "#groupchat-container" );
	if (container.is( ":visible" )){
		// Hide - slide up.
		//container.slideUp( 2000 );
	} else {
		// Show - slide down.
		container.slideDown( 2000 );
	}
});
</script>
<div id="gCMd" style="position:fixed; bottom:0%; z-index:9999" >
	<div id="groupchat-container">
		<div id="inner">
			<?php
			echo elgg_view('group_chat/chat_process_engine', array());
			echo elgg_view('group_chat/chat_window', $vars);
			?>
		</div>
	</div>
</div>

