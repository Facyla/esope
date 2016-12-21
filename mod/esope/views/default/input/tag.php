<?php
/**
 * Elgg tag input
 *
 * Accepts a single tag value
 *
 * @uses $vars['value'] The default value for the tag
 * @uses $vars['class'] Additional CSS class
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-tag';

// Esope : auto set id for easier label
if (isset($vars['name']) && !isset($vars['id'])) {
  $vars['id'] = $vars['name'];
}

$defaults = array(
	'value' => '',
	'disabled' => false,
	'autocapitalize' => 'off',
	'type' => 'text'
);

$vars = array_merge($defaults, $vars);

echo elgg_format_element('input', $vars);
