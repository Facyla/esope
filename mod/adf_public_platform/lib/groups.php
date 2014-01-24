<?php
/**
 * Groups function library
 */

/**
 * List all groups
 */
function adf_platform_groups_handle_all_page() {
	$groups_alpha = elgg_get_plugin_setting('groups_alpha', 'adf_public_platform');
	$groups_discussion = elgg_get_plugin_setting('groups_discussion', 'adf_public_platform');
	$db_prefix = elgg_get_config('dbprefix');
	if (elgg_is_active_plugin('au_subgroups')) {
		$display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
		$display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
	} else $display_subgroups = false;

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

	switch ($selected_tab) {
		
		case 'popular':
			$options = array(
				'type' => 'group', 'relationship' => 'member', 'inverse_relationship' => false,
				'full_view' => false, 'limit' => $limit,
			);
			if ($display_subgroups != 'yes') {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities_from_relationship_count($options);
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
			
		case 'friends':
			if (elgg_is_logged_in()) {
				$user_guid = elgg_get_logged_in_user_guid();
				if (!$friends = get_user_friends($user_guid, ELGG_ENTITIES_ANY_VALUE, 0)) {
					$content = elgg_echo('friends:none:you');
				} else {
					$options = array('type' => 'group', 'full_view' => FALSE, 'limit' => $limit,);
					if ($display_subgroups != 'yes') {
						$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
					}
					foreach ($friends as $friend) { $options['container_guids'][] = $friend->getGUID(); }
					$content = elgg_list_entities_from_metadata($options);
					if (!$content) { $content = elgg_echo('groups:none'); }
				}
			}
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
			
		case 'discussion':
			$content = elgg_list_entities(array(
				'type' => 'object', 'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc',
				'limit' => $limit, 'full_view' => false,
			));
			if (!$content) { $content = elgg_echo('discussion:none'); }
			break;
			
		case 'alpha':
			$options = array('type' => 'group', 'full_view' => false, 'limit' => $limit);
			if ($display_subgroups != 'yes') {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			// Alphabetic sort
			$options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
			$options['order_by'] = 'ge.name ASC';
			$content = elgg_list_entities($options);
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
			
		case 'newest':
		default:
			$options = array('type' => 'group', 'full_view' => false, 'limit' => $limit);
			if ($display_subgroups != 'yes') {
				$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
			}
			$content = elgg_list_entities($options);
			if (!$content) { $content = elgg_echo('groups:none'); }
			break;
	}

	//$filter = elgg_view('groups/find');
	$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));
	
	// Add tags blocks before featured groups if search enabled
	$groups_search = elgg_get_plugin_setting('groups_searchtab', 'adf_public_platform');
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
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page(elgg_echo('groups:all'), $body);
}



/* Liste les groupes dont on est owner ou operator (si le plugin est activé) */
function adf_platform_groups_handle_owned_page() {

	$page_owner = elgg_get_page_owner_entity();

	if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('groups:owned');
	} else {
		$title = elgg_echo('groups:owned:user', array($page_owner->name));
	}
	elgg_push_breadcrumb($title);

	elgg_register_title_button();

	
	$groups = esope_get_owned_groups($page_owner->guid, 'all');
	$options = array('full_view' => false);
	$content = elgg_view_entity_list($groups, $options);
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



function esope_groups_search_page() {
	elgg_push_breadcrumb(elgg_echo('search'));
	include elgg_get_plugins_path() . 'adf_public_platform/pages/search/index.php';
}

function esope_groups_groupsearch_page() {
	elgg_push_breadcrumb(elgg_echo('search'));
	include elgg_get_plugins_path() . 'adf_public_platform/pages/groups/groupsearch.php';
}


