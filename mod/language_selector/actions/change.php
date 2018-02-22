<?php 
	
$new_lang_id = get_input("lang_id");
$installed = get_installed_translations();

if (!empty($new_lang_id) && array_key_exists($new_lang_id, $installed)) {
	if ($user = elgg_get_logged_in_user_entity()) {
		
		$user->language = $new_lang_id;
		$user->save();
		
		// let other plugins know we updated the language
		elgg_trigger_event("update", "language", $user);
	}	
}

forward(REFERER);
	