<?php
// Extends a view for a site chat
// @todo : improve site integration
?>


<script>
$(document).ready(function(){
  var wh = $(window).height();
  var dH = wh -385;
  $('#gCMd').offset({top:dH});

  $(window).resize(function(){
    var wh = $(window).height();
    var dH = wh - 390;
    if(dH < 0)
      $('#gCMd').offset({top:0});
    else
      $('#gCMd').offset({top:dH});
  });
  
  // Go to end of div content + hide at startup - @todo : make this a plugin setting
  $('#chat-area').scrollTop($('#chat-area')[0].scrollHeight);
  $(".chatWrapper").hide(); $(".miniMize").hide(); $(".maxMize").show();
});

jQuery(function( $ ){
  var container = $( "#container" );
  if (container.is( ":visible" )){
    // Hide - slide up.
    container.slideUp( 2000 );
  } else {
    // Show - slide down.
    container.slideDown( 2000 );
  }    
});
</script>
<div style="position:fixed; bottom:0%; z-index:9999" id="gCMd" >
  <?php
  $content = '';
  $content .= elgg_view('group_chat/chat_process_engine', array());
  $content .= elgg_view('group_chat/chat_window', $vars);  
  ?>
  <div id="container">
    <div id="inner">
      <?php echo $content;?>
    </div>
  </div>
</div>

