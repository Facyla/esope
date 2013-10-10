<?php
global $CONFIG;

// Events
elgg_register_event_handler('init','system','pdf_export_init');

// Page handler
elgg_register_page_handler('pdfexport','pdf_export_page_handler');

// Actions
//elgg_register_action("pdf_export/add", false, $CONFIG->pluginspath . "pdf_export/actions/add.php");


function pdf_export_init() {
	
	//elgg_extend_view('css', 'pdf_export/css');
	
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'pdf_export_dropdown_registration', 9999);
	
}


// page structure for exports <url>/pdf_export/<guid>
function pdf_export_page_handler($page) {
	global $CONFIG;
	
	// pdfexport/{format}/{guid} => pdfexport/pdf/1234
	switch($page[0]) {
		case 'pdf':
		default:
			if ($page[1]) set_input('guid', $page[1]);
			if (!include dirname(__FILE__) . '/pages/pdf_export/export.php') { return false; }
	}
	return true;
}


function pdf_export_dropdown_registration($hook, $type, $return, $params) {
	global $CONFIG;
	// Add entity menu
	if (elgg_instanceof($params['entity'], 'object')) {
		// Settings
		$validsubtypes = elgg_get_plugin_setting('validsubtypes', 'pdf_export');
		if (empty($validsubtypes)) $validsubtypes = 'page, page_top, blog, groupforumtopic, bookmarks';
		$validsubtypes = str_replace(' ', '', $validsubtypes); // No white space ! (we want clean array values)
		$validsubtypes = explode(',', $validsubtypes);
		// Only add menu to valid chosen object subtypes
		if (in_array($params['entity']->getSubtype(), $validsubtypes)) {
			// Menu elements
			$link_url = $CONFIG->url . 'pdfexport/pdf/' . $params['entity']->guid;
			$text = '<img src="' . $CONFIG->url . 'mod/pdf_export/graphics/pdf4_32.png" alt="' . elgg_echo('pdfexport:download:alt') . '" />';
			//$text = '<img src="' . $CONFIG->url . 'mod/pdf_export/graphics/pdf4_16.png" alt="' . elgg_echo('pdfexport:download:alt') . '" />';
			$title = elgg_echo('pdfexport:download:title');
			// Build the menu
			$pdf_export_menu = new ElggMenuItem('pdf_export', $text, $link_url);
			$pdf_export_menu->addLinkClass('pdf_export');
			$pdf_export_menu->setTooltip($title);
			$pdf_export_menu->setPriority(900);
			$return[] = $pdf_export_menu;
		}
	}
	return $return;
}


/* TCPDF config*/
function pdf_export_get_config($config = '') {
	global $CONFIG;
	if (!include_once(dirname(__FILE__) . '/assets/tcpdf/config/tcpdf_config.php')) { return false; }
	$sitename = $CONFIG->site->name;
	$siteurl = $CONFIG->site->url;
	// Force own settings
	// document creator
	define ('PDF_CREATOR', $sitename);
	// document author
	define ('PDF_AUTHOR', $sitename);
	// header title
	define ('PDF_HEADER_TITLE', 'Export PDF ' . $sitename);
	// header description string
	define ('PDF_HEADER_STRING', "$sitename - $siteurl");
	// image logo
	define ('PDF_HEADER_LOGO', 'logo.png');
	// header logo image width [mm]
	define ('PDF_HEADER_LOGO_WIDTH', 30);
	/* if true allows to call TCPDF methods using HTML syntax
	 * IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
	 */
	define('K_TCPDF_CALLS_IN_HTML', false);
	
	return true;
}


/* Note sur l'erreur : "TCPDF ERROR: [Image] Unable to get image: ..."
 => lié à la récupération de l'image via cURL, qui n'a pas les droits d'un user loggué..
 
*/

