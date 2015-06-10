<?php 
global $CONFIG;
$baseUrl = elgg_get_site_url();

// At this step, we assume we should have a valid chat_id
if (empty($vars['chat_id'])) { return; }
?>

<script type="text/javascript" language="javascript">
var instanse = false;
var state;
var groupchat_url = elgg.security.addToken("<?php echo $baseUrl;?>action/group_chat/process");
var chat_id = '<?php echo $vars['chat_id']; ?>';


//gets the state of the chat
function getStateOfChat(){
	//alert('getStateOfChat');
	if(!instanse){
		instanse = true;
		$.ajax({
			type: "POST",
			url: groupchat_url,
			data: {
				'function': 'getState',
				'container': chat_id
			},
			dataType: "json",
			success: function(data){
				state = data.output.state;
				instanse = false;
			},
		});
	}
}

//Updates the chat
function updateChat(){
	//alert('updateChat');
	if(!instanse){
		instanse = true;
		$.ajax({
			type: "POST",
			url: groupchat_url,
			data: {
				'function': 'update',
				'state': state,
				'container': chat_id
			},
			dataType: "json",
			success: function(data){
				if(data.output.text){
					for (var i = 0; i < data.output.text.length; i++) {
						$('#chat-area').append($(data.output.text[i]));
					}
					document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				}
				instanse = false;
				state = data.output.state;
			},
		});
		$('#chat-area').scrollTop($('#chat-area')[0].scrollHeight);
	} else {
		setTimeout(updateChat, 1500);
	}
}

//send the message
function sendChat(message) {
	updateChat();
	$.ajax({
		type: "POST",
		url: groupchat_url,
		data: {
			'function': 'send',
			'message': message,
			'container': chat_id
		},
		dataType: "json",
		success: function(data){
			//alert('sendChat: success');
			updateChat();
		},
	});
}
</script>

