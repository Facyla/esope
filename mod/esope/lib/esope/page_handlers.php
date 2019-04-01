<?php



// Remplace la page d'accueil selon les demandes
// IMPORTANT : ne pas modifier le nom de cette fonction car elle est réécrite par les différents thèmes !! (implique des modifs en série)
function esope_public_index($page) {
	// Remplacement page d'accueil publique - ssi si pas en mode walled_garden
	//$site = elgg_get_site_entity();
	//if (elgg_instanceof($site, 'site') && $site->checkWalledGarden()) {
	if (elgg_get_config('walled_garden')) {
		// NOTE : In walled garden mode, the walled garden page layout is used, not the index hook
		return;
	}
	
	// PARAM : Désactivé si 'no', ou activé avec paramètre de config
	$replace_public_home = elgg_get_plugin_setting('replace_public_homepage', 'esope');
	if ($replace_public_home != 'no') {
		switch($replace_public_home) {
			case 'cmspages':
				include(elgg_get_plugins_path() . 'esope/pages/esope/public_cmshomepage.php');
				break;
			case 'default':
			default:
				include(elgg_get_plugins_path() . 'esope/pages/esope/public_homepage.php');
		}
		return true;
	}
}


// Remplace la page d'accueil connectée selon les demandes
// IMPORTANT : ne pas modifier le nom de cette fonction car elle est réécrite par les différents thèmes !! (implique des modifs en série)
function esope_index($page) {
	// Remplacement page d'accueil par tableau de bord personnel
	// PARAM : Désactivé si 'no', ou activé avec paramètre de config optionnel
	$replace_home = elgg_get_plugin_setting('replace_home', 'esope');
	if ($replace_home != 'no') {
		// Remplace l'index par un tableau de bord légèrement modifié
		include(elgg_get_plugins_path() . 'esope/pages/esope/homepage.php');
		return true;
		
		/* Pour remplacer par une page spécifique
		$replace_home = elgg_get_plugin_setting('replace_home', 'esope');
		if ($replace_home != 'yes') {
			$homepage_test = @fopen(elgg_get_site_url() . $replace_home, 'r'); 
			if ($homepage_test) {
				fclose($$homepage_test);
				forward(elgg_get_site_url() . $replace_home);
			}
		} else {}
		*/
	}
}


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
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			if (!empty($page[2])) { set_input('metadata', $page[2]); }
			include "$base/download_entity_file.php";
			break;
		
		case 'forum_refresh':
			// API : Renvoie les réponses à un sujet de forum (actualisation auto)
			if (isset($page[1])) { set_input('guid', $page[1]); }
			if (isset($page[2])) { set_input('lower_ts', $page[2]); }
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

/* Esope livesearch page handler
 * Tweak search results methods
 * Adds ability to search for objects
 * Format results differently
 * Add return option : user_return = name|username|guid (default)
 */
/**
 * Page handler for autocomplete endpoint.
 *
 * @todo split this into functions/objects, this is way too big
 *
 * /livesearch?q=<query>
 *
 * Other options include:
 *     match_on	   string all or array(groups|users|friends|objects)
 *     match_owner int    0/1
 *     limit       int    default is 10
 *     name        string default "members"
 *
 * @param array $page
 * @return string JSON string is returned and then exit
 * @access private
 */
