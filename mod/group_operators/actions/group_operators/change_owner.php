<?php

$group_guid = get_input('mygroup');
$user_guid = get_input('who');
$group = get_entity($group_guid);
$user = get_entity($user_guid);

if (elgg_instanceof($group, 'group') && elgg_instanceof($user, 'user') && ($group->owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {
	
	$old_owner_guid = $group->owner_guid;
	
	// Transfer ownership
	$group->owner_guid = $user_guid;
	$group->container_guid = $user_guid;
	$group->join($user);
	
	if ($group->save()) {
		
		// Update owner as a simple operator
		if (!check_entity_relationship($old_owner_guid, 'operator', $group_guid)) {
			add_entity_relationship($old_owner_guid, 'operator', $group_guid);
		}
		
		// Old method used direct file update
		// rename("$old_path/{$group_guid}{$size}.jpg", "$new_path/{$group_guid}{$size}.jpg");
		
		// Update group icons - updated using Coldtrick's group_tools' piece of code
		if (!empty($group->icontime)) {
			$prefix = "groups/" . $group_guid;
			
			$old_fh = new ElggFile();
			$old_fh->owner_guid = $old_owner_guid;
	
			$new_fh = new ElggFile();
			$new_fh->owner_guid = $user_guid;
			
			//$sizes = elgg_get_config("icon_sizes"); // @TODO if using these, need to update the foreach loop to array structure
			$sizes = array("", "tiny", "small", "medium", "large");
			
			foreach ($sizes as $size) {
				// set correct file to handle
				$old_fh->setFilename($prefix . $size . ".jpg");
				$new_fh->setFilename($prefix . $size . ".jpg");
				
				// open files
				$old_fh->open("read");
				$new_fh->open("write");
					
				// copy file
				$new_fh->write($old_fh->grabFile());
					
				// close file
				$old_fh->close();
				$new_fh->close();
					
				// cleanup old file
				$old_fh->delete();
			}
			
			$group->icontime = time();
		}
		
	}
	
	system_message(elgg_echo('group_operators:owner_changed', array($user->name)));
} else {
	register_error(elgg_echo('group_operators:change_owner:error'));
}
forward(REFERER);

