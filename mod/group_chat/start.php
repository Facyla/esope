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
	
	$site_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
	if ($site_chat == 'yes') {
		elgg_register_page_handler('chat', 'group_chat_page_handler');
		elgg_extend_view('adf_platform/adf_header', 'group_chat/sitechat_extend', 1000);
	}
	
	// Extend the main css view
	elgg_extend_view('css/elgg', 'group_chat/css');
	
	$group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
	if ($group_chat == 'groupoption') {
		add_group_tool_option('group_chat', elgg_echo('group_chat:group_option'), false);
	}
	if (in_array($group_chat, array('yes', 'groupoption'))) {
		$pageowner = elgg_get_page_owner_entity();
		if (elgg_in_context('groups') || (elgg_instanceof($pageowner, 'group'))) {
			elgg_extend_view('group/default', 'group_chat/chat_extend');
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
	if (!isset($page[0])) { $page[0] = 'site'; }
	switch ($page[0]) {
		case "site":
		default:
			gatekeeper();
			$site = $CONFIG->site;
			$guid = $CONFIG->site_guid;
			$title = elgg_echo('group_chat:site_chat');
			$vars['title'] = $title;
			elgg_set_page_owner_guid($guid);
			$content = '';
			$content .= elgg_view('group_chat/site_chat', array('entity' => $site));
			
			// Render pure content (for popup, lightbox or embed/iframe use)
			header('Content-Type: text/html; charset=utf-8');
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo $title; ?></title>
	<?php echo elgg_view('page/elements/head', $vars); ?>
	<style>
	html, body { background:#FFFFFF !important; }
	</style>
</head>
<body style="height:100%; margin:0; border:0;">
	<div style="padding:0 4px;">
		<?php echo $content; ?>
	</div>
</body>
</html>
			<?php
	}
	
	return true;
}


