<?php
/**
 * theme_compnum
 *
 * @package theme_compnum
 *
 */

elgg_register_event_handler('init', 'system', 'theme_compnum_init');
elgg_register_event_handler("pagesetup", "system", "theme_compnum_pagesetup"); // Menu

/**
 * Init theme plugin.
 */
function theme_compnum_init() {
	
	elgg_extend_view('css', 'theme_compnum/css');
	
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_compnum_index');
	} else {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
		elgg_register_plugin_hook_handler('index','system','theme_compnum_public_index');
	}
	
	// Suppression radicale des outils du groupe (PR => 2 modifs dans le start des plugins et 1 dans group_module)
	//remove_group_tool_option('forum');
	remove_group_tool_option('blog');
	remove_group_tool_option('bookmarks');
	//remove_group_tool_option('file');
	//remove_group_tool_option('pages');
	
	// Ajoute le widget de complétion du profil sous les infos du profil
	elgg_extend_view('profile/owner_block', 'profile_manager/profile_completeness', 800);
	
	// Supprime le lien vers les wikis perso de l'owner_block
	elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'pages_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_compnum_pages_owner_block_menu');
	// Supprime le lien vers les blogs perso de l'owner_block
	elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'blog_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_compnum_blog_owner_block_menu');
	// Supprime le lien vers les fichiers perso de l'owner_block
	elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'file_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_compnum_file_owner_block_menu');
	
	// Réécriture du page_handler des wikis : permet de supprimer les filtres
	elgg_register_page_handler('pages', 'theme_compnum_pages_page_handler');
	
	// Réécriture du page_handler des membres : ajout de nouveaux filtres
	elgg_register_page_handler('members', 'theme_compnum_members_page_handler');
	
	// Droits d'accès : on veut tous les groupes (or le hook de groupes filtre)
	elgg_unregister_plugin_hook_handler('access:collections:write', 'all', 'groups_write_acl_plugin_hook');
	elgg_register_plugin_hook_handler('access:collections:write', 'all', 'theme_compnum_groups_write_acl_plugin_hook');
	
}



function theme_compnum_members_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_compnum/pages/members';
	if (!isset($page[0])) { $page[0] = 'newest'; }
	$vars = array();
	$vars['page'] = $page[0];
	if ($page[0] == 'search') {
		$vars['search_type'] = $page[1];
		require_once "$base/search.php";
	} else {
		require_once "$base/index.php";
	}
	return true;
}


/* On repart de la fonction modifiée qui corrige qqs bugs */
function theme_compnum_pages_page_handler($page) {
	elgg_load_library('elgg:pages');
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');
	if (!isset($page[0])) { $page[0] = 'all'; }
	elgg_push_breadcrumb(elgg_echo('pages'), 'pages/all');
	$base_dir = elgg_get_plugins_path() . 'pages/pages/pages';
	$alt_base_dir = elgg_get_plugins_path() . 'adf_public_platform/pages/pages';
	$page_type = $page[0];
	if (in_array($page_type, array('owner', 'friends'))) $page_type = 'all';
	switch ($page_type) {
		/*
		case 'owner':
			include "$alt_base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		*/
		case 'view':
			set_input('guid', $page[1]);
			include "$alt_base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
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
			include "$base_dir/world.php";
			//return false;
	}
	return true;
}


/*
*/
function theme_compnum_pagesetup() {
	global $CONFIG;
	$page_owner = elgg_get_page_owner_entity();
	
	//echo print_r($CONFIG->menus, true);
	
	// Supprime le lien pour créer un wiki personnel
	if (elgg_in_context('pages') && !elgg_instanceof($page_owner, 'group')) { elgg_unregister_menu_item('title', 'add'); }
	
	// Ajoute un lien pour créer des comptes à partir du menu Inviter des groupes
	// Note : pas de contexte spécifique, donc on bidouille un peu pour savoir si on est au bon endroit
	// Autre piste : via l'url ?
	if (elgg_get_context() == "groups") {
		$breadcrumbs = elgg_get_breadcrumbs();
		$invite_title = elgg_echo('groups:invite');
		if ($breadcrumbs) foreach ($breadcrumbs as $breadcrumb) {
			if ($breadcrumb['title'] == $invite_title) { $add_menu = true; break; }
		}
		if ($add_menu) {
			elgg_register_menu_item('title', array(
					'name' => 'create-users',
					'title' => elgg_echo('theme_compnum:newusers:help'),
					'text' => elgg_echo('theme_compnum:newusers'),
					'href' => $CONFIG . 'dossierdepreuve/inscription?group_guid=' . $page_owner->guid,
					'link_class' => 'elgg-button elgg-button-action',
				));
		}
	}
	
	// Retire les demandes de contact des messages
	// Modifie les menus des contacts et annuaire
		//if ((elgg_get_context() == "friends") || (elgg_get_context() == "members")) {
		if (elgg_get_context() == "friends") {
			elgg_register_menu_item("page", array(
					'name' => 'members', 'href' => $CONFIG->url . 'members', 
					'title' => elgg_echo('theme_compnum:directory:help'), 'text' => elgg_echo('theme_compnum:directory'), 
					"section" => "directory",
				));
			elgg_register_menu_item("page", array(
					'name' => 'members-organisation', 'href' => $CONFIG->url . 'members/organisation', 
					'title' => elgg_echo('theme_compnum:directory:organisation:help'), 
					'text' => elgg_echo('theme_compnum:directory:organisation'), 
					"section" => "directory",
				));
			elgg_register_menu_item("page", array(
					'name' => 'members-tutors', 'href' => $CONFIG->url . 'members/formateur', 
					'title' => elgg_echo('theme_compnum:directory:tutors:help'), 
					'text' => elgg_echo('theme_compnum:directory:tutors'), 
					"section" => "directory",
				));
			elgg_register_menu_item("page", array(
					'name' => 'members-learners', 'href' => $CONFIG->url . 'members/candidat', 
					'title' => elgg_echo('theme_compnum:directory:learners:help'), 
					'text' => elgg_echo('theme_compnum:directory:learners'), 
					"section" => "directory",
				));
		}
		
	return true;
}


