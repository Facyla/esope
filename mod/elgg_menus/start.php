<?php
/**
 * elgg_menus plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'elgg_menus_init');


/**
 * Init elgg_menus plugin.
 */
function elgg_menus_init() {
	global $CONFIG; // All site useful vars
	
	
	elgg_extend_view('css', 'elgg_menus/css');
	elgg_extend_view('css/admin', 'elgg_menus/css');
	
	elgg_register_admin_menu_item('configure', 'menus', 'appearance');
	
	elgg_register_page_handler('elgg_menus', 'elgg_menus_page_handler');
	
	// register the JavaScript (autoloaded in 1.10)
	elgg_register_simplecache_view('js/elgg_menus/edit');
	$js = elgg_get_simplecache_url('js', 'elgg_menus/edit');
	elgg_register_js('elgg.elgg_menus.edit', $js);
	
	// Set up menus at last - so we can override
	elgg_register_event_handler('pagesetup','system','elgg_menus_pagesetup', 1000);
	
	/* Register menu hook : register,menu-menu_name
	// @TODO hook sur register:menu avec poids 1000 pour pouvoir ajouter et retirer items d'un menu construit en dernier
	//elgg_register_plugin_hook_handler(); // 'prepare', "menu:$menu_name"
	 */
	elgg_register_plugin_hook_handler('register', 'all', 'elgg_menus_register_menu_hook');
	
	/* Latest menu hook : prepare,menu-menu_name
	 * Note : hook a priori non nécessaire sauf si on veut vraiment être sûr que plus rien ne puisse être modifié par la suite
	 *  @TODO hook sur prepare:menu avec poids 1000 pour pouvoir remplacer un menu système en dernier
	 */
	//elgg_register_plugin_hook_handler('prepare', 'all', 'elgg_menus_prepare_menu_hook');
	
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . 'elgg_menus/actions/elgg_menus/';
	elgg_register_action("elgg_menus/edit", $actions_path . 'edit.php');
	
}


/* Page handler : used by callback preview calls */
function elgg_menus_page_handler($page) {
	if (!empty($page[0])) $page[0] = 'preview';
	set_input('menu', $page[1]);
	switch($page[0]) {
		case 'preview':
		default:
			if (include(elgg_get_plugins_path() . 'elgg_menus/pages/elgg_menus/preview.php')) return true;
	}
	return false;
}


/* Page setup : loads custom menus */
function elgg_menus_pagesetup() {
	// Get custom menus names
	$custom_menus = elgg_menus_get_custom_menus();
	// Set up menus
	foreach ($custom_menus as $menu_name) { elgg_menus_setup_menu($menu_name); }
	return true;
}


/* Add custom items to menu, and/or remove items */
function elgg_menus_register_menu_hook($hook, $type, $return, $params) {
	if (substr($type, 0, 5) != 'menu:') { return $return; }
	
	// Filter : 'menu-$menu_name'
	$menu_name = substr($type, 5);
	$menu_config = elgg_menus_get_menu_config($menu_name);
	global $CONFIG;
	
	switch($menu_config['mode']) {
		// Do not change menu
		case 'disabled':
			break;
		
		// No menu at all
		case 'clear':
			$return = array();
			break;
		
		// Nettoyage du menu précédent si demandé : replace (ou merge sinon)
		case 'replace':
			$CONFIG->menus[$menu_name] = array();
			elgg_menus_setup_menu($menu_name);
			/* Alternative menu creation method
			$return = array();
			foreach($menu_config['items'] as $menu_item) { $return[] = $item = \ElggMenuItem::factory($menu_item); }
			$CONFIG->menus[$menu_name] = $return;
			*/
			$return = $CONFIG->menus[$menu_name];
			break;
			
		// Set up new items and remove unnwanted ones
		case 'merge':
		default:
			// New items already added in pagesetup
			//elgg_menus_setup_menu($menu_name);
			// Remove unwanted menu items
			if (!empty($menu_config['remove'])) {
				foreach ($return as $k => $menu_item) {
					// error_log("$k => {$menu_item->getName()}"); // debug
					if (in_array($menu_item->getName(), $menu_config['remove'])) {
						unset($return[$k]);
					}
				}
			}
	}
	// Update menus
	$CONFIG->menus[$menu_name] = $return;
	return $return;
}


/* Replace menu with custom one at latest
 * Note : on ne devrait pas avoir besoin d'intervenir aussi en aval : 
 * hook register maxi, voire pagesetup devrait suffire
 */
