<?php 
global $CONFIG;
$baseUrl = $CONFIG->url;  
$ts = time();
$token = generate_action_token($ts);
$guid =  elgg_get_page_owner_guid();
?>
<script type="text/javascript" language="javascript">
/* 
Created by: Mitesh Chavda

Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;

function chat(){
   updateChat();
   sendChat();
   getStateOfChat();
}

//gets the state of the chat
function getStateOfChat(){
  //alert('getStateOfChat');
  if(!instanse){
     instanse = true;
     $.ajax({
       type: "GET",
       url: "<?php echo $baseUrl;?>action/group_chat/process",
       data: {
          'function': 'getState',
          'file': file,
          '__elgg_ts':'<?php echo $ts;?>',
          '__elgg_token':'<?php echo $token; ?>',
          'groupEntityId':'<?php echo $guid; ?>'
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
       type: "GET",
       url: "<?php echo $baseUrl;?>action/group_chat/process",
       data: {
          'function': 'update',
          'state': state,
          'file': file,
          '__elgg_ts':'<?php echo $ts;?>',
          '__elgg_token':'<?php echo $token; ?>',
          'groupEntityId':'<?php echo $guid; ?>'
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
function sendChat(message, nickname, profilePic) {
  updateChat();
   $.ajax({
     type: "GET",
     url: "<?php echo $baseUrl;?>action/group_chat/process",
     data: {
        'function': 'send',
        'message': message,
        'nickname': nickname,
        'profilePic':profilePic,
        'file': file,
        '__elgg_ts':'<?php echo $ts;?>',
        '__elgg_token':'<?php echo $token; ?>',
        'groupEntityId':'<?php echo $guid; ?>'
       },
     dataType: "json",
     success: function(data){
       //alert('sendChat: success');
       updateChat();
     },
  });
}
</script>

