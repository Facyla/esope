<?php

function esope_page_handler($page) {
	$base = elgg_get_plugins_path() . 'esope/pages/esope';
	switch ($page[0]) {
		case 'tools':
			// Index des outils (principalement admin)
			// These tools are handy for administrators and allow them to perform some exceptional tasks.
			// Note : allowed tools must be checked before any inclusion...
			$allowed_tools = esope_admin_tools_list();
			if (!empty($page[1]) && in_array($page[1], $allowed_tools)) {
				include "$base/tools/{$page[1]}.php";
			} else {
				include "$base/tools.php";
			}
			break;
		case 'statistics':
			// Page de statistiques à destination des admins, mais avec divers éléments accessibles à d'autres personnes (configurables)
			include "$base/statistics.php";
			break;
		case 'group_requests':
			// Page de listing de requêtes en attente (pour rejoindre un groupe)
			include "$base/group_requests.php";
			break;
		
		case 'download_entity_file':
			if (!empty($page[1])) set_input('guid', $page[1]);
			if (!empty($page[2])) set_input('metadata', $page[2]);
			include "$base/download_entity_file.php";
			break;
		
		case 'forum_refresh':
			// API : Renvoie les réponses à un sujet de forum (actualisation auto)
			if (isset($page[1])) set_input('guid', $page[1]);
			if (isset($page[2])) set_input('lower_ts', $page[2]);
			include "$base/forum_refresh.php";
			break;
		
		// Used to provide JSON config or HTML templates for wysiwyg editors
		// Note : prefered cached JS view
		/*
		case 'templates':
			if (isset($page[1])) set_input('mode', $page[1]); // config or html
			if (isset($page[2])) set_input('editor', $page[2]); // if config, the used editor
			include "$base/templates.php";
			break;
		*/
		
		default:
	}
	return true;
}



// Esope search page handler
function esope_esearch_page_handler($page) {
	$base = elgg_get_plugins_path() . 'esope/pages/esope';
	require_once "$base/esearch.php";
	return true;
}



// Esope liked content page handler
function esope_likes_page_handler($page) {
	$base = elgg_get_plugins_path() . 'esope/pages/likes';
	require_once "$base/liked_content.php";
	return true;
}



/* Modification members */
function esope_members_page_handler($page) {
	$base = elgg_get_plugins_path() . 'members/pages/members';
	$alt_base = elgg_get_plugins_path() . 'esope/pages/members';
	$members_alpha = elgg_get_plugin_setting('members_alpha', 'esope');
	if (!isset($page[0])) {
		if ($members_alpha == 'yes') $page[0] = 'alpha';
		else $page[0] = 'online';
	}
	$vars = array();
	$vars['page'] = $page[0];
	if ($page[0] == 'search') {
		$vars['search_type'] = $page[1];
		require_once "$alt_base/search.php";
	} else {
		require_once "$alt_base/index.php";
	}
	return true;
}

function esope_pages_page_handler($page) {
	elgg_load_library('elgg:pages');
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');
	if (!isset($page[0])) { $page[0] = 'all'; }
	elgg_push_breadcrumb(elgg_echo('pages'), 'pages/all');
	$base_dir = elgg_get_plugins_path() . 'pages/pages/pages';
	$alt_base_dir = elgg_get_plugins_path() . 'esope/pages/pages';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$alt_base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$alt_base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$alt_base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$alt_base_dir/edit.php";
			break;
		case 'group':
			include "$alt_base_dir/owner.php";
			break;
		case 'history':
			set_input('guid', $page[1]);
			include "$base_dir/history.php";
			break;
		case 'revision':
			set_input('id', $page[1]);
			include "$base_dir/revision.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		default:
			return false;
	}
	return true;
}

