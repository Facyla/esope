<?php
/**
 * theme_propage_paca plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'theme_propage_paca_init');


/**
 * Init theme_propage_paca plugin.
 */
function theme_propage_paca_init() {
	global $CONFIG; // All site useful vars
	
	elgg_extend_view('css', 'theme_propage_paca/css');
	elgg_extend_view('css/digest/core', 'css/digest/extend_core');
	
	// Extend digest
	// Note : unextending does not work here, but changing priority works.. to remove modules, use empty views.
	elgg_extend_view('digest/elements/site', 'digest/elements/site/news_group', 100);
	elgg_extend_view('digest/elements/site', 'digest/elements/site/profile', 200);
	elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
	
	elgg_extend_view('groups/sidebar/members', 'theme_propage_paca/extend_group_sidebar', 800);
	
	// HOMEPAGE - Replace public and loggedin homepage
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_propage_paca_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_propage_paca_public_index');
		}
	}
	
	/*
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'theme_propage_paca');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'theme_propage_paca');
	}
	*/
	
	// Register a page handler on "poles-rh/"
	elgg_register_page_handler('poles-rh', 'theme_propage_paca_poles_page_handler');
	
		// Fonctions liées à Profile_manager
	if (elgg_is_active_plugin('profile_manager')) {
		// Nouveaux types de champs pour les groupes (permet des corrections manuelles si nécessaire)
		$group_options = array("output_as_tags" => true, "admin_only" => true);
		add_custom_field_type("custom_group_field_types", 'poles_rh', elgg_echo('theme_propage_paca:field:poles_rh'), $group_options);
	}
	
}


// Page handler
// Loads pages located in theme_propage_paca/pages/theme_propage_paca/
function theme_propage_paca_poles_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_propage_paca/pages/theme_propage_paca';
	switch ($page[0]) {
		default:
			if (!empty($page[0])) { set_input('pole', $page[0]); }
			include "$base/poles_rh.php";
	}
	return true;
}



// Other useful functions
// prefixed by plugin_name_
/*
function theme_propage_paca_function() {
	
}
*/

// Theme inria logged in index page
function theme_propage_paca_index(){
	include(elgg_get_plugins_path() . 'theme_propage_paca/pages/theme_propage_paca/loggedin_homepage.php');
	return true;
}

// Theme inria public index page
function theme_propage_paca_public_index() {
	include(elgg_get_plugins_path() . 'theme_propage_paca/pages/theme_propage_paca/public_homepage.php');
	return true;
}




// Vérification du statut d'un groupe Pôle (avec cache)
// Returns : false si non Pôle, nom du pole sinon
function theme_propage_paca_is_pole($group) {
	if (!elgg_instanceof($group, 'group')) return false;
	// Cache results
	global $theme_propage_paca;
	if (!isset($theme_propage_paca['poles'])) {
		$theme_propage_paca['poles'] = array();
		// Vérification via config (et MAJ pour accès plus rapide)
		$pole_names = theme_propage_paca_get_poles_names();
		foreach ($pole_names as $pole_name => $pole_title) {
			$pole_guid = elgg_get_plugin_setting("{$pole_name}group_guid", 'theme_propage_paca');
			$theme_propage_paca['poles'][$pole_guid ] = $pole_name;
		}
	}
	if (isset($theme_propage_paca['poles'][$group->guid])) { return $theme_propage_paca['poles'][$group->guid]; }
	return false;
}

// Get and cache Départements
function theme_propage_paca_cache_departements() {
	global $theme_propage_paca;
	if (!isset($theme_propage_paca['departements'])) {
		// Vérification via config (et MAJ pour accès plus rapide)
		$poles = theme_propage_paca_get_poles();
		foreach ($poles as $pole_name => $pole) {
			$options = array('type' => 'group', 'relationship' => AU_SUBGROUPS_RELATIONSHIP, 'relationship_guid' => $pole->guid, 'inverse_relationship' => true, 'limit' => 0);
			$departements = elgg_get_entities_from_relationship($options);
			foreach ($departements as $ent) {
				$theme_propage_paca['departements'][$pole_name][$ent->guid] = $ent;
			}
		}
	}
	return $theme_propage_paca['departements'];
}


// Vérification du statut d'un groupe Département (avec cache)
// Returns : false si non Departement, nom du pole sinon
function theme_propage_paca_is_departement($group) {
	if (!elgg_instanceof($group, 'group')) return false;
	$departements_cache = theme_propage_paca_cache_departements();
	// Check if departement is in departements list
	foreach ($departements_cache as $pole_name => $departements) {
		if (isset($departements[$group->guid])) { return $pole_name; }
	}
	return false;
}

