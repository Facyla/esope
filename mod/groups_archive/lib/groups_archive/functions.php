<?php
/**
 * groups_archive plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright FlorianDANIEL aka Facyla 2015-2021
 * @link https://facyla.fr/
 */


/**
 * Add links/info to entity menu particular to group entities
 */
function groups_archive_entity_menu_setup(\Elgg\Hook $hook) {
	if (elgg_in_context('widgets')) { return $return; }
	
	$return = $hook->getValue();
	$params = $hook->getParams();
	$entity = $hook->getEntityParam();
	
	// feature link
	if ($entity instanceof ElggEntity && $entity->getType() == 'group' && elgg_is_admin_logged_in()) {
		$url = elgg_get_site_url() . "groups-archive?guid={$entity->guid}&enabled=no";
		$text = elgg_echo('groups_archive:archive');
		$return->add(\ElggMenuItem::factory([
			'name' => 'groups-archive',
			'text' => $text,
			'href' => $url,
			'priority' => 900,
			'is_action' => true,
			'confirm' => elgg_echo('groups_archive:confirm'),
			'icon' => 'archive'
		]));
	}
	
	return $return;
}


// Return all disabled groups
function groups_archive_get_disabled_groups($params = []) {
	$groups_params = array('types' => "group", 'wheres' => ["e.enabled = 'no'"]);
	// Merge custom params (limit, etc.)
	if (is_array($params)) {
		$groups_params = array_merge($params, $groups_params);
	}
	
	$groups = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function () use ($groups_params) {
		return elgg_get_entities($groups_params);
	});
	
	return $groups;
}


// Return disabled group content
function groups_archive_get_groups_content($group, $params = []) {
	if (!$group instanceof ElggGroup) { return false; }
	
	$objects_params = array('types' => "object", 'container_guid' => $group->guid);
	// Merge custom params (limit, count, etc.)
	if (is_array($params)) {
		$objects_params = array_merge($params, $objects_params);
	}
	
	$objects = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function () use ($objects_params) {
		return elgg_get_entities($objects_params);
	});
	
	return $objects;
}


