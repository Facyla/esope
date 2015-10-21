<?php
/**
 * bootstrap plugin
 *
 */

elgg_register_event_handler('init', 'system', 'bootstrap_init'); // Init


/**
 * Init adf_bootstrap plugin.
 */
function bootstrap_init() {
	
	elgg_extend_view('css', 'bootstrap/css');
	/*
	elgg_register_simplecache_view('bootstrap/js');
	$bootstrap_js = elgg_get_simplecache_url('js', 'bootstrap');
	elgg_register_js('bootstrap', $bootstrap_js, 'head');
	*/
	
	// Register JS scripts and CSS
	$vendors_url = '/mod/bootstrap/vendors/bootstrap-3.3.5/';
	// Main style
	elgg_register_css('bootstrap', $vendors_url . 'css/bootstrap.min.css');
	// Optional theme
	//elgg_register_css('bootstrap-theme', $vendors_url . 'css/bootstrap.theme.min.css');
	
	// JS scripts
	// Bootstrap core
	elgg_define_js('bootstrap', array(
		'src' => $vendors_url . 'js/bootstrap.min.js',
	));
	
	// Load JS and CSS
	elgg_load_css('bootstrap');
	//elgg_load_css('bootstrap-theme');
	elgg_require_js("bootstrap");
	
}



