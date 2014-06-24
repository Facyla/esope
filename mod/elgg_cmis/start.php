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
	global $CONFIG;
	
	// CSS et JS
	elgg_extend_view('css/elgg', 'elgg_cmis/css');
	elgg_register_js('elgg_cmis:dialog', '/mod/elgg_cmis/vendors/cmis/soap/include/dialog.js', 'head');
	elgg_load_js('elgg_cmis:dialog');
	
	//elgg_load_js('lightbox');
	//elgg_load_css('lightbox');

	// Custom CMIS functions
	elgg_register_library('elgg:elgg_cmis', elgg_get_plugins_path() . 'elgg_cmis/lib/elgg_cmis.php');
	
	// CMIS widgets - add only if enabled
	if (elgg_get_plugin_setting('widget_mine', 'elgg_cmis') == 'yes') 
	elgg_register_widget_type('elgg_cmis_mine', elgg_echo('elgg_cmis:widget:cmis_mine'), elgg_echo('elgg_cmis:widget:cmis_mine:details'), 'dashboard', false);
	if (elgg_get_plugin_setting('widget_cmis', 'elgg_cmis') == 'yes') 
	elgg_register_widget_type('elgg_cmis', elgg_echo('elgg_cmis:widget:cmis'), elgg_echo('elgg_cmis:widget:cmis:details'), 'dashboard', true);
	if (elgg_get_plugin_setting('widget_folder', 'elgg_cmis') == 'yes') 
	elgg_register_widget_type('elgg_cmis_folder', elgg_echo('elgg_cmis:widget:cmis_folder'), elgg_echo('elgg_cmis:widget:cmis_folder:details'), 'dashboard', true);
	if (elgg_get_plugin_setting('widget_search', 'elgg_cmis') == 'yes') 
	elgg_register_widget_type('elgg_cmis_search', elgg_echo('elgg_cmis:widget:cmis_search'), elgg_echo('elgg_cmis:widget:cmis_search:details'), 'dashboard', true);
	if (elgg_get_plugin_setting('widget_insearch', 'elgg_cmis') == 'yes') 
	elgg_register_widget_type('elgg_cmis_insearch', elgg_echo('elgg_cmis:widget:cmis_insearch'), elgg_echo('elgg_cmis:widget:cmis_insearch:details'), 'dashboard', true);
	
	// CMIS page handler
	elgg_register_page_handler('cmis', 'elgg_cmis_page_handler');
	elgg_register_page_handler('cmisembed', 'elgg_cmisembed_page_handler');
	
}


function elgg_cmis_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_cmis/pages/elgg_cmis';
	switch($page[0]) {
		case 'repo':
			elgg_load_library('elgg:elgg_cmis');
			/* URL : repo/query/type/filter/value
			query : list, view
			type : folder, document, site
			filter : author, search, insearch, folder
			filter_value : filter value (author, etc.)
			*/
			if (isset($page[1])) set_input('query', $page[1]);
			if (isset($page[2])) set_input('type', $page[2]);
			if (isset($page[3])) set_input('filter', $page[3]);
			if (isset($page[4])) set_input('filter_value', $page[4]);
			if (!include_once "$base/cmis_repo.php") return false;
			break;
		/*
		case 'atom':
			if (!include_once "$base/cmis_atom.php") return false;
			break;
		*/
		case 'soap':
			if (!include_once "$base/cmis_soap.php") return false;
			break;
		default:
			if (!include_once "$base/index_soap.php") return false;
	}
	return true;
}



function elgg_cmisembed_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_cmis/pages/elgg_cmis';
	if (!include_once "$base/embed_soap.php") return false;
	return true;
}


// Adds the required function for password encryption, in case the main plugin is not activated
/*
if (!elgg_is_active_plugin('adf_public_platform') && !function_exists('esope_vernam_crypt')) {
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



