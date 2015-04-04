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
	// elgg_register_plugin_hook('route', 'all', 'download_counter_route');
	
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

/* Filtrage via le page_handler
 * 
 * Principes de conception : 
 * - ne filtre que si on l'a explicitement demandé quelque part (pas de modification du comportement par défaut
 * 
*/
function download_counter_route($hook, $type, $return, $params) {
	/*
	global $CONFIG;
	$home = $CONFIG->url;
	
	// Page handler et segments de l'URL
	// Note : les segments commencent après le page_handler (ex.: URL: groups/all donne 0 => 'all')
	$handler = $return['handler'];
	$segments = $return['segments'];
	//echo print_r($segments, true); // debug
	//register_error($handler . ' => ' . print_r($segments, true));
	//error_log('DEBUG externalmembers ROUTE : ' . $handler . ' => ' . print_r($segments, true));
	
	if (!elgg_is_logged_in()) {
		// Il n'y a verrouillage du profil que si cette option est explicitement activée (pour ne pas modifier le comportement par défaut)
		$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');
		if ($public_profiles == 'yes') {
			if ($handler == 'profile') {
				$username = $segments[0];
				if ($user = get_user_by_username($username)) {
					esope_user_profile_gatekeeper($user);
				}
			}
		}
	}
	
	//	@todo : Pour tous les autres cas => déterminer le handler et ajuster le comportement
	//register_error("L'accès à ces pages n'est pas encore déterminé : " . $handler . ' / ' . print_r($segments, true));
	//error_log("L'accès à ces pages n'est pas encore déterminé : " . $handler . ' / ' . print_r($segments, true));
	
	/* Valeurs de retour :
	 * return false; // Interrompt la gestion des handlers
	 * return $params; // Laisse le fonctionnement habituel se poursuivre
	*/
	// Par défaut on ne fait rien du tout
	return $params;
	*/
}


