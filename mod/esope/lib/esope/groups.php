<?php
/**
 * ESOPE Groups function library additions adn alternative functions
 * This version DOES NOT replace elgg:groups library, but adds alternative functions that are used as a replacement for some elgg:groups functions
 * Main reasons are :
 *  - Esope settings or additions
 *  - au_subgroups replaces the groups library and is not updated as often so we should not rely on it for some functions
 */

/**
 * List all groups
 */
function esope_groups_handle_all_page() {
	// Esope settings
	$groups_alpha = elgg_get_plugin_setting('groups_alpha', 'esope');
	$groups_discussion = elgg_get_plugin_setting('groups_discussion', 'esope');
	
	$dbprefix = elgg_get_config('dbprefix');
	
	// Subgroups settings
	$display_subgroups = false;
	$active_subgroups = elgg_is_active_plugin('au_subgroups');
	if ($active_subgroups) {
		$display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
		$display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
	}
	
	// Force listing context, if needed for summary rendering (but keep groups displayed)
	/*
	elgg_pop_context();
	elgg_push_context('listing');
	elgg_push_context('groups');
	*/
	
	// all groups doesn't get link to self
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('groups'));
	
	if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
		elgg_register_title_button();
	}
	
	// Page title (can be updated afterwards)
	$title = elgg_echo('groups');
	
	$limit = get_input('limit', 40);
	$selected_tab = get_input('filter', 'popular');
	if ($groups_alpha == 'yes') { $selected_tab = get_input('filter', 'alpha'); }
	$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
	$user = get_entity($user_guid);
	
	switch ($selected_tab) {
		// Popular groups
		case 'popular':
			$options = array(
				'type' => 'group',
				'relationship' => 'member',
				'inverse_relationship' => false,
				'full_view' => false, 
				'no_results' => elgg_echo('groups:none'),
				'limit' => $limit,
			);
			if ($active_subgroups && ($display_subgroups != 'yes')) {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities_from_relationship_count($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_relationship_count($options);
			$title = elgg_echo("groups") . " ($count)";
			break;
		
		// Latest discussion topics
		case 'discussion':
			$options = array(
				'type' => 'object',
				'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc',
				'limit' => $limit,
				'full_view' => false,
				'no_results' => elgg_echo('discussion:none'),
				'distinct' => false,
				'preload_containers' => true,
			);
			
			if ($active_subgroups && ($display_subgroups != 'yes')) {
			  $options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities($options);
			$title = elgg_echo("groups:latestdiscussion") . " ($count)";
			break;
			
		// Alphabetic sort
		case 'alpha':
			$options = array(
				'type' => 'group', 
				'full_view' => false, 
				'limit' => $limit,
				'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
				'order_by' => 'ge.name ASC',
				'no_results' => elgg_echo('groups:none'),
			);
			if ($active_subgroups && ($display_subgroups != 'yes')) {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities($options);
			$title = elgg_echo("groups") . " ($count)";
			break;
			
		// Featured groups
		case 'featured':
			$options = array(
					'type' => 'group',
					'metadata_name' => 'featured_group',
					'metadata_value' => 'yes',
					'full_view' => false, 
					'limit' => $limit,
					'no_results' => elgg_echo('groups:nofeatured'),
				);
			$content = elgg_list_entities_from_metadata($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_metadata($options);
			$title = elgg_echo("groups:featured") . " ($count)";
			break;
		
		// Groups user is member of (including owned groups)
		case "member":
			// Invalid user provided : can be not set, or a wrong one (no access)
			if (!elgg_instanceof($user, 'user')) {
				if (!empty($user_guid)) {
					register_error(elgg_echo('noaccess'));
				}
				forward('groups/all');
			}
			$options = array(
				'type' => 'group', 
				'relationship' => 'member', 
				'relationship_guid' => $user_guid, 
				'inverse_relationship' => false, 
				'full_view' => false, 
				'limit' => $limit,
				'no_results' => elgg_echo('groups:none'),
			);
			if ($active_subgroups && ($display_subgroups != 'yes')) {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities_from_relationship_count($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_relationship_count($options);
			if ($user_guid == elgg_get_logged_in_user_guid()) {
				$title = elgg_echo("groups:yours") . " ($count)";
			} else {
				$title = elgg_echo("groups:user", array($user->name)) . " ($count)";
			}
			break;
		
		// Owned (and operated) groups
		case "owner":
			$groups = esope_get_owned_groups($user_guid, 'all');
			$options = array(
				'full_view' => false, 
				'entities' => $groups, 
				'no_results' => elgg_echo('groups:none'),
			);
			$content = elgg_view_entity_list($groups, $options);
			//$content = elgg_list_entities($options); // Should pass guids (not entities)
			// Add title + count
			$count = sizeof($groups);
			$title = elgg_echo("groups") . " ($count)";
			break;
		
		// Friends' groups
		case 'friends':
			if (!elgg_is_logged_in()) {
				forward('groups/all');
			}
			$friends = $user->getFriends(array('limit' => 0));
			if (!$friends) {
				$content = elgg_echo('friends:none:you');
			} else {
				$options = array(
					'type' => 'group',
					'full_view' => false,
					'limit' => $limit,
					'no_results' => elgg_echo('groups:none'),
				);
				if ($active_subgroups && ($display_subgroups != 'yes')) {
					$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
				}
				foreach ($friends as $friend) { $options['container_guids'][] = $friend->getGUID(); }
				$content = elgg_list_entities_from_metadata($options);
			}
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_metadata($options);
			$title = elgg_echo("groups") . " ($count)";
			break;
			
		case 'newest':
		default:
			$options = array(
				'type' => 'group',
				'full_view' => false,
				'no_results' => elgg_echo('groups:none'),
				'distinct' => false,
				'limit' => $limit,
			);
			if ($active_subgroups && ($display_subgroups != 'yes')) {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities($options);
			$title = elgg_echo("groups") . " ($count)";
			break;
	}

	//$filter = elgg_view('groups/find');
	$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));
	
	// Add tags blocks before featured groups if search enabled
	$groups_search = elgg_get_plugin_setting('groups_searchtab', 'esope');
	if ($groups_search == 'yes') {
		$sidebar = elgg_view('groups/group_tagcloud_block');
	} else {
		$sidebar = elgg_view('groups/find');
	}
	$sidebar .= elgg_view('groups/sidebar/featured');
	
	// Esope : add discussions if asked to (default to yes = in a tab)
	if ($groups_discussion == 'always') {
		$discussion = elgg_list_entities(array(
				'type' => 'object', 
				'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc', 
				'limit' => $limit, 
				'full_view' => false,
				'no_results' => elgg_echo('discussion:none'),
			));
		$content .= '<div class="clearfloat"></div><br /><br /><h3>' . elgg_echo('groups:latestdiscussion') . '</h3>' . $discussion;
	}
	
	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => $filter,
		'title' => $title,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}



/* Liste les groupes dont on est owner ou operator (si le plugin est activé) */
function esope_groups_handle_owned_page() {

	$page_owner = elgg_get_page_owner_entity();

	if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('groups:owned');
	} else {
		$title = elgg_echo('groups:owned:user', array($page_owner->name));
	}
	elgg_push_breadcrumb($title);

	if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
		elgg_register_title_button();
	}
	
	// Get user's groups where admin and/or operator (all|owned|operated)
	$owner_type = get_input('owner_type', 'all');
	if (!in_array($owner_type, array('all', 'owned', 'operated'))) { $owner_type = 'all'; }
	$groups = esope_get_owned_groups($page_owner->guid, $owner_type);
	// Now order results
	if (sizeof($groups) > 1) {
		usort($groups, create_function('$a,$b', 'return strcmp($a->name,$b->name);'));
	}
	
	//$content = elgg_list_entities($options); // To use, pass GUIDS, not entities !
	$content = elgg_view_entity_list($groups, array(
			'full_view' => false, 
			'no_results' => elgg_echo('groups:none'),
		)
	);

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}


/**
 * Group members page
 *
 * @param int $guid Group entity GUID
 */
// ESOPE : modified because of the hardcoded 'limit' param in au_subgroups version
function esope_groups_handle_members_page($guid) {

	elgg_entity_gatekeeper($guid, 'group');

	$group = get_entity($guid);
	if (!$group || !elgg_instanceof($group, 'group')) {
		forward();
	}

	elgg_set_page_owner_guid($guid);

	elgg_group_gatekeeper();

	$title = elgg_echo('groups:members:title', array($group->name));

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:members'));

	$dbprefix = elgg_get_config('dbprefix');
	$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'type' => 'user',
		'limit' => (int)get_input('limit', max(20, elgg_get_config('default_limit')), false),
		'joins' => array("JOIN {$dbprefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC',
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}


// Main search restricted to group content
function esope_groups_search_page() {
	elgg_push_breadcrumb(elgg_echo('search'));
	include elgg_get_plugins_path() . 'esope/pages/search/index.php';
}

// Search groups
function esope_groups_groupsearch_page() {
	elgg_push_breadcrumb(elgg_echo('search'));
	include elgg_get_plugins_path() . 'esope/pages/groups/groupsearch.php';
}




