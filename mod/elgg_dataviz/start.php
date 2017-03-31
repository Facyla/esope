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
	$vendors_url = '/mod/elgg_dataviz/vendors/';
	
	//elgg_register_js('elgg:dataviz:chartjs', $vendors_url . 'chartjs/Chart.min.js', 'head');
	elgg_define_js('elgg.dataviz.chartjs', array(
		'src' => $vendors_url . 'chartjs/Chart.min.js',
		'deps' => array(''),
		//'exports' => "Chart",
	));
	
	//elgg_register_js('elgg:dataviz:d3', $vendors_url . 'd3/d3.min.js', 'head');
	elgg_define_js('elgg.dataviz.d3', array(
		'src' => $vendors_url . 'd3/d3.min.js',
		'deps' => array(''),
		//'exports' => "d3",
	));
	
	//elgg_register_js('elgg:dataviz:nvd3', $vendors_url . 'nvd3/nv.d3.min.js', 'head');
	elgg_define_js('elgg.dataviz.nvd3', array(
		'src' => $vendors_url . 'nvd3/nv.d3.min.js',
		'deps' => array('elgg.dataviz.d3'),
		//'exports' => "nv",
	));
	elgg_register_css('elgg:dataviz:nvd3', $vendors_url . 'nvd3/nv.d3.min.css', 'head');
	
	//elgg_register_js('elgg:dataviz:vega', $vendors_url . 'vega/vega.min.js', 'head');
	elgg_define_js('elgg.dataviz.vega', array(
		'src' => $vendors_url . 'vega/vega.min.js',
		'deps' => array('elgg.dataviz.d3'),
	));
	
	//elgg_register_js('elgg:dataviz:dygraphs', $vendors_url . 'dygraphs/dygraph-combined.js', 'head');
	elgg_define_js('elgg.dataviz.dygraphs', array(
		'src' => $vendors_url . 'dygraphs/dygraph-combined.js',
		'deps' => array(''),
	));
	
	//elgg_register_js('elgg:dataviz:crossfilter', $vendors_url . 'crossfilter/crossfilter.min.js', 'head');
	elgg_define_js('elgg.dataviz.crossfilter', array(
		'src' => $vendors_url . 'crossfilter/crossfilter.min.js',
		'deps' => array(''),
	));
	
	//elgg_register_js('elgg:dataviz:raphael', $vendors_url . 'raphael/raphael-min.js', 'head');
	elgg_define_js('elgg.dataviz.raphael', array(
		'src' => $vendors_url . 'raphael/raphael-min.js',
		'deps' => array(''),
	));
	
	// AnyChart
	elgg_define_js('elgg.dataviz.anychart', array(
		'src' => $vendors_url . 'anychart/AnyChart/anychart-bundle.min.js',
	));
	elgg_define_js('elgg.dataviz.graphicsjs', array(
		'src' => $vendors_url . 'anychart/GraphicsJS/graphics.min.js',
	));
	/*
	elgg_define_js('google.closure', array(
		'src' => $vendors_url . 'google/closure-library/',
	));
	*/
	
	// jquery data tables plugin
	//elgg_register_js('jquery.datatables', $vendors_url . 'jquery_datatables/media/js/jquery.dataTables.min.js', 'head');
	elgg_define_js('jquery.datatables', array(
		'src' => $vendors_url . 'jquery_datatables/media/js/jquery.dataTables.min.js',
		'deps' => array('jquery'),
	));
	elgg_register_css('jquery.datatables', $vendors_url . 'jquery_datatables/media/css/jquery.dataTables.min.css', 'head');
	
	/*
	elgg_register_js('elgg_dataviz:dialog', $vendors_url . 'd3js/soap/include/dialog.js');
	elgg_require_js('elgg_dataviz:dialog');
	
	// d3js widgets - add only if enabled
	if (elgg_get_plugin_setting('widget_mine', 'elgg_dataviz') == 'yes') 
	elgg_register_widget_type('elgg_dataviz_mine', elgg_echo('elgg_dataviz:widget:d3js_mine'), elgg_echo('elgg_dataviz:widget:d3js_mine:details'), 'dashboard', false);
	*/
	
	
	// elgg_dataviz page handler
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
		$id = esope_unique_id($prefix);
	} else {
		global $dataviz_unique_id;
		if (!isset($dataviz_unique_id)) {
			$dataviz_unique_id = 1;
		} else {
			$dataviz_unique_id++;
		}
		$id = $prefix . $dataviz_unique_id;
	}
	$id = elgg_get_friendly_title($id);
	// Ensure valid id for JS
	$id = str_replace('-', '_', $id);
	return $id;
}


/* Data model notes
* @TODO !!
 * Data structures should be normalised so that any visualisation from any library can use the same source
 * Note : this will not work with specific visualisations based eg. on relations, but should meet most use cases
 * 
 * Basic series vs multiple series
 * Most basic data structures use a single data series, with labels and other settings (style, etc.)
 * So data will be normalised using a serie structure so it can fits all cases, and can easily be extended :
 * $data = array(
 * 		'serie_key' => $serie_data,
 * 	);
 * 
 * Data serie structure
 * Data serie can contain only raw values, or named values, and also some global or value-specific settings
 * $serie_data = array(
 * 	'label' => 'serie_label',
 * 	//'type' => 'serie', // optional ?
 * 	'options' => array(
 * 			'option1' => 'value1',
 * 			'option2' => 'value2',
 * 		),
 * 	'values' => array(
 * 		'value',
 * 		'key' => 'value',
 * 		array(
 * 			'value' => 'value',
 * 			'label' => 'label',
 * 		),
 * 	),
 * ),
 * 	
 * 	
 * 	);
 */


