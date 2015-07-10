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
$link = get_input('url');
$relation = get_input('relation');

if ($guid) {
	$entity = get_entity($guid);
	if (!elgg_instanceof($entity, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
}

// Add new link
if (!empty($link)) {
	if ($relation == 'invalidates') {
		$links = (array)$entity->links_invalidates + (array)$link;
		$entity->links_invalidates = $links;
	} else {
		$links = (array)$entity->links_supports + (array)$link;
		$entity->links_supports = $links;
	}
}


forward($entity->getURL());

