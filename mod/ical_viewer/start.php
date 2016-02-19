<?php
/* iCal viewer */


// Initialise log browser
elgg_register_event_handler('init','system','ical_viewer_init');


/* Initialise le plugin */
function ical_viewer_init() {
	elgg_extend_view('css','ical_viewer/css');
	
	elgg_register_library('elgg:ical_viewer', elgg_get_plugins_path() . 'ical_viewer/lib/ical_viewer/functions.php');
	
	elgg_register_page_handler('ical_viewer','ical_viewer_page_handler');
	
	elgg_register_widget_type('ical_viewer', elgg_echo('ical_viewer:widget:title'), elgg_echo('ical_viewer:widget:description'), array('all'), true);
	
}


// Gestion des URL
function ical_viewer_page_handler($page) {
	$root = elgg_get_plugins_path() . 'ical_viewer/pages/ical_viewer/';
	
	if (!isset($page[0])) { $page[0] = 'index'; }
	switch($page[0]) {
		case 'read':
		case 'view':
			include($root . "view.php");
			break;
		
		case 'index':
		default:
			include($root . "index.php");
	}
	return true;
}


