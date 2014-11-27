<?php
/* d3js plugin
* 
 * @author : 
 */

// Initialise log browser
elgg_register_event_handler('init','system','elgg_dataviz');


/* Initialise the theme */
function elgg_dataviz(){
	global $CONFIG;
	
	// CSS et JS
	elgg_extend_view('css', 'elgg_dataviz/css');
	
	// Register datavisualisation libraries
	elgg_register_js('elgg:dataviz:D3', '/mod/elgg_dataviz/vendors/d3/d3.min.js', 'head');
/*
	elgg_register_js('elgg_dataviz:dialog', '/mod/elgg_dataviz/vendors/d3js/soap/include/dialog.js');
	elgg_load_js('elgg_dataviz:dialog');
	
	// d3js widgets - add only if enabled
	if (elgg_get_plugin_setting('widget_mine', 'elgg_dataviz') == 'yes') 
	elgg_register_widget_type('elgg_dataviz_mine', elgg_echo('elgg_dataviz:widget:d3js_mine'), elgg_echo('elgg_dataviz:widget:d3js_mine:details'), 'dashboard', false);
*/	
	// d3js page handler
	elgg_register_page_handler('d3js', 'elgg_dataviz_page_handler');

}


function elgg_dataviz_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_dataviz/pages/elgg_dataviz';
	switch($page[0]) {
		case 'data':
			if (isset($page[1])) set_input('viztype', $page[1]);
			if (!include_once "$base/data.php") return false;
			break;
		case 'view':
			if (isset($page[1])) set_input('viztype', $page[1]);
			if (!include_once "$base/view.php") return false;
			break;
		case 'edit':
			if (!include_once "$base/edit.php") return false;
			break;
		default:
			if (!include_once "$base/index.php") return false;
	}
	return true;
}



