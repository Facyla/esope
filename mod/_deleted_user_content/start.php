<?php

namespace deleted_user_content;

require_once 'lib/hooks.php';
require_once 'lib/events.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');


function init() {
	elgg_register_plugin_hook_handler('action', 'admin/user/delete', __NAMESPACE__ . '\\delete_user_action');
	elgg_register_event_handler('delete', 'user', __NAMESPACE__ . '\\delete_user_event', 1000);
}


/**
 * reassigns the content owned by $user1 to $user2
 * 
 * @param type $user1
 * @param type $user2
 * 
 * @return bool
 */
function reassign_content($user1, $user2) {
	if (!elgg_instanceof($user1, 'user') || !elgg_instanceof($user2, 'user')) {
		return false;
	}
	
	// do this by direct query for performance
	$dbprefix = elgg_get_config('dbprefix');
	$q = "UPDATE {$dbprefix}entities SET owner_guid = {$user2->guid} WHERE owner_guid = {$user1->guid}";
	update_data($q);
	
	$q = "UPDATE {$dbprefix}entities SET container_guid = {$user2->guid} WHERE container_guid = {$user1->guid}";
	update_data($q);
	
	$q = "UPDATE {$dbprefix}annotations SET owner_guid = {$user2->guid} WHERE owner_guid = {$user1->guid}";
	update_data($q);
	
	$q = "UPDATE {$dbprefix}metadata SET owner_guid = {$user2->guid} WHERE owner_guid = {$user1->guid}";
	update_data($q);
	
	return true;
}


function recurse_copy($src,$dst) { 
    $dir = opendir($src);
	
	if ($dir === false) {
		return;
	}
		
	if (!is_dir($dst)) {
		@mkdir($dst); 
	}
	
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file);
            } 
        } 
    } 
    closedir($dir); 
} 