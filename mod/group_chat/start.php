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
		case "notifier":
			require_once "$base/notifier.php";
			break;
			
		case "group":
			if (isset($page[1])) { set_input('group_guid', $page[1]); }
			require_once "$base/group_chat.php";
			break;
			
		case "user":
			if (isset($page[1])) { set_input('chat_id', $page[1]); }
			require_once "$base/user_chat.php";
			break;
			
		case "site":
		default:
			if (isset($page[1])) { set_input('site_guid', $page[1]); }
			require_once "$base/site_chat.php";
	}
	
	return true;
}


// Menu that appears on hovering over a user profile icon
function group_chat_normalise_chat_id($chat_id = '') {
	$chat_id = elgg_get_friendly_title($chat_id);
	$chat_user_guids = explode('-', $chat_id);
	// Sort guids
	sort($chat_user_guids);
	$chat_id = implode('-', $chat_user_guids);
	return $chat_id;
}


// Menu that appears on hovering over a user profile icon
function group_chat_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	// Allow Add menu for logged in users only, and not on self profile
	if (elgg_is_logged_in()) {
		$ownguid = elgg_get_logged_in_user_guid();
		if ($user->guid != $ownguid) {
			$chat_id = $ownguid . '-' . $user->guid;
			$url = elgg_get_site_url() . "chat/user/" . $chat_id;
			$title = '<i class="fa fa-comments-o"></i> ' . elgg_echo("groupchat:user:openlink:ownwindow");
			$item = new ElggMenuItem('group_chat_user', $title, $url);
			//$item->setSection('admin');
			$item->onClick = "window.open('$url', '$chat_id', 'menubar=no, status=no, scrollbars=no, menubar=no, copyhistory=no, width=400, height=500').focus(); return false;";
			$return[] = $item;
		}
	}
	return $return;
}

// Tells which chat type it is (site / group / user)
function group_chat_container_type($chat_id) {
	// Check which container we are using : site / group / user(s)
	if (strpos($chat_id, '-')) {
		return 'user';
	} else {
		$chat_container = get_entity($chat_id);
		if (elgg_instanceof($chat_container, 'site')) {
			return 'site';
		} else if (elgg_instanceof($chat_container, 'group')) {
			return 'group';
		} else if (elgg_instanceof($chat_container, 'object')) {
			// Per-entity chat is not handled yet, though it would be an easy one
			return 'object';
		} else if (elgg_instanceof($chat_container, 'user')) {
			return 'user';
		}
	}
	// Other types are not handled
	return false;
}


// Remove unread chat messages markers (for a given chat)
function group_chat_update_marker($chat_id) {
	global $CONFIG;
	// Update marker so we know we're up-to-date
	$own = elgg_get_logged_in_user_entity();
	$container_type = group_chat_container_type($chat_id);
	switch($container_type) {
		case 'site':
			// Update ts to latest read message
			$own->group_chat_unread_site = $CONFIG->site->group_chat_unread;
			break;
		case 'group':
			// Update list of unread group chats
			return esope_remove_from_meta_array($own, 'group_chat_unread_group', $chat_id);
			break;
		case 'user':
			// Update list of unread user chats
			return esope_remove_from_meta_array($own, 'group_chat_unread_user', $chat_id);
			break;
	}
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



/* Add useful ESOPE functions, if not available */
if (!elgg_is_active_plugin('esope') && !elgg_is_active_plugin('adf_public_platform')) {
	// Double check in case these were included from somewhere else..
	if (!function_exists('esope_add_to_meta_array')) {
		/* Ajoute des valeurs dans un array de metadata (sans doublon)
		 * $entity : the source/target entity
		 * $meta : metadata to be updated
		 * $add : value(s) to be added
		 */
		function esope_add_to_meta_array($entity, $meta = '', $add = array()) {
			if (!($entity instanceof ElggEntity) || empty($meta) || empty($add)) { return false; }
			$values = $entity->{$meta};
			// Make it an array, even empty
			if (!is_array($values)) {
				if (!empty($values)) $values = array($values);
				else $values = array();
			}
			// Allow multiple values to be added in one pass
			if (!is_array($add)) $add = array($add);
			foreach ($add as $new_value) {
				if (!in_array($new_value, $values)) { $values[] = $new_value; }
			}
			// Ensure unique values
			$values = array_unique($values);
			// Update entity
			if ($entity->{$meta} = $values) { return true; }
			return false;
		}
	}

	// Double check in case these were included from somewhere else..
	if (!function_exists('esope_remove_from_meta_array')) {
		/* Retire des valeurs d'un array de metadata (sans doublon)
		 * $entity : the source/target entity
		 * $meta : metadata to be updated
		 * $remove : value(s) to be removed
		 */
		function esope_remove_from_meta_array($entity, $meta = '', $remove = array()) {
			if (!($entity instanceof ElggEntity) || empty($meta) || empty($remove)) { return false; }
			$values = $entity->{$meta};
			// Make it an array, even empty
			if (!is_array($values)) {
				if (!empty($values)) { $values = array($values); } else { $values = array(); }
			}
			// Allow multiple values to be removed in one pass
			if (!is_array($remove)) $remove = array($remove);
			foreach ($values as $key => $value) {
				if (in_array($value, $remove)) { unset($values[$key]); }
			}
			// Ensure unique values
			$values = array_unique($values);
			// Update entity
			if ($entity->{$meta} = $values) { return true; }
			return false;
		}
	}
}