// Départements d'un Pôle donné (= sous-groupes d'un groupe de type Pôle)
function theme_propage_paca_get_pole_departements($group) {
	$pole = theme_propage_paca_is_pole($group);
	if (!$pole) return false;
	$departements_cache = theme_propage_paca_cache_departements();
	return $departements_cache[$pole];
}

// Liste des Départements
function theme_propage_paca_list_pole_departements($group) {
	$content = '';
	$departements = theme_propage_paca_get_pole_departements($group);
	if ($departements) {
		elgg_push_context('widgets');
		$content .= '<h3>' . elgg_echo('theme_propage_paca:departements') . '</h3>';
		foreach ($departements as $ent) {
			$content .= '<span class="afparh-departements"><a href="' . $ent->getURL() . '" title="' . $ent->name . ' - ' . $ent->briefdescription . '">' 
			. elgg_view_entity_icon($ent, 'medium') 
			//. '<img src="' . $ent->getIconURL('medium') . '" alt="' . $ent->name . ' - ' . $ent->briefdescription . '" />' 
			. '<br />' . $ent->name . '</a></span>';
		}
		$content .= '<div class="clearfloat"></div>';
		elgg_pop_context();
	}
	return $content;
}


// Renvoie tous les groupes associés à un Pôle donné : Pôle, Départements, sous-groupes, et groupes de travail
// Filtre possible pour ne pas avoir les départements (ni le Pôle)
function theme_propage_paca_get_pole_groups($pole, $workgrouponly = false) {
	if (empty($pole)) return false;
	// Cache results
	global $theme_propage_paca;
	if (!isset($theme_propage_paca['groups'][$pole])) {
		// All related groups
		$pole_groups_params = array('type' => 'group', 'limit' => 0, 'metadata_name_value_pairs' => array('name' => 'poles_rh', 'value' => $pole, 'case_sensitive' => false));
		$pole_groups = elgg_get_entities_from_metadata($pole_groups_params);
		
		// Note : some subgroups or the pole itself may ot be tagged with 'poles_rh'
		// Ensure we have the pole itself + all subgroups
		$pole_group = theme_propage_paca_get_pole($pole);
		if ($pole_group) {
			// Add Pôle
			$pole_groups[] = $pole_group;
			// Add all Pôle subgroups (including Département)
			$subgroups = au_subgroups_get_all_children_guids($group);
			if ($subgroups) foreach($subgroups as $guid) {
				$subgroup = get_entity($guid);
				if ($subgroup) $pole_groups[] = $subgroup;
			}
		}
		$theme_propage_paca['groups'][$pole] = $pole_groups;
		
		// Now list Work groups only
		foreach ($pole_groups as $i => $ent) {
			// Remove Departements
			if (theme_propage_paca_is_departement($ent)) { unset($pole_groups[$i]); }
			// Remove Pole
			if (theme_propage_paca_is_pole($ent)) { unset($pole_groups[$i]); }
		}
		$theme_propage_paca['workgroups'][$pole] = $pole_groups;
	}
	
	if ($workgrouponly) return $theme_propage_paca['workgroups'][$pole];
	return $theme_propage_paca['groups'][$pole];
}

// GUID des groupes associés à un Pôle donné
// @TODO : inclure les Départements et les sous-groupes de tous niveaux
function theme_propage_paca_get_pole_groups_guids($pole, $workgrouponly = false) {
	$groups = theme_propage_paca_get_pole_groups($pole, $workgrouponly);
	foreach ($groups as $ent) { $group_guids[] = $ent->guid; }
	return $group_guids;
}

// Returns array of 'pole_name' => $pole_group_entity
function theme_propage_paca_get_poles_names() {
	return array(
		'social' => elgg_echo('theme_propage_paca:pole:social'),
		'devpro' => elgg_echo('theme_propage_paca:pole:devpro'),
		'gestion' => elgg_echo('theme_propage_paca:pole:gestion'),
	);
}

// Returns array of 'pole_name' => $pole_group_entity
function theme_propage_paca_get_poles() {
	$poles = array();
	$pole_names = theme_propage_paca_get_poles_names();
	foreach ($pole_names as $pole_name => $pole_title) {
		$pole_guid = elgg_get_plugin_setting("{$pole_name}group_guid", 'theme_propage_paca');
		if ($pole = get_entity($pole_guid)) { $poles[$pole_name] = $pole; }
	}
	return $poles;
}

// Returns a pole group entity
function theme_propage_paca_get_pole($pole_name) {
	if (empty($pole_name)) return false;
	$poles = theme_propage_paca_get_poles();
	if (isset($poles[$pole_name])) return $poles[$pole_name];
	return false;
}


