<?php
$qrcode_url = elgg_extract('qrcode_url', $vars);
/* Unused in image generation library
$height = $vars['height'];
$width = $vars['width'];
*/

//$img = elgg_get_site_url() . "qrcode/qr_img?d=$qrcode_url&height=$height&width=$width";
$img = elgg_get_site_url() . "qrcode/qr_img?d=$qrcode_url";
$dl = $img . '&download=true';

?>
<div>
	<a href="<?php echo $dl; ?>">
		<img src="<?php echo $img; ?>" />
		<br />
		<small><?php echo elgg_echo('qrcode:download'); ?></small>
	</a>
</div>

