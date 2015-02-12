<?php
/**
 * group_chats
 *
 * @package group_chat
 *
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
	
	// Page handler for group, site and user chat
	elgg_register_page_handler('chat', 'group_chat_page_handler');
	
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
	
	// Site chat
	$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
	if ($site_chat == 'yes') {
		elgg_extend_view('adf_platform/adf_header', 'group_chat/sitechat_extend', 1000);
	}
	
	// User chat
	$user_chat = elgg_get_plugin_setting('user_chat', 'group_chat');
	if ($user_chat == 'yes') {
		elgg_extend_view('adf_platform/adf_header', 'group_chat/userchat_extend', 1000);
	}
	
	// Chat notifications
	$notifications = elgg_get_plugin_setting('notifications', 'group_chat');
	elgg_extend_view('adf_platform/adf_header', 'group_chat/js_extend', 1000);
	
	
	// Register action
	$action_base = elgg_get_plugins_path() . 'group_chat/actions/group_chat';
	elgg_register_action("group_chat/process","$action_base/process.php", 'public');
	//elgg_register_action("group_chat/discussion","$action_base/discussion.php", 'public');
	
	
	// Modification du menu des membres
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'group_chat_user_hover_menu');
	
}


// Return chat content, using the defined timeframe
function get_chat_content($guid = false, $days = false){
	if (!$guid) $guid = elgg_get_page_owner_guid();
	if (!$days) $days = elgg_get_plugin_setting('group_chat_days', 'group_chat');
	global $CONFIG;
	$fileContent = '';
	$days = ($days)?$days:2;
	// Get history for wanted days
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


/* Chat page handler */
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


// Menu that appears on hovering over a user profile icon
function group_chat_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	
	// Allow Add menu for logged in users only, and not on self profile
	$ownguid = $elgg_get_logged_in_user_guid();
	if (elgg_is_logged_in() && ($user->guid != $ownguid)) {
		$url = "group_chat/user/" . $ownguid . '-' . $user->getGUID();
		$title = elgg_echo("group_chat:user_chat:open");
		$item = new ElggMenuItem('group_chat_user', $title, $url);
		//$item->setSection('admin');
		$return[] = $item;
	}
	return $return;
}


// Convert text smileys to images
function group_chat_convert_smileys($message = '') {
	// Define smiley array
	$smiley_url = elgg_get_site_url() . 'mod/group_chat/graphics/smiley/';
	$smiley = array(':)' => '<img src="'.$smiley_url.'smile.gif">',
			':(' => '<img src="'.$smiley_url.'frown.gif">',
			':0' => '<img src="'.$smiley_url.'gasp.gif">',
			'O:-)' => '<img src="'.$smiley_url.'angel.gif">',
			':3' => '<img src="'.$smiley_url.'colonthree.gif">',

			'o.O' => '<img src="'.$smiley_url.'confused.gif">',
			":'(" => '<img src="'.$smiley_url.'cry.gif">',
			'3:-)' => '<img src="'.$smiley_url.'devil.gif">',
			':o' => '<img src="'.$smiley_url.'gasp.gif">',
			'B-)' => '<img src="'.$smiley_url.'glasses.gif">',

			':D' => '<img src="'.$smiley_url.'grin.gif">',
			'-.-' => '<img src="'.$smiley_url.'grumpy.gif">',
			'^_^' => '<img src="'.$smiley_url.'kiki.gif">',
			':-*' => '<img src="'.$smiley_url.'kiss.gif">',
			':v' => '<img src="'.$smiley_url.'pacman.gif">',

			'-_-' => '<img src="'.$smiley_url.'squint.gif">',
			'8|' => '<img src="'.$smiley_url.'sunglasses.gif">',
			':p' => '<img src="'.$smiley_url.'tongue.gif">',
			':-/' => '<img src="'.$smiley_url.'unsure.gif">',
			'-_-' => '<img src="'.$smiley_url.'upset.gif">',

			'heart' => '<img src="'.$smiley_url.'heart.gif">',
			'HEART' => '<img src="'.$smiley_url.'heart.gif">',
			'LOVE' => '<img src="'.$smiley_url.'heart.gif">',
			'love' => '<img src="'.$smiley_url.'heart.gif">',
			'X)' => '<img src="'.$smiley_url.'devil.gif">',
		);
	
	foreach($smiley as $key => $value){
		$message = str_replace($key, $value, $message);
	}
	
	return $message;
}

// Displays smileys list to be used in chat window
function group_chat_smileys_list() {
	$content = '';
	$smiley_url = elgg_get_site_url() . 'mod/group_chat/graphics/smiley/';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'smile.gif" data-value=":)" class="smileyCon" title="Smile"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'frown.gif" data-value=":(" class="smileyCon" title="Frown"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'gasp.gif" data-value=":0" class="smileyCon" title="Gasp"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'angel.gif" data-value="O:-)" class="smileyCon" title="Angel"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'colonthree.gif" data-value=":3" class="smileyCon" title="Colon Three"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'confused.gif" data-value="o.O" class="smileyCon" title="Confused"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'cry.gif" data-value=":\'(" class="smileyCon" title="Cry"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'devil.gif" data-value="3:-)" class="smileyCon" title="Devil"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'gasp.gif" data-value=":o" class="smileyCon" title="Gasp"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'glasses.gif" data-value="B-)" class="smileyCon" title="Glasses"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'grin.gif" data-value=":D" class="smileyCon" title="Grin"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'grumpy.gif" data-value="-.-" class="smileyCon" title="Grumpy"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'kiki.gif" data-value="^_^" class="smileyCon" title="Kiki"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'kiss.gif" data-value=":-*" class="smileyCon" title="Kiss" /></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'pacman.gif" data-value=":v" class="smileyCon" title="Pacman"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'squint.gif" data-value="-_-" class="smileyCon" title="Squint"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'sunglasses.gif" data-value="8|" class="smileyCon" title="Sunglasses"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'tongue.gif" data-value=":p" class="smileyCon" title="Tongue"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'unsure.gif" data-value=":-/" class="smileyCon" title="Unsure"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'upset.gif" data-value="-_-" class="smileyCon" title="Upset"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'heart.gif" data-value="heart" class="smileyCon" title="Eeart"/></div>';
	$content .= '<div class="floatLeft pad5"><img src="' . $smiley_url . 'devil.gif" data-value="X)" class="smileyCon" title="Devil"/></div>';
	return $content;
}


