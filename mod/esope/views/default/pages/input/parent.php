<?php
/**
 * Parent picker
 *
 * @uses $vars['value']          The current value, if any
 * @uses $vars['options_values']
 * @uses $vars['name']           The name of the input field
 * @uses $vars['entity']         Optional. The child entity (uses container_guid)
 */

elgg_load_library('elgg:pages');

if (empty($vars['entity'])) {
	$container = elgg_get_page_owner_entity();
} else {
	$container = $vars['entity']->getContainerEntity();
}

$pages = pages_get_navigation_tree($container);
$options = array();
// Note : we need to add an empty option to make it a top level page
$options['top'] = "----";

$depth_break = false;
foreach ($pages as $page) {
	// Important : pas de page sous-page d'elle-même ou d'une de ses pages filles !
	// Pour cela, l'arbre étant ordonné, on ne liste aucune des sous-page à partir de l'actuelle
	if ($page['guid'] == $vars['entity']->guid) {
		$depth_break = (int)$page['depth'];
		continue;
	}
	// Si depth équivalent ou inférieur à la valeur mémorisée on reprend la liste des options
	if ($depth_break !== false) {
		if ((int)$page['depth'] > $depth_break) { continue; } else { $depth_break = false; }
	}
	
	$spacing = "";
	for ($i = 0; $i < $page['depth']; $i++) {
		$spacing .= "--";
	}
	$options[$page['guid']] = "$spacing " . $page['title'];
}

$defaults = array(
	'class' => 'elgg-pages-input-parent-picker',
	'options_values' => $options,
);

$vars = array_merge($defaults, $vars);

echo elgg_view('input/select', $vars);
