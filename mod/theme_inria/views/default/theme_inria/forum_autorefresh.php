<?php
// @TODO : keep autorefresh hidden until fully implemented
$auto_refresh = get_input('autorefresh');
if ($auto_refresh != 'auto') { return; }

$refresh_url = elgg_get_site_url() . 'inria/forum_refresh/' . $vars['entity']->guid;
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
			url: '<?php echo $refresh_url; ?>/' + annotation_latest,
			success: function(data) {
				$('#group-replies .elgg-annotation-list').prepend(data);
			}
		});
	} else {
		$('#group-replies .elgg-annotation-list').load('<?php echo $refresh_url; ?>').fadeIn("slow");
	}
	// Store latest timestamp +1 to avoid duplicate
	annotation_latest = Math.floor(Date.now() / 1000) + 1;
}

$(document).ready(function() {
	$('#group-replies .elgg-pagination').hide();
	//$('#group-replies .elgg-annotation-list').html('<i class="fa fa-spinner fa-spin></i>').fadeOut("slow");
	forum_refresh();
	var auto_refresh = setInterval(function() { forum_refresh(); }, 20000); // Timeout de 10 secondes
	$('#group-replies').prepend('<div id="annotations-loading" style="display:none;">Loading content</div>');
});
</script>


