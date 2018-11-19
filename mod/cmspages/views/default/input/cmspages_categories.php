<?php
/* CMSPages tree categories
 * Defined using basic tree syntax :
 *   Home
 *   -Sub-level 1
 *   --Sub-level 2
 *   -Sub-level 1
 *   Contact
 */

/**
 * Elgg checkbox input
 * Displays a checkbox input field
 *
 * @note This also includes a hidden input with the same name as the checkboxes
 * to make sure something is sent to the server.  The default value is 0.
 * If using JS, be specific to avoid selecting the hidden default value:
 * 	$('input[type=checkbox][name=name]')
 * 
 * @warning Passing integers as labels does not currently work due to a
 * deprecated hack that will be removed in Elgg 1.9. To use integer labels,
 * the labels must be character codes: 1 would be &#0049;
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses string $vars['name']     The name of the input fields
 *                                (Forced to an array by appending [])
 * @uses array  $vars['options']  An array of strings representing the
 *                                label => option for the each checkbox field
 * @uses string $vars['default']  The default value to send if nothing is checked.
 *                                Optional, defaults to 0. Set to FALSE for no default.
 * @uses bool   $vars['disabled'] Make all input elements disabled. Optional.
 * @uses string $vars['value']    The current value. Single value or array. Optional.
 * @uses string $vars['class']    Additional class of the list. Optional.
 * @uses string $vars['align']    'horizontal' or 'vertical' Default: 'vertical'
 *
 */

$defaults = array(
	'align' => 'vertical',
	'value' => array(),
	'default' => 0,
	'disabled' => false,
	'options' => array(),
	'name' => '',
);

$vars = array_merge($defaults, $vars);

$class = "elgg-input-checkboxes elgg-vertical";
if (isset($vars['class'])) {
	$class .= " {$vars['class']}";
	unset($vars['class']);
}

$id = '';
if (isset($vars['id'])) {
	$id = "id=\"{$vars['id']}\"";
	unset($vars['id']);
}
if (isset($vars['name']) && !isset($vars['id'])) {
	$vars['id'] = $vars['name'];
}

if (is_array($vars['value'])) {
	$values = array_map('elgg_strtolower', $vars['value']);
} else {
	$values = array(elgg_strtolower($vars['value']));
}

$input_vars = $vars;
$input_vars['default'] = false;
if ($vars['name']) {
	$input_vars['name'] = "{$vars['name']}[]";
}
unset($input_vars['align']);
unset($input_vars['options']);


// Get and process tree categories
$categories_opt = array();
$categories = elgg_get_plugin_setting('categories', 'cmspages');
$categories = esope_get_input_array($categories, "\n");
if (count($categories) > 0) {
	// include a default value so if nothing is checked 0 will be passed.
	if ($vars['name'] && $vars['default'] !== false) {
		echo "<input type=\"hidden\" name=\"{$vars['name']}\" value=\"{$vars['default']}\" />";
	}

	echo "<ul class=\"$class\" $id><li>";
	
	$parents = array(); // dernier parent pour chaque niveau de l'arborescence
	if ($categories) foreach ($categories as $key => $category) {
		// Niveau dans l'arborescence
		$level = 0;
		while($category[0] == '-') {
			$category = substr($category, 1);
			$level++;
		}
		// Correction auto des sous-niveaux utilisant trop de tirets (saut de 3 à 5 par ex.)
		// eg. level = 3 avec sizeof(parent) = 1 (soit niveau 0) => level corrigé à 1
		// Note : pour la première entrée, on aura toujours level == 0
		if ($level > sizeof($parents)) { $level = sizeof($parents); }
		
		// Gestion des nouvelles entrées et sous-niveaux, après la 1ère entrée
		if (sizeof($parents) > 0) {
			// Niveau identique => Passage à l'entrée suivante (sauf pour la 1ère entrée)
			if (($key > 0) && ($level == (sizeof($parents) - 1))) { echo '</li><li>'; }
			// Niveau supérieur : fermeture des sous-menus précédents ; par ex. passage de 2 à 0 : 2 sous-menus à fermer
			while((sizeof($parents) > 1) && ($level < (sizeof($parents) - 1))) {
				// Suppression du dernier sous-niveau
				array_pop($parents);
				// Fermeture du sous-menu
				echo '</li></ul>';
			}
			// Ouverture d'un nouveau sous-menu
			if ($level > (sizeof($parents) - 1)) { echo '<ul><li>'; }
		}
		// Dernier parent connu pour le niveau courant
		$parents[$level] = $category;
		
		$name = elgg_get_friendly_title($category);
		if (is_array($values)) {
			$input_vars['checked'] = in_array(elgg_strtolower($name), $values);
		}
		$input_vars['value']   = $name;
		
		$input = elgg_view('input/checkbox', $input_vars);
		
		echo "<label>$input$category</label>";
		
	}
	
	echo '</li></ul>';
}
