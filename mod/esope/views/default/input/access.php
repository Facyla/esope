<?php
/**
 * Elgg access level input
 * Displays a dropdown input field
 *
 * @uses $vars['value']					The current value, if any
 * @uses $vars['options_values'] Array of value => label pairs (overrides default)
 * @uses $vars['name']					 The name of the input field
 * @uses $vars['entity']				 Optional. The entity for this access control (uses access_id)
 * @uses $vars['class']					Additional CSS class
 *
 * @uses $vars['entity_type']            Optional. Type of the entity
 * @uses $vars['entity_subtype']         Optional. Subtype of the entity
 * @uses $vars['container_guid']         Optional. Container GUID of the entity
 * @usee $vars['entity_allows_comments'] Optional. (bool) whether the entity uses comments - used for UI display of access change warnings
 *
 */

// bail if set to a unusable value
if (isset($vars['options_values'])) {
	if (!is_array($vars['options_values']) || empty($vars['options_values'])) {
		return;
	}
}

// Esope : update access select options depending on context / settings
// Standard cases = read/write access + group visibility and membership
// vis = visibilité du groupe, membership = adhésion au groupe
$standard_cases = array('access_id', 'write_access_id', 'vis', 'membership');
// Do not modify cases = when access is used with very custom values that should not be too much tweaked...
// Group membership is not a standard access level - rather an access setting
$donotmodify_cases = array('membership');

// Do we have a real value ?
$no_current_value = false;
if (!isset($vars['value']) || ($vars['value'] == ACCESS_DEFAULT)) {
	$no_current_value = true;
}

$entity_allows_comments = elgg_extract('entity_allows_comments', $vars, true);
unset($vars['entity_allows_comments']);

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-access';

// this will be passed to plugin hooks ['access:collections:write', 'user'] and ['default', 'access']
$params = array();

$keys = array(
	'entity' => null,
	'entity_type' => null,
	'entity_subtype' => null,
	'container_guid' => null,
	'purpose' => 'read',
);
foreach ($keys as $key => $default_value) {
	$params[$key] = elgg_extract($key, $vars, $default_value);
	unset($vars[$key]);
}

/* @var ElggEntity $entity */
$entity = $params['entity'];

if ($entity) {
	$params['value'] = $entity->access_id;
	$params['entity_type'] = $entity->type;
	$params['entity_subtype'] = $entity->getSubtype();
	$params['container_guid'] = $entity->container_guid;

	if ($entity_allows_comments && ($entity->access_id != ACCESS_PUBLIC)) {
		$vars['data-comment-count'] = (int) $entity->countComments();
		$vars['data-original-value'] = $entity->access_id;
	}
}

$container = elgg_get_page_owner_entity();
if (!$params['container_guid'] && $container) {
	$params['container_guid'] = $container->guid;
}

/* Esope: this feature is unclear and even misleading to users due to translation strings
 * It doesn't default the value, nor limit the available access levels...
 */
$restricted_content_access = false;
// should we tell users that public/logged-in access levels will be ignored?
if (($container instanceof ElggGroup)
	&& $container->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY
	&& !elgg_in_context('group-edit')
	&& !($entity instanceof ElggGroup)) {
	$show_override_notice = true;
	$restricted_content_access = true;
} else {
	$show_override_notice = false;
}

/* Esope main access tweaks
 * - set some defaults in various contexts
 * - remove some unwanted access levels globally
 */

/* Supprime le niveau d'accès Public => Membres connectés
// @TODO if we do that, do it only under specific circumstances eg. walled garden,  group settings...
if (isset($vars['options_values'][2]) && in_array($vars['name'], $standard_cases)) { unset($vars['options_values'][2]); }
// Même en Walled Garden, on veut pouvoir autoriser quelques pages publiques
if (!isset($vars['options_values'][2]) && in_array($vars['name'], $standard_cases)) { $vars['options_values'][2] = elgg_echo('esope:access:public'); }

// Auto-update current public value to loggedin / MAJ auto accès Public => Membres
// @TODO auto-update is not something we want to do (use scripting instead if required)
//if (($vars['value'] == 2) && in_array($vars['name'], $standard_cases)) { $vars['value'] = 1; }
*/

