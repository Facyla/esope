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
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:disable_content');
	elgg_register_library('elgg:disable_content', elgg_get_plugins_path() . 'disable_content/lib/disable_content.php');
	
	// Register JS script - use with : elgg_load_js('disable_content');
	elgg_register_js('disable_content', '/mod/disable_content/vendors/disable_content.js', 'head');
	
	// Register CSS - use with : elgg_load_css('disable_content');
	elgg_register_simplecache_view('css/disable_content');
	$disable_content_css = elgg_get_simplecache_url('css', 'disable_content');
	elgg_register_css('disable_content', $disable_content_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'disable_content');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'disable_content');
	}
	*/
	
	// Register a page handler on "disable_content/"
	elgg_register_page_handler('disable_content', 'disable_content_page_handler');
	
	// group entity menu
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
 * Add links/info to entity menu particular to group entities
 */
function disable_content_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	
	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	// @TODO filter on objects
	if ($handler != 'groups') { return $return; }
	
	// feature link
	if (elgg_is_admin_logged_in()) {
		$url = elgg_get_site_url() . "disable_content?guid={$entity->guid}&enabled=no";
		$wording = elgg_echo('disable_content:archive');
		$options = array(
			'name' => 'disable_content',
			'text' => $wording,
			'href' => $url,
			'class' => 'elgg-button elgg-button-delete',
			'priority' => 800,
			'is_action' => true,
			'confirm' => elgg_echo('disable_content:confirm'),
		);
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}


// Return all disabled objects
function disable_content_get_disabled_groups($params = array()) {
	access_show_hidden_entities(true);
	$ia = elgg_set_ignore_access(true);
	$objects_params = array('types' => "object", 'wheres' => array("e.enabled = 'no'"));
	// Merge custom params (limit, etc.)
	if (is_array($params)) $objects_params = array_merge($params, $objects_params);
	
	$objects = elgg_get_entities($objects_params);
	
	elgg_set_ignore_access($ia);
	return $objects;
}