function theme_compnum_pages_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
		if ($params['entity']->pages_enable == "yes") {
			$url = "pages/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('pages', elgg_echo('pages:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}
function theme_compnum_blog_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
		if ($params['entity']->blog_enable == "yes") {
			$url = "blog/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('blog', elgg_echo('blog:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}
function theme_compnum_file_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
		if ($params['entity']->file_enable == "yes") {
			$url = "file/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('file', elgg_echo('file:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}


function theme_compnum_index() {
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_compnum/homepage.php');
	return true;
}

function theme_compnum_public_index() {
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_compnum/public_homepage.php');
	return true;
}



function theme_compnum_groups_write_acl_plugin_hook($hook, $entity_type, $returnvalue, $params) {
	$page_owner = elgg_get_page_owner_entity();
	$user_guid = $params['user_id'];
	$user = get_entity($user_guid);
	if (!$user) {
		return $returnvalue;
	}

	// only insert group access for current group
	if ($page_owner instanceof ElggGroup) {
		if ($page_owner->canWriteToContainer($user_guid)) {
			$returnvalue[$page_owner->group_acl] = elgg_echo('groups:group') . ': ' . $page_owner->name;

			unset($returnvalue[ACCESS_FRIENDS]);
		}
	} else {
		// if the user owns the group, remove all access collections manually
		// this won't be a problem once the group itself owns the acl.
		// Compétences numérique : ici on veut l'inverse : avoir les groupes lorsqu'on publie un article perso
		$groups = elgg_get_entities_from_relationship(array(
					'relationship' => 'member',
					'relationship_guid' => $user_guid,
					'inverse_relationship' => FALSE,
					'limit' => false
				));

		if ($groups) foreach ($groups as $group) {
			//unset($returnvalue[$group->group_acl]);
			$returnvalue[$group->group_acl] = 'Groupe: ' . $group->name;
		}
	}

	return $returnvalue;
}


/* Returns a list of administered groups (owned + group operator) for a given $user entity */
function theme_compnum_myadmin_groups($user) {
	return theme_compnum_admin_groups($user->guid);
}

/* Returns a list of administered groups (owned + group operator) for a given GUID */
function theme_compnum_admin_groups($user_guid) {
	// Groupe dont je suis le propriétaire (plutôt organisation, mais ne soyons pas trop restrictifs sur les process de gestion)
	$owned_groups_count = elgg_get_entities(array('type' => 'group', 'owner_guid' => $user_guid, 'count' => true));
	$owned_groups = elgg_get_entities(array('type' => 'group', 'owner_guid' => $user_guid, 'limit' => $owned_groups_count));
	// Groupe dont je suis le co-responsable (idem)
	$admin_groups_count = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'operator', 'relationship_guid' => $user_guid, 'inverse_relationship' => false, 'count' => true));
	$admin_groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'operator', 'relationship_guid' => $user_guid, 'inverse_relationship' => false, 'limit' => $admin_groups_count));
	// Dédoublonnage de tous ces groupes
	if ($owned_groups) foreach ($owned_groups as $ent) {
		if (!is_array($myadmin_groups) || !in_array($ent->guid, $myadmin_groups)) $myadmin_groups[$ent->guid] = $ent;
	}
	if ($admin_groups) foreach ($admin_groups as $ent) {
		if (!is_array($myadmin_groups) || !in_array($ent->guid, $myadmin_groups)) $myadmin_groups[$ent->guid] = $ent;
	}
	return $myadmin_groups;
}

