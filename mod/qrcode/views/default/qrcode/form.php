<?php
$img = elgg_get_site_url() . 'qrcode/qr_img/?d=';
$dl = $img . '&download=true';

?>
<div>
	<p><?php echo elgg_echo('qrcode:form:notice'); ?></p>
	<?php
	$input = '<p><label>' . elgg_echo('qrcode:form:texttoencode') . elgg_view('input/plaintext', array('id' => 'qrcodeinput')) . '</label></p>';
	$submit = elgg_view('input/submit', array('value' => elgg_echo('qrcode:form:submit')));
	$form = elgg_view('input/form', array('id' => 'qrcodeform', 'body' => $input . $submit));
	echo $form;
	?>

	<img id="qrcodeimage" src="<?php echo $img; ?>" />

	<script type="text/javascript"> 
	$('#qrcodeform').submit(function(event) {
		event.preventDefault();
		$('#qrcodeimage').attr('src', '<?php echo $img; ?>' + $('#qrcodeinput').attr('value'));
	});
	</script>
</div>

