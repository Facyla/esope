<?php echo elgg_view('input/text',$vars); ?>
<script type="text/javascript">
$().ready(function() {

	$("#<?php echo $vars['internalid']; ?>").autocomplete("<?php echo $vars['lookup_url']; ?>", {
		width: <?php echo $vars['width']; ?>,
		selectFirst: false,
		mustMatch: <?php if (isset($vars['mustMatch'])) {echo $vars['mustMatch'];} else {echo 'false';} ?>,
		minChars: <?php if (isset($vars['minChars'])) {echo $vars['minChars'];} else {echo '1';} ?>
	});
});
</script>