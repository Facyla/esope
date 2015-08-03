<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */

// main profile page : replace widgets by static blocks
echo elgg_view('profile/wrapper');

elgg_push_context('widgets');
elgg_push_context('listing');

echo '<div class="flexible-block" style="width:33.3333%; float:right;">';
echo '<div class="profile-static-block">';
$transitions = elgg_list_entities(array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 5));
echo elgg_view_module('info',elgg_echo('theme_transitions:contributions'), $transitions, array());
echo '</div>';
echo '</div>';

echo '<div class="flexible-block" style="width:33.3333%;">';
echo '<div class="profile-static-block">';
$collections = elgg_list_entities(array('types' => 'object', 'subtypes' => 'collection', 'limit' => 3));
echo elgg_view_module('info','COLLECTIONS', $collections, array());
echo '</div>';
echo '</div>';

echo '<div class="elgg-col-1of3 flexible-block" style="width:33.3333%;">';
echo '<div class="profile-static-block">';
$comments = elgg_view('page/elements/comments_block', array(
	'subtypes' => 'transitions',
	'owner_guid' => elgg_get_page_owner_guid(),
	'limit' => 3,
));
echo elgg_view_module('info','COMMENTAIRES', $comments, array());
echo '</div>';
echo '</div>';

elgg_pop_context();
elgg_pop_context();

