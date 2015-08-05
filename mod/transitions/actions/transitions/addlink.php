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
$link = string_to_tag_array($link);
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
		$links = (array)$entity->links_invalidates;
		foreach($link as $url) {
			if (in_array($url, $links)) { register_error(elgg_echo('transitions:addlink:alreadyexists')); }
			$links[] = $url;
		}
		$links = array_unique($links);
		$links = array_filter($links);
		$entity->links_invalidates = $links;
	} else {
		$links = (array)$entity->links_supports;
		foreach($link as $url) {
			if (in_array($url, $links)) { register_error(elgg_echo('transitions:addlink:alreadyexists')); }
			$links[] = $url;
		}
		$links = array_unique($links);
		$links = array_filter($links);
		$entity->links_supports = $links;
	}
	system_messages(elgg_echo('transitions:addlink:success'));
} else {
	register_error(elgg_echo('transitions:addlink:emptylink'));
}


forward($entity->getURL());

