<?php
global $CONFIG;

admin_gatekeeper();

$guid = (int)get_input('guid');

access_show_hidden_entities(true);
$entity = get_entity($guid);

if ($entity) {
	
	// Some useful lists for entity editing
	$non_editable = array('guid', 'type', 'subtype', 'tables_split', 'tables_loaded');
	$special_fields = array('enabled', 'time_created', 'time_updated', 'last_action', 'owner_guid', 'container_guid', 'access_id');
	
	// Define the fields that one want to edit
	$edit_fields = get_input('guidtool_edit_fields', false);
	$edit_fields = str_replace(' ', '', $edit_fields);
	$edit_fields = str_replace(';', ',', $edit_fields);
	if (!empty($edit_fields)) $edit_fields = explode(',', $edit_fields);
	
	
	// New fields support
	$new_metadata = get_input('new_metadata', false);
	$new_metadata = str_replace(array("\n", "\r", "\t"), "\n", $new_metadata);
	$new_metadata = explode("\n", $new_metadata);
	foreach ($new_metadata as $new_field) {
		$new_field = explode("=", $new_field);
		$field = trim($new_field[0]);
		$new_value = trim($new_field[1]);
		if (!empty($field) && !empty($new_value)) {
			// Edit only manually added values
			if (!in_array($field, $edit_fields)) {
				register_error("Field not set in edit fields field : $field");
				continue;
			}
			if (in_array($field, $non_editable)) {
				register_error("Non-editable field : $field");
				continue;
			}
			if (in_array($field, $special_fields)) {
				register_error("Special field : $field");
				continue;
			}
			$entity->$field = $new_value;
		}
	}
	
	
	// Update only explicitely asked fields
	if ($edit_fields) foreach ($edit_fields as $field) {
		// Some fields cannot be edited in any case.
		// Or at least not that way : use DB queries if you really need to change type, subtype or  guid...
		if (in_array($field, $non_editable)) {
			register_error("Non-editable field : $field");
			continue;
		}
		
		$done = false;
		
		// Update field with new value - empty values are accepted.
		$field = trim($field);
		$new_value = get_input($field, false);
		$old_value = $entity->$field;
		if (($new_value !== false) && !empty($field)) {
			// Update only if changed
			if ($entity->$field != $new_value) {
				
				// Handle the -many- special cases
				switch ($field) {
					// Enable/disable entity
					case 'enabled':
						// No recursivity here - we are doing very specific manual changes
						if ($new_value == 'yes') $done = enable_entity($guid, false);
						else if ($new_value == 'no') $done = disable_entity($guid, false);
						break;
						
					// New value has to be a valid timestamp
					case 'time_created':
					case 'time_updated':
					case 'last_action':
						$check = (is_int($new_value) OR is_float($new_value)) ? $new_value : (string) (int) $new_value;
						if (($check === $new_value) AND ( (int) $new_value <=  PHP_INT_MAX) AND ( (int) $new_value >= ~PHP_INT_MAX)) {
							$entity->$field = $new_value;
							$done = true;
						} else register_error("Invalid timestamp : $check !== $timestamp");
						break;
					
					// Has to be a valid owner/container
					// Invalid data would break the site display (though it should not cause any data loss by itself)
					case 'owner_guid':
					case 'container_guid':
						if (!empty($new_value) && ($ent = get_entity($new_value)) && (elgg_instanceof($ent, 'user') || elgg_instanceof($ent, 'group') || elgg_instanceof($ent, 'site'))) {
							$entity->$field = $new_value;
							$done = true;
						} else register_error("Invalid GUID for $field : $new_value is not a user/group/site");
						break;
					
					case 'access_id':
						// Should be a valid access_id : -2 >= access_id >= 2, or is a valid collection id
						if ((($new_value >= -2) && ($new_value <= 2)) || (($test_access = get_access_collection($new_value)) && ($test_access != false))) {
							// Access default is not a value => use site default value
							if ($new_value == -1) {
								$new_value = $CONFIG->default_access;
								system_message("$field updated to site default : $new_value");
							}
							$entity->$field = $new_value;
							$done = true;
						} else register_error("Invalid access id $field : $new_value is neither a default access level nor a valid collection id");
						break;
					
					default:
						$entity->$field = $new_value;
						$done = true;
				}
			}
		} else register_error("Invalid field or value : $field / $new_value");
		
		// Messages report
		if ($done) system_message($field . ' updated : ' . $old_value . ' => ' . $new_value);
		else register_error("Something went wrong while updating : $field / $new_value");
	}
	$entity->save();
	
} else {
	register_error(sprintf(elgg_echo('guidtool:invalidentity'), $guid));
}
access_show_hidden_entities(true);

forward($_SERVER['HTTP_REFERER']);

