<?php
/**
 * Elgg Simple editing of CMS "static" pages
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2008-2015
 * @link http://id.facyla.net/
*/

// TODO : permettre d'utiliser une cmspage existante comme moteur de template en passant des params côté code cette fois : 
// elgg_view('cmspages/view',array('pagetype'=>"maghrenov-public-template", 'customvar1' => 'whatever'))

// Initialise log browser
elgg_register_event_handler('init','system','cmspages_init');


function cmspages_init() {
	elgg_extend_view('css/elgg','cmspages/css');
	elgg_extend_view('css/admin','cmspages/css');
	if (!elgg_is_active_plugin('esope')) { elgg_extend_view('page/elements/head','cmspages/head_extend'); }
	
	// Register menus
	// Topbar menu (admin | editors)
	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'cmspages_topbar_menu');
	// Navigation menu
	elgg_register_plugin_hook_handler('register', 'menu:site', 'cmspages_categories_menu');
	
	// Register entity type for search
	if (elgg_get_plugin_setting('register_object', 'cmspages') != 'no') {
		elgg_register_entity_type('object', 'cmspage');
		elgg_register_plugin_hook_handler('search', 'object:cmspage', 'cmspages_search_hook');
	}
	
	// Register a URL handler for CMS pages
	// override the default url to view a blog object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'cmspages_url_handler');
	
	// Override icons
	//elgg_register_plugin_hook_handler("entity:icon:url", "object", "cmspages_icon_hook");
	
	// Register main page handler
	elgg_register_page_handler('cmspages', 'cmspages_page_handler');
	// CMS main page handlers (externalblogs can define new ones if we want multisite)
	elgg_register_page_handler('p', 'cmspages_cms_article_page_handler'); // Articles
	elgg_register_page_handler('r', 'cmspages_cms_category_page_handler'); // Categories
	elgg_register_page_handler('t', 'cmspages_cms_tag_page_handler'); // Tags
	
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'cmspages_public_pages');
	
	// Hooks
	// ACCESS - Write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'cmspages_permissions_check');
	
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . 'cmspages/actions/cmspages/';
	elgg_register_action("cmspages/edit", $actions_path . 'edit.php');
	elgg_register_action("cmspages/delete", $actions_path . 'delete.php');
	
	elgg_register_event_handler('upgrade', 'upgrade', 'cmspages_run_upgrades');
	
}


/* Gets the cmspage entity for a given pagetype (= slURL)
 * ElggEntity / false
 */
function cmspages_get_entity($pagetype = '') {
	$cmspage = false;
	if (!empty($pagetype)) {
		$cmspages = elgg_get_entities_from_metadata(array(
				'types' => 'object', 'subtypes' => 'cmspage', 
				'metadata_name_value_pairs' => array('name' => 'pagetype', 'value' => $pagetype), 
				'limit' => 1, 
			));
		if ($cmspages) $cmspage = $cmspages[0];
	}
	return $cmspage;
}


/* Checks if a cmspage entity exists for a given pagetype (= slURL)
 * true / false
 */
function cmspages_exists($pagetype = '') {
	$ia = elgg_set_ignore_access(true);
	if (!empty($pagetype)) {
		$cmspage = cmspages_get_entity($pagetype);
		if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
			elgg_set_ignore_access($ia);
			return true;
		}
	}
	elgg_set_ignore_access($ia);
	return false;
}


/* Main tool page handler */
function cmspages_page_handler($page) {
	$include_path = elgg_get_plugins_path() . 'cmspages/pages/cmspages/';
	if (empty($page[0])) { $page[0] = 'index'; }
	switch ($page[0]) {
		case "read":
			// Tell it's a permanent redirection
			$new_url = elgg_get_site_url() . 'p/' . $page[1];
			header("Status: 301 Moved Permanently", false, 301);
			header('Location: '.$new_url);
			//header("Status: 301 Moved Permanently", false, 301);
			/*
			forward("p/{$page[1]}");
			if ($page[1]) { set_input('pagetype', $page[1]); }
			if (!include($include_path . 'read.php')) { return false; }
			*/
			break;
			
		/* It was a test, better in a specific plugin instead (export_embed)
		case "embed";
			if (@include(dirname(__FILE__) . "/external_embed.php")) return true;
			break;
		case "template";
			if (@include(dirname(__FILE__) . "/template.php")) return true;
			break;
		*/
		case 'admin':
		case 'edit':
			if (!empty($page[1])) { set_input('pagetype', $page[1]); }
			set_input('pagetype', $page[1]);
			if (!include($include_path . 'edit.php')) { return false; }
			break;
		
		case 'file':
			// file/{$entity->guid}/featured_image/$size/
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			if (!empty($page[2])) { set_input('metadata', $page[2]); }
			if (!empty($page[3])) { set_input('size', $page[3]); }
			if (!include($include_path . 'file.php')) { return false; }
			break;
		
		case 'index':
			if (!include($include_path . 'index.php')) { return false; }
			break;
		
		default:
			forward('cmspages/edit/' . $page[0]);
	}
	return true;
}

/* Public site page handler /p/article */
function cmspages_cms_article_page_handler($page) {
	set_input('pagetype', $page[0]);
	if (!include(elgg_get_plugins_path() . 'cmspages/pages/cmspages/cms_article.php')) { return false; };
	return true;
}

/* Public site categories page handler /r/rubrique */
function cmspages_cms_category_page_handler($page) {
	set_input('category', $page[0]);
	if (!include(elgg_get_plugins_path() . 'cmspages/pages/cmspages/cms_category.php')) { return false; };
	return true;
}

/* Public site tags page handler : /t/tag */
function cmspages_cms_tag_page_handler($page) {
	set_input('tag', $page[0]);
	if (!include(elgg_get_plugins_path() . 'cmspages/pages/cmspages/cms_tag.php')) { return false; };
	return true;
}


/**
 * Format and return the URL for cmspage.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of blog.
 */
function cmspages_url_handler($hook, $type, $url, $params) {
	$entity = $params['entity'];
	
	if (!elgg_instanceof($entity, 'object', 'cmspage')) { return; }
	
	return elgg_get_site_url() . "p/" . $entity->pagetype;
}

