<?php
/* Helpers and other Inria specific functions
 * 
 */

// INDEX PAGES

// Theme inria logged in index page
function theme_inria_index($page) {
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/loggedin_homepage.php');
	return true;
}

// Theme inria public index page
function theme_inria_public_index($page) {
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/public_homepage.php');
	return true;
}



// New "inria/" page handler
function inria_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/';
	switch($page[0]){
		case "userimage":
			include($base . 'userimage.php');
			break;
		case "userprofile":
			include($base . 'userprofile.php');
			break;
		case "usergroups":
			include($base . 'usergroups.php');
			break;
		case "linkedin":
			include($base . 'linkedin_profile_update.php');
			break;
		/*
		case "invite":
			include($base . 'invite_external.php');
			break;
		*/
		case "animation":
			include($base . 'admin_tools.php');
			break;
		case "share_url_generator":
			include($base . 'share_url_generator.php');
			break;
		case 'admin_cron':
			if (elgg_is_admin_logged_in()) {
				theme_inria_daily_cron('cron', 'daily', '', array('force' => 'yes'));
			}
			break;
		default:
			include($base . 'index.php');
	}
	return true;
}

// New "ressources/" page handler
function inria_ressources_page_handler($page) {
	//elgg_load_library('elgg:groups');
	$base = elgg_get_plugins_path() . 'theme_inria/pages/ressources/';
	$page_type = $page[0];
	// Only valid URL model : ressources/group/GUID/all (or without 'all')
	if (isset($page[1])) set_input('guid', $page[2]);
	switch ($page_type) {
		case 'group':
			include $base . 'group_ressources.php';
			break;
		default:
			return false;
	}
	return true;
}

// Override pour ajouter une explication sur la page thewire/all
function theme_inria_thewire_page_handler($page) {
	$base = elgg_get_plugins_path() . 'thewire/pages/thewire/';
	$esope_base = elgg_get_plugins_path() . 'esope/pages/thewire/';
	$inria_base = elgg_get_plugins_path() . 'theme_inria/pages/thewire/';
	if (!isset($page[0])) {
		$page = array('all');
	}

	switch ($page[0]) {
		case "all":
			include $inria_base . "everyone.php";
			break;

		case "friends":
			include $base . "friends.php";
			break;

		case "owner":
			include $base . "owner.php";
			break;

		case "group":
			//if (isset($page[1])) { set_input('guid', $page[1]); }
			include $esope_base . "group.php";
			break;

		case "view":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include $base . "view.php";
			break;

		case "thread":
			if (isset($page[1])) {
				set_input('thread_id', $page[1]);
			}
			include $base . "thread.php";
			break;

		case "reply":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include $base . "reply.php";
			break;

		case "tag":
			if (isset($page[1])) {
				set_input('tag', $page[1]);
			}
			include $base . "tag.php";
			break;

		case "previous":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include $base . "previous.php";
			break;

		default:
			return false;
	}
	return true;
}


// Override river PH to add an info block
function theme_inria_elgg_river_page_handler($page) {
	// make a URL segment available in page handler script
	$page_type = elgg_extract(0, $page, 'all');
	$page_type = preg_replace('[\W]', '', $page_type);
	switch($page_type) {
		case 'mine':
			elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
			$page_type = 'mine';
			break;
		case 'friends':
			elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
			$page_type = 'friends';
			break;
		case 'owner':
			$page_type = 'owner';
			if (empty($page[1])) {
				elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
				$page_type = 'mine';
			} else {
				set_input('username', $page[1]);
			}
			break;
		default:
			$page_type = 'all';
	}
	set_input('page_type', $page_type);

	require_once(elgg_get_plugins_path() . "theme_inria/pages/river.php");
	return true;
}




/**
 * Profile page handler
 *
 * @param array $page Array of URL segments passed by the page handling mechanism
 * @return bool
 */
