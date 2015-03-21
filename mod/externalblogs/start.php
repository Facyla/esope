<?php
/**
 * Externalblogs plugin
 * Principe : 
	 - un object "blog de sortie" = on définit un objet externalblog, comprenant : un template de page, et des modes d'affichage et de navigation
	 - et du côté des contenus, on étend les objets classiques pour leur ajouter des metadata simples supplémentaires, qui permettent de rendre ces contenus accessibles
	 - alternative à réfléchir : des critères de sélection de contenus (owners, containers, tags, subtypes, dates, tris)
 * On a ensuite besoin de rendre ces contenus publiquement accessibles : il faut les ajouter à l'array des pages publiquement accessibles, avec leur URL exacte ET avoir des droits publics sur ces contenus (pas d'override des droits standards)
 * les metadata à ajouter = marqueurs spécifiques, type 'pin', facilement activable et qui enregistrent la date de "première publication" (sélection) => $object->externablog_ts (timestamp), et les id des blogs/espaces de publication ->externalblog_blogs = array(guids des blogs externes)
 * Enfin, on peut protéger l'accès à certains de ces blogs par mot de passe...
 *
 * Faire des blogs des ElggGroup ? ou des ElggUser ? ou des ElggEntity de base (mais Friendable) ?
 *
 */
elgg_register_event_handler('init', 'system', 'externalblogs_init'); // Init


/**
 * Init externalblogs plugin.
 */
function externalblogs_init() {
	
	// ACTIONS
	$action_path = dirname(__FILE__) . "/actions/externalblogs";
	// Actions pour éditer les blogs : edit, delete
	elgg_register_action('externalblogs/edit', "$action_path/edit.php");
	elgg_register_action('externalblog/delete', "$action_path/delete.php");
	// Actions pour (dé)sélectionner les articles : selectedit
	// note : pas de delete car on modifie seulement les valeurs
	elgg_register_action('externalblogs/selectedit', "$action_path/selectedit.php");
	/*
	// Actions pour éditer les modules (blocs de contenus configurables) : edit, delete
	elgg_register_action('externalblog_module/edit', "$action_path/modules/edit.php");
	elgg_register_action('externalblog_module/delete', "$action_path/modules/delete.php");
	// Actions pour éditer les layouts (N zones agencés dans une page) : edit, delete
	elgg_register_action('externalblog_layout/edit', "$action_path/layout/edit.php");
	elgg_register_action('externalblog_layout/delete', "$action_path/layout/delete.php");
	*/
	
	// ACCESS - Write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'externalblogs_canedit_permission_check');
	
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'externalblogs_public_pages');
	
	// ENTITY MENU (select/unselect)
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'externalblogs_entity_menu_setup', 600);
	
	// PAGE HANDLERS
	elgg_register_page_handler('externalblog', 'externalblogs_page_handler');
	// On définit la liste des page_handler configurables des blogs à mettre en place
	// = ce qu'on veut sauf ceux réservés..
	$ia = elgg_set_ignore_access(true);
	$externalblogs_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'count' => true));
	//$externalblogs = elgg_get_entities(array('subtypes' => 'externalblog', 'limit' => $externalblogs_count));
	$externalblogs = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'limit' => $externalblogs_count));
	// @todo voir si fonction pour les récupérer ? ou dans $CONFIG ?
	$reserved_handlers = array('admin', 'view', 'entity', 'action', 'blog', 'bookmarks', 'pages', 'cmspage');
	if (is_array($externalblogs))
	foreach ($externalblogs as $externablog) {
		if (in_array($externablog->blogname, $reserved_handlers)) {
			register_error('Page handler réservé (' . $externablog->blogname . '), veuillez en choisir un autre.');
		} else {
			elgg_register_page_handler($externablog->blogname, 'externalblogs_blog_page_handler');
		}
	}
	elgg_set_ignore_access($ia);
	
	/*
	// Widgets
	$externalblog_contexts = array('externalblog_home', 'externalblog_fullview', 'externalblog_category', 'externalblog_listing');
	foreach ($externalblog_contexts as $externalblog_context) {
		use_widgets($externalblog_context); // Register a particular context for use with widgets
	}
	*/
	
	// @TODO : étendre les objets pour leur attribuer des metadata et dates de publication, fin de publication
	
}


// Routage des URLs des blogs externes
function externalblogs_page_handler($page) {
	$pages = dirname(__FILE__) . '/pages/externalblogs';
	if (empty($page[0])) $page[0] = 'all';
	switch($page[0]) {
		case "blog":
			set_input('blogname', $page[1]);
			include "$pages/blog_index.php";
			break;
		case "add":
			set_input('container_guid', $page[1]);
			include "$pages/blog_edit.php";
			break;
		case "edit":
			set_input('guid', $page[1]);
			include "$pages/blog_edit.php";
			break;
		case "all":
		default:
			include("$pages/externalblogs.php");
	}
	return true;
}
// Routage des URLs des blogs (affiche un blog donné via son propre handler)
function externalblogs_blog_page_handler($page) {
	$pages = dirname(__FILE__) . '/pages/externalblogs';
	//global $CONFIG; $CONFIG->walled_garden = false;
	include("$pages/blog_index.php");
	return true;
}


