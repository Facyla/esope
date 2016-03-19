<?php
/**
 * ESOPE Groups function library
 * This version does NOT replace elgg:groups lbrary, but adds replacement functions that can are used as a replacement for some elgg:groups functions
 */

/**
 * List all groups
 */
function esope_groups_handle_all_page() {
	//$count = elgg_get_entities(array('type' => 'group', 'count' => true));
	$groups_alpha = elgg_get_plugin_setting('groups_alpha', 'esope');
	$groups_discussion = elgg_get_plugin_setting('groups_discussion', 'esope');
	$display_subgroups = false;
	$db_prefix = elgg_get_config('dbprefix');
	if (elgg_is_active_plugin('au_subgroups')) {
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
	
	$limit = get_input('limit', 20);
	$selected_tab = get_input('filter', 'popular');
	if ($groups_alpha == 'yes') $selected_tab = get_input('filter', 'alpha');
	$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
	$user = get_entity($user_guid);
	
	// Page title
	$title = elgg_echo('groups');
	
	$active_subgroups = elgg_is_active_plugin('au_subgroups');
	
	switch ($selected_tab) {
		
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
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities_from_relationship_count($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_relationship_count($options);
			$title = elgg_echo("groups") . " ($count)";
			break;
			
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
			  $options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities($options);
			$title = elgg_echo("groups:latestdiscussion") . " ($count)";
			break;
			
		case 'alpha':
			$options = array('type' => 'group', 'full_view' => false, 'limit' => $limit);
			if ($active_subgroups && ($display_subgroups != 'yes')) {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			// Alphabetic sort
			$options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
			$options['order_by'] = 'ge.name ASC';
			$content = elgg_list_entities($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities($options);
			$title = elgg_echo("groups") . " ($count)";
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
			
		case 'featured':
			$options = array(
					'type' => 'group',
					'metadata_name' => 'featured_group',
					'metadata_value' => 'yes',
					'full_view' => false, 
					'limit' => $limit,
				);
			$content = elgg_list_entities_from_metadata($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_metadata($options);
			$title = elgg_echo("groups") . " ($count)";
			if (!$content) { $content = elgg_echo('groups:nofeatured'); }
			break;
			
		case "member":
			$options = array(
				'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user_guid, 
				'inverse_relationship' => false, 'full_view' => false, 'limit' => $limit,
			);
			if ($active_subgroups && ($display_subgroups != 'yes')) {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities_from_relationship_count($options);
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_relationship_count($options);
			$title = elgg_echo("groups") . " ($count)";
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
			
		case "owner":
			$groups = esope_get_owned_groups($user_guid, 'all');
			$options = array('full_view' => false, 'entities' => $groups);
			//$content = elgg_view_entity_list($groups, $options);
			$content = elgg_list_entities($options);
			// Add title + count
			$count = sizeof($groups);
			$title = elgg_echo("groups") . " ($count)";
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
			
		case 'friends':
			if (elgg_is_logged_in()) {
				//if (!$friends = get_user_friends($user_guid, ELGG_ENTITIES_ANY_VALUE, 0)) {
				$friends = $user->getFriends(array('limit' => 0));
				if (!$friends) {
					$content = elgg_echo('friends:none:you');
				} else {
					$options = array('type' => 'group', 'full_view' => FALSE, 'limit' => $limit,);
					if ($active_subgroups && ($display_subgroups != 'yes')) {
						$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
					}
					foreach ($friends as $friend) { $options['container_guids'][] = $friend->getGUID(); }
					$content = elgg_list_entities_from_metadata($options);
				}
			}
			// Add title + count
			$options['count'] = true;
			$count = elgg_get_entities_from_metadata($options);
			$title = elgg_echo("groups") . " ($count)";
			if (!$content) { $content = elgg_echo('groups:none'); }
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
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
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
		$sidebar .= elgg_view('page/elements/group_tagcloud_block');
	} else {
		$sidebar = elgg_view('groups/find');
	}
	$sidebar .= elgg_view('groups/sidebar/featured');
	
	
	// Add discussions if asked to (default to yes = in a tab)
	if ($groups_discussion == 'always') {
		$discussion = elgg_list_entities(array(
				'type' => 'object', 'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc', 'limit' => $limit, 'full_view' => false,
			));
		if (!$discussion) { $discussion = elgg_echo('discussion:none'); }
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

	
	$groups = esope_get_owned_groups($page_owner->guid, 'all');
	$options = array('full_view' => false, 'entities' => $groups);
	//$content = elgg_view_entity_list($groups, $options);
	$content = elgg_list_entities($options);
	if (!$content) {
		$content = elgg_echo('groups:none');
	}

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
// ESOPE : modified because of the hardcoded 'limit' param
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

	$db_prefix = elgg_get_config('dbprefix');
	$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'type' => 'user',
		//'limit' => 20, // Remove hardcoded limit
		'limit' => (int)get_input('limit', max(20, elgg_get_config('default_limit')), false),
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
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


// Search restrited to group content
function esope_groups_search_page() {
	elgg_push_breadcrumb(elgg_echo('search'));
	include elgg_get_plugins_path() . 'esope/pages/search/index.php';
}

// Search into a group
function esope_groups_groupsearch_page() {
	elgg_push_breadcrumb(elgg_echo('search'));
	include elgg_get_plugins_path() . 'esope/pages/groups/groupsearch.php';
}