// @TODO use views instead
function theme_inria_profile_page_handler($page) {
	
	// Add some custom settings
	$remove_profile_widgets = elgg_get_plugin_setting('remove_profile_widgets', 'esope');
	$add_profile_activity = elgg_get_plugin_setting('add_profile_activity', 'esope');
	$custom_profile_layout = elgg_get_plugin_setting('custom_profile_layout', 'esope');
	$add_comments = elgg_get_plugin_setting('add_profile_comments', 'esope');
	// Iris v2
	$remove_profile_widgets = 'yes';
	$add_profile_activity = 'no';
	$custom_profile_layout = 'no';
	$add_comments = 'no';
	
	if (isset($page[0])) {
		$username = $page[0];
		$user = get_user_by_username($username);
		elgg_set_page_owner_guid($user->guid);
	} elseif (elgg_is_logged_in()) {
		forward(elgg_get_logged_in_user_entity()->getURL());
	}

	// short circuit if invalid or banned username
	if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
		register_error(elgg_echo('profile:notfound'));
		forward();
	}

	$action = NULL;
	if (isset($page[1])) { $action = $page[1]; }

	if ($action == 'edit') {
		// use the core profile edit page
		$base_dir = elgg_get_root_path();
		require "{$base_dir}pages/profile/edit.php";
		return true;
	}

	// main profile page
	// Theme settings : Custom profile layout ? (default: no)
	if ($custom_profile_layout == 'yes') {
		
		$content = elgg_view('esope/profile/wrapper');
		
	} else {
		
		// Classic layout + some theme options
		$content = elgg_view('profile/wrapper');
		
		// Theme settings : Remove widgets ? (default: no)
		if ($remove_profile_widgets != 'yes') {
			$params = array('content' => $content, 'num_columns' => 3);
			$content = elgg_view_layout('widgets', $params);
		}
		
		// Theme settings : Add activity feed ? (default: no)
		if ($add_profile_activity == 'yes') {
			$db_prefix = elgg_get_config('dbprefix');
			$activity = elgg_view('user/elements/activity', array('entity' => $user));
			$content .= '<div class="profile-activity-river">' . $activity . '</div>';
		}
	}
	
	if ($add_comments == 'yes') {
		$content .= elgg_view('user/elements/comments', array('entity' => $user));
	}
	
	$body = elgg_view_layout('one_column', array('content' => $content));
	echo elgg_view_page($user->name, $body);
	return true;
}



// New "ressources/" page handler
function theme_inria_members_page_handler($page) {
	//elgg_load_library('elgg:groups');
	$base = elgg_get_plugins_path() . 'theme_inria/pages/';
	$page_type = $page[0];
	//if (isset($page[1])) set_input('guid', $page[2]);
	/*
	switch ($page_type) {
		default:
			include $base . 'members.php';
			return false;
	}
	*/
	include $base . 'members.php';
	return true;
}

// New "ressources/" page handler
function theme_inria_search_page_handler($page) {
	// if there is no q set, we're being called from a legacy installation
	// it expects a search by tags.
	// actually it doesn't, but maybe it should.
	// maintain backward compatibility
	if(!get_input('q', get_input('tag', NULL))) {
		set_input('q', $page[0]);
		//set_input('search_type', 'tags');
	}
	$base = elgg_get_plugins_path() . 'theme_inria/pages/search/';
	include_once($base . 'index.php');
	return true;
}