// Define object icon : custom or default
// @TODO : should featured image be used as icon ?
function cmspages_icon_hook($hook, $entity_type, $returnvalue, $params) {
	$entity = $params["entity"];
	$size = $params["size"];
	if (elgg_instanceof($entity, "object", "cmspage")) {
		$icon_sizes = elgg_get_config("icon_sizes");
		if (!isset($icon_sizes[$size])) { $size = 'original'; }
		if (!empty($entity->featured_image)) {
			$fh = new ElggFile();
			$fh->owner_guid = $entity->guid;
			if ($size != 'original') {
				$filename = "cmspages/" . $entity->guid . $size . ".jpg";
				$extension = '.jpg';
			} else {
				$filename = $entity->featured_image;
				$extension = pathinfo($entity->featured_image, PATHINFO_EXTENSION);
				if (!is_null($extension)) { $extension = ".$extension"; } else { $extension = ''; }
			}
			$fh->setFilename($filename);
			if ($fh->exists()) {
				return elgg_get_site_url() . "cmspages/file/{$entity->guid}/featured_image/$size/{$entity->pagetype}{$extension}";
			}
		}
		return elgg_get_site_url() . "mod/cmspages/graphics/icons/$size.png";
	}
	return $returnvale;
}

/* Adds admin menu */
function cmspages_topbar_menu($hook, $type, $return, $params) {
	// Facyla: allow main & local admins to use this tool
	// and also a custom editor list
	// if ( (elgg_in_context('admin') || elgg_is_admin_logged_in()) || ((elgg_in_context('cmspages_admin')) && in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) ) {
	if (cmspage_is_editor()) {
		$return[] = new ElggMenuItem('cmspages', elgg_echo('cmspages'), 'cmspages/');
	}
	return $return;
}
/* Sets custom CMS menu based on categories */
function cmspages_categories_menu($hook, $type, $return, $params) {
	// List categories - For each entry, add parent if set
	$tree_categories = elgg_get_plugin_setting('menu_categories', 'cmspages');
	$tree_categories = unserialize($tree_categories);
	if (is_array($tree_categories)) foreach ($tree_categories as $cat) {
		$item = new ElggMenuItem((string)$cat['name'], (string)$cat['title'], 'r/'.$cat['name']);
		if (!empty($cat['parent'])) $item->setParentName($cat['parent']);
		$return[] = $item;
	}
	return $return;
}



/* ACCESS and PERMISSIONS */

/* Determines if user has global editing rights
* ie can create a new cmspage, or can edit any cmspage
 */
function cmspage_is_editor($user = false) {
	if (!$user) {
		if (!elgg_is_logged_in()) return false;
		$user = elgg_get_logged_in_user_entity();
	}
	if (elgg_is_admin_user($user->guid)) return true;
	//if (elgg_in_context('cmspages_admin')) return true;
	$editors = explode(',', elgg_get_plugin_setting('editors', 'cmspages'));
	if (in_array($user->guid, $editors)) return true;
	// Not an editor
	return false;
}

/* Determines if user has limited editing rights
* ie can create new author cmspage, or can edit own cmspage
 */
function cmspage_is_author($user) {
	if (!$user) { $user = elgg_get_logged_in_user_entity(); }
	if (elgg_is_admin_logged_in()) return true;
	if (elgg_in_context('cmspages_admin')) return true;
	$authors = explode(',', elgg_get_plugin_setting('authors', 'cmspages'));
	if (in_array($user->guid, $authors)) return true;
	return false;
}

/* Checks if a given user has provided the right password to access cmspage (or is an editor)
 * Optionally display the authorisation form
 * Return : true : user authorised / no password / valid password
 *          false : not authorised
 */
function cmspages_check_password($cmspage, $display_form = true) {
	if (!elgg_instanceof($cmspage, 'object', 'cmspage')) return false;
	
	// Y a-t-il un mot de passe ?
	if (empty($cmspage->password)) { return true; }
	
	// Authorisation end command - remove password authorisations
	$logout = get_input('cmspages_logout', false);
	if (!empty($logout)) {
		if ($logout == 'all') {
			unset($_SESSION['cmspages']);
			system_message(elgg_echo('cmspage:password:cleared'));
		} else {
			$guids = explode($logout);
			// Per-GUID close
			foreach ($guids as $guid) {
				unset($_SESSION['cmspages'][$guid]['passhash']);
			}
			system_message(elgg_echo('cmspage:password:cleared:page'));
		}
	}
	
	// Contrôle du mot de passe
	// Editors are always allowed
	if (cmspage_is_editor()) { return true; }
	
	// Generate hash that authenticates the user
	$pass_hash = md5(get_site_secret() . $cmspage->password);
	
	// Already validated
	if ($_SESSION['cmspages'][$cmspage->guid]['pass_hash'] == $pass_hash) { return true; }
	
	// Need to authenticate using provided information, and store that information
	$input_pass = get_input('cmspage_password_' . $cmspage->guid);
	if (!empty($input_pass)) {
		$input_pass_hash = md5(get_site_secret() . $input_pass);
		if ($input_pass && ($input_pass_hash == $pass_hash)) {
			$_SESSION['cmspages'][$cmspage->guid]['pass_hash'] = $pass_hash;
			return true;
		}
	}
	
	// Not validated at this step => display form (using unique ids to avoid conflicts)
	if ($display_form) {
		echo '<form method="POST" class="cmspage-password-form" id="cmspage-password-' . $cmspage->guid . '">';
		echo elgg_echo('cmspages:password:form');
		echo elgg_view('input/password', array('name' => 'cmspage_password_' . $cmspage->guid));
		echo elgg_view('input/submit', array('value' => elgg_echo('cmspages:password:submit'), 'class' => "elgg-button elgg-button-submit"));
		echo '</form>';
	}
	// Tell we do not have access to the page content
	return false;
}

/* Permissions for the cmspages context : determines canEdit()
 * Extends permissions checking to allow editors and other roles
 */
