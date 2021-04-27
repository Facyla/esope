<?php


// Event handler
// Add sharing tools to owner block
function socialshare_pagesetup(){
	elgg_register_menu_item("extras", array(
		"name" => "socialshare",
		"href" => false,
		"text" => elgg_view("socialshare/owner_block_extend"),
		"priority" => 10000,
	));
}


// Plugin hook handler
// Add social share buttons to entity menu (close to end of the menu)
function socialshare_entity_menu_setup(\Elgg\Hook $hook) {
	// Not in widgets, and for admin users only
	$return = $hook->getValue();
	if (elgg_in_context('widgets')) { return $return; }
	
	$entity = $hook->getEntityParam();
	if ($entity->getType() == 'object') {
		// Only allow to share public content
		if ($entity->access_id == 2) {
			$menu_content = elgg_view('socialshare/entity_menu_extend', array('entity' => $entity));
			if (!empty($menu_content)) {
				$options = array('name' => 'socialshare', 'href' => false, 'priority' => 10000, 'text' => $menu_content);
				$return[] = ElggMenuItem::factory($options);
			}
		}
	}
	
	return $return;
}

