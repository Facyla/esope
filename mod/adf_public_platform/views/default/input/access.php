<?php
/**
 * Elgg access level input
 * Displays a dropdown input field
 *
 * @uses $vars['value']          The current value, if any
 * @uses $vars['options_values'] Array of value => label pairs (overrides default)
 * @uses $vars['name']           The name of the input field
 * @uses $vars['entity']         Optional. The entity for this access control (uses access_id)
 * @uses $vars['class']          Additional CSS class
 */

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

// Facyla : no public access at all for the moment
$limit_cases = array('access_id', 'write_access_id', 'vis'); // vis = visibilité des groupes
if (isset($vars['options_values'][2]) && in_array($vars['name'], $limit_cases)) { unset($vars['options_values'][2]); }
if (($vars['value'] == 2) && in_array($vars['name'], $limit_cases)) { $vars['value'] = 1; } // Si Public => Membres connectés

// Facyla : Default access to group only when no other value than default specified
//if ($vars['value'] == ACCESS_DEFAULT) {
//if (!$vars['value'] || ($vars['value'] == ACCESS_DEFAULT)) { // Problème = modifie accès existants
if (!isset($vars['value']) || ($vars['value'] == '-1')) {
	//$vars['value'] = get_default_access();
  $page_owner = elgg_get_page_owner_entity();
  if ($page_owner instanceof ElggGroup) {
    $vars['value'] = $page_owner->group_acl;
  } else {
    $vars['value'] = get_default_access();
  }
}

if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/dropdown', $vars);
}