// Permet l'accès aux pages des blogs en mode "walled garden"
function externalblogs_public_pages($hook, $type, $return_value, $params) {
	global $CONFIG;
	$return_value[] = 'externalblog'; // Index des blogs externes
	elgg_set_ignore_access(true);
	$externalblogs_count = elgg_get_entities(array('subtypes' => 'externalblog', 'count' => true));
	//$externalblogs = elgg_get_entities(array('subtypes' => 'externalblog', 'limit' => $externalblogs_count));
	$externalblogs = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'limit' => $externalblogs_count));
	// Autorisation des fichiers (ssi publics, les autres = page vide)
	$return_value[] = 'mod/file/thumbnail.php.*';
	//$return_value[] = 'file/download/.*';
	foreach ($externalblogs as $eblog) {
		// Page d'accueil du blog externe
		if ($eblog->access_id == 2) {
			$return_value[] = $eblog->blogname;
			$return_value[] = $eblog->blogname.'/.*';
			// On récupère toutes les pages concernées par ce blog externe
			$articles = elgg_get_entities_from_relationship(array('relationship_guid' => $eblog->guid, 'relationship' => 'attached', 'inverse_relationship' => false));
			//error_log($eblog->blogname . ' : ' . $eblog->blogname . ' => ' . count($articles));
			// Note : les URL changent d'un blog externe à l'autre..
			foreach ($articles as $article) {
				// Pages publiques seulement si le niveau d'accès est public (2) (on vérifie car override d'accès)
				if ($article->access_id == 2) {
					// On autorise l'URL complète, mais aussi courte (permalien)
					$return_value[] = $eblog->blogname . '/' . $article->guid; // Permalien
					$return_value[] = $eblog->blogname . '/' . $article->guid . '/' . friendly_title($article->title);
				}
			}
		}
	}
	elgg_set_ignore_access(false);
	return $return_value;
}


// Bouton de publication dans les blogs - Add externalblogs to entity menu at end of the menu
function externalblogs_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	$entity = $params['entity'];
	if ($entity->getType() == 'object') {
		if ($entity->getSubtype() != 'externalblog') {
			$options = array('name' => 'externalblogs', 'href' => false, 'priority' => 900, 'text' => elgg_view('externalblogs/button', array('entity' => $entity)));
			$return[] = ElggMenuItem::factory($options);
		}
	}
	return $return;
}


function externalblogs_count($entity) {
	$type = $entity->getType();
	$params = array('entity' => $entity);
	$number = elgg_trigger_plugin_hook('externalblogs:count', $type, $params, false);
	if ($number) { return $number; }
	else { return $entity->countAnnotations('externalblogs'); }
}
function externalblogs_list($entity) {
	$type = $entity->getType();
	$params = array('entity' => $entity);
	//$list = $entity->getAnnotations('externalblogs');
	return $list;
}

/* Affiche une page en fonction du layout choisi
 * Le layout définit N zones et leur agencement
 * Les zones sont définies dans la configuration, et comprennent la configuration des modules
*/
function externalblog_compose_layout($layout = '1column', $layout_config, $externalblog_context = '', $content = false) {
	// zone1?module1=param1:xx,param2:yy&module2=param1:xx&module3
	// zone2?module2=param1:xx
	// zone3?module3
	// Note : le contenu peut être défini directement dans les zones 
	// au lieu d'être forcé dans l'une en particulier
	$zones_config = externalblog_extract_zones_config($layout_config);
	switch($layout) {
		case '1column':
			$zone1 = externalblog_compose_zone($zones_config['zone1'], $content);
			return '<div id="' . $externalblog_context . '"><div id="externalblog_1column" style=""><div id="externalblog_zone1">' . $zone1 . '</div></div></div>';
			break;
		case '2column':
			$zone1 = externalblog_compose_zone($zones_config['zone1'], $content);
			$zone2 = externalblog_compose_zone($zones_config['zone2'], $content);
			return '<div id="' . $externalblog_context . '"><div id="externalblog_2column" style="width:70%; margin:0 auto;"><div id="externalblog_zone1" style="float:left; width:30%;">' . $zone1 . '</div><div id="externalblog_zone2" style="float:right; width:68%;">' . $zone2 . '</div></div></div>';
			break;
		case '3column':
			$zone1 = externalblog_compose_zone($zones_config['zone1'], $content);
			$zone2 = externalblog_compose_zone($zones_config['zone2'], $content);
			$zone3 = externalblog_compose_zone($zones_config['zone3'], $content);
			return '<div id="' . $externalblog_context . '"><div id="externalblog_3column" style="width:70%; margin:0 auto;"><div id="externalblog_zone1">' . $zone1 . '</div><div id="externalblog_zone2">' . $zone2 . '</div><div id="externalblog_zone3">' . $zone3 . '</div></div></div>';
			break;
	}
}

