<?php
//global $CONFIG, $SESSION;

$title = elgg_echo('qrcode:title');
$content = '';

//$sidebar = elgg_view_title('QR Code');
$content .= elgg_view('qrcode/form');


// Setup page
$body = elgg_view_layout('one_sidebar', array(
	'filter_context' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

// Display page
echo elgg_view_page($title, $body);

