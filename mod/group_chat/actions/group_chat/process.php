<?php

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

$function = get_input('function');
$state = get_input('state');
$message = htmlentities(strip_tags(get_input('message')), ENT_QUOTES | ENT_IGNORE, "UTF-8");
$chat_container_id = get_input('container');

// Check which container we are using : site / group / user(s)
if (strpos($chat_container_id, '-')) {
	// Let's assume we're using "users" chat with multiple users
	$chat_container_ids = explode($chat_container_id);
	$chat_container_type = 'user';
} else {
	$chat_container = get_entity($chat_container_id);
	if (elgg_instanceof($chat_container, 'site')) {
		$chat_container_type = 'site';
	} else if (elgg_instanceof($chat_container, 'group')) {
		$chat_container_type = 'group';
	} else if (elgg_instanceof($chat_container, 'object')) {
		// Per-entity chat is not handled yet, though it would be an easy one
		$chat_container_type = 'object';
	} else if (elgg_instanceof($chat_container, 'user')) {
		$chat_container_type = 'user';
	} else {
		// Other types are not handled
		echo json_encode(array('error' => "Invalid chat id"));
		exit;
	}
}

$log = array();

// Connect to database to retrieve dataroot
global $CONFIG;


// Create chat folders and file
// Check group chat directory. if not exist then create else use it
$dataroot = $CONFIG->dataroot;
if(!is_dir($dataroot.'group_chat')){
	mkdir($dataroot.'group_chat', 0777);
	chmod($dataroot.'group_chat', 0777);
}

// Ensure that folder name respects some rules (12345, or 12345-23456)
$chat_container_id = elgg_get_friendly_title($chat_container_id);
if(!is_dir($dataroot.'group_chat'.'/'.$chat_container_id)){
	mkdir($dataroot.'group_chat'.'/'.$chat_container_id, 0777);
	chmod($dataroot.'group_chat'.'/'.$chat_container_id, 0777);
}
$chatLogDir = $dataroot.'group_chat'.'/'.$chat_container_id.'/';
// Store log in 1 file per day
$dayWiseChatLog = date('mdY').'.txt';
$filePath = $chatLogDir.$dayWiseChatLog;


// Chat actions
switch($function) {
	case('getState'):
		if (file_exists($filePath)) { $lines = file($filePath); }
		$log['state'] = count($lines); 
		break;
		
	case('update'):
		if (file_exists($filePath)) { $lines = file($filePath); }
		$log['count_lines'] = $state.'_'.count($lines);
		$count =	count($lines);
		if ($state == $count) {
			$log['state'] = $state;
			$log['text'] = false;
		} else {
			$text= array();
			$log['state'] = $state + count($lines) - $state;
			foreach ($lines as $line_num => $line) {
				if ($line_num >= $state) {
					$text[] =	$line = str_replace("\n", "", $line);
				}
			}
			$log['text'] = $text; 
		}
		break;
		
	case('send'):
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		if (($message) != "\n") {
			// Process message
			// Parse URL
			// Note  we're not using "parse_urls" because we need target="_blank"
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
			}
		}
		break;
	
}
$log['dataroot'] = $dataroot;
echo json_encode($log);


