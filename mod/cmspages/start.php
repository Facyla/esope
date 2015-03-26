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
elgg_register_event_handler('pagesetup','system','cmspages_pagesetup');


function cmspages_init() {
	global $CONFIG;
	elgg_extend_view('css','cmspages/css');
	if (!elgg_is_active_plugin('adf_public_platform')) elgg_extend_view('page/elements/head','cmspages/head_extend');
	
	// Register entity type
	elgg_register_entity_type('object', 'cmspage');
	
	// Register a URL handler for CMS pages
	elgg_register_entity_url_handler('object', 'cmspage', 'cmspage_url');
	
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


/* Gets the cmspage entity for a given pagetype (= slURL)
 * ElggEntity / false
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
	global $CONFIG;
	$include_path = elgg_get_plugins_path() . 'cmspages/pages/cmspages/';
	if (empty($page[0])) { $page[0] = 'index'; }
	switch ($page[0]) {
		case "read":
			// Tell it's a permanent redirection
			header("Status: 301 Moved Permanently", false, 301);
			forward("p/$page[1]");
			if ($page[1]) { set_input('pagetype', $page[1]); }
			if (!include($include_path . 'read.php')) { return false; }
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
	if (include(elgg_get_plugins_path() . 'cmspages/pages/cmspages/cms_article.php')) return true;
	return false;
}

/* Public site categories page handler /r/rubrique */
function cmspages_cms_category_page_handler($page) {
	set_input('category', $page[0]);
	if (include(elgg_get_plugins_path() . 'cmspages/pages/cmspages/cms_category.php')) return true;
	return false;
}

/* Public site tags page handler : /t/tag */
function cmspages_cms_tag_page_handler($page) {
	set_input('tag', $page[0]);
	if (include(elgg_get_plugins_path() . 'cmspages/pages/cmspages/cms_tag.php')) return true;
	return false;
}


/* Populates the ->getUrl() method for cmspage objects */
function cmspage_url($cmspage) {
	//return elgg_get_site_url() . "cmspages/read/" . $cmspage->pagetype;
	return elgg_get_site_url() . "p/" . $cmspage->pagetype;
}


/* Page setup. Adds admin controls */
function cmspages_pagesetup() {
	global $CONFIG;
	// Facyla: allow main & local admins to use this tool
	// and also a custom editor list
	// if ( (elgg_in_context('admin') || elgg_is_admin_logged_in()) || ((elgg_in_context('cmspages_admin')) && in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) ) {
	if (cmspage_is_editor()) {
		$item = new ElggMenuItem('cmspages', elgg_echo('cmspages'), 'cmspages/');
		elgg_register_menu_item('topbar', $item);
	}
	return true;
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

/* Returns layouts and config
 * Eg. layout params tu be used
 * Note only templates should use this as it defines a full interface
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
			$limit = $module_config['limit']; if (!isset($limit)) $limit = 5;
			$sort = $module_config['sort']; if (!isset($sort)) $sort = "time_created desc";
			$owner_guids = $module_config['owner_guids'];
			$container_guids = $module_config['container_guids'];
			// We need arrays as params
			//$type = explode(',', $type);
			//$subtype = explode(',', $subtype);
			//$owner_guids = explode(',', $owner_guids);
			//$container_guids = explode(',', $container_guids);
			if ($subtype == 'all') $subtype = get_registered_entity_types($type);
			if (!$subtype) $subtype = '';
			//$ents = elgg_get_entities(array('type_subtype_pairs' => array($type => $subtype), 'limit' => $limit, 'order_by' => $sort));
			$params = array('types' => $type, 'subtypes' => $subtype, 'limit' => $limit, 'order' => $sort);
			if (sizeof($owner_guids) > 0) $params['owner_guids'] = $owner_guids;
			if (sizeof($container_guids) > 0) $params['container_guids'] = $container_guids;
			// Get the entities
			$ents = elgg_get_entities($params);
			
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
			$return .= '<h3>' . elgg_echo('cmspages:chosenentity') . '</h3>';
			if ($module_config['guid'] && ($ent = get_entity($module_config['guid']))) $return .= $ent->guid . ' : ' . $ent->title . $ent->name . '<br />' . $ent->description;
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


/* Utilisation d'un template : remplacement (non récursif ?) des blocs par les pages correspondantes
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
function cmspages_render_template($template, $content = null) {
	// Compatibilité : accepte une simple valeur au lieu d'un array()
	if (!empty($content) && !is_array($content)) $content = array('content' => $content);
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
					$rendered_template .= $content[$marker];
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
	global $CONFIG;
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