function cmspages_permissions_check($hook, $type, $returnval, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'cmspage')) {
		if (cmspage_is_editor()) { return true; }
		//if (elgg_in_context('admin') && elgg_is_admin_logged_in()) { return true; }
		//if ( (elgg_in_context('cmspages_admin')) || in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))) ) { return true; }
		
		// Add a hook to allow other plugins handle other CMS pages edition rules
		// ie. define an extended set of editors, based on a custom rules
		$returnval = elgg_trigger_plugin_hook('cmspages:edit', 'cmspage', $params, $returnval);
	}
	return $returnval;
}

// Permet l'accès aux pages CMS en mode "walled garden"
// Allows public visibility of public cmspages which allows fullview page rendering
function cmspages_public_pages($hook, $type, $return_value, $params) {
	
	// Globally allow all pages matching p/, r/ and t/
	$return_value[] = 'p/.*';
	$return_value[] = 'r/.*';
	$return_value[] = 't/.*';
	
	// No need to get into details for each cmspage : 
	// gatekeeper is applied on the page itself anyway, so we can use a wildcard match
	$return_value[] = 'cmspages/read/.*';
	return $return_value;
	/*
	$ia = elgg_set_ignore_access(true);
	// Get pages that are public, and can be displayed as a full page
	$cmspages = cmspages_get_public_pages();
	//$options = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'limit' => 0);
	//$cmspages = elgg_get_entities($options);
	if ($cmspages) foreach ($cmspages as $ent) {
		$return_value[] = 'cmspages/read/' . $ent->pagetype;
	}
	elgg_set_ignore_access($ia);
	*/
	
	return $return_value;
}


/* PAGES GETTERS */

/* Returns all public pages
 * Ssi le niveau d'accès est public = 2 (on vérifie car override d'accès)
 * Et autorisé en pleine page
 */
function cmspages_get_public_pages() {
	$options = array(
			'types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 
			'metadata_name_value_pairs' => array('name' => 'display', 'value' => 'no', 'operand' => '<>'),
			'wheres' => array("(e.access_id = 2)"),
			'limit' => 0, 
		);
	$cmspages = elgg_get_entities_from_metadata($options);
	return $cmspages;
}

/* Returns all templates cmspages
 */
function cmspages_get_templates_pages() {
	$options = array(
			'types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 
			'metadata_name_value_pairs' => array('name' => 'content_type', 'value' => 'template'),
			'limit' => 0, 
		);
	$cmspages = elgg_get_entities_from_metadata($options);
	return $cmspages;
}

/* Returns templates as pulldown options */
function cmspages_templates_opts() {
	$cmspages = cmspages_get_templates_pages();
	$options = array('' => '');
	if ($cmspages) foreach ($cmspages as $cmspage) {
		$options[$cmspage->pagetype] = $cmspage->pagetype . ' (' . $cmspage->pagetitle . ')';
	}
	return $options;
}

/* Returns display options
 * Eg. display params tu be used
 */
function cmspages_display_opts() {
	// Zones : nav defaults to breadcrumb
	//$all_zones = array('title', 'header', 'nav', 'content', 'footer', 'sidebar', 'sidebar-alt');
	$display_opts = array(
			'' => 'Autorisé (par défaut)',
			'noview' => "Exclusif (pleine page uniquement)",
			'no' => "Interdit (élément d'interface uniquement)",
			//'default' => '', // deprecated
			//'one_column' => "Pleine page",
			//'one_sidebar' => "Barre latérale droite",
			//'two_sidebar' => "2 barres latérales",
			/*
			'one_column' => array('name' => 'Full width', 'zones' => array('header', 'nav', 'footer')),
			'one_sidebar' => array('name' => 'Right sidebar', 'zones' => array('header', 'nav', 'footer', 'sidebar')),
			'two_sidebar' => array('name' => '2 sidebars', 'zones' => array('header', 'nav', 'footer', 'sidebar', 'sidebar_alt')),
			*/
		);
	// @TODO : Permettre d'ajouter d'autres layouts via config ?
	return $display_opts;
}


/* Returns layouts and config
 * Eg. layout params to be used
 */
function cmspages_layouts_opts($add_default = true) {
	$layout_opts = array(
			'one_column' => elgg_echo('cmspages:layout:one_column'),
			'one_sidebar' => elgg_echo('cmspages:layout:one_sidebar'),
			'two_sidebar' => elgg_echo('cmspages:layout:two_sidebar'), 
			'custom' => elgg_echo('cmspages:layout:custom'),
		);
	if ($add_default) $layout_opts[""] = elgg_echo('cmspages:layout:');
	// @TODO : Permettre d'ajouter d'autres layouts via config ?
	return $layout_opts;
}

/* Returns pageshells and config
 * Eg. pageshell params to be used
 */
function cmspages_pageshells_opts($add_default = true) {
	$pageshell_opts = array(
			'default' => elgg_echo('cmspages:pageshell:default'),
			'cmspages' => elgg_echo('cmspages:pageshell:cmspages'),
			'cmspages_cms' => elgg_echo('cmspages:pageshell:cmspages_cms'), 
			'iframe' => elgg_echo('cmspages:pageshell:iframe'),
			'inner' => elgg_echo('cmspages:pageshell:inner'),
			'custom' => elgg_echo('cmspages:pageshell:custom'),
		);
	if ($add_default) $pageshell_opts[""] = elgg_echo('cmspages:pageshell:');

	// @TODO : Permettre d'ajouter d'autres pageshells via config ?
	return $pageshell_opts;
}

/* Returns header cmspage
 * Eg. header cmspage to be used
 */
function cmspages_headers_opts($add_default_config = true) {
	$header_opts = array(
			'initial' => elgg_echo('cmspages:cms_header:initial'),
			'no' => elgg_echo('cmspages:cms_header:no'),
			'cms-header' => elgg_echo('cmspages:cms_header:custom'),
		);
	if ($add_default_config) $header_opts[""] = elgg_echo('cmspages:cms_header:default');
	// @TODO : Permettre d'ajouter d'autres pageshells via config ?
	return $header_opts;
}

/* Returns menu name
 * Eg. menu to be used
 */
function cmspages_menus_opts($add_default_config = true) {
	$menu_opts = array();
	if (elgg_is_active_plugin('elgg_menus')) {
		if (function_exists('elgg_menus_menus_opts')) {
			$menu_opts = elgg_menus_menus_opts();
		}
	}
	$menu_opts['cmspages_categories'] = elgg_echo('cmspages:settings:cms_menu:cmspages_categories');
	$menu_opts[''] = elgg_echo('cmspages:settings:cms_menu:default');
	$menu_opts['no'] = elgg_echo('cmspages:settings:cms_menu:no');
	return $menu_opts;
}