function esope_input_livesearch_page_handler($page) {
	$dbprefix = elgg_get_config('dbprefix');

	// only return results to logged in users.
	if (!$user = elgg_get_logged_in_user_entity()) {
		exit;
	}

	if (!$q = get_input('term', get_input('q'))) {
		exit;
	}

	$input_name = get_input('name', 'members');

	$q = sanitise_string($q);

	// replace mysql vars with escaped strings
	$q = str_replace(array('_', '%'), array('\_', '\%'), $q);

	$match_on = get_input('match_on', 'all');

	if (!is_array($match_on)) {
		$match_on = array($match_on);
	}

	//$default_limit = elgg_get_config('default_limit');
	$default_limit = 0; // or very high, eg. 500 ?
	$limit = sanitise_int(get_input('limit', $default_limit));
	//error_log("ESOPE livesearch limit = $limit");
	
	// all = users and groups
	if (in_array('all', $match_on)) {
		$match_on = array('users', 'groups', 'objects');
		$default_limit = 3;
	}

	$owner_guid = ELGG_ENTITIES_ANY_VALUE;
	if (get_input('match_owner', false)) {
		$owner_guid = $user->getGUID();
	}
	
	// Note : it requires a custom input/autocomplete view to handle new vars
	// Control input value
	$user_return = get_input('user_return', '');
	if (empty($user_return)) {
		// This is from core : keep it - but which special case should this handle ?
		if (in_array('groups', $match_on)) { $user_return = 'guid'; } else { $user_return = 'username'; }
	} else {
		if (!in_array($user_return, array('name', 'username', 'guid'))) { $user_return = 'guid'; }
	}

	// grab a list of entities and send them in json.
	$results = array();
	foreach ($match_on as $match_type) {
		switch ($match_type) {
			case 'users':
				$options = array(
					'type' => 'user',
					'limit' => $limit,
					'joins' => array("JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid"),
					'wheres' => array(
						"ue.banned = 'no'",
//						"(ue.name LIKE '$q%' OR ue.name LIKE '% $q%' OR ue.username LIKE '$q%')"
						"(ue.name LIKE '%$q%' OR ue.username LIKE '%$q%')"
					)
				);
				
				$entities = elgg_get_entities($options);
				if (!empty($entities)) {
					foreach ($entities as $entity) {
						switch($user_return) {
							case 'name':
								$value = $entity->name;
								break;
							case 'username':
								$value = $entity->username;
								break;
							default:
								$value = $entity->guid;
						}

						$output = elgg_view_list_item($entity, array(
							'use_hover' => false,
							'use_link' => false,
							'class' => 'elgg-autocomplete-item',
							'title' => $entity->name, // Default title would be a link
						));

						$icon = elgg_view_entity_icon($entity, 'tiny', array(
							'use_hover' => false,
						));

						$result = array(
							'type' => 'user',
							'name' => $entity->name,
							'desc' => $entity->username,
							'guid' => $entity->guid,
							'label' => $output,
							'value' => $value,
							'icon' => $icon,
							'url' => $entity->getURL(),
							'html' => elgg_view('input/userpicker/item', array(
								'entity' => $entity,
								'input_name' => $input_name,
							)),
						);
						$results[$entity->name . rand(1, 100)] = $result;
					}
				}
				break;

			case 'groups':
				// don't return results if groups aren't enabled.
				if (!elgg_is_active_plugin('groups')) {
					continue;
				}
				
				$options = array(
					'type' => 'group',
					'limit' => $limit,
					'owner_guid' => $owner_guid,
					'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
					'wheres' => array(
//						"(ge.name LIKE '$q%' OR ge.name LIKE '% $q%' OR ge.description LIKE '% $q%')"
						"(ge.name LIKE '%$q%' OR ge.description LIKE '%$q%')"
					)
				);
				
				$entities = elgg_get_entities($options);
				if (!empty($entities)) {
					foreach ($entities as $entity) {
						$output = elgg_view_list_item($entity, array(
							'use_hover' => false,
							'class' => 'elgg-autocomplete-item',
							'full_view' => false,
							'href' => false,
							'title' => $entity->name, // Default title would be a link
						));

						$icon = elgg_view_entity_icon($entity, 'tiny', array(
							'use_hover' => false,
						));

						$result = array(
							'type' => 'group',
							'name' => $entity->name,
							'desc' => strip_tags($entity->description),
							'guid' => $entity->guid,
							'label' => $output,
							'value' => $entity->guid,
							'icon' => $icon,
							'url' => $entity->getURL(),
						);

						$results[$entity->name . rand(1, 100)] = $result;
					}
				}
				break;

			case 'friends':
				$options = array(
					'type' => 'user',
					'limit' => $limit,
					'relationship' => 'friend',
					'relationship_guid' => $user->getGUID(),
					'joins' => array("JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid"),
					'wheres' => array(
						"ue.banned = 'no'",
						"(ue.name LIKE '$q%' OR ue.name LIKE '% $q%' OR ue.username LIKE '$q%')"
					)
				);
				
				$entities = elgg_get_entities_from_relationship($options);
				if (!empty($entities)) {
					foreach ($entities as $entity) {
						
						$output = elgg_view_list_item($entity, array(
							'use_hover' => false,
							'use_link' => false,
							'class' => 'elgg-autocomplete-item',
							'title' => $entity->name, // Default title would be a link
						));

						$icon = elgg_view_entity_icon($entity, 'tiny', array(
							'use_hover' => false,
						));

						$result = array(
							'type' => 'user',
							'name' => $entity->name,
							'desc' => $entity->username,
							'guid' => $entity->guid,
							'label' => $output,
							'value' => $entity->username,
							'icon' => $icon,
							'url' => $entity->getURL(),
							'html' => elgg_view('input/userpicker/item', array(
								'entity' => $entity,
								'input_name' => $input_name,
							)),
						);
						$results[$entity->name . rand(1, 100)] = $result;
					}
				}
				break;
			
			// ESOPE : add objects livesearch
			case 'objects':
				$options = array(
					'type' => 'object',
					'subtypes' => get_registered_entity_types('object'),
					'limit' => $limit,
					'owner_guid' => $owner_guid,
					'joins' => array("JOIN {$dbprefix}objects_entity oe ON e.guid = oe.guid"),
					'wheres' => array(
						"(oe.title LIKE '%$q%' OR oe.description LIKE '%$q%')"
					)
				);
				
				$entities = elgg_get_entities($options);
				if (!empty($entities)) {
					foreach ($entities as $entity) {
						/*
						$output = elgg_view_list_item($entity, array(
							'use_hover' => false,
							'class' => 'elgg-autocomplete-item',
							'full_view' => false,
							'href' => false,
							'title' => $entity->title, // Default title would be a link
						));
						$output = '<h3><a href="' . $entity->getURL() . '">' . $entity->title . '</a></h3>';
						*/
						$output = '<h3>' . $entity->title . '</h3>';
						if (elgg_instanceof($entity, 'object', 'comment')) {
							$output = '<h3>' . elgg_get_excerpt($entity->description, 100) . '</h3>';
						}

						$icon = elgg_view_entity_icon($entity, 'tiny', array(
							'use_hover' => false,
						));

						$desc = $entity->excerpt;
						if (empty($desc)) { $desc = $entity->briefdescription; }
						if (empty($desc)) { $desc = $entity->description; }
						$desc = elgg_get_excerpt(strip_tags($desc));

						$output = elgg_view_image_block($icon, $output);
						// Make full output clickable
						//$output = '<a href="' . $entity->getURL() . '">' . elgg_view_image_block($icon, $output) . '</a>';

						$result = array(
							'type' => 'object',
							'name' => $entity->name,
							'desc' => $desc,
							'guid' => $entity->guid,
							'label' => $output,
							'value' => $entity->guid,
							'icon' => $icon,
							'url' => $entity->getURL(),
						);

						$results[$entity->name . rand(1, 100)] = $result;
					}
				}
				break;

			default:
				header("HTTP/1.0 400 Bad Request", true);
				echo "livesearch: unknown match_on of $match_type";
				exit;
				break;
		}
	}

	ksort($results);
	header("Content-Type: application/json;charset=utf-8");
	echo json_encode(array_values($results));
	exit;
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

// Enable to list all owner blogs (including those published in groups)
function esope_blog_page_handler($page) {
	elgg_load_library('elgg:blog');
	// push all blogs breadcrumb
	elgg_push_breadcrumb(elgg_echo('blog:blogs'), "blog/all");

	if (!isset($page[0])) { $page[0] = 'all'; }
	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			if (!$user) { forward('', '404'); }
			$use_owner = elgg_get_plugin_setting('blog_user_listall', 'esope');
			if (($use_owner == 'yes') && elgg_instanceof($user, 'user')) {
				$params = blog_get_page_content_list($user->guid, true);
			} else {
				$params = blog_get_page_content_list($user->guid);
			}
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			if (!$user) { forward('', '404'); }
			$params = blog_get_page_content_friends($user->guid);
			break;
		case 'archive':
			$user = get_user_by_username($page[1]);
			if (!$user) { forward('', '404'); }
			$params = blog_get_page_content_archive($user->guid, $page[2], $page[3]);
			break;
		case 'view':
			$params = blog_get_page_content_read($page[1]);
			break;
		/*
		case 'read': // Elgg 1.7 compatibility
			register_error(elgg_echo("changebookmark"));
			forward("blog/view/{$page[1]}");
			break;
		*/
		case 'add':
			elgg_gatekeeper();
			$params = blog_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			elgg_gatekeeper();
			$params = blog_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'group':
			$group = get_entity($page[1]);
			if (!elgg_instanceof($group, 'group')) { forward('', '404'); }
			if (!isset($page[2]) || $page[2] == 'all') {
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
			// Because we want to add discussions (if setting enabled) + alpha order tab + subgroups + other tweaks
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
			// Because we want to get operated groups too (or choose bewteen owned or operated)
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
			// ESOPE: use custom function because au_subgroups lib has hardcoded limit + add invite button for group admins
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

	/*
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
	*/

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
			elgg_gatekeeper();
			include "$pages/add.php";
			break;

		case "edit":
			elgg_gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;

		case 'group':
			elgg_group_gatekeeper();
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
// @TODO use views instead
function esope_profile_page_handler($page) {
	
	// Add some custom settings
	$remove_profile_widgets = elgg_get_plugin_setting('remove_profile_widgets', 'esope');
	$add_profile_activity = elgg_get_plugin_setting('add_profile_activity', 'esope');
	$custom_profile_layout = elgg_get_plugin_setting('custom_profile_layout', 'esope');
	$add_comments = elgg_get_plugin_setting('add_profile_comments', 'esope');
	
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
		//$base_dir = elgg_get_root_path();
		//require "{$base_dir}pages/profile/edit.php";
		echo elgg_view_resource('profile/edit');
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


// Replaces Digest page handler so we can use a custom test page ?
// Disabled because produces an empty digest
/*
function esope_digest_page_handler($page) {
	$base = elgg_get_plugins_path() . 'digest/';
	$alt_base = elgg_get_plugins_path() . 'esope/pages/digest/';
	switch ($page[0]) {
		case "test":
			include($alt_base . "test.php");
			break;
		case "show":
			include($base . "pages/show.php");
			break;
		case "unsubscribe":
			include($base . "procedures/unsubscribe.php");
			break;
		case "user":
		default:
			if (!empty($page[1])) {
				set_input("username", $page[1]);
			}
			include($base . "pages/usersettings.php");
			break;
	}
	return true;
}
*/
/**
 * Serves the content for the embed lightbox
 *
 * @param array $page URL segments
 * 
 * ESOPE : enable admin to use the same way as members
 */
function esope_embed_page_handler($page) {

	$container_guid = (int)get_input('container_guid');
	if ($container_guid) {
		$container = get_entity($container_guid);

//		if (elgg_instanceof($container, 'group') && $container->isMember()) {
		if (elgg_instanceof($container, 'group') && ($container->isMember() || $container->canEdit())) {
			// embedding inside a group so save file to group files
			elgg_set_page_owner_guid($container_guid);
		}
	}

	set_input('page', $page[1]); 

	echo elgg_view('embed/layout');

	// exit because this is in a modal display.
	exit;
}



