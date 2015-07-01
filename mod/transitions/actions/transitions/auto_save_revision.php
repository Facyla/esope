<?php
/**
 * Action called by AJAX periodic auto saving when editing.
 *
 * @package Transitions
 */

$guid = get_input('guid');
$user = elgg_get_logged_in_user_entity();
$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');
$description = get_input('description');
$excerpt = get_input('excerpt');

// because get_input() doesn't use the default if the input is ''
if (empty($excerpt)) {
	$excerpt = $description;
}

// store errors to pass along
$error = FALSE;

if ($title && $description) {

	if ($guid) {
		$entity = get_entity($guid);
		if (elgg_instanceof($entity, 'object', 'transitions') && $entity->canEdit()) {
			$transitions = $entity;
		} else {
			$error = elgg_echo('transitions:error:post_not_found');
		}
	} else {
		$transitions = new ElggTransitions();
		$transitions->subtype = 'transitions';

		// force draft and private for autosaves.
		$transitions->status = 'unsaved_draft';
		$transitions->access_id = ACCESS_PRIVATE;
		$transitions->title = $title;
		$transitions->description = $description;
		$transitions->excerpt = elgg_get_excerpt($excerpt);

		// mark this as a brand new post so we can work out the
		// river / revision logic in the real save action.
		$transitions->new_post = TRUE;

		if (!$transitions->save()) {
			$error = elgg_echo('transitions:error:cannot_save');
		}
	}

	// creat draft annotation
	if (!$error) {
		// annotations don't have a "time_updated" so
		// we have to delete everything or the times are wrong.

		// don't save if nothing changed
		$auto_save_annotations = $transitions->getAnnotations(array(
			'annotation_name' => 'transitions_auto_save',
			'limit' => 1,
		));
		if ($auto_save_annotations) {
			$auto_save = $auto_save_annotations[0];
		} else {
			$auto_save = FALSE;
		}

		if (!$auto_save) {
			$annotation_id = $transitions->annotate('transitions_auto_save', $description);
		} elseif ($auto_save instanceof ElggAnnotation && $auto_save->value != $description) {
			$transitions->deleteAnnotations('transitions_auto_save');
			$annotation_id = $transitions->annotate('transitions_auto_save', $description);
		} elseif ($auto_save instanceof ElggAnnotation && $auto_save->value == $description) {
			// this isn't an error because we have an up to date annotation.
			$annotation_id = $auto_save->id;
		}

		if (!$annotation_id) {
			$error = elgg_echo('transitions:error:cannot_auto_save');
		}
	}
} else {
	$error = elgg_echo('transitions:error:missing:description');
}

if ($error) {
	$json = array('success' => FALSE, 'message' => $error);
	echo json_encode($json);
} else {
	$msg = elgg_echo('transitions:message:saved');
	$json = array('success' => TRUE, 'message' => $msg, 'guid' => $transitions->getGUID());
	echo json_encode($json);
}
exit;
