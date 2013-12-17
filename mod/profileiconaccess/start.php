<?php

function profileiconaccess_init()	{

  elgg_extend_view('css/elgg', 'css/profileiconaccess');
  elgg_extend_view('core/avatar/upload', 'forms/profileiconaccess');
  
  // register our access save action
  elgg_register_action('profileiconaccess', elgg_get_plugins_path() . 'profileiconaccess/actions/profileiconaccess.php');
  
  // add some custom js
  $js = elgg_get_simplecache_url('js', 'profileiconaccess/js');
	elgg_register_simplecache_view('js/profileiconaccess/js');
	elgg_register_js('profileiconaccess.js', $js);
  
	elgg_register_plugin_hook_handler('entity:icon:url', 'user', 'profileiconaccess_usericon_acl'); 
}
	
// takes access input and saves it as metadata on the user
// this occurs right before the icon save action
function profileiconaccess_action_hook($hook, $entity_type, $returnvalue, $params) {
  // Apply access permission here
	$iconaccess = (int)get_input('iconaccess');
	$username = get_input('username');
	
	$user = get_user_by_username($username);
		
	if ($user) {
    create_metadata($user->guid, 'iconaccess', $iconaccess, 'integer', $user->guid, $iconaccess);	
	}
}


function profileiconaccess_usericon_acl($hook, $type, $return, $params) {
		
  if (elgg_instanceof($params['entity'], 'user')) {
    $user = $params['entity'];
    	
    $options = array(
        'guid' => $user->guid,
        'metadata_name' => 'iconaccess',
        'limit' => 0
        );
    
		// See if we can access the metadata with normal access
		$metadata = elgg_get_metadata($options);
    
    // we may not have the metadata because it may not be set - in which case it's public
    // so look again with the access ignored and see if we have it then
    $ignore = elgg_set_ignore_access();
    $check = elgg_get_metadata($options);
    elgg_set_ignore_access($ignore);
    
    // if we have metadata in $check and not in $metadata, it's because we're not allowed to see it
    if (!$metadata && $check) {
      $size = $params['size'];			
			return "_graphics/icons/user/default{$size}.gif";
    }
	}
}
	
elgg_register_event_handler('init','system','profileiconaccess_init');