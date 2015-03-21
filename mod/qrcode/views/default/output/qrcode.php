<?php
global $CONFIG;

$qrcode_url = $vars['qrcode_url'];
/* Unused in image generation library
$height = $vars['height'];
$width = $vars['width'];
*/

//$img = $CONFIG->wwwroot . "qrcode/qr_img?d=$qrcode_url&height=$height&width=$width";
$img = $CONFIG->wwwroot . "qrcode/qr_img?d=$qrcode_url";
$dl = $img . '&download=true';

?>
<div>
	<a href="<?php echo $dl; ?>">
		<img src="<?php echo $img; ?>" />
		<br />
		<small>Télécharger le QR Code</small>
	</a>
</div>