/* Returns footer cmspage
 * Eg. footer cmspage to be used
 */
function cmspages_footers_opts($add_default_config = true) {
	$footer_opts = array(
			'initial' => elgg_echo('cmspages:cms_footer:initial'), // default footer
			'no' => elgg_echo('cmspages:cms_footer:no'), // no footer
			'cms-footer' => elgg_echo('cmspages:cms_footer:custom'),
		);
	if ($add_default_config) $footer_opts[""] = elgg_echo('cmspages:cms_footer:default');
	// @TODO : Permettre d'ajouter d'autres pageshells via config ?
	return $footer_opts;
}




/* CONTENT RENDERING FUNCTIONS */

// Renvoie un tableau de configuration du module à partir d'une chaîne de configuration
// 2 utilisation : soit avec module_name?param1=xx&param2=yy, soit avec (module_name, param1=xx&param2=yy)
function cmspages_extract_module_config($module_name = '', $module_config) {
	$module_config = html_entity_decode($module_config);
	$return = array();
	// Gestion cas où on a les 2 ensemble (module_name?param1=xx&param2=yy)
	if (empty($module_name) && strpos('?', $module_config)) {
		// module?param1=xx&param2=yy
		$module_config = explode("?", $module_string);
		$module_name = $module_config[0];
		$module_params = explode("&", $module_config[1]);
	} else {
		// param1=xx&param2=yy =>	param1=xx, param2=yy
		$module_params = explode("&", $module_config);
	}
	// module1
	if (!$module_params) $return[$module_name] = false; else 
	foreach ($module_params as $module_param) {
		$module_param = explode('=', $module_param);
		$param_name = $module_param[0];
		$param_value = $module_param[1];
		// Composition du tableau de retour : $config[module][param1] = valeur param
		$return[$module_name][$param_name] = $param_value;
	}
	return $return;
}


// Affiche le contenu d'un module paramétré
function cmspages_compose_module($module_name, $module_config = false) {
	$return = '';
	// Attention : toute entité non affichable renvoie sur la home
	switch($module_name) {
		case 'title':
			$return .= "<h3>" . $module_config['text'] . "</h3>";
			break;
			
		case 'listing':
			// Affichage d'un listing d'entités
			$full_view = $module_config['full_view'];
			$type = $module_config['type'];
			$subtype = $module_config['subtype'];
			$limit = $module_config['limit'];
			if (!isset($limit)) $limit = 10;
			$sort = $module_config['sort'];
			if (!isset($sort)) $sort = "time_created desc";
			$guids = $module_config['guids'];
			$owner_guids = $module_config['owner_guids'];
			$container_guids = $module_config['container_guids'];
			//Extract multiple values
			$fields_multiple = array('guids', 'owner_guids', 'container_guids');
			foreach($fields_multiple as $field) {
				if (strpos($$field, ',')) {
					$$field = explode(',', $$field);
					$$field = array_filter($$field);
					$$field = array_unique($$field);
				}
			}
			// We need arrays as params
			//$type = explode(',', $type);
			//$subtype = explode(',', $subtype);
			//$owner_guids = explode(',', $owner_guids);
			//$container_guids = explode(',', $container_guids);
			if ($subtype == 'all') $subtype = get_registered_entity_types($type);
			if (!$subtype) $subtype = '';
			//$ents = elgg_get_entities(array('type_subtype_pairs' => array($type => $subtype), 'limit' => $limit, 'order_by' => $sort));
			$params = array('types' => $type, 'subtypes' => $subtype, 'limit' => $limit, 'order' => $sort);
			if (sizeof($guids) > 0) $params['guids'] = $guids;
			if (sizeof($owner_guids) > 0) $params['owner_guids'] = $owner_guids;
			if (sizeof($container_guids) > 0) $params['container_guids'] = $container_guids;
			// Get the entities
			//$ents = elgg_get_entities($params);
			$ents = elgg_get_entities_from_relationship($params);
			
			// Rendu groupe et membre
			if (in_array($module_config['type'], array('group', 'user'))) {
				if ($full_view == 'yes') {
					foreach ($ents as $ent ) $return .= elgg_view_entity($ent, array('full_view' => true));
				} else {
					foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->name . '</a><br />';
				}
			
			} else if (is_array($ents)) {
				if ($full_view == 'yes') {
					elgg_push_context('widgets');
					foreach ($ents as $ent ) $return .= elgg_view_entity($ent, array('full_view' => true));
					elgg_pop_context('widgets');
				} else if ($full_view == 'titlecontent') {
					foreach ($ents as $ent ) $return .= '<h3>' . $ent->title . '</h3>' . $ent->description;
				} else {
					foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->title . '</a><br />';
				}
			}
			
			break;
			
		case 'search':
			// Affichage des résultats d'une recherche (par type d'entité)
			$return .= '<h3>' . elgg_echo('cmspages:searchresults') . '</h3>';
			// @TODO : améliorer la recherche, mais sans tout réécrire..
			switch($module_config['type']) {
				case 'object': $ents = search_for_object($module_config['criteria']); break;
				case 'group': $ents = search_for_group($module_config['criteria']); break;
				case 'user': $ents = search_for_user($module_config['criteria']); break;
				case 'site': $ents = search_for_site($module_config['criteria']); break;
			}
			if (in_array($module_config['type'], array('group', 'user'))) foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->name . '</a><br />';
			else foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->title . '</a><br />';
			break;
			
		case 'entity':
			// Affichage d'une entité : celle-ci doit exister
			// champs ou template au choix ? autres paramètres ?
			//$return .= '<h3>' . elgg_echo('cmspages:chosenentity') . '</h3>';
			//if ($module_config['guid'] && ($ent = get_entity($module_config['guid']))) $return .= $ent->guid . ' : ' . $ent->title . $ent->name . '<br />' . $ent->description;
			//$return .= elgg_echo('cmspages:chosenentity') . '</h3>';
			if ($module_config['guid'] && ($ent = get_entity($module_config['guid']))) {
				$return .= '<h3>' . $ent->title . $ent->name . '</h3><div class="elgg-output">' . $ent->description . '</div>';
			}
			break;
			
		case 'view':
			// Affichage d'une vue configurée : la vue doit exister, paramètres au choix
			$return .= '<h3>' . elgg_echo('cmspages:configuredview') . '</h3>';
			$view_name = $module_config['view'];
			if (elgg_view_exists($view_name)) {
				unset($module_config['view']);
				$return .= elgg_view($view_name, $module_config);
			}
			break;
			
		default:
			// Pour le développement
			$return .= '<h3>' . elgg_echo('cmspages:module', array($module_name)) . '</h3>' . print_r($module_config, true) . "<br />";
			break;
	}
	return $return;
}



