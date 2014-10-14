<?php
/**
 * elgg_etherpad plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'elgg_etherpad_init');


/**
 * Init elgg_etherpad plugin.
 */
function elgg_etherpad_init() {
	global $CONFIG; // All site useful vars
	
	elgg_extend_view('css', 'elgg_etherpad/css');
	
	// Register PHP library - use with : elgg_load_library('elgg:plugin_template');
	// Note this library was partly derived from https://github.com/0x46616c6b/etherpad-lite-client 
	// but i just didn't want to load thousands of dependency files 
	// So the calls are made with pieces from https://github.com/efault/elggpad-lite
	// I don't know where the original lib come from...
	elgg_register_library('elgg:elgg_etherpad', elgg_get_plugins_path() . 'elgg_etherpad/lib/elgg_etherpad/elgg_etherpad.php');
	elgg_load_library('elgg:elgg_etherpad');
	
	
	$action_url = elgg_get_plugins_path() . 'elgg_etherpad/actions/elgg_etherpad';
	elgg_register_action("elgg_etherpad/edit", "$action_url/edit.php");
	
	
	
	// Get a plugin setting
	//$api_key = elgg_get_plugin_setting('api_key', 'elgg_etherpad');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'elgg_etherpad');
	}
	*/
	
	// Register a page handler on "elgg_etherpad/"
	elgg_register_page_handler('pad', 'elgg_etherpad_page_handler');
	
	// ENTITY MENU (edit with pad)
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'elgg_etherpad_entity_menu_setup', 200);
	
	
}


// Page handler
// Loads pages located in elgg_etherpad/pages/elgg_etherpad/
function elgg_etherpad_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_etherpad/pages/elgg_etherpad';
	switch ($page[0]) {
		case 'admin':
			include "$base/admin.php";
			break;
		case 'view':
			set_input('padID', $page[1]);
			include "$base/view.php";
			break;
		case 'edit':
			set_input('padID', $page[1]);
			include "$base/edit.php";
			break;
		case 'editwithpad':
			set_input('guid', $page[1]);
			include "$base/editwithpad.php";
			break;
		case 'index':
		default:
			include "$base/index.php";
	}
	return true;
}



// Add pin button to entity menu (close to end of the menu)
function elgg_etherpad_entity_menu_setup($hook, $type, $return, $params) {
	// Not in widgets, and for admin users only
	if (elgg_in_context('widgets')) { return $return; }
	if (!elgg_is_logged_in()) { return $return; }
	$entity = $params['entity'];
	if ($entity->getType() == 'object') {
		global $CONFIG;
		$subtype = $entity->getSubtype();
		if (in_array($subtype, array('page', 'page_top', 'blog'))) {
			// We need to be able to edit the entity to edit it with a pad...
			if ($entity->canEdit()) {
				$options = array('name' => 'elgg_etherpad', 'href' => $CONFIG->url . 'pad/editwithpad/' . $entity->guid, 'priority' => 200, 'text' => elgg_echo('elgg_etherpad:menu:editwithpad'));
				$return[] = ElggMenuItem::factory($options);
			}
		}
	}
	return $return;
}



