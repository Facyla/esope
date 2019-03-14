<?php

/**
 * Is editor mode turned on?
 * 
 * @return boolean
 */
function tooltip_editor_can_edit() {

	$edit_enabled = ElggSession::offsetGet('tooltip_editor_enabled');
	
	if ($edit_enabled && elgg_is_admin_logged_in()) {
		return true;
	}
	
	return false;
}