<?php
$title = elgg_echo('qrcode:page:title');
$uri = current_page_url();
// Id utile seulement si plusieurs QR codes par page - pas ici
//$id = substr(md5($uri), 0, 8);

//$qrcode = elgg_get_site_url() . 'qrcode/qr_page/?d=' . urlencode($uri) . '&height=300&width=300';

$icon = elgg_get_site_url() . 'mod/qrcode/image/qrcode.png';
$link_text = '<img src="' . $icon . '" title="' . $title . '" />';
$link = elgg_view('output/url', array('text' => $link_text, 'href' => "#elgg-popup-qrcode-page", 'rel' => 'popup'));

//$content = elgg_view('qrcode/qrcode', array('qrcode_url' => $uri, 'height' => '500', 'width' => '500'));
$content = elgg_view('output/qrcode', array('qrcode_url' => $uri));

// Render QR code
echo '<span>' . $link . '</span><br />';
echo elgg_view_module('popup', $title, $content, array(
	'id' => "elgg-popup-qrcode-page",
	'class' => 'hidden clearfix developers-content-thin',
));

