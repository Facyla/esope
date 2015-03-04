<?php
// Common part for all chats
global $CONFIG;

$chat_id = elgg_extract('chat_id', $vars);
$chat_days = elgg_extract('days', $vars, false);
$chat_content = group_chat_get_chat_content($chat_id, $chat_days);
$smiley_url = elgg_get_site_url() . 'mod/group_chat/graphics/smiley/';


// Update marker so we know we're up-to-date
group_chat_update_marker($chat_id);


?>
<script type="text/javascript">
	$(document).ready(function() {
		getStateOfChat();
		$("#sendie").keydown(function(a){var b=a.which;if(b>=33){var c=$(this).attr("maxlength");var d=this.value.length;if(d>=c){a.preventDefault()}}});
		$("#chat-area li").hover(function(){$(".chatTime").hide();$(this).children(".chatTime").show()});
		$("#chat-area li").mouseover(function(){$(".chatTime").hide();$(this).children(".chatTime").show()});
		$("#chat-area li").click(function(){$(".chatTime").hide();$(this).children(".chatTime").show()});
		$("#sendie").keyup(function(a){if(a.keyCode==13){var b=$(this).val();var c=$(this).attr("maxlength");var d=b.length;if(d<=c+1){sendChat(b);$(this).val("")}else{$(this).val(b.substring(0,c))}}});
		
		updateChat();
		// This may produce much logs
		var refresh_rate = 300;
		// @todo : auto-adjust update rate to real activity : 
		// lowering when new updates, and delaying when no activity
		setInterval('updateChat()', refresh_rate);
		
		$(".smileyCon").click(function(){$("#mainCon").show();var a=$(this).attr("data-value");var b=$("#sendie").val();$("#sendie").val(b+" "+a);$("#smileyGroup").hide();$("#sendie").focus()});
		$("#mainCon").click(function(){$("#mainCon").hide();$("#smileyGroup").show()});
		$(".closeIcon").click(function(){$("#mainCon").show();$("#smileyGroup").hide()});
		
		<?php if ($chat_content) { ?>
		// Open chat if not empty !
		$(".chatWrapper").show();
		<?php } ?>
		
	});
	
	// Replaced by CSS hover effect
	//function chatCall(a){$(".chatTime").hide();$(a).children(".chatTime").show()}
</script>

<div id="sitechat-page-wrap">
	<div id="chat-wrap">
		<div class="chatWrapper">
			<div class='site-outSide'>
				<div class="chat-title"><?php echo group_chat_friendly_title($chat_id, true, true); ?></div>
				<ol id="chat-area">
					<?php if ($chat_content) { echo $chat_content; } ?>
				</ol>
			</div>

			<div class="clearfloat site-sendieDiv">
				<div id="sitechat-compose" class="floatLeft">
					<form id="send-message-area">
						<textarea id="sendie" maxlength='300' placeholder="<?php echo elgg_echo('group_chat:placeholder'); ?>"></textarea>
					</form>
				</div>

				<div id="sitechat-helpers" class="floatRight">
					<div id="mainCon"><img src="<?php echo $smiley_url; ?>smile.gif" class="smileyMain" title="Smiley"></div>
				</div>
				<div id="smileyGroup">
					<?php echo group_chat_smileys_list(); ?>
					<div class="floatRight pad5"><a class="closeIcon"><i class="fa fa-close"></i></a></div>
					<div class="clearfloat"></div>
				</div>
				<div class="clearfloat"></div>
			</div>
		</div>
	</div>
	<div class="clearfloat"></div>
</div>