/* Affichage d'une page cms de tout type
 * $params : rendering parameters (which does not depend of page content)
 * $vars : content vars and data to be passed to the views (used by the page)
 *   - 'mode' : view/read (only first level can be in mode 'read')
 *        Certaines infos sont masquées en mode 'view' (titre, tags...) 
 *        + softfail si accès interdit + aucun impact sur la suite de l'affichage (contextes, etc.)
 *   - 'embed' : can be passed to change some rendering elements based on read embed
 *   - 'add_edit_link' : allow non-defined pages rendering (and edit links)
 *   - 'noedit' : Removes admin links (useful for 'inner' and 'iframe' embed mode, required for tinymce templates)
 * STEPS :
 * 1. Check validity, access, contexts (can we display that page ?)
 * 2. Render cmspage "own" content
 * 3. Add optional edit block
 * 4. Wrap into containing content block .cmspages-output
 * 5. Render content into optional template
 */
function cmspages_view($cmspage, $params = array(), $vars = array()) {
	
	// Determine if we have an entity or a pagetype, and get both vars
	if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
		// Get pagetype from entity
		$pagetype = $cmspage->pagetype;
	} else if (!empty($cmspage)) {
		$pagetype = $cmspage;
		// Or optional entity from pagetype
		$cmspage = cmspages_get_entity($pagetype);
	}
	
	// Set defaults and custom params
	$mode = 'view';
	$add_edit_link = true;
	if (isset($params['mode'])) $mode = $params['mode'];
	if (isset($params['add_edit_link'])) $add_edit_link = $params['add_edit_link'];
	if ($params['noedit'] == 'true') $add_edit_link = false;
	if (!empty($params['embed'])) $embed = $params['embed'];
	if (!isset($params['recursion'])) $params['recursion'] = array();
	$read_more = false;
	if (isset($vars['read_more'])) $read_more = $vars['read_more'];

	
	
	/* 1. Check validity, access, contexts (can we display that page ?) */
	// Access rights : is viewer a page editor ?
	$is_editor = false;
	if (cmspage_is_editor()) {
		$is_editor = true;
		// Editors can also edit any cmspage - including private ones
		$ia = elgg_set_ignore_access(true);
	}
	
	// Page inexistante ? Seuls les éditeurs peuvent rester (ils pourront créer la page)
	if (!elgg_instanceof($cmspage, 'object', 'cmspage') && !$is_editor) { return; }
	
	if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
		
		// Check if read/view display is allowed - contenu vide si pas autorisé
		// Note : pages should allow view mode to be used as templates
		if ($mode == 'view') {
			if ($cmspage->display == 'noview') { return; }
		} else {
			// Read mode : check if full page display is allowed
			if ($cmspage->display == 'no') { return; }
		}
		
		// Check if using a password, and if user has access, or display auth form
		// If form is displayed, user does not have access so return right after form
		if ($cmspage && !cmspages_check_password($cmspage)) { return; }
		
		// Check allowed contexts - Exit si contexte non autorisé
		if (!empty($cmspage->contexts) && ($cmspage->contexts != 'all')) {
			$exit = true;
			$allowed_contexts = explode(',', $cmspage->contexts);
			foreach ($allowed_contexts as $context) {
				if (elgg_in_context(trim($context))) { $exit = false; break; }
			}
			if ($exit) {
				if ($mode != 'view') {
					register_error(elgg_echo('cmspages:wrongcontext'));
					//forward(REFERER);
				}
				return;
			}
		}
	}
	
	
	/* 2. Render cmspage "own" content */
	$content = '';
	// Contexte spécifique
	elgg_push_context('cmspages');
	elgg_push_context('cmspages:pagetype:' . $pagetype);
	
	// Start composing content
	if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
		$title = $cmspage->pagetitle;
		
		switch ($cmspage->content_type) {
			// Load a specific module
			case 'module':
				if (!empty($cmspage->module)) {
					$module_config = cmspages_extract_module_config($cmspage->module, $cmspage->module_config);
					foreach ($module_config as $module_name => $config) {
						$content .= cmspages_compose_module($module_name, $config);
					}
				}
				break;
			
			/* Use as a templating system
			 * see cmspages_render_template() for allowed template syntax
			 * Replace tags : {{pagetype}}, {{:view}}, {{:view|param=value}}, {{%VARS%}}, {{[shortcode]}}
			 */
			case 'template':
				// Replace wildcards with values.. {{pagetype}}
				$content .= cmspages_render_template($cmspage->description, $vars['body']);
				break;
		
			// Render cmspage raw content (unfiltered text / HTML)
			case 'rawhtml':
			default:
				// Display tags
				if ($mode != 'view') {
					$content .= elgg_view('output/cmspages_tags', array('tags' => $cmspage->tags));
					$content .= elgg_view('output/cmspages_categories', array('categories' => $cmspage->categories));
				}
				
				// Display page actual content, with custom markers rendering (and shortcodes)
				// Always use a containing div, because we need elgg-output class for lists (for pure content only !), plus a custom class for finer output control
				// Note : cannot use output/longtext view because of tags filtering
				if (($mode == 'view') && $vars['rawcontent']) {
					$content .= cmspages_render_template($cmspage->description);
				} else {
					$content .= '<div class="elgg-output elgg-cmspage-output">' . cmspages_render_template($cmspage->description) . '<div class="clearfloat"></div></div>';
				}
				
				if ($mode != 'view') {
					// Set container as page_owner
					// useful mainly when displayed as a full page
					// @TODO use also in view mode ? => need to set it back to previous owner afterwards
					if (!empty($cmspage->container_guid)) { elgg_set_page_owner_guid($cmspage->container_guid); }
					
					// Ajout de la page parente
					// Use parent entity as hierarchical navigation link
					if (!empty($cmspage->parent_guid)) {
						$parent = get_entity($cmspage->parent_guid);
						$content .= '<br /><a href="' . $parent->getURl() . '">Parent : ' . $parent->title . $parent->name . '</a>';
					}
					
					// Ajout page liée
					// Use sibling entity as horizontal navigation link
					if (!empty($cmspage->sibling_guid)) {
						$sibling = get_entity($cmspage->sibling_guid);
						$content .= '<br /><a href="' . $sibling->getURl() . '">Lien connexe : ' . $sibling->title . $sibling->name . '</a>';
					}
				}
		}
		
		// Ajout des feuilles de style personnalisées
		if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
		
		// Ajout des JS personnalisés
		if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";
		
	}
	
	
	/* 3. Add optional edit block */
	// Admin links : direct edit link for users who can edit this
	$edit_link = '';
	if ($add_edit_link && $is_editor) {
		$edit_level = count($params['recursion']);
		$edit_icon = '<i class="fa fa-edit"></i>';
		$edit_title = elgg_echo('cmspages:editlink', array($pagetype));
		if ($edit_level > 0) {
			$edit_icon = '<i class="fa fa-edit">(' . $edit_level . ')</i>';
			$edit_title .= ' - ' . elgg_echo('cmspages:nestedlevel', array($edit_level));
		}
		if ($cmspage) {
			$edit_link .= '<span class="cmspages-admin-link"><kbd>' . elgg_echo('cmspages:edit', array($pagetype)) . '</kbd></span>';
		} else {
			$edit_details = '<blockquote class="notexist">' . elgg_echo('cmspages:notexist:create') . '</blockquote>';
			$edit_link .= '<span class="cmspages-admin-link"><kbd>' . elgg_echo('cmspages:createnew', array($pagetype)) . '</kbd></span>';
		}
		$edit_link = '<a class="cmspages-admin-block cmspages-edit-level-' . $edit_level . '" href="' . elgg_get_site_url() . 'cmspages/edit/' . $pagetype . '" title="' . $edit_title . '"> ' . $edit_link . $edit_icon . '</a>' . $edit_details;
	}
	
	// If asked for "Read more" button, apply it to the whole content (but before the wrapper)
	if ($read_more) {
		$content = elgg_get_excerpt($content, $read_more);
		$content .= '<p><a href="' . $cmspage->getURL() . '" class="elgg-button elgg-button-action elgg-button-esope">' . elgg_echo('cmspages:readmore') . '</a></p>';
	}
	
	
	/* 4. Wrap into container (.cmspages-output) */
	// Add enclosing span for custom styles + optional editable class and edit link
	if ($add_edit_link && $is_editor) {
		$content = '<span class="cmspages-output cmspages-editable">' . $edit_link . $content . '</span>';
	} else {
		$content = '<span class="cmspages-output">' . $content . '</span>';
	}
	
	
	// On retire les contextes spécifiques à ce bloc pour laisser le système dans l'état initial
	if ($mode == 'view') {
		elgg_pop_context();
		elgg_pop_context();
	}
	
	
	/* 5. Render content into optional template */
	// TEMPLATE - Use another cmspage as a wrapper template
	// Note : we can use recursive templates too, ie. templates that will call display templates. But in that case, we keep track of template stack, and will no use templates recursively, to avoid looping.
	// Content is passed to the template as 'CONTENT'
	//if ($cmspage->content_type != 'template') {
	if (!empty($cmspage->template)) {
		// Allow unset pages edit link to be displayed too
		$template = cmspages_get_entity($cmspage->template);
		//$content = elgg_view('cmspages/view', array('pagetype' => $cmspage->template, 'body' => $content));
		
		// Set some params for template
		// Set template content
		$vars['body'] = $content;
		// Add current pagetype to recursion stack
		$params['recursion'][] = $cmspage->pagetype;
		// Force recursive call to view mode (no breaking because of sub-content)
		$params['mode'] = 'view';
		
		// Display content in template (if it doesn't exist, link will be displayed to admin, otherwise nothing will be displayed)
		// Block loop recursion (if some template uses an inner template, or calls itself)
		if (!in_array($cmspage->template, $params['recursion'])) {
			$content = cmspages_view($cmspage->template, $params, $vars);
		}
	}
	//}
	
	elgg_set_ignore_access($ia);
	
	return $content;
}


