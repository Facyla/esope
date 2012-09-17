<?php
		$assign_to = get_input($assign_to);
		$guid = get_input('guid');
		if ($entity = get_entity($guid)) {
			
			if ($entity->canEdit() || isadminloggedin()) {
				
				if ($entity->delete()) {
					
					system_message(elgg_echo("microthemes:delete:success"));
					forward("pg/microthemes/view?assign_to=".$assign_to);					
					
				}
				
			}
			
		}
		
		register_error(elgg_echo("bookmarks:delete:failed"));
		forward("pg/microthemes/view?assign_to=".$assign_to);					
?>
