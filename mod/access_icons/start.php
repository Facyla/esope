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
	
	// It's pointless to tell not loggedin users that what they see is public...
	if (elgg_is_logged_in()) {
		// Modify group menu in listing view : add classes + access level
		// Note : no need to rewrite groups_entity_menu_setup() because we're overriding its return
		elgg_register_plugin_hook_handler('register', 'menu:entity', 'access_icons_groups_menu_entity_setup', 1000);
		
		// Ajout des accès sur la rivière
		elgg_register_plugin_hook_handler('register', 'menu:river', 'access_icons_river_menu_setup');
		
		// Rewrite entity menu in listing view : add classes + access level
		// NOTE : this is not useful anymore because access is now added directly by /engine/lib/navigation.php
		// Note : on modifie tout de même page/components/list si on veut avoir l'accès sur tous types de contenus, 
		// et notamment dans les listes et widgets (ce qui est le choix privilégié sur adf_public_platform)
		//elgg_register_plugin_hook_handler('register', 'menu:entity', 'access_icons_entity_menu_setup', 1000);
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
		$mem = elgg_echo("groups:open");
		$class = 'membership-group-open';
	} else {
		$mem = elgg_echo("groups:closed");
		$class = 'membership-group-closed';
	}
	// Wrap membership info
	$mem = '<span class="' . $class . '">' . $mem . '</span>';
	$options = array(
		'name' => 'membership',
		'text' => $mem,
		'href' => false,
		'priority' => 0,
		'class' => $class,
	);
	$return[] = ElggMenuItem::factory($options);
	
	// Access info
	$options = array(
		'name' => 'access',
		'text' => elgg_view('output/access', array('entity' => $entity, 'hide_text' => false)),
		'href' => false,
		'priority' => 10,
		'class' => 'elgg-access',
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}


/**
 * Add access info to river menu
 */
function access_icons_river_menu_setup($hook, $type, $return, $params) {
	/*
	if (elgg_in_context('widgets')) { return $return; }
	*/
	
	$item = $params['item'];
	
	if ($item->type != 'object') { return $return; }
	
	$entity = $item->getObjectEntity();
	//$subtype = $item->getSubtype();
	
	// Access info
	$class = "elgg-access";
	$options = array(
		'name' => 'access',
		'text' => elgg_view('output/access', array('entity' => $entity)),
		'href' => false,
		'priority' => 10,
		'class' => 'elgg-access',
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}



/**
 * Add access info to entity menu
 * Note : not used anymore
 */
/*
function access_icons_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		//return $return;
	}
	$entity = $params['entity'];
	
	$handler = elgg_extract('handler', $params, false);
	if ($handler == 'groups') { return $return; }
	//if (($handler == 'groups') || elgg_instanceof($entity, 'group')) { return $return; }
	
	// access info
	$access_info = elgg_view('output/access', array('entity' => $entity, 'hide_text' => true));
	$class = "elgg-access";
	$options = array(
		'name' => 'access',
		'text' => $access_info,
		'href' => false,
		'priority' => 10,
		'class' => $class, // Facyla : ajout class
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}
*/