/*
function elgg_menus_prepare_menu_hook($hook, $type, $return, $params) {
	if (substr($type, 0, 5) != 'menu:') { return $return; }
	
	// Filter : 'menu-$menu_name'
	$menu_name = substr($type, 5);
	$menu_config = elgg_menus_get_menu_config($menu_name);
	
	// Ne s'applique que pour le mode 'replace'
	if ($menu_config['mode'] != 'replace') { return $return; }
	//error_log("prepare MENU : $menu_name => OK ({$menu_config['mode']})");
	
	//$return = array(); // Clear current values
	// @TODO Setup new menu
	//elgg_menus_setup_menu($menu_name);
	//$menu = $CONFIG->menus[$menu_name];
	
	return $return;
}
*/


/* Récupère la configuration d'un menu
 * $menu_name : nom du menu
 * $key : élément de configuration
 * Return : array $config / $config[$key]
 */
function elgg_menus_get_menu_config($menu_name, $key = false) {
	$menu_config_data = elgg_get_plugin_setting("menu-$menu_name", 'elgg_menus');
	if (!$menu_config_data) { return false; }
	
	$menu_config = unserialize($menu_config_data);
	
	if ($key) { return $menu_config[$key]; }
	return $menu_config;
	
}

/* Récupère et prépare le menu : ajoute ou remplace ses éléments
 * $menu_name : nom du menu à préparer
 * $mode : force un mode particulier (utile notamment pour éditer un menu, ou lors de la prévisualisation)
 * Modes : merge = ajoute les items, replace = vide et remplace le menu pré-existant, disabled = menu personnalisé désactivé, clear = vide le menu pré-existant
 */
function elgg_menus_setup_menu($menu_name, $mode = false) {
	// GET AND SET CUSTOM MENU CONFIGURATION
	$menu_config = elgg_menus_get_menu_config($menu_name);
	if (!$menu_config) { return false; }
	
	// Force to replace when editing custom menu (otherwise we may lose changes)
	if ($mode) { $menu_config['mode'] = $mode; }
	
	global $CONFIG;
	switch($menu_config['mode']) {
		case 'disabled':
			return true;
			break;
		
		// No menu at all
		case 'clear':
			$CONFIG->menus[$menu_name] = array();
			return true;
			break;
		
		// Nettoyage du menu précédent si demandé : replace (ou merge sinon)
		case 'replace':
			$CONFIG->menus[$menu_name] = array();
		case 'merge':
		default:
			// Set up new menu items
			// function also acccepts an array instead of an ElggMenuItem
			foreach ($menu_config['items'] as $item) { elgg_register_menu_item($menu_name, $item); }
	}
	
	return true;
}


/* Menus prédéfinis ou définis par d'autres plugins
 * Note : que faire des menus type 'entity' qui sont très contextuels ? 
 *  => liste des menu_name à retirer
 *  => merge/replace
 *  => menu personnalisé
 */
function elgg_menus_get_system_menus() {
	$system_menus = array();
	// Registered menus at that time
	$menus = elgg_get_config('menus');
	// Site reserved menus : can add items, but replacing or removing items cannot be guaranteed
	if ($menus) foreach ($menus as $name => $menu_items) {
		if (!empty($name)) $system_menus[$name] = $name;
	}
	return $system_menus;
}

/* Menus personnalisés (nouveaux menus ou menus modifiés) */
function elgg_menus_get_custom_menus() {
	$custom_menus_data = elgg_get_plugin_setting('menus', 'elgg_menus');
	$custom_menus = explode(',', $custom_menus_data);
	return $custom_menus;
}


/* Sélecteur des menus disponibles
 * $menu_name : menu actuellement selectionné (si nouvelle entrée)
 */
function elgg_menus_menus_opts($menu_name = false) {
	// Registered menus at that time
	$system_menus = elgg_menus_get_system_menus();
	
	// Menus personnalisés
	$custom_menus = elgg_menus_get_custom_menus();

	// Option vide ssi aucun menu n'a encore été choisi...
	$menu_opts = array();
	if (empty($menu_name)) $menu_opts[''] = '';
	
	// Menus du système
	if ($system_menus) foreach ($system_menus as $name) {
		if (!empty($name)) $menu_opts[$name] = $name . ' &nbsp; (' . elgg_echo('elgg_menus:system') . ')';
	}
	
	// Liste des menus personnalisés
	if ($custom_menus) foreach ($custom_menus as $name) {
		if (!empty($name)) $menu_opts[$name] = $name . ' &nbsp; (' . elgg_echo('elgg_menus:custom') . ')';
	}
	
	// Nouveau menu en cours de définition
	if (!empty($menu_name) && !isset($menu_opts[$menu_name])) { $menu_opts[$menu_name] = elgg_echo('elgg_menus:new') . '&nbsp;: ' . $menu_name; }
	
	return $menu_opts;
}



