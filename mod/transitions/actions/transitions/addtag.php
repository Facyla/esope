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


// edit or create a new entity
$guid = get_input('guid');
$tags = get_input('tags');

if ($guid) {
	$entity = get_entity($guid);
	if (!elgg_instanceof($entity, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
}

// Add new tag
if (!empty($tags)) {
	$new_tags = string_to_tag_array($tags);
	$tags = (array)$entity->tags_contributed;
	foreach($new_tags as $tag) { $tags[] = $tag; }
	$tags = array_filter($tags);
	$entity->tags_contributed = $tags;
}


forward($entity->getURL());

