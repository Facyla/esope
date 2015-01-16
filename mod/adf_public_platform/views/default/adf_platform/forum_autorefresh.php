<?php
// @TODO : keep autorefresh hidden until fully implemented
$auto_refresh = get_input('autorefresh');
if ($auto_refresh != 'auto') { return; }

// Refresh rate : floor to 10 seconds
$auto_refresh_rate = get_input('rate', 20);
if (!is_int($auto_refresh_rate) || ($auto_refresh_rate < 10)) { $auto_refresh_rate = 20; }
$auto_refresh_rate = $auto_refresh_rate * 1000;

$refresh_url = elgg_get_site_url() . 'esope/forum_refresh/' . $vars['entity']->guid;
$ts = time();
$token = generate_action_token($ts);
$action_token = '?__elgg_token=' . $token . '&__elgg_ts=' . $ts;

// echo '<a href="javascript:void(0);" onclick="forum_refresh();">Refresh</a>';
// echo "Load URL : $refresh_url";
?>

<script type="text/javascript">
var annotation_latest = 0; // Use latest annotation timestamp

function forum_refresh() {
	//$('#annotations-loading').show();
	//$('#annotations-loading').fadeOut('slow');
	if (annotation_latest > 0) {
		$.ajax({
			url: '<?php echo $refresh_url; ?>/' + annotation_latest + '<?php echo $action_token; ?>',
			success: function(data) {
				$('#group-replies .elgg-annotation-list').prepend(data);
			}
		});
	} else {
		$('#group-replies .elgg-annotation-list').load('<?php echo $refresh_url . $action_token; ?>').fadeIn("slow");
		/*
		$.ajax({
			url: '<?php echo $refresh_url . $action_token; ?>',
			success: function(data) {
				$('#group-replies .elgg-annotation-list').html(data).fadeIn("slow");
			}
		});
		*/
	}
	// Store latest timestamp +1 to avoid duplicate
	annotation_latest = Math.floor(Date.now() / 1000) + 1;
}

$(document).ready(function() {
	$('#group-replies .elgg-pagination').hide();
	//$('#group-replies .elgg-annotation-list').html('<i class="fa fa-spinner fa-spin></i>').fadeOut("slow");
	forum_refresh();
	// Autorefresh de 20 secondes par défaut
	var auto_refresh = setInterval(function() { forum_refresh(); }, <?php echo $auto_refresh_rate; ?>);
	//$('#group-replies').prepend('<div id="annotations-loading" style="display:none;">Loading content</div>');
});
</script>


