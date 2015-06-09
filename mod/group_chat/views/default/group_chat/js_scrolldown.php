<?php
// JS script that scrolls down to the latest content
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

