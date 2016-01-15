<?php
/**
 * Market sidebar
 */

echo elgg_view_module('aside', elgg_echo('market:categories'), elgg_view('market/categories'));

echo elgg_view('page/elements/comments_block', array(
	'subtypes' => 'market',
	'owner_guid' => elgg_get_page_owner_guid(),
));

echo elgg_view('page/elements/tagcloud_block', array(
	'subtypes' => 'market',
	'owner_guid' => elgg_get_page_owner_guid(),
));

