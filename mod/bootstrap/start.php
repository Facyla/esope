<?php
/**
 * Twitter Bootstrap plugin
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
	// Note : using 4.0 alpha because there is a really bad CSS declaration in previous versions 
	// ie: .hidden { display:none !important; }
	// which breaks most jquery and Elgg toggles
	//$vendors_url = '/mod/bootstrap/vendors/bootstrap-3.3.5/';
	$vendors_url = elgg_get_site_url() . 'mod/bootstrap/vendors/';
	$bootstrap_version = elgg_get_plugin_setting('bootstrap_version', 'bootstrap');
	if (empty($bootstrap_version)) { $bootstrap_version = 'bootstrap-3.3.6'; }
	$bootstrap_url = $vendors_url . $bootstrap_version . '/';
	
	// Tether script
	elgg_define_js('tether', array(
		'src' => $vendors_url . 'tether/tether.min.js',
		//'deps' => 'bootstrap',
		//'exports' => 'Tether',
	));
	
	// Main style
	elgg_register_css('bootstrap', $bootstrap_url . 'css/bootstrap.min.css');
	// Optional theme (not available on 4.0.0)
	//elgg_register_css('bootstrap-theme', $vendors_url . 'css/bootstrap-theme.min.css');
	
	// JS scripts
	// Bootstrap core
	elgg_define_js('bootstrap', array(
		'src' => $bootstrap_url . 'js/bootstrap.min.js',
		'deps' => 'tether',
	));
	
	// Load JS and CSS : leave this up to the theme
	// so we can activate the plugin without applying its styles on every page
	//elgg_load_css('bootstrap');
	//elgg_load_css('bootstrap-theme');
	//elgg_require_js("bootstrap");
	
}



