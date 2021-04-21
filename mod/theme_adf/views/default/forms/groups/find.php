<?php
/**
 * Group tag-based search form body
 */

$tag = get_input('tag');

echo elgg_view_field([
	'#type' => 'text',
	'name' => 'tag',
	'required' => true,
	'class' => 'elgg-input-search',
	'placeholder' => elgg_echo('groups:search'),
	'value' => $tag,
]);

/* @TODO Filter by group type
echo elgg_view_field([
	'#type' => 'select',
	'name' => 'grouptype',
	'required' => true,
	'class' => 'elgg-input-search',
	'placeholder' => elgg_echo('groups:search:grouptype'),
	'value' => $grouptype,
]);
*/

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('search:go'),
]);

elgg_set_form_footer($footer);
