<?php
/**
* Elgg socialshare plugin
* 
* @package
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL http://id.facyla.net/
* @copyright Florian DANIEL
* @link http://id.facyla.net/
*/

elgg_register_event_handler('init','system','socialshare_init');

function socialshare_init() {
	
	elgg_extend_view('css/elgg', 'socialshare/css');
	/*
	//$extended = 'owner_block/extend';
	$extension = 'socialshare/extend';
	$extendviews = elgg_get_plugin_setting('extendviews', 'socialshare');
	if (!empty($extendviews)) {
		$extendviews = str_replace(array(';', ' ', '\n', '\r', '\t'), ',', $extendviews);
		$extendviews = explode(',', $extendviews);
		$extendviews = array_filter($extendviews);
		foreach($extendviews as $view) {
			$view = trim($view);
			if (!empty($view)) {
				elgg_extend_view($view, $extension);
			}
		}
	}
	*/
	
	// Adds menu to page owner block - user and group only
	elgg_register_event_handler("pagesetup", "system", "socialshare_pagesetup");
	
	// Adds menu to entity menu - objects only
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'socialshare_entity_menu_setup', 600);

	
}

// Add sharing tools to owner block
function socialshare_pagesetup(){
	elgg_register_menu_item("extras", array(
		"name" => "socialshare",
		"href" => false,
		"text" => elgg_view("socialshare/owner_block_extend"),
		"priority" => 10000,
	));
}


// Add pin button to entity menu (close to end of the menu)
function socialshare_entity_menu_setup($hook, $type, $return, $params) {
	// Not in widgets, and for admin users only
	if (elgg_in_context('widgets')) { return $return; }
	$entity = $params['entity'];
	if ($entity->getType() == 'object') {
		// Only allow to share public content
		if ($entity->access_id == 2) {
			$options = array('name' => 'socialshare', 'href' => false, 'priority' => 10000, 'text' => elgg_view('socialshare/entity_menu_extend', array('entity' => $entity)));
			$return[] = ElggMenuItem::factory($options);
		}
	}
	return $return;
}



