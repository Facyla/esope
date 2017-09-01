<?php
/**
 * Elgg tag input
 * Displays a tag input field
 *
 * @uses $vars['disabled']
 * @uses $vars['class']    Additional CSS class
 * @uses $vars['value']    Array of tags or a string
 * @uses $vars['entity']   Optional. Entity whose tags are being displayed (metadata ->tags)
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-tags';

// Esope : auto set id for easier label
if (isset($vars['name']) && !isset($vars['id'])) {
	$vars['id'] = $vars['name'];
}

if (!isset($vars['placeholder'])) { $vars['placeholder'] = elgg_echo('placeholder:tags'); }

$defaults = array(
	'value' => '',
	'disabled' => false,
	'autocapitalize' => 'off',
	'type' => 'text'
);

if (isset($vars['entity'])) {
	$defaults['value'] = $vars['entity']->tags;
	unset($vars['entity']);
}

$vars = array_merge($defaults, $vars);

if (is_array($vars['value'])) {
	$tags = array();

	foreach ($vars['value'] as $tag) {
		if (is_string($tag)) {
			$tags[] = $tag;
		} else {
			$tags[] = $tag->value;
		}
	}

	$vars['value'] = implode(", ", $tags);
}

echo elgg_format_element('input', $vars);
