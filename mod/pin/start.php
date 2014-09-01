<?php

elgg_register_event_handler('init','system','pin_init');


function pin_init() {
	global $CONFIG;
	
	elgg_extend_view('css/elgg','pin/css');
	elgg_extend_view('js/elgg','pin/js');
	
	// ENTITY MENU (select/unselect)
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'pin_entity_menu_setup', 600);
	
	// Note : always extend, but actions are available only to valid loggedin users
	/*
	$extendfullonly = elgg_get_plugin_setting('extendfullonly ', 'pin');
	if ($extendfullonly == 'no') {
		elgg_extend_view('search/gallery','pin/extend_entity');
		elgg_extend_view('search/listing','pin/extend_entity');
	}
	*/
	
	/*
	// Highlight - displayed only for loggedin users
	$usehighlight = elgg_get_plugin_setting('highlight', 'pin');
	if (($usehighlight == 'yes') && elgg_is_logged_in()) {
		// Types d'entités concernées
		$validhighlight = elgg_get_plugin_setting('validhighlight', 'pin');
		if (!empty($validhighlight)) $validhighlight = explode(',', $validhighlight);
		else $validhighlight = get_registered_entity_types('object');
		// Extend chosen entities views
		foreach($validhighlight as $type) {
			$type = trim($type);
			if ($type == 'groupforumtopic') elgg_extend_view("forum/viewposts",'pin/highlight_extend', 0);
			else elgg_extend_view("object/$type",'pin/highlight_extend', 300);
		}
	}
	*/
	
	elgg_register_action("pin/highlight",false,$CONFIG->pluginspath . "pin/actions/highlight.php");
	
}


// Add pin button to entity menu (close to end of the menu)
function pin_entity_menu_setup($hook, $type, $return, $params) {
	// Not in widgets, and for admin users only
	if (elgg_in_context('widgets')) { return $return; }
	if (!elgg_is_admin_logged_in()) { return $return; }
	if (!elgg_is_logged_in()) { return $return; }
	$entity = $params['entity'];
	if ($entity->getType() == 'object') {
		// @TODO : filter on chosen subtypes only
		/*
		// Types d'entités concernées
		$validhighlight = elgg_get_plugin_setting('validhighlight', 'pin');
		if (!empty($validhighlight)) $validhighlight = explode(',', $validhighlight);
		else $validhighlight = get_registered_entity_types('object');
		*/
		
		$options = array('name' => 'pins', 'href' => false, 'priority' => 900, 'text' => elgg_view('pin/entity_menu', array('entity' => $entity)));
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}