function theme_inria_groups_page_handler($page) {
	elgg_load_library('elgg:groups');
	elgg_load_library('elgg:group_operators');
	elgg_load_library('elgg:esope:groups');

	elgg_push_breadcrumb(elgg_echo('groups'), "groups/all");
	$esope_base = elgg_get_plugins_path() . 'esope/pages/';
	$iris_base = elgg_get_plugins_path() . 'theme_inria/pages/';

	set_input('group_layout_header', false); // Default to no header, add it for appropriate pages only
	switch ($page[0]) {
		case 'file':
			if (isset($page[1])) { set_input("guid",$page[1]); }
			if (isset($page[2])) { set_input("name",$page[2]); }
			include($iris_base . 'groups/file.php');
			break;
		
		// Internal group search = regular search in group interface/context
		/*
		case 'groupsearch':
			if (!empty($page[1])) set_input('q', $page[1]);
			esope_groups_groupsearch_page();
			break;
		*/
		case 'search':
			// No group set : use group search instead
			if (empty($page[1])) { forward('groups'); }
			set_input('container_guid', $page[1]);
			elgg_set_page_owner_guid($page[1]);
			set_input('group_layout_header', 'yes');
			if (!empty($page[2])) { set_input('q', $page[2]); }
			include_once(elgg_get_plugins_path() . 'theme_inria/pages/search/index.php');
			//esope_groups_search_page();
			break;
		case 'owner': forward('groups?filter=owner'); break;
		// Iris note : cannot view other user groups anymore (now in profile)
		case 'member':
			//forward('groups?filter=member');
			set_input('filter', 'member');
			include $iris_base . 'groups.php';
			break;
		case 'discover':
			if (!empty($page[1])) { forward('groups?community=' . $page[1]); }
			set_input('filter', 'discover');
			include $iris_base . 'groups.php';
			break;
		
		case 'add':
			elgg_push_context('groups_add');
			set_input('group_layout_header', 'yes');
			//groups_handle_edit_page('add');
			echo elgg_view('resources/groups/edit', array('page' => 'add', 'group_guid' => $page[1]));
			break;
		case 'edit':
			elgg_push_context('group_edit');
			set_input('group_layout_header', 'yes');
			//groups_handle_edit_page('edit', $page[1]);
			echo elgg_view('resources/groups/edit', array('page' => 'edit', 'group_guid' => $page[1]));
			break;
		
		case 'profile':
			set_input('group_layout_header', 'yes');
			//groups_handle_profile_page($page[1]);
			echo elgg_view('resources/groups/profile', array('group_guid' => $page[1]));
			return true;
			break;
		case 'activity': // detailed profile activity
			set_input('group_layout_header', 'yes');
			groups_handle_activity_page($page[1]);
			break;
		case 'workspace':
			set_input('group_layout_header', 'yes');
			echo elgg_view('resources/groups/workspace', array('group_guid' => $page[1]));
			return true;
		case 'content':
			elgg_push_context('group_content');
			if (empty($page[2])) { forward('groups/workspace/'.$page[1]); }
			set_input('subtype', $page[2]);
			elgg_push_context($page[2]); // set subtype context
			set_input('filter', $page[3]);
			echo elgg_view('resources/groups/content', array('group_guid' => $page[1]));
			return true;
		
		case 'members':
			elgg_push_context('group_members');
			set_input('group_layout_header', 'yes');
			// ESOPE: use custom function because au_subgroups lib has hardcoded limit + add invite button for group admins
			//esope_groups_handle_members_page($page[1]);
			echo elgg_view('resources/groups/members', array('group_guid' => $page[1]));
			break;
		case 'invitations':
			set_input('group_layout_header', 'yes');
			set_input('username', $page[1]);
			groups_handle_invitations_page();
			break;
		case 'invite':
			elgg_push_context('group_invites');
			set_input('group_layout_header', 'yes');
			//groups_handle_invite_page($page[1]);
			echo elgg_view('resources/groups/invite', array('group_guid' => $page[1]));
			break;
		case 'requests':
			set_input('group_layout_header', 'yes');
			groups_handle_requests_page($page[1]);
			break;
		
		case 'all':
		case 'groupsearch':
			if (!empty($page[1])) { set_input('q', $page[1]); }
			include $iris_base . 'groups.php';
			break;
		default:
			if (!empty($page[0])) { set_input('q', $page[0]); }
			include $iris_base . 'groups.php';
	}
	return true;
}


function theme_inria_group_operators_page_handler($page) {
	if (isset($page[0])) {
		$file_dir = elgg_get_plugins_path() . 'group_operators/pages/group_operators';
		$page_type = $page[0];
		switch($page_type) {
			case 'manage':
				set_input('group_layout_header', 'yes');
				set_input('group_guid', $page[1]);
				include "$file_dir/manage.php";
				return true; // Facyla 20111123
				break;
		}
	}
}


function theme_inria_au_subgroups_page_handler($page) {
	
	// dirty check to avoid duplicate page handlers
	// since this should only be called from the route, groups hook
	if (strpos(current_page_url(), elgg_get_site_url() . 'au_subgroups') === 0) {
		return false;
	}
	
	set_input('group_layout_header', 'yes');
	switch ($page[0]) {
		case 'add':
			elgg_push_context('groups_add');
			set_input('au_subgroup', true);
			set_input('au_subgroup_parent_guid', $page[1]);
			elgg_set_page_owner_guid($page[1]);
			echo elgg_view('resources/au_subgroups/add');
			return true;
			break;
		
		case 'list':
			elgg_set_page_owner_guid($page[1]);
			echo elgg_view('resources/au_subgroups/list');
			break;
		
		case 'delete':
			elgg_set_page_owner_guid($page[1]);
			echo elgg_view('resources/au_subgroups/delete');
			break;
		
		case 'openclosed':
			set_input('filter', $page[1]);
			echo elgg_view('resources/au_subgroups/openclosed');
			return true;
			break;
	}
	
	return false;
}



