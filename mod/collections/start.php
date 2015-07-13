<?php
/**
 * Collections
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

/* Modes de fonctionnement :
 * Edition comme un slider : on crée la collection et on y ajoute des éléments
 * Edition "en situation" : menu sur les publications, avec choix (select) des collections existantes, ou lien pour créer une nouvelle collection
 */


elgg_register_event_handler('init','system','collections_plugin_init');
elgg_register_event_handler('pagesetup','system','collections_pagesetup');

function collections_plugin_init() {
	
	// Note : CSS we will be output anyway directly into the view, so we can embed collections on other sites
	elgg_extend_view('css','collections/css');
	
	//elgg_extend_view('shortcodes/embed/extend', 'collections/extend_shortcodes_embed');
	
	
	// Register main page handler
	elgg_register_page_handler('collection', 'collections_page_handler');
	
	// Register a URL handler for collections
	elgg_register_plugin_hook_handler('entity:url', 'object', 'collections_url');
	
	// ENTITY MENU (add to collection)
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'collections_entity_menu_setup', 600);
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . 'collections/actions/collections/';
	elgg_register_action("collections/edit", $actions_path . 'edit.php');
	elgg_register_action("collections/delete", $actions_path . 'delete.php');
	
		// register the JavaScript (autoloaded in 1.10)
	elgg_register_simplecache_view('js/collections/edit');
	$js = elgg_get_simplecache_url('js', 'collections/edit');
	elgg_register_js('elgg.collections.edit', $js);
	
	elgg_register_simplecache_view("js/collections/embed");
	$js = elgg_get_simplecache_url('js', 'collections/embed');
	elgg_register_js('elgg.collections.embed', $js);
	
}


/* Main tool page handler */
function collections_page_handler($page) {
	$include_path = elgg_get_plugins_path() . 'collections/pages/collections/';
	if (empty($page[0])) { $page[0] = 'index'; }
	switch ($page[0]) {
		case "view":
			// @TODO display collections in one_column layout, or iframe mode ?
			set_input("guid", elgg_extract("1", $page));
			if (include($include_path . 'view.php')) { return true; }
			break;
			
		case "add":
			set_input("container_guid", elgg_extract("1", $page));
			set_input("add_guid", elgg_extract("2", $page)); // Direct content add (to new collection)
			// @TODO display collections in one_column layout, or iframe mode ?
			if (include($include_path . 'edit.php')) { return true; }
			break;
		
		case "edit":
			set_input("guid", elgg_extract("1", $page));
			set_input("add_guid", elgg_extract("2", $page)); // Direct content add (to existing collection)
			// @TODO display collections in one_column layout, or iframe mode ?
			if (include($include_path . 'edit.php')) { return true; }
			break;
			
		case "embed":
			set_input("guid", elgg_extract("1", $page));
			if (include($include_path . 'embed.php')) { return true; }
			break;
			
		case 'index':
		default:
			if (include($include_path . 'index.php')) { return true; }
	}
	return false;
}


/* Populates the ->getUrl() method for collections objects */
function collections_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'collection')) {
		return elgg_get_site_url() . 'collection/view/' . $entity->pagetype;
	}
}


// Bouton de publication dans les blogs - Add externalblogs to entity menu at end of the menu
function collections_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	$entity = $params['entity'];
	//if (elgg_instanceof($entity, 'object', 'collection')) {
	if (elgg_instanceof($entity, 'object')) {
		$options = array('name' => 'collections', 'href' => false, 'priority' => 900, 'text' => elgg_view('collections/button', array('entity' => $entity)));
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}


/* Gets a collection by its name, allowing theming on different instances
 * In case several collections are found, only first match is displayed with an alert
 */
function collections_get_entity_by_name($name = '') {
	if (!empty($name)) {
		$collections = elgg_get_entities_from_metadata(array(
				'types' => 'object', 'subtypes' => 'collection', 
				'metadata_name_value_pairs' => array('name' => 'name', 'value' => $name), 
			));
		if ($collections) {
			if (count($collections) == 1) {
				return $collections[0];
			} else {
				register_error(elgg_echo('collections:error:multiple'));
			}
		}
	}
	return false;
}

/* Checks if a given name is already used by a collection */
function collections_exists($name = '') {
	$ia = elgg_set_ignore_access(true);
	if (!empty($name)) {
		$collections = collections_get_entity_by_name($name);
		if (elgg_instanceof($collections, 'object', 'collection')) {
			elgg_set_ignore_access($ia);
			return true;
		}
	}
	elgg_set_ignore_access($ia);
	return false;
}



// Fonctions à exécuter après le chargement de tous les plugins
function collections_pagesetup() {
	
	// Add collection shortcode for easier embedding of collections
	if (elgg_is_active_plugin('shortcodes')) {
		elgg_load_library('elgg:shortcode');
		/**
		 * Collection shortcode
		 * [collection id="GUID"]
		 */
		function collections_shortcode_function($atts, $content='') {
			extract(elgg_shortcode_atts(array(
					'width' => '100%',
					'height' => '300px',
					'id' => '',
				), $atts));
			if (!empty($id)) {
				$collection = get_entity($id);
				if (elgg_instanceof($collection, 'object', 'collection')) {
					$content = elgg_view('collection/view', array('entity' => $collection));
				}
			}
			return $content;
		}
		elgg_add_shortcode('collection', 'collections_shortcode_function');
	}
	
}


