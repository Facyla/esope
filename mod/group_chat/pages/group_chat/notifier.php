<?php
// Checks if there are new messages for a given user
// This should be as quick as we can, so add shortcuts to avoid unecessary checks
// file latest_site, latest_group, latest_user with latest timestamp

$site_notifiation = get_input('site');
$group_notifiation = get_input('group');
$user_notifiation = get_input('user');


global $CONFIG;
$log = array();

// Add some security
if (elgg_is_logged_in()) {
	// Check if user has a group_chat_unread mark for site, group and user
	$own = elgg_get_logged_in_user_entity();
	
	
	// Site notifications
	// Compare site stored timestamp with user ts
	$unread_site_chat = '';
	if ($site_notifiation == 'yes') {
		if ($CONFIG->site->group_chat_unread > $own->group_chat_unread_site) {
			$url = elgg_get_site_url() . "chat/site";
			$js_link = "window.open('$url', 'groupchat_site', 'menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500').focus(); return false;";
			$unread_site_link = '<a href="' . elgg_get_site_url() . 'chat/user' . $chat_id . '" onClick="' . $js_link . '">' . elgg_echo('groupchat:site:openlink') . '</a>';
			$unread_site_chat = '<p>' . elgg_echo('group_chat:notification:site', array($unread_site_link)) . '</p>';
		}
	}
	$log['notification']['site'] = $unread_site_chat;
	
	
	// Group notifications
	// We cannot get all groups all the time, so we need to make it quick and get deeper only if we have some details
	/* Compare latest group update with own group update time ? 
	 * if > then check which groups have been updated and update own metadata list ?
	 * otherwise (<=), just re-send the (up-to-date) list
	 */
	$unread_group_chat = '';
	if ($group_notifiation == 'yes') {
		// Check if there are any update to any group (avoids checking all groups every time)
		// Note : we are checking a few seconds after so we don't get messages we've just posted
		if (elgg_get_site_entity()->group_chat_unread_group > $own->group_chat_unread_group_ts) {
			// Check groups chat to update messages
			$own_groups = $own->getGroups('', 0);
			if ($own_groups) {
				foreach($own_groups as $group) {
					$unread_groups = array();
					// Compare group check to latest user check
					if ($group->group_chat_unread > $own->group_chat_unread_group_ts) {
						$unread_groups[] = $group->guid;
					}
					// Add new group notifications to the unread group chat list
				}
				esope_add_to_meta_array($own, 'group_chat_unread_group', $unread_groups);
			}
			// Now mark we have checked latest group chat messages (to latest message TS))
			$own->group_chat_unread_group_ts = elgg_get_site_entity()->group_chat_unread_group;
		}
		// Display messages if there is any
		if ($own->group_chat_unread_group) {
			$unread = $own->group_chat_unread_group;
			if (!is_array($unread)) $unread = array($unread);
			if ($unread) {
				foreach($unread as $chat_id) {
					$url = elgg_get_site_url() . "chat/group/" . $chat_id;
					$js_link = "window.open('$url', '$chat_id', 'menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500').focus(); return false;";
					$unread_group_link = '<a href="' . $url . '" onClick="' . $js_link . '">' . elgg_echo('groupchat:group:openlink', array($chat_id)) . '</a>';
					$unread_group_chat .= '<p>' . elgg_echo('group_chat:notification:group', array($chat_id, $unread_group_link)) . '</p>';
				}
			}
		}
	}
	$log['notification']['group'] = $unread_group_chat;
	
	
	// User notifications
	// Check list of unread user chats
	$unread_user_chat = '';
	if ($user_notifiation == 'yes') {
		if ($own->group_chat_unread_user) {
			$unread = $own->group_chat_unread_user;
			if (!empty($unread) && !is_array($unread)) $unread = array($unread);
			if ($unread) {
				foreach($unread as $chat_id) {
					$url = elgg_get_site_url() . "chat/user/" . $chat_id;
					$js_link = "window.open('$url', '$chat_id', 'menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500').focus(); return false;";
					$unread_user_link = '<a href="' . $url . '" onClick="' . $js_link . '">' . elgg_echo('groupchat:user:openlink', array($chat_id)) . '</a>';
					$unread_user_chat .= '<p>' . elgg_echo('group_chat:notification:user', array($chat_id, $unread_user_link)) . '</p>';
				}
			}
		}
	}
	$log['notification']['user'] = $unread_user_chat;
	
} else {
	$log['error'] = 'Not logged in.';
}

//error_log(print_r($log, true)); // debug & tests
echo json_encode($log);


