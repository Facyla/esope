<?php
/**
 * Elgg email input
 * Displays an email input field
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['class'] Additional CSS class
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-email';

// Esope : auto set id for better label
if (isset($vars['name']) && !isset($vars['id'])) {
	$vars['id'] = $vars['name'];
}

$defaults = array(
	'disabled' => false,
	'autocapitalize' => 'off',
	'autocorrect' => 'off',
	'type' => 'email'
);

$vars = array_merge($defaults, $vars);

echo elgg_format_element('input', $vars);
