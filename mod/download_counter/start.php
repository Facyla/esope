<?php
/**
 * download_counter plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'download_counter_init');


/**
 * Init download_counter plugin.
 */
function download_counter_init() {
	global $CONFIG; // All site useful vars
	
	elgg_extend_view('css', 'download_counter/css');
	
	// @TODO plugin hook on page handler, as there is not necessarly an action...
	// Route => return not false pour poursuivre : $request = array('handler' => $handler, 'segments' => $page);
	// elgg_register_plugin_hook('route')
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'download_counter');
	
	
	// Register a page handler on "download_counter/"
	//elgg_register_page_handler('download_counter', 'download_counter_page_handler');
	
	
}


// Other useful functions
// prefixed by plugin_name_
/*
function download_counter_function() {
	
}
*/