/* Rendu d'un template : remplacement (récursif) des blocs par les pages correspondantes
 * $template : texte ou code HTML à utiliser comme template
 * $content : éléments de contenu ou variables - array($varname => $value)
 * {{pagetype}} => HTML ou template ou module
 * si on utilise un autre template, rendre les boucles impossibles (l'appelant ne peut être appelé)
 * @TODO : permettre plus de champs de base, genre :
 		- {{pagetype}} : pages CMS
 		- {{:view}} : vue d'Elgg
 		- {{:view|param=value}} : vue d'Elgg + paramètres
 		- {{%VARS%}} : infos issues d'Elgg, listings configurables, etc.
 		- {{[shortcode]}} : shortcodes
*/
function cmspages_render_template($template, $content_vars = null) {
	// Compatibilité : accepte une simple valeur au lieu d'un array()
	if (!empty($content_vars) && !is_array($content_vars)) $content_vars = array('content' => $content_vars);
	$temp1 = explode('}}', $template);
	foreach ($temp1 as $temp) {
		$temp2 = explode('{{', $temp);
		$rendered_template .= $temp2[0]; // Ajout du texte (partie avant le template)
		// Remplacement du template par le contenu correspondant
		$marker = $temp2[1];
		if (isset($marker) && !empty($marker)) {
			$first_letter = substr($marker, 0, 1);
			switch ($first_letter) {
				// Vars replacement
				case '%':
					$marker = strtolower(substr($marker, 1, -1));
					$rendered_template .= $content_vars[$marker];
					break;
				
				// Elgg view replacement
				case ':':
					$view_param = explode('|', substr($marker, 1));
					$view_vars = array();
					foreach($view_param as $key => $param) {
						if ($key == 0) $marker = strtolower($view_param[0]);
						else {
							$param = explode('=', $param);
							$view_vars[$param[0]] = $param[1];
						}
					}
					$rendered_template .= elgg_view($marker, $view_vars);
					break;
				
				// Shortcode replacement
				case '[':
					$marker = strtolower(substr($marker, 1, -1));
					$shortcode_content = "[$marker]";
					if (function_exists('elgg_do_shortcode')) {
						$rendered_template .= elgg_do_shortcode($shortcode_content);
					}
					break;
				
				// Cmspages recursive inclusion
				default:
					$rendered_template .= elgg_view('cmspages/view', array('pagetype'=>$marker));
			}
		}
	}
	return $rendered_template;
}


