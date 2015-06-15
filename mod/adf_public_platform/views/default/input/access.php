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
 * @TODO : add options to add/remove other options ?
 */

// Exclude some access levels
$user_exclude_access = elgg_get_plugin_setting('user_exclude_access', 'adf_public_platform');
if (!empty($user_exclude_access)) $user_exclude_access = explode(',', $user_exclude_access);
$admin_exclude_access = elgg_get_plugin_setting('admin_exclude_access', 'adf_public_platform');
if (!empty($admin_exclude_access)) $admin_exclude_access = explode(',', $admin_exclude_access);


if (isset($vars['class'])) {
	$vars['class'] = "elgg-input-access {$vars['class']}";
} else {
	$vars['class'] = "elgg-input-access";
}

$defaults = array(
	'disabled' => false,
	'value' => get_default_access(),
	'options_values' => get_write_access_array(),
);

if (isset($vars['entity'])) {
	$defaults['value'] = $vars['entity']->access_id;
	unset($vars['entity']);
}

$vars = array_merge($defaults, $vars);


// Facyla : custom access lists depending on context / settings
$content_cases = array('access_id', 'write_access_id');
$standard_cases = array('access_id', 'write_access_id', 'vis'); // vis = visibilité des groupes
/*
// Supprime le niveau d'accès Public => Membres connectés
if (isset($vars['options_values'][2]) && in_array($vars['name'], $standard_cases)) { unset($vars['options_values'][2]); }
// Change tous les accès Public => Membres connectés
if (($vars['value'] == 2) && in_array($vars['name'], $standard_cases)) { $vars['value'] = 1; }
*/
// Même en Walled Garden, on veut pouvoir autoriser quelques pages publiques
if (!isset($vars['options_values'][2]) && in_array($vars['name'], $standard_cases)) { $vars['options_values'][2] = elgg_echo('adf_platform:access:public'); }

// Facyla : Content gains plugin-set default access to group - only when no value specified
if (!isset($vars['value']) || ($vars['value'] == '-1')) {
	$page_owner = elgg_get_page_owner_entity();
	if (elgg_instanceof($page_owner, 'group') && in_array($vars['name'], $content_cases)) {
		// Add parent group access id (all parent groups)
		$group = $page_owner;
		while($parent = au_subgroups_get_parent_group($group)) {
			$vars['options_values'][$parent->group_acl] = $group->name;
			$group = $parent;
		}
		
		
		// Default group access
		if ($page_owner->membership == 2) {
			$defaultaccess = elgg_get_plugin_setting('opengroups_defaultaccess', 'adf_public_platform');
			if (empty($defaultaccess)) $defaultaccess = 'groupvis';
		} else {
			$defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'adf_public_platform');
			if (empty($defaultaccess)) $defaultaccess = 'group';
		}
		switch($defaultaccess) {
			case 'group': $vars['value'] = $page_owner->group_acl; break;
			case 'groupvis': $vars['value'] = $page_owner->access_id; break;
			case 'members': $vars['value'] = 1; break;
			case 'public': $vars['value'] = 2; break;
			case 'default': $vars['value'] = get_default_access(); break;
			default: $vars['value'] = $page_owner->group_acl;
		}
	} else {
		$vars['value'] = get_default_access();
	}
}

// Liste d'exclusion des droits : permet de n'autoriser que certains niveaux aux membres, voire aux admins
foreach ($vars['options_values'] as $key => $val) {
	if (elgg_is_admin_logged_in()) {
		if (is_array($admin_exclude_access) && in_array($key, $admin_exclude_access)) unset($vars['options_values'][$key]);
	} else {
		if (is_array($user_exclude_access) && in_array($key, $user_exclude_access)) unset($vars['options_values'][$key]);
	}
}

if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/dropdown', $vars);
}

