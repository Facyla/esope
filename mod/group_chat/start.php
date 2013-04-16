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
  }
  
  // Extend the main css view
  elgg_extend_view('css/elgg', 'group_chat/css');
  
  $group_chat = elgg_get_plugin_setting('group_chat', 'group_chat');
  if ($group_chat == 'groupoption') {
    add_group_tool_option('group_chat', elgg_echo('group_chat:group_option'), false);
  }
  if ($group_chat != 'no') {
    $pageowner = elgg_get_page_owner_entity();
    if (elgg_in_context('groups') || (elgg_instanceof($pageowner, 'group'))) {
      elgg_extend_view('group/default', 'group_chat/chat_extend');
      /*
      if ($group_chat == 'groupoption') {
        if ($pageowner->group_chat_enable) {
          elgg_extend_view('group/default', 'group_chat/chat_extend');
        }
      } else {
        elgg_extend_view('group/default', 'group_chat/chat_extend');
      }
      */
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
    if (file_exists($filepath)) $content = file_get_contents($filepath);
    if($content)
    $fileContent .= '<li class="dateD" >'.date('D, F d, Y', strtotime('-'.$i.' Days')).'<li>';
    $fileContent .= $content;
  }
  return $fileContent;
}


/* Site chat : not seriously implemented yet, but functional */
function group_chat_page_handler($page) {
  global $CONFIG;
  gatekeeper();
  
  $site = $CONFIG->site;
  $guid = $CONFIG->site_guid;
  $title = elgg_echo('group_chat:site_chat');
  elgg_set_page_owner_guid($guid);
  elgg_push_breadcrumb(ucfirst($site->name), $site->getURL());
  elgg_push_breadcrumb($title);
  
  $content = '';
  //$content .= $groupChat['processEngine'];
  //$content .= elgg_view('group_chat/chat_window');
  $content .= elgg_view('group_chat/chat_extend', array('entity' => $site)); // En popup en bas
  //$content .= elgg_view('group_chat/chat_window', array('entity' => $site)); // Dans la page (mais petit)
  
  $body = elgg_view_layout('content', array('content' => $content, 'title' => $title, 'filter' => ''));
  echo elgg_view_page($title, $body);
  return true;
}


