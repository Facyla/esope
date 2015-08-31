<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */

// main profile page : replace widgets by static blocks
echo elgg_view('profile/wrapper');

echo '<div class="elgg-col-1of3 flexible-block" style="float:right;">';
echo '<div class="profile-static-block profile-transitions">';
echo '<h2>' . elgg_echo('theme_transitions:contributions') . '</h2>';
echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 6, 'owner_guid' => elgg_get_page_owner_guid(), 'list_type' => 'gallery', 'item_class' => 'transitions-item'));
echo '</div>';
echo '</div>';

elgg_push_context('widgets');
elgg_push_context('listing');

echo '<div class="elgg-col-2of3 flexible-block">';
echo '<div class="profile-static-block profile-collections">';
echo '<h2>' . elgg_echo('theme_transitions:collections') . '</h2>';
echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'collection', 'limit' => 3, 'owner_guid' => elgg_get_page_owner_guid(), 'list_class' => "elgg-list-collections"));
echo '</div>';
echo '</div>';

echo '<div class="elgg-col-2of3 flexible-block">';
echo '<div class="profile-static-block profile-comments">';
echo '<h2>' . elgg_echo('theme_transitions:comments') . '</h2>';
echo elgg_view('theme_transitions2/comments_block', array(
	'subtypes' => 'transitions',
	'owner_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
));
echo '</div>';
echo '</div>';

elgg_pop_context();
elgg_pop_context();

