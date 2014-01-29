<?php
/**
 * group_chats
 *
 * @package group_chat
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 * 
 * @TODO :
 * - limit log entries
 * - limit server load
 * 
 */

elgg_register_event_handler('init', 'system', 'group_chat_init');

/**
 * Init group_chat plugin.
 */
function group_chat_init() {

	/*
	// entity menu
	//elgg_register_plugin_hook_handler('register', 'menu:page', 'chat_group_page_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'group_chat_owner_block_menu');
	
	elgg_register_entity_url_handler('group_chat', '', 'group_chat_url'); 
	
	elgg_register_page_handler('chat', 'group_chat_page_handler');
	*/
	
	// Extend the main css view
	elgg_extend_view('css/elgg', 'group_chat/css');
	
	// Page handler for group and site chat
	elgg_register_page_handler('chat', 'group_chat_page_handler');
	
	// Site chat
	$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
	if ($site_chat == 'yes') {
		elgg_extend_view('adf_platform/adf_header', 'group_chat/sitechat_extend', 1000);
	}
	
	// Group chat
	$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
	if ($group_chat == 'groupoption') {
		add_group_tool_option('group_chat', elgg_echo('group_chat:group_option'), false);
	}
	if (in_array($group_chat, array('yes', 'groupoption'))) {
		$pageowner = elgg_get_page_owner_entity();
		if (elgg_in_context('groups') || (elgg_instanceof($pageowner, 'group'))) {
			// Old version : integrated into window
			//elgg_extend_view('group/default', 'group_chat/chat_extend');
			// New version : own window
			elgg_extend_view('adf_platform/adf_header', 'group_chat/groupchat_extend', 1000);
		}
	}
	
	// Register action
	$action_base = elgg_get_plugins_path() . 'group_chat/actions/group_chat';
	elgg_register_action("group_chat/process","$action_base/process.php", 'public');
	//elgg_register_action("group_chat/discussion","$action_base/discussion.php", 'public');	
}


function get_chat_content(){
	$guid = elgg_get_page_owner_guid();
	$days = elgg_get_plugin_setting('group_chat_days', 'group_chat');
	global $CONFIG;
	$fileContent = '';
	$days = ($days)?$days:2;
	for ($i=$days; $i>=0; $i--) {
		$filename = date('mdY', strtotime('-'.$i.' Days')).'.txt';
		$filepath = $CONFIG->dataroot.'/group_chat/'.$guid.'/'.$filename;
		if (file_exists($filepath)) {
			$content = file_get_contents($filepath);
			if($content) {
				$ts = strtotime('-'.$i.' Days');
				if (empty($date_format)) $date_format = 'D, F d, Y';
				if ($CONFIG->language == 'en') {
					$date_format = 'D, F d, Y';
					$fileContent .= '<li class="dateD" >'.date($date_format, $ts).'<li>';
				} else {
					$fileContent .= '<li class="dateD" >';
					$fileContent .= elgg_echo('date:day:'.date('w', $ts)) . ' ' . date('j', $ts) . ' ' . elgg_echo('date:month:'.date('n', $ts)) . ' ' . date('Y', $ts);
					$fileContent .= '</li>';
				}
				$fileContent .= $content;
			}
		}
	}
	return $fileContent;
}


/* Site chat : not seriously implemented yet, but functional */
function group_chat_page_handler($page) {
	global $CONFIG;
	$base = elgg_get_plugins_path() . 'group_chat/pages/group_chat';
	if (!isset($page[0])) { $page[0] = 'site'; }
	
	switch ($page[0]) {
		case "group":
			if (isset($page[1])) { set_input('group_guid', $page[1]); }
			require_once "$base/group_chat.php";
			break;
			
		case "site":
		default:
			require_once "$base/site_chat.php";
	}
	
	return true;
}