/* Recherche des templates dans un contenu texte */
function cmspages_list_subtemplates($content, $recursive = true) {
	$return = '';
	// List all template types = everything between {{ and }}
	$motif = "#(?<=\{{)(.*?)(?=\}})#";
	// List templates only (exclude shortcodes, content vars and views)
	//$motif = "#(?<=\{{)([^:[%]*?)(?=\}})#";
	preg_match_all($motif, $content, $templates);
	if ($templates[0]) {
		$return .= '<ul>';
		foreach ($templates[0] as $template) {
			$first_letter = substr($template, 0, 1);
			switch($first_letter) {
				// Vars replacement
				case '%':
					$content_vars .= '<li>\'' . str_replace('%', '', strtolower($template)) . '\'</li>';
					break;
				
				// Views
				case ':':
					$view_param = explode('|', substr($template, 1));
					$params = array();
					foreach($view_param as $key => $param) {
						if ($key == 0) {
							$views .= "<li>elgg_view('" . strtolower($view_param[0]) . "'";
						} else {
							$params[] = "'" . str_replace('=', "' => \"", $param) . '"';
						}
					}
					if (!empty($params)) $views .= ', array(' . implode(', ', $params) . ')';
					$views .= ')</li>';
					break;
				
				// Shortcodes
				case '[':
					$shortcodes .= '<li>' . strtolower($template) . '</li>';
					break;
				
				// CMSPages
				default:
					$return .= '<li>';
					$return .= '<a href="' . elgg_get_site_url() . 'cmspages/?pagetype=' . $template . '" target="_new">' . $template . '</a>';
					// Get and check recursively cmspages for sub-templates
					if ($recursive) {
						$cmspage = cmspages_get_entity($template);
						if ($cmspage) {
							$return .= cmspages_list_subtemplates($cmspage->description, true);
						}
					}
					$return .= '</li>';
			}
		}
		$return .= '</ul>';
	}
	
	// List content vars
	if ($content_vars) { $return .= '<br />' . elgg_echo('cmspages:templates:parameters') . '<ul>' . $content_vars . '</ul>'; }
	// List shortcodes
	if ($shortcodes) { $return .= '<br />' . elgg_echo('cmspages:templates:shortcodes') . '<ul>' . $shortcodes . '</ul>'; }
	// List views
	if ($views) { $return .= '<br />' . elgg_echo('cmspages:templates:views') . '<ul>' . $views . '</ul>'; }
	
	return $return;
}



/* Returns all read cmspages by category
 */
function cmspages_get_pages_by_category($category) {
	if (empty($category)) return false;
	$options = array(
			'types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 
			'metadata_name_value_pairs' => array(
				array('name' => 'categories', 'value' => $category),
				array('name' => 'display', 'value' => 'no', 'operand' => '<>'),
			),
			'limit' => 0, 
		);
	$cmspages = elgg_get_entities_from_metadata($options);
	return $cmspages;
}

/* Returns all read cmspages by tag
 * string|array $tags   optionally use an array of tags (IN clause)
 */
function cmspages_get_pages_by_tag($tags) {
	if (empty($tags)) return false;
	$options = array(
			'types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 
			'metadata_name_value_pairs' => array(
				array('name' => 'tags', 'value' => $tags),
				array('name' => 'display', 'value' => 'no', 'operand' => '<>'),
			),
			'limit' => 0, 
		);
	$cmspages = elgg_get_entities_from_metadata($options);
	return $cmspages;
}



/* Registers an Elgg menu from categories config */
function cmspages_history_list($cmspage, $metadata_name, $limit = false, $offset = false) {
	// Page metadata history
	// @TODO ability to browse and restore content
	if (elgg_instanceof($cmspage, 'object', 'cmspage') && !empty($metadata_name)) {
		if (!$limit) $limit = get_input('limit', 50);
		if (!$offset) $offset = get_input('offset', 0);
		$history = $cmspage->getAnnotations(array('annotation_names' => 'history_' . $metadata_name, 'limit' => $limit, 'offset' => $offset, 'order_by' => 'n_table.time_created desc'));
		if ($history) {
			$content .= '<div class="cmspages-history">';
			$content .= '<strong><a href="javascript:void(0);" onClick="$(\'#cmspages-history-' . $metadata_name . '\').toggle();"><i class="fa fa-toggle-down"></i>' . elgg_echo('cmspages:history') . '</a></strong>';
			$content .= '<ol id="cmspages-history-' . $metadata_name . '" style="display:none;">';
			foreach ($history as $annotation) {
			if (empty($annotation->value)) continue;
				$content .= '<li class="cmspages-history-item">';
				//$editor_content .= elgg_echo('cmspages:history:version', array($annotation->getOwnerEntity()->name, elgg_view_friendly_time($annotation->time_created)));
				//$editor_content .= '<div class="cmspages-history-value"><textarea>' . $annotation->value . '</textarea></div>';
				//$editor_content .= '<pre>' . print_r($annotation, true) . '</pre>';
				$version_details = elgg_echo('cmspages:history:version', array($annotation->getOwnerEntity()->name, elgg_view_friendly_time($annotation->time_created)));
				$content .= elgg_view('output/url', array(
						'text' => $version_details, 
						'href' => '#cmspage-history-item-' . $annotation->id,
						'class' => 'elgg-lightbox',
					));
				$content .= '<div class="hidden">' . elgg_view_module('aside', strip_tags($version_details), '<textarea>' . $annotation->value . '</textarea>', array('id' => 'cmspage-history-item-' . $annotation->id)) . '</div>';
				$content .= '</li>';
			}
			$content .= '</ol>';
			$content .= '</div>';
		} else return false;
	}
	return $content;
}