function externalblog_compose_zone($zone_config, $content = false) {
	foreach ($zone_config as $module_index => $module_config) {
		$module_name = $module_config['module_name'];
		//error_log("TEST externalblog start.php externalblog_compose_zone : $module_index / $module_name");
		if ($module_name == "content") $return .= '<div id="externalblog_content">' . $content . '</div>';
		else $return .= externalblog_compose_module($module_name, $module_config, $content);
	}
	return $return;
}

/* Composes a module from its name + optional settings and content
 * module_name String
 * module_config Array('name_or_index' => array('param' => value))
 * body String (templates only) : Loads additional content that will be rendered in {{%CONTENT%}}
*/
function externalblog_compose_module($module_name, $module_config = false, $body = null) {
	// Attention : toute entité non affichable renvoie sur la home
	switch($module_name) {
		case 'cmspage':
			// @todo : ce serait bien de pouvoir passer un contenu dans les templates..
			$return = elgg_view('cmspages/view',array('pagetype'=> $module_config['page'], 'body' => $body));
			break;
		case 'title':
			$return .= "<h3>" . $module_config['text'] . "</h3>";
			break;
		case 'listing':
			$return = "<h3>Listing configurable</h3>";
			$type = $module_config['type'];
			$subtype = $module_config['subtype'];
			if ($subtype == 'all') $subtype = get_registered_entity_types($type);
			if (!$subtype) $subtype = '';
			$ents = elgg_get_entities(array('type' => $type, 'subtype' => $subtype));
			if (is_array($ents)) {
				if (in_array($module_config['type'], array('group', 'user'))) {
					foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->name . '</a><br />';
				} else {
					foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->title . '</a><br />';
				}
			}
			break;
		case 'search':
			$return = "<h3>Résultats de recherche</h3>";
			switch($module_config['type']) {
				case 'object': $ents = search_for_object($module_config['criteria']); break;
				case 'group': $ents = search_for_group($module_config['criteria']); break;
				case 'user': $ents = search_for_user($module_config['criteria']); break;
				case 'site': $ents = search_for_site($module_config['criteria']); break;
			}
			if (in_array($module_config['type'], array('group', 'user'))) foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->name . '</a><br />';
			else foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->title . '</a><br />';
			break;
		case 'view':
			$return = "<h3>Vue configurée</h3>";
			if ($module_config['guid'] && ($ent = get_entity($module_config['guid']))) $return .= $ent->guid . ' : ' . $ent->title . $ent->name . '<br />' . $ent->description;
			break;
		default:
			$return = "<h3>Module $module_name</h3>" . print_r($module_config, true) . "<br />";
			break;
	}
	return $return;
}

function externalblog_extract_zones_config($layout_config) {
	$return = array();
	$layout_config = str_replace('\r', '\n', $layout_config);
	$layout_config = str_replace('\n\n', '\n', $layout_config);
	$config_lines = explode("\n", $layout_config);
	if (!$config_lines) $return = false; else 
	foreach ($config_lines as $config_line) {
		// zone1?module1=param1:xx,param2:yy&module2=param1:xx&module3
		$config = explode('?', $config_line);
		// zone1, module1=param1:xx,param2:yy&module2=param1:xx&module3
		$zone_name = $config[0];
		$zone_config = explode("&", $config[1]);
		// module1=param1:xx,param2:yy, module2=param1:xx, module3
		// Configuration de chacun des modules
		if (!$zone_config) $return[$zone_name] = false; else 
		$i = 0;
		foreach ($zone_config as $module) {
			$module = explode('=', $module);
			// module1, param1:xx,param2:yy
			$module_name = $module[0];
			$module_params = explode(",", $module[1]);
			// param1:xx, param2:yy
			$return[$zone_name][$i]['module_name'] = $module_name;
			if (!$module_params) $return[$zone_name][$module_name] = false; else 
			foreach ($module_params as $module_param) {
				$module_param = explode(':', $module_param);
				$param_name = $module_param[0];
				$param_value = $module_param[1];
				// Composition du tableau de retour : $config[zone][module][param1] = valeur param
				$return[$zone_name][$i][$param_name] = $param_value;
			}
			$i++;
		}
	}
	return $return;
}

/**
 * Extend permissions checking to extend can-edit for blogadmin users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function externalblogs_canedit_permission_check($hook, $entity_type, $returnvalue, $params) {
	if ($params['entity']->getSubtype() == 'externalblog') {
		$userguid = $params['user']->guid;
		$blogadmins = string_to_tag_array($params['entity']->blogadmin_guids);
		// Can edit : owner + other blog admins, container admins, admins
		if ( ($userguid == $params['entity']->owner_guid) || in_array($userguid, $blogadmins) 
		|| (($container = get_entity($params['entity']->container_guid)) && $container->canEdit($userguid))
		|| is_admin_logged_in()
		) {
			return true;
		}
	}
}


