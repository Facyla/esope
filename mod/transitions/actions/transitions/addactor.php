<?php
/**
 * Save transitions entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 *
 * @package Transitions
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('transitions');


// edit or create a new entity
$guid = get_input('guid');
$actor_guid = get_input('actor_guid');

if ($guid) {
	$entity = get_entity($guid);
	if (!elgg_instanceof($entity, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
}

// Check if actor exists
if ($actor_guid) {
	$actor = get_entity($actor_guid);
	if (!elgg_instanceof($actor, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:actor_not_found'));
		forward(get_input('forward', REFERER));
	}
	if ($actor->category != 'actor') {
		register_error(elgg_echo('transitions:error:not_an_actor'));
	}
}

// Add new relation
add_entity_relationship($actor->guid, 'partner_of', $entity->guid);


forward($entity->getURL());

