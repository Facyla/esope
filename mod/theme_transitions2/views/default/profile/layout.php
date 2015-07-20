<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */

// main profile page : replace widgets by static blocks
echo elgg_view('profile/wrapper');

elgg_push_context('listing');

$transitions = elgg_list_entities(array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 3));
echo elgg_view_module('aside','CONTRIBUTIONS', $transitions, array('class' => "flexible-block", 'style' => "width:33.3333333%;"));

$comments = elgg_view('page/elements/comments_block', array(
	'subtypes' => 'transitions',
	'owner_guid' => elgg_get_page_owner_guid(),
	'limit' => 3,
));
echo elgg_view_module('aside','COMMENTAIRES', $comments, array('class' => "flexible-block", 'style' => "width:33.3333333%;"));


$collections = elgg_list_entities(array('types' => 'object', 'subtypes' => 'collection', 'limit' => 3));
echo elgg_view_module('aside','COLLECTIONS', $collections, array('class' => "flexible-block", 'style' => "width:33.3333333%;"));

elgg_pop_context();

