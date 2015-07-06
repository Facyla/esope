<?php
/**
 * Slider
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

elgg_register_event_handler('init','system','collections_plugin_init');
elgg_register_event_handler('pagesetup','system','collections_pagesetup');

function collections_plugin_init() {
	
	// Note : CSS we will be output anyway directly into the view, so we can embed collectionss on other sites
	elgg_extend_view('css','collections/css');
	
	//elgg_extend_view('shortcodes/embed/extend', 'collections/extend_shortcodes_embed');
	
	
	// Register main page handler
	elgg_register_page_handler('collection', 'collections_page_handler');
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . 'collections/actions/collections/';
	elgg_register_action("collections/edit", $actions_path . 'edit.php');
	elgg_register_action("collections/delete", $actions_path . 'delete.php');
	
		// register the JavaScript (autoloaded in 1.10)
	elgg_register_simplecache_view('js/collections/edit');
	$js = elgg_get_simplecache_url('js', 'collections/edit');
	elgg_register_js('elgg.collections.edit', $js);
	
	// Register a URL handler for collectionss
	elgg_register_plugin_hook_handler('entity:url', 'object', 'collections_url');
	
}


/* Populates the ->getUrl() method for collections objects */
function collections_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'collection')) {
		return elgg_get_site_url() . 'collection/view/' . $entity->pagetype;
	}
}


/* Gets a collection by its name, allowing theming on different instances
 * In case several collectionss are found, only first match is displayed with an alert
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

/* Main tool page handler */
function collections_page_handler($page) {
	$include_path = elgg_get_plugins_path() . 'collections/pages/collections/';
	if (empty($page[0])) { $page[0] = 'index'; }
	switch ($page[0]) {
		case "view":
			// @TODO display collections in one_column layout, or iframe mode ?
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			if (include($include_path . 'view.php')) { return true; }
			break;
			
		case "add":
			if (!empty($page[1])) { set_input('container_guid', $page[1]); }
			// @TODO display collections in one_column layout, or iframe mode ?
			if (include($include_path . 'edit.php')) { return true; }
			break;
		
		case "edit":
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			// @TODO display collections in one_column layout, or iframe mode ?
			if (include($include_path . 'edit.php')) { return true; }
			break;
			
		case 'index':
		default:
			if (include($include_path . 'index.php')) { return true; }
	}
	return false;
}



// Foncitons à exécuter après le chargement de tous les plugins
function collections_pagesetup() {
	
	// Add collection shortcode for easier embedding of collectionss
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


