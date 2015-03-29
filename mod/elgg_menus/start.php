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
	
	// @TODO hook sur prepare:menu avec poids 1000 pour pouvoir remplacer un menu système en dernier
	//elgg_register_plugin_hook_handler(); // 'prepare', "menu:$menu_name"
	
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
	$custom_menus = elgg_get_plugin_setting('menus', 'elgg_menus');
	$custom_menus = elgg_menus_get_custom_menus();
	// Set up menus
	foreach ($custom_menus as $menu_name) { elgg_menus_setup_menu($menu_name); }
	return true;
}

/* Récupère et prépare le menu
 * $menu_name : nom du menu à préparer
 */
function elgg_menus_setup_menu($menu_name) {
	// GET AND SET CUSTOM MENU CONFIGURATION
	$menu_config_data = elgg_get_plugin_setting("menu-$menu_name", 'elgg_menus');
	//$content .= "menu-$menu_name => $menu_config_data<br />";
	if ($menu_config_data) {
		$menu_config = unserialize($menu_config_data);
		
		// Nettoyage du menu précédent si demandé : replace (ou merge sinon)
		if ($menu_config['mode'] == 'replace') {
			// Clean previous menu
			global $CONFIG;
			$CONFIG->menus[$menu_name] = array();
			/*
			$menus = elgg_get_config('menus');
			$menus[$menu_name] = array();
			$menus = elgg_set_config('menus', $menus);
			*/
		}
		
		// Set up new menu : function also acccepts an array instead of an ElggMenuItem
		foreach ($menu_config['items'] as $item) { elgg_register_menu_item($menu_name, $item); }
		return true;
	}
	return false;
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

/* Menus personnalisés */
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



