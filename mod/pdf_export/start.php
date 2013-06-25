<?php
global $CONFIG;

// register for events
elgg_register_event_handler('init','system','pdf_export_init');

// register page handler
elgg_register_page_handler('pdfexport','pdf_export_page_handler');

//register our actions
//elgg_register_action("pdf_export/add", false, $CONFIG->pluginspath . "pdf_export/actions/add.php");


function pdf_export_init() {
  
  //elgg_extend_view('css', 'pdf_export/css');
  
  //elgg_extend_view('owner_block/extend', 'pdf_export/owner_block_extend');
  /* Oui.. mais non : mieux vaut une liste bien définie 
  // le rendu dépend beaucoup de ce qu'on met dans le contenu, 
  // par ex. bookmarks ou fichiers : il faut le lien sinon c'est inutile)
  $validhighlight = get_registered_entity_types('object');
  $validhighlight[] = 'groupforumtopic';
  */
  $validhighlight = array('page', 'page_top', 'blog', 'groupforumtopic', 'bookmarks');
  //$validhighlight = array('page', 'page_top', 'blog', 'groupforumtopic', 'bookmarks', 'file');
  // Extend chosen entities views
  foreach($validhighlight as $type) {
    $type = trim($type);
    if ($type == 'groupforumtopic') elgg_extend_view("forum/viewposts", 'pdf_export/owner_block_extend', 100);
    else elgg_extend_view("object/$type", 'pdf_export/owner_block_extend', 100);
  }
  
}

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

// page structure for imports <url>/pdf_export/<container_guid>/<context>/<pdf_export_guid>
// history: <url>/pg/pdf_export/<container_guid>/<context>/<pdf_export_guid>/history
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

/* Note sur l'erreur : "TCPDF ERROR: [Image] Unable to get image: ..."
 => lié à la récupération de l'image via cURL, qui n'a pas les droits d'un user loggué..
 
*/

