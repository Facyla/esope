<?php
/* CMIS and Alfresco CMIS plugin
 * Implements access to a CMIS repository, through SOAP and ATOMPUB
 * Also provides widgets and views for Alfresco embeds, using current (browser) authentication
 * @author : Florian DANIEL
 */

// Initialise log browser
elgg_register_event_handler('init','system','elgg_cmis_init');

/* Initialise the theme */
function elgg_cmis_init(){
	
	// CSS et JS
	elgg_extend_view('css/elgg', 'elgg_cmis/css');
	elgg_register_js('elgg_cmis:dialog', '/mod/elgg_cmis/vendors/cmis/soap/include/dialog.js', 'head');
	elgg_load_js('elgg_cmis:dialog');
	
	//elgg_load_js('lightbox');
	//elgg_load_css('lightbox');
	
	// CMIS libraries : as we want to switch between 2 libraries, we will register and load through own functions instead
	
	// CMIS widgets - add only if enabled
	if (elgg_get_plugin_setting('widget_mine', 'elgg_cmis') == 'yes') {
		elgg_register_widget_type('elgg_cmis_mine', elgg_echo('elgg_cmis:widget:cmis_mine'), elgg_echo('elgg_cmis:widget:cmis_mine:details'), array('dashboard'), false);
	}
	if (elgg_get_plugin_setting('widget_cmis', 'elgg_cmis') == 'yes') {
		elgg_register_widget_type('elgg_cmis', elgg_echo('elgg_cmis:widget:cmis'), elgg_echo('elgg_cmis:widget:cmis:details'), array('dashboard'), true);
	}
	if (elgg_get_plugin_setting('widget_folder', 'elgg_cmis') == 'yes') {
		elgg_register_widget_type('elgg_cmis_folder', elgg_echo('elgg_cmis:widget:cmis_folder'), elgg_echo('elgg_cmis:widget:cmis_folder:details'), array('dashboard'), true);
	}
	if (elgg_get_plugin_setting('widget_search', 'elgg_cmis') == 'yes') {
		elgg_register_widget_type('elgg_cmis_search', elgg_echo('elgg_cmis:widget:cmis_search'), elgg_echo('elgg_cmis:widget:cmis_search:details'), array('dashboard'), true);
	}
	if (elgg_get_plugin_setting('widget_insearch', 'elgg_cmis') == 'yes') {
		elgg_register_widget_type('elgg_cmis_insearch', elgg_echo('elgg_cmis:widget:cmis_insearch'), elgg_echo('elgg_cmis:widget:cmis_insearch:details'), array('dashboard'), true);
	}
	
	// CMIS page handler
	// @TODO use 1 PH - that's enough !
	elgg_register_page_handler('cmis', 'elgg_cmis_page_handler');
	elgg_register_page_handler('cmisembed', 'elgg_cmisembed_page_handler');
	
	
	// Actions
	$action_url = elgg_get_plugins_path() . 'elgg_cmis/actions/' . elgg_cmis_vendor() . '/';
	if (elgg_get_plugin_setting('backend', 'elgg_cmis') == 'yes') {
		// If Backend mode enabled, override default action
		elgg_unregister_action('file/upload');
		elgg_register_action("file/upload", $action_url . "file/upload.php");
	}
	
	
}


/** Returns selected library */
function elgg_cmis_vendor() {
	$vendors = array('php-cmis-client', 'chemistry-phpclient');
	$vendor = elgg_get_plugin_setting('vendor', 'elgg_cmis');
	// Note : Apache Chemistry is default library (for BC reasons)
	if (!in_array($vendor, $vendors)) { $vendor = 'chemistry-phpclient'; }
	return $vendor;
}

/** Register and load chosen library
 * @return : path base for page handler includes
 */
function elgg_cmis_libraries() {
	$vendor = elgg_cmis_vendor();
	
	if ($vendor == 'php-cmis-client') {
		elgg_register_library('elgg:elgg_cmis:vendor', elgg_get_plugins_path() . 'elgg_cmis/vendors/php-cmis-client/vendor/autoload.php');
		elgg_register_library('elgg:elgg_cmis', elgg_get_plugins_path() . 'elgg_cmis/lib/elgg_cmis_php-cmis-client.php');
		$base = elgg_get_plugins_path() . 'elgg_cmis/pages/elgg_cmis/php-cmis-client';
	} else {
		elgg_register_library('elgg:elgg_cmis:vendor', elgg_get_plugins_path() . 'elgg_cmis/vendors/chemistry-phpclient/lib/cmis_repository_wrapper.php');
		elgg_register_library('elgg:elgg_cmis', elgg_get_plugins_path() . 'elgg_cmis/lib/elgg_cmis_chemistry-phpclient.php');
		$base = elgg_get_plugins_path() . 'elgg_cmis/pages/elgg_cmis/chemistry-phpclient';
	}
	
	// Load selected libraries
	elgg_load_library('elgg:elgg_cmis:vendor');
	elgg_load_library('elgg:elgg_cmis');
	
	return $base;
}


// Page handler
function elgg_cmis_page_handler($page) {
	
	$base = elgg_cmis_libraries();
	
	switch($page[0]) {
		// Main CMIS repository (used with personal credentials)
		case 'repo':
			/* URL : repo/query/type/filter/value
			query : list, view
			type : folder, document, site
			filter : author, search, insearch, folder
			filter_value : filter value (author, etc.)
			*/
			if (isset($page[1])) { set_input('query', $page[1]); }
			if (isset($page[2])) { set_input('type', $page[2]); }
			if (isset($page[3])) { set_input('filter', $page[3]); }
			if (isset($page[4])) { set_input('filter_value', $page[4]); }
			if (include_once "$base/cmis_repo.php") { return true; }
			break;
		
		// This is for development
		// Site file repository backend
		case 'test':
			if (isset($page[1])) { set_input('query', $page[1]); }
			if (isset($page[2])) { set_input('type', $page[2]); }
			if (isset($page[3])) { set_input('filter', $page[3]); }
			if (isset($page[4])) { set_input('filter_value', $page[4]); }
			if (include_once "$base/cmis_global.php") { return true; }
			break;
		
		/*
		case 'atom':
			if (include_once "$base/cmis_atom.php") { return true; }
			break;
		*/
		
		case 'soap':
			if ($page[1] == 'embed') {
				if (include_once "$base/index_soap.php") { return true; }
			} else {
				if (include_once "$base/cmis_soap.php") { return true; }
			}
			break;
		
		case 'embed':
			if (include_once "$base/embed_soap.php") { return true; }
			break;
		
		// Provide an information / index page
		default:
			if (include_once "$base/index.php") { return true; }
	}
	return false;
}


// Page handler to provide embeddable frames
function elgg_cmisembed_page_handler($page) {
	$base = elgg_cmis_libraries();
	if (include_once "$base/embed_soap.php") { return true; }
	return false;
}


// Adds the required function for password encryption, in case the main plugin is not activated
/*
if (!elgg_is_active_plugin('esope') && !function_exists('esope_vernam_crypt')) {
	function esope_vernam_crypt($text, $key){
		$keyl = strlen($key);
		$textl = strlen($text);
		if ($keyl < $textl){
			$key = str_pad($key, $textl, $key, STR_PAD_RIGHT);
		} elseif ($keyl > $textl){
			$diff = $keyl - $textl;
			$key = substr($key, 0, -$diff);
		}
		return $text ^ $key;
	}
}
*/



