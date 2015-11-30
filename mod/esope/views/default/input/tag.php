<?php
/**
 * Elgg tag input
 *
 * Accepts a single tag value
 *
 * @uses $vars['value'] The default value for the tag
 * @uses $vars['class'] Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "elgg-input-tag {$vars['class']}";
} else {
	$vars['class'] = "elgg-input-tag";
}

// Esope : auto set id for easier label
if (isset($vars['name']) && !isset($vars['id'])) {
  $vars['id'] = $vars['name'];
}

$defaults = array(
	'value' => '',
	'disabled' => false,
	'autocapitalize' => 'off',
);

$vars = array_merge($defaults, $vars);
?>

<input type="text" <?php echo elgg_format_attributes($vars); ?> />
