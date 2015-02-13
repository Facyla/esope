<?php
// Original chat window - not used anymore

global $CONFIG;
$guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();

$smiley_url = $CONFIG->url . 'mod/group_chat/graphics/smiley/';

$chat_content = group_chat_get_chat_content();
?>
<script type="text/javascript">
	$(document).ready(function() {
		getStateOfChat();
		<?php
		//if ($vars['entity']->isMember($user)) {
		// Support for group & site chat
		if ( (elgg_instanceof($vars['entity'], 'group') && $vars['entity']->isMember($user))
		|| (elgg_instanceof($vars['entity'], 'site')) 
		) {
			?>
		$("#sendie").keydown(function(a){var b=a.which;if(b>=33){var c=$(this).attr("maxlength");var d=this.value.length;if(d>=c){a.preventDefault()}}});
		$("#chat-area li").hover(function(){$(".chatTime").hide();$(this).children(".chatTime").show()});
		$("#chat-area li").mouseover(function(){$(".chatTime").hide();$(this).children(".chatTime").show()});
		$("#chat-area li").click(function(){$(".chatTime").hide();$(this).children(".chatTime").show()});
		$("#sendie").keyup(function(a){if(a.keyCode==13){var b=$(this).val();var c=$(this).attr("maxlength");var d=b.length;if(d<=c+1){sendChat(b);$(this).val("")}else{$(this).val(b.substring(0,c))}}});
			<?php
		}
		?>
		updateChat();
		var refresh_rate = 100;
		// @todo : auto-adjust update rate to real activity : 
		// lowering when new updates, and delaying when no activity
		setInterval('updateChat()', refresh_rate);
		
		<?php if ($guid <=0 ) { ?>
			$('#sendie').attr('disabled','disabled');
		<?php } ?>
		$(".miniMize").click(function(){$(".chatWrapper").hide();$(this).hide();$(".maxMize").show();var a=$(window).height();var b=a-30;$("#gCMd").offset({top:b})});
		$(".maxMize").click(function(){$(".chatWrapper").show();$(this).hide();$(".miniMize").show();var a=$(window).height();var b=a-385;$("#gCMd").offset({top:b})});
		$(".smileyCon").click(function(){$("#mainCon").show();var a=$(this).attr("data-value");var b=$("#sendie").val();$("#sendie").val(b+" "+a);$("#smileyGroup").hide();$("#sendie").focus()});
		$("#mainCon").click(function(){$("#mainCon").hide();$("#smileyGroup").show()});
		$(".closeIcon").click(function(){$("#mainCon").show();$("#smileyGroup").hide()});
		
		<?php if ($chat_content) { ?>
		// Open chat if not empty !
		$(".chatWrapper").show(); $(".miniMize").show(); $(".maxMize").hide();
		<?php } ?>
		
	});
	
	function chatCall(a){$(".chatTime").hide();$(a).children(".chatTime").show()}
</script>

<div id="page-wrap">
	<div id="chat-wrap">
		<div class="clear" id="groupTitleChat">
			<div class="floatLeft"><?php echo ucfirst($vars['entity']->username); ?> Chat</div>
			<div class="floatRight">
				<div class="floatLeft padRht10 cursor miniMize">[-]</div>
				<div class="floatLeft padRht10 cursor maxMize">[+]</div>
			</div>
		</div>
		<div class="chatWrapper">
			<div class='outSide'>
				<ol id="chat-area">
					<?php
					if ($chat_content) { echo $chat_content; }
					?>
				</ol>
			</div>
			<div class="clear sendieDiv">
				<?php
				//if ($vars['entity']->isMember($user)) {
				if ( (elgg_instanceof($vars['entity'], 'group') && $vars['entity']->isMember($user))
				|| (elgg_instanceof($vars['entity'], 'site'))
				) {
					?>
				<div class="floatLeft">
					<form id="send-message-area">
						<textarea id="sendie" maxlength = '300'	 ></textarea>
					</form>
				</div>
				<div class="floatRight">
					<div id="smileyGroup">
					<?php echo group_chat_smileys_list(); ?>
						<div class="floatRight pad5"><a class="closeIcon">x</a></div>
						<div class="clear"></div>
					</div>
					<div id="mainCon"> <img src="<?php echo $smiley_url; ?>smile.gif" class="smileyMain" title="Smiley"></div>
				</div>
				<?php } else { ?>
				<div class="floatLeft joinGroup"><?php echo elgg_echo('group_chat:joingrouptochat'); ?></div>
				<?php } ?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div id="clear_both"></div>
</div>

