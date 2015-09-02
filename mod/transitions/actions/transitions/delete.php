<?php
/**
 * Delete transitions entity
 *
 * @package Blog
 */

$transitions_guid = get_input('guid');
$transitions = get_entity($transitions_guid);

elgg_load_library('elgg:transitions');	$container = get_entity($transitions->container_guid);

if (elgg_instanceof($transitions, 'object', 'transitions') && $transitions->canEdit()) {
	
	// remove icon
	transitions_remove_icon($transitions);
	
	if ($transitions->delete()) {
		system_message(elgg_echo('transitions:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("catalogue/group/$container->guid/all");
		} else {
			forward("catalogue/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('transitions:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('transitions:error:post_not_found'));
}

forward(REFERER);
