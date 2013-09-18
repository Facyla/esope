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
	
	// Rewrite groupe menu in listing view : add classes + access level
	elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'groups_entity_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'access_icons_groups_entity_menu_setup');
	
}


/**
 * Add links/info to entity menu particular to group entities
 */
function access_icons_groups_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'groups') {
		return $return;
	}

	foreach ($return as $index => $item) {
		//if (in_array($item->getName(), array('access', 'likes', 'edit', 'delete'))) {
		if (in_array($item->getName(), array('likes', 'edit', 'delete'))) {
			unset($return[$index]);
		}
	}

	// membership type
	$membership = $entity->membership;
	if ($membership == ACCESS_PUBLIC) {
		$mem = elgg_echo("groups:open");
		$class = 'membership-group-open'; // Facyla : ajout class
	} else {
		$mem = elgg_echo("groups:closed");
		$class = 'membership-group-closed'; // Facyla : ajout class
	}
	$mem = '<span class="' . $class . '">' . $mem . '</span>';
	$options = array(
		'name' => 'membership',
		'text' => $mem,
		'href' => false,
		'priority' => 100,
		'class' => $class, // Facyla : ajout class
	);
	$return[] = ElggMenuItem::factory($options);

	// number of members
	$num_members = get_group_members($entity->guid, 10, 0, 0, true);
	$members_string = elgg_echo('groups:member');
	$options = array(
		'name' => 'members',
		'text' => $num_members . ' ' . $members_string,
		'href' => false,
		'priority' => 200,
	);
	$return[] = ElggMenuItem::factory($options);

	// feature link
	if (elgg_is_admin_logged_in()) {
		if ($entity->featured_group == "yes") {
			$url = "action/groups/featured?group_guid={$entity->guid}&action_type=unfeature";
			$wording = elgg_echo("groups:makeunfeatured");
		} else {
			$url = "action/groups/featured?group_guid={$entity->guid}&action_type=feature";
			$wording = elgg_echo("groups:makefeatured");
		}
		$options = array(
			'name' => 'feature',
			'text' => $wording,
			'href' => $url,
			'priority' => 300,
			'is_action' => true
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}


