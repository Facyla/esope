<?php
/**
 * Elgg Simple editing of CMS "static" pages
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2008-2011
 * @link http://id.facyla.net/
*/

// TODO : permettre d'utiliser une cmspage existante comme moteur de template en passant des params côté code cette fois : 
// elgg_view('cmspages/view',array('pagetype'=>"maghrenov-public-template", 'customvar1' => 'whatever'))

// Hooks
elgg_register_plugin_hook_handler('permissions_check', 'object', 'cmspages_permissions_check');

// Initialise log browser
elgg_register_event_handler('init','system','cmspages_init');
elgg_register_event_handler('pagesetup','system','cmspages_pagesetup');

// Register actions
$actions_path = elgg_get_plugins_path() . 'cmspages/actions/cmspages/';
elgg_register_action("cmspages/edit", $actions_path . 'edit.php');
elgg_register_action("cmspages/delete", $actions_path . 'delete.php');



function cmspages_init() {
	elgg_extend_view('css','cmspages/css');
	
	// Register entity type
	elgg_register_entity_type('object', 'cmspage');
	
	// Register a URL handler for CMS pages
	elgg_register_plugin_hook_handler('entity:url', 'object', 'cmspages_url_handler');
	
	elgg_register_page_handler('cmspages', 'cmspages_page_handler'); // Register a page handler, so we can have nice URLs
	
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'cmspages_public_pages');
	
}


/* Populates the ->getUrl() method for cmspage objects */
function cmspages_url_handler($hook, $type, $url, $params) {
	$entity = $params['entity'];
	return elgg_get_site_url() . "cmspages/read/" . $entity->pagetype;
}


function cmspages_page_handler($page) {
	$include_path = elgg_get_plugins_path() . 'cmspages/pages/cmspages/';
	if (!isset($page[0])) { $page[0] = 'admin'; }
	if ($page[1]) { set_input('pagetype', $page[1]); }
	switch ($page[0]) {
		case "read":
			if (!include($include_path . 'read.php')) return false;
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
		default:
			if (!include($include_path . 'index.php')) return false;
	}
	return true;
}

/* Page setup. Adds admin controls */
function cmspages_pagesetup() {
	// Facyla: allow main & local admins to use this tool
	// and also a custom editor list
	if ( (elgg_in_context('admin') || elgg_is_admin_logged_in())
		|| ((elgg_in_context('cmspages_admin')) && in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))))
		) {
		$item = new ElggMenuItem('cmspages', elgg_echo('cmspages'), 'cmspages/');
		elgg_register_menu_item('topbar', $item);
	}
	return true;
}

/* Permissions for the cmspages context */
function cmspages_permissions_check($hook, $type, $returnval, $params) {
	// Handle only cmspages !!
	if (elgg_instanceof($params['entity'], 'object', 'cmspage')) {
		if (elgg_in_context('admin') && elgg_is_admin_logged_in()) { return true; }
		if (elgg_in_context('localmultisite')) { return true; }
		if ( (elgg_in_context('cmspages_admin')) || in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))) ) { return true; }
		// Add a hook for special CMS pages edition rules - let's other plugins define an extended set of editors
		// based on a custom or permission rules
		return elgg_trigger_plugin_hook('cmspages:edit', 'cmspage', $params, $returnval);
	}
	return $returnval;
}

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

/* Recherche des templates dans une page */
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
				case '%':
					$content_vars .= '<li>\'' . str_replace('%', '', strtolower($template)) . '\'</li>';
					break;
					
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
					
				case '[':
					$shortcodes .= '<li>' . strtolower($template) . '</li>';
					break;
					
				default:
					$return .= '<li>';
					$return .= '<a href="' . elgg_get_site_url() . 'cmspages/?pagetype=' . $template . '" target="_new">' . $template . '</a>';
					if ($recursive) {
							$options = array('metadata_names' => array('pagetype'), 'metadata_values' => array($template), 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1, 'offset' => 0, 'order_by' => '', 'count' => false);
							$cmspages = elgg_get_entities_from_metadata($options);
							if ($cmspages) {
								$cmspage = $cmspages[0];
								$return .= cmspages_list_subtemplates($cmspage->description, $recursive);
							}
					}
					$return .= '</li>';
			}
		}
		$return .= '</ul>';
	}
	
	// List content vars
	if ($content_vars) { $return .= '<br />Content parameters<ul>' . $content_vars . '</ul>'; }
	// List shortcodes
	if ($shortcodes) { $return .= '<br />Shortcodes<ul>' . $shortcodes . '</ul>'; }
	// List views
	if ($views) { $return .= '<br />Views<ul>' . $views . '</ul>'; }
	
	return $return;
}

// Permet l'accès aux pages des blogs en mode "walled garden"
// Allows public visibility of public cmspages which allow fullview page rendering
function cmspages_public_pages($hook, $type, $return_value, $params) {
	$ignore_access = elgg_get_ignore_access();
	elgg_set_ignore_access(true);
	
	$params = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'limit' => 0);
	$cmspages = elgg_get_entities($params);
	foreach ($cmspages as $ent) {
		// Pages publiques seulement si le niveau d'accès est public = 2 (on vérifie car override d'accès)
		// Et autorisé en pleine page
		if (($ent->access_id == 2) && ($ent->display != 'no')) {
			$return_value[] = 'cmspages/read/' . $ent->pagetype;
		}
	}
	
	/* Export embeddable content : was a test, now use a specific plugin instead
	// $return_value[] = 'cmspages/embed'; // URL pour les embed externes
	*/
	
	elgg_set_ignore_access($ignore_access);
	
	return $return_value;
}


