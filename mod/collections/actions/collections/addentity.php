<?php
/**
 * Save collections entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 *
 * @package Collections
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('collections-addentity');

// edit or create a new entity
$guid = get_input('guid');
$entity_guid = get_input('entity_guid');
$comment = get_input('comment');

if ($guid) {
	$entity = get_entity($guid);
	if (!elgg_instanceof($entity, 'object', 'collection')) {
		register_error(elgg_echo('collections:error:entity_not_found'));
		forward(get_input('forward', REFERER));
	}
}

// Add new contribution (any member, if allowed by author)
if (!elgg_is_logged_in() || ($entity->write_access_id <= 0)) {
	register_error('collections:addentity:notallowed');
	forward(get_input('forward', REFERER));
}

// Check if entity exists
if ($entity_guid) {
	$publication = get_entity($entity_guid);
	if (!elgg_instanceof($publication, 'object')) {
		register_error(elgg_echo('collections:error:entity_not_found'));
		forward(get_input('forward', REFERER));
	}
	
	$entities = (array)$entity->entities;
	$entities_comment = (array)$entity->entities_comment;
	// Dédoublonnage : ssi GUID déjà ajouté
	if (in_array($entity_guid, $entities)) {
		register_error(elgg_echo('collections:addentity:alreadyexists'));
		forward(get_input('forward', REFERER));
	}
	
	// Ajout de la publication
	$entities[] = $entity_guid;
	$entities_comment[] = $comment;
	$entity->entities = $entities;
	$entity->entities_comment = $entities_comment;
	
	system_message(elgg_echo('collections:addentity:success'));
	elgg_clear_sticky_form('collections-addentity');
} else {
	register_error(elgg_echo('collections:addentity:emptyentity'));
}

forward($entity->getURL());