function esope_blog_page_handler($page) {
	elgg_load_library('elgg:blog');
	// forward to correct URL for blog pages pre-1.8
	blog_url_forwarder($page);
	// push all blogs breadcrumb
	elgg_push_breadcrumb(elgg_echo('blog:blogs'), "blog/all");

	if (!isset($page[0])) { $page[0] = 'all'; }
	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			$use_owner = elgg_get_plugin_setting('blog_user_listall', 'esope');
			if (($use_owner == 'yes') && elgg_instanceof($user, 'user')) $params = blog_get_page_content_list($user->guid, true);
			else $params = blog_get_page_content_list($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			$params = blog_get_page_content_friends($user->guid);
			break;
		case 'archive':
			$user = get_user_by_username($page[1]);
			$params = blog_get_page_content_archive($user->guid, $page[2], $page[3]);
			break;
		case 'view':
			$params = blog_get_page_content_read($page[1]);
			break;
		case 'read': // Elgg 1.7 compatibility
			register_error(elgg_echo("changebookmark"));
			forward("blog/view/{$page[1]}");
			break;
		case 'add':
			gatekeeper();
			$params = blog_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			gatekeeper();
			$params = blog_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'group':
			if ($page[2] == 'all') {
				$params = blog_get_page_content_list($page[1]);
			} else {
				$params = blog_get_page_content_archive($page[1], $page[3], $page[4]);
			}
			break;
		case 'all':
			$params = blog_get_page_content_list();
			break;
		default:
			return false;
	}

	if (isset($params['sidebar'])) {
		$params['sidebar'] .= elgg_view('blog/sidebar', array('page' => $page_type));
	} else {
		$params['sidebar'] = elgg_view('blog/sidebar', array('page' => $page_type));
	}

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
	return true;
}


function esope_search_page_handler($page) {
	// if there is no q set, we're being called from a legacy installation
	// it expects a search by tags.
	// actually it doesn't, but maybe it should.
	// maintain backward compatibility
	if(!get_input('q', get_input('tag', NULL))) {
		set_input('q', $page[0]);
		//set_input('search_type', 'tags');
	}
	$base_dir = elgg_get_plugins_path() . 'esope/pages/search';
	include_once("$base_dir/index.php");
	return true;
}


function esope_groups_page_handler($page) {
	elgg_load_library('elgg:groups');
	elgg_load_library('elgg:esope:groups');

	elgg_push_breadcrumb(elgg_echo('groups'), "groups/all");

	switch ($page[0]) {
		case 'all':
			esope_groups_handle_all_page();
			break;
		case 'search':
			if (!empty($page[1])) set_input('container_guid', $page[1]);
			if (!empty($page[2])) set_input('q', $page[2]);
			esope_groups_search_page();
			break;
		case 'groupsearch':
			if (!empty($page[1])) set_input('q', $page[1]);
			esope_groups_groupsearch_page();
			break;
		case 'owner':
			//groups_handle_owned_page();
			esope_groups_handle_owned_page();
			break;
		case 'member':
			set_input('username', $page[1]);
			groups_handle_mine_page();
			break;
		case 'invitations':
			set_input('username', $page[1]);
			groups_handle_invitations_page();
			break;
		case 'add':
			groups_handle_edit_page('add');
			break;
		case 'edit':
			groups_handle_edit_page('edit', $page[1]);
			break;
		case 'profile':
			groups_handle_profile_page($page[1]);
			break;
		case 'activity':
			groups_handle_activity_page($page[1]);
			break;
		case 'members':
			esope_groups_handle_members_page($page[1]);
			break;
		case 'invite':
			groups_handle_invite_page($page[1]);
			break;
		case 'requests':
			groups_handle_requests_page($page[1]);
			break;
		case 'subgroups':
			// AU subgroups will add the breacrumb so avoid duplicating
			elgg_pop_breadcrumb();
			switch ($page[1]) {
				case 'add':
					set_input('au_subgroup', true);
					set_input('au_subgroup_parent_guid', $page[2]);
					elgg_set_page_owner_guid($page[2]);
					echo elgg_view('resources/au_subgroups/add');
					return true;
					break;
				case 'list':
					elgg_set_page_owner_guid($page[2]);
					echo elgg_view('resources/au_subgroups/list');
					break;
				case 'delete':
					elgg_set_page_owner_guid($page[2]);
					echo elgg_view('resources/au_subgroups/delete');
					break;
				case 'openclosed':
					set_input('filter', $page[2]);
					echo elgg_view('resources/au_subgroups/openclosed');
					return true;
					break;
			}
			break;
		default:
			return false;
	}
	return true;
}

function esope_categories_page_handler() {
	include elgg_get_plugins_path() . 'esope/pages/categories/listing.php';
	return true;
}


// Handle file page handler
function esope_file_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$file_dir = elgg_get_plugins_path() . 'file/pages/file';
	$custom_file_dir = elgg_get_plugins_path() . 'esope/pages/file';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			file_register_toggle();
			include "$custom_file_dir/owner.php";
			break;
		case 'friends':
			file_register_toggle();
			include "$file_dir/friends.php";
			break;
		case 'read': // Elgg 1.7 compatibility
			register_error(elgg_echo("changebookmark"));
			forward("file/view/{$page[1]}");
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$file_dir/view.php";
			break;
		case 'add':
			include "$file_dir/upload.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$file_dir/edit.php";
			break;
		case 'search':
			file_register_toggle();
			include "$file_dir/search.php";
			break;
		case 'group':
			file_register_toggle();
			include "$file_dir/owner.php";
			break;
		case 'all':
			file_register_toggle();
			include "$file_dir/world.php";
			break;
		case 'download':
			set_input('guid', $page[1]);
			include "$file_dir/download.php";
			break;
		default:
			return false;
	}
	return true;
}


