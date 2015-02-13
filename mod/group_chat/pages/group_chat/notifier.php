<?php

// Add some security
gatekeeper();
$own = elgg_get_logged_in_user_entity();



global $CONFIG;
$log = array();

// Check if user has a group_chat_unread mark for site, group and user
// Site : compare site stored timestamp with user ts
if ($CONFIG->site->group_chat_unread > $own->group_chat_unread_site) {
	$log['notification']['site'] = elgg_echo('group_chat:notification:site');
} else $log['notification']['site'] = '';

// Group : compare unread group stored timestamp with user ts
// @TODO get own groups, then check for each group... ?? find smthg quick
/*
$own_groups = $own->getGroups('', 0);
foreach($own_groups as $group) {}
*/
if ($own->group_chat_unread_group) {
	$log['notification']['group'] = elgg_echo('group_chat:notification:group');
} else $log['notification']['group'] = '';

// User : check list of unread user chats
//error_log($own->guid . ': ' . print_r($own->group_chat_unread_user, true));
if ($own->group_chat_unread_user) {
	$unread_user_chat = '';
	$unread = $own->group_chat_unread_user;
	if (!empty($unread) && !is_array($unread)) $unread = array($unread);
	if ($unread) foreach($unread as $chat_id) {
		$url = elgg_get_site_url() . "chat/user/" . $chat_id;
		$js_link = "window.open('$url', '$chat_id', 'menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500').focus(); return false;";
		$unread_user_chat .= '<p><a href="' . elgg_get_site_url() . 'chat/user' . $chat_id . '" onClick="' . $js_link . '">' . elgg_echo('group_chat:notification:user', array($chat_id)) . '</a></p>';
	}
	$log['notification']['user'] = $unread_user_chat;
} else $log['notification']['user'] = '';


//error_log(print_r($log, true));
echo json_encode($log);


