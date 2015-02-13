<?php
// Process chat requests : read, writes

// Add some security
gatekeeper();
$own = elgg_get_logged_in_user_entity();

// Determine automatically some input data
//$profilePic = get_input('profilePic');
$profilePic = $own->getIconURL('tiny');
if(!strstr($profilePic, 'defaulttiny.gif')) $profilePic .= '.jpg';
//$profileUrl = $CONFIG->url.'profile/'.$nickname;
$profileUrl = $own->getURL();
//$nickname = htmlentities(strip_tags(get_input('nickname')));
$nickname = $own->name;

$chat_id = get_input('container');
$function = get_input('function');
$state = get_input('state');
$message = htmlentities(strip_tags(get_input('message')), ENT_QUOTES | ENT_IGNORE, "UTF-8");


// Check which container we are using : site / group / user(s)
$chat_container_type = group_chat_container_type($chat_id);
if (!$chat_container_type) {
	// Other types are not handled
	echo json_encode(array('error' => "Invalid chat id"));
	exit;
}

// Perform some further tests for users
if ($chat_container_type == 'user') {
	// User chat should at least involve 2 users...
	if (!strpos($chat_id, '-') && ($chat_id != $own->guid)) {
		$chat_user_guids = array($chat_id, $own->guid);
		sort($chat_user_guids);
		$chat_id = implode('-', $chat_user_guids);
	}
	// Block unauthorized access to private chat
	$chat_user_guids = explode('-', $chat_id);
	if (!in_array($own->guid, $chat_user_guids)) { exit; }
}

// Order and normalize chat_id
// Ensure that folder name respects some rules (12345, or 12345-23456)
$chat_id = group_chat_normalise_chat_id($chat_id);


global $CONFIG;
$log = array();

// Trigger paths upgrade - Detect new structure and update paths (once) before doing anything else
if (!is_dir($groupchat_dataroot.'/site')) { group_chat_update_paths(); }

// Create chat folders and file
// Check group chat directory
$groupchat_dataroot = elgg_get_data_path() . 'group_chat';
if (!is_dir($groupchat_dataroot)) {
	mkdir($groupchat_dataroot, 0777);
	chmod($groupchat_dataroot, 0777);
}
// Now we can use new directory structure, using chat types
$groupchat_dataroot .= '/' . $chat_container_type;
// Create some structure for chat types
if (!is_dir($groupchat_dataroot)){
	mkdir($groupchat_dataroot, 0777);
	chmod($groupchat_dataroot, 0777);
}
// Create chat container directory
$groupchat_dataroot .= '/' . $chat_id;
if (!is_dir($groupchat_dataroot)){
	mkdir($groupchat_dataroot, 0777);
	chmod($groupchat_dataroot, 0777);
}
// Store log in 1 file per day
//$filePath = $groupchat_dataroot . '/' . date('mdY').'.txt'; // Old version
$filePath = $groupchat_dataroot . '/' . date('Ymd').'.txt';


// Chat actions
switch($function) {
	case('getState'):
		if (file_exists($filePath)) { $lines = file($filePath); }
		$log['state'] = count($lines); 
		break;
		
	case('update'):
		if (file_exists($filePath)) { $lines = file($filePath); }
		$log['count_lines'] = $state.'_'.count($lines);
		$count = count($lines);
		if ($state == $count) {
			$log['state'] = $state;
			$log['text'] = false;
		} else {
			$text= array();
			$log['state'] = $state + count($lines) - $state;
			foreach ($lines as $line_num => $line) {
				if ($line_num >= $state) {
					$text[] = $line = str_replace("\n", "", $line);
				}
			}
			$log['text'] = $text; 
		}
		// Update marker so we know we're up-to-date
		group_chat_update_marker($chat_id);
		break;
		
	case('send'):
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		if (($message) != "\n") {
			// Process message
			// Parse URL - Note  we're not using "parse_urls" because we need target="_blank"
			if(preg_match($reg_exUrl, $message, $url)) {
				$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			}
			// Replace smileys with images
			$message = group_chat_convert_smileys($message);
			// Remove newlines
			$messageStr = str_replace("\n", " ", $message);
			if (trim($messageStr) != '') {
				$message = '<li class="chatTxt" id="chat" onmouseover="chatCall(this);"><div class="chatTime">'
					//.date('h:i a')
					.date('H:i') // 24 hours format
					.'</div><div class="clear padTop5"><div style="float:left"><a href="'.$profileUrl.'" target="_blank"><img src="'.$profilePic.'" title="title" width="25" height="25" /></a></div><div class="floatLeft txtDiv"><a href="'.$profileUrl.'" target="_blank"><strong>'.htmlentities(ucfirst($nickname)).':</strong></a>&nbsp;<span style="color:#666666">'.$messageStr.'</span></div></div><div class="clear"></div></li>';
				fwrite(fopen($filePath, 'a'), $message. "\n");
				
				// Let recipients know there is a message unread for them
				if ($chat_container_type == 'site') {
					// Site vs user TS comparison
					$chat_container = get_entity($chat_id);
					$chat_container->group_chat_unread = time();
					// Update own user to avoid any notification
					$own->group_chat_unread_site = time();
					
				} else if ($chat_container_type == 'group') {
					$chat_container = get_entity($chat_id);
					$chat_container->group_chat_unread = time();
					// Add site-wide marker for quick checking of updates
					elgg_get_site_entity()->group_chat_unread_group = time();
					
				} else if ($chat_container_type == 'user') {
					// Personnal list of unread chat ids
					// Note : we need to allow any user to update some other users meta
					$ia = elgg_get_ignore_access();
					elgg_set_ignore_access(true);
					// Add unread mark to each user
					foreach($chat_user_guids as $guid) {
						// Skip own user
						if ($guid == $own->guid) continue;
						$recipient = get_entity($guid);
						if (elgg_instanceof($recipient, 'user')) {
							esope_add_to_meta_array($recipient, 'group_chat_unread_user', $chat_id);
						}
					}
					elgg_set_ignore_access($ia);
				}
				// Update own marker so we know we're up-to-date
				group_chat_update_marker($chat_id);
				
			}
		}
		break;
	
}
//$log['status'] = 1;
echo json_encode($log);


