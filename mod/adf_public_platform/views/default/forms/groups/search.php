<?php
/**
 * Group search form
 *
 * @uses $vars['entity'] ElggGroup
 */

$params = array(
	'name' => 'q',
	'class' => 'elgg-input-search mbm',
	'value' => $tag_string,
);
echo '<label for="q">' . elgg_echo('groups:search_in_group') . '</label>';
echo elgg_view('input/text', $params);

echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['entity']->getGUID(),
));

echo elgg_view('input/submit', array('value' => elgg_echo('search:go')));
