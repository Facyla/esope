<?php
/* QR Code generator, based on initial plugin by Justin Richer 
 * http://community.elgg.org/plugins/475144/0.2/qr-code-generator
 * 
 */


// Make sure the profile initialisation function is called on initialisation
elgg_register_event_handler('init','system','qrcode_init');



function qrcode_init() {
	elgg_extend_view('css', 'qrcode/css');
	
	// give us a link up top
	//elgg_extend_view('elgg_topbar/extend', 'qrcode/topbar');
	// And also on page owner block
	//elgg_extend_view('page/elements/owner_block', 'qrcode/topbar');
	elgg_extend_view('page/elements/owner_block', 'qrcode/ownerblock_extend');
	
	// Add QR code menu in sidebar
	$popup_title = elgg_echo('qrcode:page:title');
	$icon = elgg_get_site_url() . 'mod/qrcode/image/qrcode.png';
	$link_text = '<img src="' . $icon . '" title="' . $popup_title . '" />';
	elgg_register_menu_item('extras', array(
			'name' => 'qrcode-page', 'text' => $link_text, 'title' => $popup_title,
			'href' => '#elgg-popup-qrcode-page', 'rel' => 'popup', 'priority' => 800,
		));
	
	// URLs
	elgg_register_page_handler('qrcode', 'qrcode_page_handler');
}


function qrcode_page_handler($page) {
	$page_url = elgg_get_plugins_path() . 'qrcode/pages/qrcode/';
	if (!isset($page[0])) { $page[0] = ''; }
	switch($page[0]) {
		case 'qr_img':
			include($page_url . 'qr_img.php');
			break;
		case 'qr_page':
			include($page_url . 'qr_page.php');
			break;
		default:
			include($page_url . 'index.php');
	}
	return true;
}


