<?php
/**
 * Elgg URL input
 * Displays a URL input field
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['class'] Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "elgg-input-url {$vars['class']}";
} else {
	$vars['class'] = "elgg-input-url";
}

// Esope : auto set id for easier label
if (isset($vars['name']) && !isset($vars['id'])) {
  $vars['id'] = $vars['name'];
}

$defaults = array(
	'value' => '',
	'disabled' => false,
	'autocapitalize' => 'off',
	'autocorrect' => 'off',
);

$vars = array_merge($defaults, $vars);

?>

<input type="url" <?php echo elgg_format_attributes($vars); ?> />
