<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */

// main profile page : replace widgets by static blocks
echo elgg_view('profile/wrapper');

echo '<div class="flexible-block" style="width:33.3333333%;">CONTRIBUTIONS';
echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 5));
echo '</div>';

echo '<div class="flexible-block" style="width:33.3333333%;">COMMENTAIRES';
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'transitions',
		'owner_guid' => elgg_get_page_owner_guid(),
		'limit' => 5,
	));
echo '</div>';

echo '<div class="flexible-block" style="width:33.3333333%;">COLLECTIONS';
echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'collection', 'limit' => 5));
echo '</div>';

