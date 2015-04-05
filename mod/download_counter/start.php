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
	elgg_register_plugin_hook_handler('route', 'all', 'download_counter_route');
	
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

/* Interception pour comptage des téléchargements
 * 
 * Principes de conception : 
 * - ne filtre que si on l'a explicitement demandé quelque part (pas de modification du comportement par défaut
 * 
 */
function download_counter_route($hook, $type, $return, $params) {
	$handler = $return['handler'];
	$segments = $return['segments'];
	// Note : les segments commencent après le page_handler (ex.: URL: groups/all donne 0 => 'all')
	//echo print_r($segments, true); // debug
	//error_log('DEBUG download_counter ROUTE : ' . $handler . ' => ' . print_r($segments, true));
	
	if (($handler == 'file') && ($segments[0] == 'download')) {
		$guid = $segments[1];
		//error_log("It's a file download !");
		$file = get_entity($guid);
		if (elgg_instanceof($file, 'object', 'file')) {
			if (isset($file->download_counter)) {
				$file->download_counter = $file->download_counter + 1;
			} else {
				$file->download_counter = 1;
			}
			//error_log(" => download count : " . $file->download_counter);
		}
	}
	
	
	/* Valeurs de retour :
	 * return false; // Interrompt la gestion des handlers
	 * return $params; // Laisse le fonctionnement habituel se poursuivre
	*/
	// Par défaut on ne fait rien du tout
	return $params;
}


