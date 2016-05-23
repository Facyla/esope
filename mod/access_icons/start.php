<?php
/**
 * access_icons
 *
 * @package access_icons
 *
 */

elgg_register_event_handler('init', 'system', 'access_icons_init');

/**
 * Init plugin.
 */
function access_icons_init() {
	
	elgg_extend_view('css', 'access_icons/css');
	
	// It's pointless to tell non-loggedin users that what they see is public...
	if (elgg_is_logged_in()) {
		// Modify group menu in listing view : add classes + access level
		// Note : no need to rewrite groups_entity_menu_setup() because we're overriding its return
		elgg_register_plugin_hook_handler('register', 'menu:entity', 'access_icons_groups_menu_entity_setup', 900);
		
		/* Rewrite entity menu in listing view : add classes + access level
		 * NOTE : on override page/components/list si on veut avoir l'accès sur tous types de contenus, 
		 * et notamment dans les listes et widgets ()
		 * Le hook modifie donc les menus des entités sauf dans le contexte des widgets
		 */
		elgg_register_plugin_hook_handler('register', 'menu:entity', 'access_icons_entity_menu_setup', 900);
		
		// Ajout des accès sur la rivière
		elgg_register_plugin_hook_handler('register', 'menu:river', 'access_icons_river_menu_setup');
	}
	
}


/**
 * Add links/info to group entity menu
 */
function access_icons_groups_menu_entity_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'groups') { return $return; }
	
	$entity = $params['entity'];
	
	// Membership type
	$membership = $entity->membership;
	if ($membership == ACCESS_PUBLIC) {
		$mem_text = elgg_echo("groups:open");
		$class = 'membership-group-open';
	} else {
		$mem_text = elgg_echo("groups:closed");
		$class = 'membership-group-closed';
	}
	// Wrap membership info : icon only (text on hover)
	$mem = '<span class="' . $class . '" title="' . $mem_text . '"></span>';
	$options = array(
		'name' => 'membership',
		'text' => $mem,
		'href' => false,
		'priority' => 0,
		'link_class' => $class,
	);
	$return[] = ElggMenuItem::factory($options);
	
	// Access info
	$options = array(
		'name' => 'access',
		'text' => elgg_view('output/access', array('entity' => $entity, 'hide_text' => true)),
		'href' => false,
		'priority' => 10,
		'link_class' => 'elgg-access',
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}


/**
 * Add access info to river menu
 */
function access_icons_river_menu_setup($hook, $type, $return, $params) {
	$item = $params['item'];
	/*
	if (elgg_in_context('widgets')) { return $return; }
	*/
	
	if ($item->type != 'object') { return $return; }
	
	$entity = $item->getObjectEntity();
	//$subtype = $item->getSubtype();
	
	// Access info
	$class = "elgg-access";
	$options = array(
		'name' => 'access',
		'text' => elgg_view('output/access', array('entity' => $entity, 'hide_text' => true)),
		'href' => false,
		'priority' => 10,
		'link_class' => 'elgg-access',
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}



/**
 * Add access info to entity menu
 */
function access_icons_entity_menu_setup($hook, $type, $return, $params) {
	$entity = $params['entity'];
	
	// Menu is displayed directly in widgets context in page/components/list override
	if (elgg_in_context('widgets')) { return $return; }
	
	$hide_text = false;
	$handler = elgg_extract('handler', $params, false);
	
	/* Skip groups
	 * Note : access information is already shown as visibility
	 * membership options is not an access but uses private and public access constants
	 */
	//if (($handler == 'groups') || elgg_instanceof($entity, 'group')) {
	if ($handler == 'groups') {
		//$hide_text = true;
		return $return;
	}
	
	/* Skip users
	 * Note : user entity is always public because it is required by the system
	 * profile visibility is not handled through entity access in that case)
	 */
	if (elgg_instanceof($entity, 'user')) {
		return $return;
	}
	
	// access info : hide_text true to display icon only
	$access_info = elgg_view('output/access', array('entity' => $entity, 'hide_text' => $hide_text));
	$class = "elgg-access";
	$options = array(
		'name' => 'access',
		'text' => $access_info ,
		'href' => false,
		'priority' => 10,
		'link_class' => $class, // Facyla : ajout class
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}



