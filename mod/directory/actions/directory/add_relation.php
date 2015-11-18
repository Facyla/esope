<?php
/**
 * Save directory entity
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
elgg_make_sticky_form('directory-addrelation');

// Add new contribution (any member, if allowed by author)
if (!elgg_is_logged_in()) {
	register_error('directory:addrelation:notallowed');
	forward(get_input('forward', REFERER));
}

// Link 2 entities
$subject_guid = get_input('guid');
$subject = get_entity($subject_guid);
$object_guid = get_input('entity_guid');
$object = get_entity($object_guid);

// Current entity
if (elgg_instanceof($subject, 'object')) { $subject_subtype = $subject->getSubtype(); }
if (!in_array($subject_subtype, array('directory', 'person', 'organisation'))) {
	register_error(elgg_echo('directory:error:entity_not_found'));
	forward(get_input('forward', REFERER));
}

// Check if target entity exists
if (!elgg_instanceof($object, 'object')) {
	register_error(elgg_echo('directory:error:entity_not_found'));
	forward(get_input('forward', REFERER));
}

// Check that user can edit both subject and target
if (!$subject->canEdit() || !$object->canEdit()) {
	register_error(elgg_echo('directory:error:notallowed'));
	forward(get_input('forward', REFERER));
}

// Comportements selon les éléments à relier
switch($subject_subtype) {
	case 'person':
			if ($object->getSubtype() == 'organisation') {
				// Add relation : subject member_of object
				//add_entity_relationship($subject->guid, 'member_of', $object->guid);
				$subject->addRelationship($object->guid, 'member_of');
			}
		break;
	case 'organisation':
			if ($object->getSubtype() == 'person') {
				// Add relation : subject member_of object
				//add_entity_relationship($object->guid, 'member_of', $subject->guid);
				$object->addRelationship($subject->guid, 'member_of');
			}
		break;
	case 'directory':
	default:
		// Not useful for now
}

$entities = (array)$subject->entities;
$entities_comment = (array)$subject->entities_comment;
// Dédoublonnage : ssi GUID déjà ajouté
if (in_array($object_guid, $entities)) {
	register_error(elgg_echo('directory:addrelation:alreadyexists'));
	forward(get_input('forward', REFERER));
}
// Ajout de la publication

system_message(elgg_echo('directory:addrelation:success'));
elgg_clear_sticky_form('directory-addrelation');


forward($subject->getURL());

