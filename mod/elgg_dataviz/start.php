<?php
/* Elgg datavizualisation plugin
 * Provides a set a visualization libraries + convenient views to use them
 * 
 * @author : 
 */

// Initialise log browser
elgg_register_event_handler('init','system','elgg_dataviz');


/* Initialise the theme */
function elgg_dataviz(){
	
	// CSS et JS
	elgg_extend_view('css', 'elgg_dataviz/css');
	
	// Register datavisualisation libraries
	elgg_register_js('elgg:dataviz:chartjs', '/mod/elgg_dataviz/vendors/chartjs/Chart.min.js', 'head');
	
	elgg_register_js('elgg:dataviz:d3', '/mod/elgg_dataviz/vendors/d3/d3.min.js', 'head');
	
	elgg_register_js('elgg:dataviz:nvd3', '/mod/elgg_dataviz/vendors/nvd3/nv.d3.min.js', 'head');
	elgg_register_css('elgg:dataviz:nvd3', '/mod/elgg_dataviz/vendors/nvd3/nv.d3.min.css', 'head');
	
	elgg_register_js('elgg:dataviz:vega', '/mod/elgg_dataviz/vendors/vega/vega.min.js', 'head');
	
	elgg_register_js('elgg:dataviz:dygraphs', '/mod/elgg_dataviz/vendors/dygraphs/dygraph-combined.js', 'head');
	
	elgg_register_js('elgg:dataviz:crossfilter', '/mod/elgg_dataviz/vendors/crossfilter/crossfilter.min.js', 'head');
	
	elgg_register_js('elgg:dataviz:raphael', '/mod/elgg_dataviz/vendors/raphael/raphael-min.js', 'head');
	// jquery data tables plugin
	elgg_register_js('jquery.datatables', '/mod/elgg_dataviz/vendors/jquery_datatables/media/js/jquery.dataTables.min.js', 'head');
	elgg_register_css('jquery.datatables', '/mod/elgg_dataviz/vendors/jquery_datatables/media/css/jquery.dataTables.min.css', 'head');
	
/*
	elgg_register_js('elgg_dataviz:dialog', '/mod/elgg_dataviz/vendors/d3js/soap/include/dialog.js');
	elgg_load_js('elgg_dataviz:dialog');
	
	// d3js widgets - add only if enabled
	if (elgg_get_plugin_setting('widget_mine', 'elgg_dataviz') == 'yes') 
	elgg_register_widget_type('elgg_dataviz_mine', elgg_echo('elgg_dataviz:widget:d3js_mine'), elgg_echo('elgg_dataviz:widget:d3js_mine:details'), 'dashboard', false);
*/	
	// d3js page handler
	elgg_register_page_handler('dataviz', 'elgg_dataviz_page_handler');

}


function elgg_dataviz_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_dataviz/pages/elgg_dataviz';
	switch($page[0]) {
		/* Data endpoint : should be able to format various data types into several data structures, 
		 * and particularly JSON
		 * Should also be able to parse and transform other data structures, such as CSV, or XML
		 */
		case 'data':
			if (isset($page[1])) set_input('library', $page[1]);
			if (isset($page[2])) set_input('viztype', $page[2]);
			if (!include_once "$base/data.php") return false;
			break;
		
		case 'view':
			if (isset($page[1])) set_input('library', $page[1]);
			if (isset($page[2])) set_input('viztype', $page[2]);
			if (!include_once "$base/view.php") return false;
			break;
		
		default:
			if (!include_once "$base/index.php") return false;
	}
	return true;
}

/* Generate a unique id to use as a div id
 * Note that the id must contain valid id for both CSS and JS, ie. no '-'
 */
function dataviz_id($prefix = 'dataviz_') {
	if (function_exists('esope_unique_id')) {
		$id = esope_unique_id('dataviz_');
	} else {
		$id = esope_unique_id('dataviz_nvd3');
	}
	$id = elgg_get_friendly_title($id);
	// Ensure valid id for JS
	$id = str_replace('-', '_', $id);
	return $id;
}


