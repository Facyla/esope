<?php

namespace deleted_user_content;

function delete_user_event($event, $type, $user) {
	
	// if we can't edit it, we're not going to worry about the content
	// there's something else at play, and core will prevent the deletion
	if (!$user->canEdit()) {
		return true;
	}
	
	$content_policy = get_input('content_policy');
	if (!$content_policy) {
		// this delete is being called from something other than our standard admin action
		// leave as default behaviour
		return true;
	}
	
	switch ($content_policy) {
		case 'reassign':
			$members = get_input('members', array());
			if (!is_array($members)) {
				$members = array($members);
			}
			
			$reassign_user = get_user($members[0]);
			if (!$reassign_user || $reassign_user->guid == $user->guid) {
				// not sure how this could happen but if it does fall back to default behavior
				return true;
			}
			
			reassign_content($user, $reassign_user);
			break;
		case 'delete':
		default:
			// nothing to do here, default behavior
			break;
	}
	
	return true;
}