function esope_bookmarks_page_handler($page) {
	elgg_load_library('elgg:bookmarks');
	if (!isset($page[0])) { $page[0] = 'all'; }
	elgg_push_breadcrumb(elgg_echo('bookmarks'), 'bookmarks/all');

	// old group usernames
	if (substr_count($page[0], 'group:')) {
		preg_match('/group\:([0-9]+)/i', $page[0], $matches);
		$guid = $matches[1];
		if ($entity = get_entity($guid)) {
			bookmarks_url_forwarder($page);
		}
	}

	// user usernames
	$user = get_user_by_username($page[0]);
	if ($user) {
		bookmarks_url_forwarder($page);
	}

	$pages = elgg_get_plugins_path() . 'bookmarks/pages/bookmarks';
	$custom_pages = elgg_get_plugins_path() . 'esope/pages/bookmarks';

	switch ($page[0]) {
		case "all":
			include "$pages/all.php";
			break;

		case "owner":
			include "$custom_pages/owner.php";
			break;

		case "friends":
			include "$pages/friends.php";
			break;

		case "view":
			set_input('guid', $page[1]);
			include "$pages/view.php";
			break;
		case 'read': // Elgg 1.7 compatibility
			register_error(elgg_echo("changebookmark"));
			forward("bookmarks/view/{$page[1]}");
			break;

		case "add":
			gatekeeper();
			include "$pages/add.php";
			break;

		case "edit":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;

		case 'group':
			group_gatekeeper();
			include "$pages/owner.php";
			break;

		case "bookmarklet":
			set_input('container_guid', $page[1]);
			include "$pages/bookmarklet.php";
			break;

		default:
			return false;
	}

	elgg_pop_context();
	return true;
}

/**
 * Profile page handler
 *
 * @param array $page Array of URL segments passed by the page handling mechanism
 * @return bool
 */
function esope_profile_page_handler($page) {
	
	// Add some custom settings
	$remove_profile_widgets = elgg_get_plugin_setting('remove_profile_widgets', 'esope');
	$add_profile_activity = elgg_get_plugin_setting('add_profile_activity', 'esope');
	$custom_profile_layout = elgg_get_plugin_setting('custom_profile_layout', 'esope');
	
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
			$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 20, 'pagination' => true));
			$content .= '<div class="profile-activity-river">' . $activity . '</div>';
		}
	}
	
	$body = elgg_view_layout('one_column', array('content' => $content));
	echo elgg_view_page($user->name, $body);
	return true;
}


function esope_messages_page_handler($page) {
	$current_user = elgg_get_logged_in_user_entity();
	if (!$current_user) {
		register_error(elgg_echo('noaccess'));
		$_SESSION['last_forward_from'] = current_page_url();
		forward('');
	}

	elgg_load_library('elgg:messages');

	elgg_push_breadcrumb(elgg_echo('messages'), 'messages/inbox/' . $current_user->username);

	if (!isset($page[0])) { $page[0] = 'inbox'; }

	// Support the old inbox url /messages/<username>, but only if it matches the logged in user.
	// Otherwise having a username like "read" on the system could confuse this function.
	if ($current_user->username === $page[0]) {
		$page[1] = $page[0];
		$page[0] = 'inbox';
	}

	if (!isset($page[1])) { $page[1] = $current_user->username; }

	$base_dir = elgg_get_plugins_path() . 'messages/pages/messages';
	$custom_dir = elgg_get_plugins_path() . 'esope/pages/messages';

	switch ($page[0]) {
		case 'inbox':
			set_input('username', $page[1]);
			include("$custom_dir/inbox.php");
			break;
		case 'unread':
			// Note : la page inbox intègre un switch, version alternative avec une page spécifique, qui nécessiterait l'ajout d'un menu'
			set_input('username', $page[1]);
			include("$custom_dir/unread.php");
			break;
		case 'sent':
			set_input('username', $page[1]);
			include("$base_dir/sent.php");
			break;
		case 'read':
			set_input('guid', $page[1]);
			include("$custom_dir/read.php");
			break;
		case 'compose':
		case 'add':
			include("$base_dir/send.php");
			break;
		default:
			return false;
	}
	return true;
}

