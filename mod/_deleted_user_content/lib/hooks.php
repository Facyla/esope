<?php

namespace deleted_user_content;


/**
 * Called when the admin/user/delete action is called
 * Redirect to a from with content policy options prior to deletion
 * Note that all actions for reassignment if necessary will take place
 * late in the 'delete', 'user' event, so other events can still intervene
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function delete_user_action($hook, $type, $return, $params) {
	
	$content_policy = get_input('content_policy');
	
	$user = get_user(get_input('guid'));
	if (!$user) {
		return $return;
	}
	
	$members = get_input('members', array());
	if (!is_array($members)) {
		$members = array($members);
	}
	
	$reassign_user = get_user($members[0]);
	
	switch ($content_policy) {
		case 'delete':
			// make sure they didn't leave 'delete' checked by mistake while adding a reassignment user
			if ($reassign_user) {
				register_error(elgg_echo('duc:error:delete_and_reassign'));
				forward(REFERER);
			}
			// standard elgg delete
			return $return;
			break;
		case 'reassign':
			if (!$reassign_user || $reassign_user->guid == $user->guid) {
				// cannot reassign to the person they're deleting
				register_error(elgg_echo('duc:error:reassign_deleted_user'));
				forward(REFERER);
			}
			
			// move any files
			// @TODO - this may need to change for 1.9
			// ideally this would be in the 'delete', 'user' event
			// but files are already deleted by then
			// see https://github.com/Elgg/Elgg/issues/6953
			$filehandler = new \ElggFile();
			$filehandler->owner_guid = $user->guid;
			$filehandler->setFilename('test.jpg');
			$dirname1 = dirname($filehandler->getFilenameOnFilestore());
	
			$filehandler->owner_guid = $reassign_user->guid;
			$dirname2 = dirname($filehandler->getFilenameOnFilestore());
	
			recurse_copy($dirname1, $dirname2);
			return $return;
			break;
		default:
			if (get_input('content_policy_seen')) {
				register_error(elgg_echo('duc:error:select_policy'));
			}
			forward('admin/user/delete/content_policy?guid=' . get_input('guid'));
			break;
	}
}
