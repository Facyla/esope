<?php
/* iCal viewer */

/* Initialise le plugin */
function ical_viewer_init() {
	elgg_extend_view('css','ical_viewer/css');
	elgg_register_page_handler('ical_viewer','ical_viewer_page_handler');
	
	elgg_register_widget_type('ical_viewer', elgg_echo('ical_viewer:widget:title'), elgg_echo('ical_viewer:widget:description'), 'all', true);
	
}


// Gestion des URL
function ical_viewer_page_handler($page) {
	if (!isset($page[0])) { $page[0] = 'world'; }
	switch($page[0]) {
		case 'view':
		case 'read':
			include(dirname(__FILE__) . "/pages/ical_viewer/ical_viewer.php");
			break;
		
		case 'world':
		default:
			include(dirname(__FILE__) . "/pages/ical_viewer/world.php");
	}
	return true;
}



// Initialise log browser
elgg_register_event_handler('init','system','ical_viewer_init');

