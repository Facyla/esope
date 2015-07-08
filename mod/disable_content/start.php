<?php
/**
 * disable_content plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright FlorianDANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'disable_content_init');


/**
 * Init disable_content plugin.
 */
function disable_content_init() {
	
	elgg_extend_view('css', 'disable_content/css');
	
	
	// Register a page handler on "disable_content/"
	elgg_register_page_handler('disable_content', 'disable_content_page_handler');
	
	// object entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'disable_content_entity_menu_setup');
	
}



// Page handler
// Loads pages located in plugin_template/pages/plugin_template/
function disable_content_page_handler($page) {
	$base = elgg_get_plugins_path() . 'disable_content/pages/disable_content';
	switch ($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		default:
			include "$base/index.php";
	}
	return true;
}


/**
 * Add links/info to entity menu particular to object entities
 */
function disable_content_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	
	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	// @TODO filter on objects
	if (!elgg_instanceof($entity, 'object')) { return $return; }
	
	// feature link
	if (elgg_is_admin_logged_in()) {
		$url = elgg_get_site_url() . "disable_content?guid={$entity->guid}&enabled=no";
		$wording = elgg_echo('disable_content:disable');
		$options = array(
			'name' => 'disable_content',
			'text' => $wording,
			'href' => $url,
			'class' => 'elgg-button elgg-button-disable',
			'priority' => 800,
			'is_action' => true,
			'confirm' => elgg_echo('disable_content:confirm'),
		);
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}


// Return all disabled objects
function disable_content_get_disabled_objects($params = array()) {
	access_show_hidden_entities(true);
	$ia = elgg_set_ignore_access(true);
	$objects_params = array('types' => "object", 'wheres' => array("e.enabled = 'no'"));
	// Merge custom params (limit, etc.)
	if (is_array($params)) $objects_params = array_merge($params, $objects_params);
	
	$objects = elgg_get_entities($objects_params);
	
	elgg_set_ignore_access($ia);
	return $objects;
}


