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
$relation = get_input('relation', 'related_content');
$entity_guid = get_input('entity_guid');

if ($guid) {
	$entity = get_entity($guid);
	if (!elgg_instanceof($entity, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
}

// Check if linked entity exists
if ($entity_guid) {
	$linked_entity = get_entity($entity_guid);
	if (!elgg_instanceof($linked_entity, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
	// Add new relation
	if (add_entity_relationship($linked_entity->guid, $relation, $entity->guid)) {
		system_messages(elgg_echo('transitions:addrelation:success'));
	} else {
		register_error(elgg_echo('transitions:addrelation:error'));
	}
} else {
	register_error(elgg_echo('transitions:addrelation:emptyactor'));
}


forward($entity->getURL());

