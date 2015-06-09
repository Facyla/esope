<?php
$d = get_input('d');
$height = get_input('height');
$width = get_input('width');

$img = elgg_get_site_url() . "qrcode/qr_img?d=$d&height=$height&width=$width";
$dl = $img . '&download=true';

?>
<div>
	<a href="<?php echo $dl; ?>">
		<img src="<?php echo $img; ?>" />
		<br />
		<small><?php echo elgg_echo('qrcode:download'); ?></small>
	</a>
</div>