// Adds a featured image (only if an image was actually sent)
function cmspages_add_featured_image($cmspage, $input_name = 'featured_image') {
	$result = false;
	if (elgg_instanceof($cmspage, "object", "cmspage")) {
		//$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));
		// Autres dimensions, notamment recadrage pour les vignettes en format carré définies via le thème
		// Check that there is a file, and that it is an image
		$is_image = get_resized_image_from_uploaded_file($input_name, 100, 100);
		if ($is_image) {
			$prefix = "{$input_name}/" . $cmspage->guid;
			$fh = new ElggFile();
			$fh->owner_guid = $cmspage->guid;
			// Save original image (using original extension)
			$uploaded_file = get_uploaded_file($input_name);
			$saved_filename = $prefix . 'original';
			$extension = pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION);
			if (!is_null($extension)) { $saved_filename .= ".$extension"; }
			$fh->setFilename($saved_filename);
			if($fh->open("write")){
				$fh->write($uploaded_file);
				$fh->close();
			}
			$path = $fh->getFilenameOnFilestore();
			// Save different sizes
			$icon_sizes = elgg_get_config("icon_sizes");
			foreach($icon_sizes as $icon_name => $icon_info){
				$icon_file = get_resized_image_from_uploaded_file($input_name, $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"]);
				if ($icon_file) {
					$fh->setFilename($prefix . $icon_name . ".jpg");
					if ($fh->open("write")) {
						$fh->write($icon_file);
						$fh->close();
					}
				}
			}
			// Keep original file path (extension cannot be guessed)
			$cmspage->{$input_name} = $saved_filename;
			$result = true;
		} else {
			// Not an image
		}
	}
	return $result;
}

// Removed featured image
function cmspages_remove_featured_image(CMSPage $cmspage, $input_name = 'featured_image') {
	$result = false;
	if (elgg_instanceof($cmspage, "object", "cmspage")) {
		if (!empty($cmspage->{$input_name})) {
			$fh = new ElggFile();
			$fh->owner_guid = $cmspage->guid;
			$prefix = "{$input_name}/" . $cmspage->guid;
			// Remove original image
			$fh->setFilename($cmspage->{$input_name});
			if ($fh->exists()) { $fh->delete(); }
			// Remove custom sizes
			$icon_sizes = elgg_get_config('icon_sizes');
			foreach($icon_sizes as $name => $info){
				$fh->setFilename($prefix . $name . ".jpg");
				if ($fh->exists()) { $fh->delete(); }
			}
			unset($cmspage->{$input_name});
			$result = true;
		} else {
			$result = true;
		}
	}
	return $result;
}


// Avoid dependencies
if (!elgg_is_active_plugin('esope')) {
	if (!function_exists('esope_get_input_array')) {
		function esope_get_input_array($input = false) {
			if ($input) {
				// Séparateurs acceptés : retours à la ligne, virgules, points-virgules, pipe, 
				$input = str_replace(array("\n", "\r", "\t", ",", ";", "|"), "\n", $input);
				$input = explode("\n", $input);
				// Suppression des espaces
				$input = array_map('trim', $input);
				// Suppression des doublons
				$input = array_unique($input);
				// Supression valeurs vides
				$input = array_filter($input);
			}
			return $input;
		}
	}
}


function cmspages_run_upgrades($event, $type, $details) {
	$cmspages_upgrade_version = elgg_get_plugin_setting('upgrade_version', 'cmspages');
	if (empty($cmspages_upgrade_version)) { $cmspages_upgrade_version = '0'; }

	//if (!$cmspages_upgrade_version != '1.11') {
	if (version_compare($cmspages_upgrade_version, '1.11') < 0) {
		 // When upgrading, check if the ElggCMSPage class has been registered as this
		 // was added in Elgg 1.11
		if (!update_subtype('object', 'cmspage', 'ElggCMSPage')) {
			add_subtype('object', 'cmspage', 'ElggCMSPage');
		}
		elgg_set_plugin_setting('upgrade_version', '1.11', 'cmspages');
	}
	
	if (version_compare($cmspages_upgrade_version, '1.12') < 0) {
		// Perform some upgrade tasks...
		//elgg_set_plugin_setting('upgrade_version', '1.12', 'cmspages');
	}
	
}


/**
 * Get objects that match the search parameters.
 *
 * @param string $hook   Hook name
 * @param string $type   Hook type
 * @param array  $value  Empty array
 * @param array  $params Search parameters
 * @return array
 */
// Return matched title
// @TODO : also perform search on metadata (pagetype)
function cmspages_search_hook($hook, $type, $value, $params) {
	$db_prefix = elgg_get_config('dbprefix');

	$join = "JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid";
	$params['joins'] = array($join);
	$fields = array('title', 'description');
	
	$where = search_get_where_sql('oe', $fields, $params);
	
	$params['wheres'] = array($where);
	$params['count'] = TRUE;
	$count = elgg_get_entities($params);
	
	// no need to continue if nothing here.
	if (!$count) {
		return array('entities' => array(), 'count' => $count);
	}
	
	$params['count'] = FALSE;
	$params['order_by'] = search_get_order_by_sql('e', 'oe', $params['sort'], $params['order']);
	$params['preload_owners'] = true;
	$entities = elgg_get_entities($params);

	// add the volatile data for why these entities have been returned.
	foreach ($entities as $entity) {
		$title = search_get_highlighted_relevant_substrings($entity->pagetype, $params['query']);
		if (empty($title)) { $title = search_get_highlighted_relevant_substrings($entity->pagetitle, $params['query']); }
		if (empty($title)) { $title = search_get_highlighted_relevant_substrings($entity->title, $params['query']); }
		$entity->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($entity->description, $params['query']);
		$entity->setVolatileData('search_matched_description', $desc);
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}


