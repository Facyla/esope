<?php
/**
 * groups_archive plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright FlorianDANIEL aka Facyla 2015-2021
 * @link https://facyla.fr/
 */



// Page handler
// Loads pages located in plugin_template/pages/plugin_template/
function groups_archive_page_handler($page) {
	$base = elgg_get_plugins_path() . 'groups_archive/pages/groups_archive';
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
function groups_archive_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	
	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'groups') { return $return; }
	
	// feature link
	if (elgg_is_admin_logged_in()) {
		$url = elgg_get_site_url() . "groups-archive?guid={$entity->guid}&enabled=no";
		$wording = elgg_echo('groups_archive:archive');
		$options = array(
			'name' => 'groups-archive',
			'text' => $wording,
			'href' => $url,
			'link_class' => 'elgg-button elgg-button-delete',
			'priority' => 800,
			'is_action' => true,
			'confirm' => elgg_echo('groups_archive:confirm'),
		);
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}


// Return all disabled groups
function groups_archive_get_disabled_groups($params = array()) {
	access_show_hidden_entities(true);
	$ia = elgg_set_ignore_access(true);
	$groups_params = array('types' => "group", 'wheres' => array("e.enabled = 'no'"));
	// Merge custom params (limit, etc.)
	if (is_array($params)) $groups_params = array_merge($params, $groups_params);
	
	$groups = elgg_get_entities($groups_params);
	
	elgg_set_ignore_access($ia);
	return $groups;
}


// Return disabled group content
function groups_archive_get_groups_content($group, $params = array()) {
	access_show_hidden_entities(true);
	$ia = elgg_set_ignore_access(true);
	
	if (!elgg_instanceof($group, 'group')) return false;
	
	$objects_params = array('types' => "object", 'container_guid' => $group->guid);
	// Merge custom params (limit, count, etc.)
	if (is_array($params)) $objects_params = array_merge($params, $objects_params);
	
	$objects = elgg_get_entities($objects_params);
	
	elgg_set_ignore_access($ia);
	return $objects;
}