// Esope : handle some group-specific cases
if (elgg_instanceof($container, 'group')) {
	// Useful vars for all group checks
	$group_acl = $container->group_acl;
	
	// Esope : default group content access value (if not set or default)
	// Content cases = read and write access
	$content_cases = array('access_id', 'write_access_id');
	if ($no_current_value) {
		if (in_array($vars['name'], $content_cases)) {
			// Define default group content access method
			if ($container->membership == 2) {
				$defaultaccess = elgg_get_plugin_setting('opengroups_defaultaccess', 'esope');
				if (empty($defaultaccess)) { $defaultaccess = 'groupvis'; }
			} else {
				$closedgroups_defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'esope');
				if (empty($defaultaccess)) { $defaultaccess = 'group'; }
			}
			// If access policy says group only, always default to group acl
			if ($restricted_content_access) {
				$defaultaccess = 'group';
			}
			// Now define default content access value
			switch($defaultaccess) {
				case 'group': $vars['value'] = $group_acl; break;
				case 'groupvis': $vars['value'] = $container->access_id; break;
				case 'members': $vars['value'] = 1; break;
				case 'public': $vars['value'] = 2; break;
				case 'default': /* Do not set (let original chack do it) $vars['value'] = get_default_access(); */ break;
				default: $vars['value'] = $group_acl;
			}
		}
	}
	
	// Subgroups : add all parents groups access ids
	if (elgg_is_active_plugin('au_subgroups')) {
		$group = $page_owner;
		$parent_level = 1;
		while($parent = AU\SubGroups\get_parent_group($group)) {
			$vars['options_values'][$parent->group_acl] = $parent->name . " ($parent_level)";
			$group = $parent;
			$parent_level++;
		}
	}
	
}

// don't call get_default_access() unless we need it
//if (!isset($vars['value']) || $vars['value'] == ACCESS_DEFAULT) {
if ($no_current_value) {
	if ($entity) {
		$vars['value'] = $entity->access_id;
	} else if (empty($vars['options_values']) || !is_array($vars['options_values'])) {
		$vars['value'] = get_default_access(null, $params);
	} else {
		$options_values_ids = array_keys($vars['options_values']);
		$vars['value'] = $options_values_ids[0];
	}
}

$params['value'] = $vars['value'];

// don't call get_write_access_array() unless we need it
if (!isset($vars['options_values'])) {
	$vars['options_values'] = get_write_access_array(0, 0, false, $params);
}

// Esope : suppression de certains niveaux d'accès / remove some unwanted access levels
// Permet de n'autoriser que certains niveaux aux membres et admins
// Note : has to be defined after write access array
if (!in_array($vars['name'], $donotmodify_cases)) {
	$remove_access_levels = false;
	// Admin and members settings
	if (!elgg_is_admin_logged_in()) {
		// Exclude member access levels
		$user_exclude_access = elgg_get_plugin_setting('user_exclude_access', 'esope');
		if (!empty($user_exclude_access)) { $remove_access_levels = explode(',', $user_exclude_access); }
	} else {
		// Exclude some admin access levels
		$admin_exclude_access = elgg_get_plugin_setting('admin_exclude_access', 'esope');
		if (!empty($admin_exclude_access)) { $remove_access_levels = explode(',', $admin_exclude_access); }
	}
	// If access policy says group only, let's at least default to group acl
	/* Note : this is done somewhere else, not sure where though (hook ?)
	if ($restricted_content_access) {
		// Remove unwanted access levels
		$remove_access_levels[] = '2';
		$remove_access_levels[] = '1';
		array_unique($remove_access_levels);
	}
	*/
	if (is_array($remove_access_levels)) {
		foreach ($remove_access_levels as $key) {
echo "$key => {$vars['options_values'][$key]}<br />";
			if (isset($vars['options_values'][$key])) { unset($vars['options_values'][$key]); }
		}
	}
}

if (!isset($vars['disabled'])) {
	$vars['disabled'] = false;
}

// if access is set to a value not present in the available options, add the option
if (!isset($vars['options_values'][$vars['value']])) {
	/*
	$acl = get_access_collection($vars['value']);
	$display = $acl ? $acl->name : elgg_echo('access:missing_name');
	$vars['options_values'][$vars['value']] = $display;
	*/
	// Esope : this is more clear, why assume it is always unknown ?
	$vars['options_values'][$vars['value']] = get_readable_access_level($vars['value']);
}


/* Esope : this has been moved on top
// should we tell users that public/logged-in access levels will be ignored?
if (($container instanceof ElggGroup)
	&& $container->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY
	&& !elgg_in_context('group-edit')
	&& !($entity instanceof ElggGroup)) {
	$show_override_notice = true;
} else {
	$show_override_notice = false;
}
*/

// Esope : never display an empty access select
if (!is_array($vars['options_values']) || sizeof($vars['options_values']) < 1) { return; }

if ($show_override_notice) {
	$vars['data-group-acl'] = $container->group_acl;
}
echo elgg_view('input/select', $vars);
if ($show_override_notice) {
	if (!$no_current_value && !in_array($vars['value'], array('0', $group_acl))) {
		echo elgg_format_element('p', ['class' => 'elgg-text-help'], elgg_echo('esope:access:overridenotice:existingvalue'));
	} else {
		echo elgg_format_element('p', ['class' => 'elgg-text-help'], elgg_echo('esope:access:overridenotice'));
	}
}
