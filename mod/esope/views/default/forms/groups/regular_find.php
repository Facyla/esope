<?php
/**
 * Group tag-based search form body
 */

$tag_string = elgg_echo('groups:regularsearch');

$params = array(
	'name' => 'q',
	'class' => 'elgg-input-search mbm',
	'value' => $tag_string,
	'onclick' => "if (this.value=='$tag_string') { this.value='' }",
);
echo '<label for="q">' . elgg_echo('groups:search:regular') . '</label>';
echo elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'group'));
echo elgg_view('input/hidden', array('name' => 'search_type', 'value' => 'entities'));
echo elgg_view('input/text', $params);

echo elgg_view('input/submit', array('value' => elgg_echo('search:group:go')));

