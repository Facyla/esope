<?php
// Display only in full view mode
if (!$vars['full_view']) { return; }

$refresh = get_input('refresh');
$refresh_sort = get_input('refresh_sort', 'latest');

// @TODO : keep autorefresh hidden until fully implemented
echo '<div id="autorefresh-menu">';
echo elgg_echo('esope:autorefresh') . ' : ';
if ($refresh == 'auto') {
	echo '<a href="' . $vars['entity']->getURL() . '">' . elgg_echo('esope:autorefresh:no') . '</a> &nbsp; ';
	echo '<strong>' . elgg_echo('esope:autorefresh:yes') . '</strong>';
	echo '<span style="float:right;">' . elgg_echo('esope:autorefresh:sortby') . ' ';
		if ($refresh_sort == 'likes') {
			echo '<a href="' . $vars['entity']->getURL() . '?refresh=auto">' . elgg_echo('esope:autorefresh:latest') . '</a> &nbsp; ';
			echo '<strong>' . elgg_echo('esope:autorefresh:likes') . '</strong>';
		} else {
			echo '<strong>' . elgg_echo('esope:autorefresh:latest') . '</strong> &nbsp; ';
			echo '<a href="' . $vars['entity']->getURL() . '?refresh=auto&refresh_sort=likes">' . elgg_echo('esope:autorefresh:likes') . '</a>';
		}
	echo '</span>';
} else {
	echo '<strong>' . elgg_echo('esope:autorefresh:no') . '</strong> &nbsp; ';
	echo '<a href="' . $vars['entity']->getURL() . '?refresh=auto">' . elgg_echo('esope:autorefresh:yes') . '</a> &nbsp; ';
}

/*
if (($refresh == 'auto') && ($refresh_sort != 'likes')) {
	echo elgg_echo('esope:autorefresh:latest') . ' &nbsp; ';
} else {
	echo '<a href="' . $vars['entity']->getURL() . '?refresh=auto">' . elgg_echo('esope:autorefresh:latest') . '</a> &nbsp; ';
}
if (($refresh == 'auto') && ($refresh_sort == 'likes')) {
	echo elgg_echo('esope:autorefresh:likes') . ' &nbsp; ';
} else {
	echo '<a href="' . $vars['entity']->getURL() . '?refresh=auto&refresh_sort=likes">' . elgg_echo('esope:autorefresh:likes') . '</a>';
}
*/
echo '</div>';

// Stop here if autorefresh is disabled
if ($refresh != 'auto') { return; }

// Refresh rate : floor to 10 seconds
$refresh_rate = get_input('refresh_rate', 20);
if (!is_int($refresh_rate) || ($refresh_rate < 10)) { $refresh_rate = 20; }
$refresh_rate = $refresh_rate * 1000;

$refresh_url = elgg_get_site_url() . 'esope/forum_refresh/' . $vars['entity']->guid;
$ts = time();
$token = generate_action_token($ts);
$action_token = '?__elgg_token=' . $token . '&__elgg_ts=' . $ts;
$parameters = $action_token . '&sort=' . $refresh_sort;

// echo '<a href="javascript:void(0);" onclick="forum_refresh();">Refresh</a>';
// echo "Load URL : $refresh_url";

echo elgg_view('adf_platform/loader', array('enabled' => true))
?>

<script type="text/javascript">
var annotation_latest = 0; // Use latest annotation timestamp


function forum_refresh() {
	// Use only basic loading if we need to refresh all content at every refresh (eg update nb of likes)
	$('#loader').fadeIn('slow');
	$('#group-replies .elgg-annotation-list').load('<?php echo $refresh_url . $parameters; ?>').fadeIn('fast');
	$('#loader').hide();
	
	/* Alternate method : lesser aggressive, but gets only the latest additions (no previous content update)
	//$('#annotations-loading').show();
	//$('#annotations-loading').fadeOut('slow');
	if (annotation_latest > 0) {
		$.ajax({
			url: '<?php echo $refresh_url; ?>/' + annotation_latest + '<?php echo $parameters; ?>',
			success: function(data) {
				$('#group-replies .elgg-annotation-list').prepend(data);
			}
		});
	} else {
		$('#group-replies .elgg-annotation-list').load('<?php echo $refresh_url . $parameters; ?>').fadeIn("slow");
	}
	// Store latest timestamp +1 to avoid duplicate
	annotation_latest = Math.floor(Date.now() / 1000) + 1;
	*/
}

$(document).ready(function() {
	$('#group-replies .elgg-pagination').hide();
	$('#group-replies .elgg-annotation-list').hide();
	// Use 1sec timeout for first load so tinymce can load before
	setTimeout(forum_refresh, 1000);
	//forum_refresh();
	// Autorefresh de 20 secondes par défaut
	var auto_refresh = setInterval(function() { forum_refresh(); }, <?php echo $refresh_rate; ?>);
});
</script>


