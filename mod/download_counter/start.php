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
	
	// @TODO : extend entity view so we can use regular listing functions
	// ..but display only in certain context (file, et selon si admin ou pas..)
	// ENTITY MENU (select/unselect)
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'download_counter_entity_menu_setup', 600);
	
	// Plugin hook on page handler, as there is not necessarly an action, but we know download has to pass through this...
	// Route => return not false pour poursuivre : $request = array('handler' => $handler, 'segments' => $page);
	elgg_register_plugin_hook_handler('route', 'all', 'download_counter_route');
	
	// Register a page handler on "download_counter/"
	elgg_register_page_handler('download_counter', 'download_counter_page_handler');
	
}


// Page handler
function download_counter_page_handler($page) {
	if (!isset($page[0])) { $page[0] = 'admin'; }
	$url = elgg_get_plugins_path() . 'download_counter/pages/download_counter/';
	switch($page[0]) {
		case 'admin':
		default:
			if (include_once($url . 'downloads.php')) return true;
	}
	return false;
}


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




// Bouton de publication dans les blogs - Add externalblogs to entity menu at end of the menu
function download_counter_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'file')) {
		$display_counter = elgg_get_plugin_setting('display_counter', 'download_counter');
		if (($display_counter == 'yes') || elgg_is_admin_logged_in()) {
			// Display only if count > 0
			if (isset($entity->download_counter)) {
				if ($entity->download_counter > 1) {
					$text = elgg_echo('download_counter:count', array($entity->download_counter));
					$options = array('name' => 'download_counter', 'href' => false, 'priority' => 900, 'text' => $text);
					$return[] = ElggMenuItem::factory($options);
				} else {
					$text = elgg_echo('download_counter:count:singular', array($entity->download_counter));
					$options = array('name' => 'download_counter', 'href' => false, 'priority' => 900, 'text' => $text);
					$return[] = ElggMenuItem::factory($options);
				}
			}
		}
	}
	return $return;
}



