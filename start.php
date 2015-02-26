<?php

// Initialise log browser
elgg_register_event_handler('init','system','cocon_methode_init');


/* Initialise the theme */
function cocon_methode_init(){
	
	// Gives access to the module at SITE_URL/cocon_methode/
	elgg_register_page_handler("methode", "cocon_methode_page_handler");
	
}


// Handles Cocon SGMAP URL
function cocon_methode_page_handler($page){
	global $CONFIG;
	forward($CONFIG->url . 'mod/cocon_methode/vendors/cocon_methode/index.php');
	//include(dirname(__FILE__) . '/vendors/cocon_methode/index.php');
	return true;
}


// Renvoie le groupe associé à l'utilisateur demandé
function cocon_methode_get_user_group($user_guid = false) {
	if (!$user_guid) {
		$user = elgg_get_logged_in_user_entity();
	} else {
		$user = get_entity($user_guid);
	}
	if (!elgg_instanceof($user, 'user')) { return false; }
	
	// Create group is it doesn't exist yet
	if (empty($user->cocon_etablissement)) { return false; }
	
	// Détermine le groupe associé à l'utilisateur - a priori celui de l'établissement correspondant
	$user_group = elgg_get_entities_from_metadata(array('type' => 'group', 'metadata_name_value_pairs' => array('name' => 'cocon_etablissement', 'value' => $user->cocon_etablissement)));
	$group = $user_group[0];
	
	
	// Create group is it does not exist
	if (!elgg_instanceof($group, 'group')) {
		$group = cocon_create_group($user->cocon_etablissement);
		$group->join($user);
		error_log("COCON : group did not exist. Created : {$group->guid}");
		// Refresh page
		//forward('methode');
	}
	
	// Join group is not member yet
	if (elgg_instanceof($group, 'group')) {
		if (!$group->isMember($user)) {
			$group->join($user);
			register_error("Vous avez été inscrit dans le groupe de votre établissement : {$group->name}");
			//error_log("COCON : group joined");
		}
	}
	
	// Update group role according to user role
	$user_role = cocon_methode_get_user_role();
	switch($user_role) {
		case "0":
			// Direction : admin groupe
			if (!check_entity_relationship($user->guid, 'operator', $group->guid)) {
				add_entity_relationship($user->guid, 'operator', $group->guid);
				register_error("En tant que membre de la Direction, vous êtes désormais l'un des responsables du groupe de votre établissement.");
			}
			break;
		case "1":
			// Equipe : simple membre
			if (check_entity_relationship($user->guid, 'operator', $group->guid)) {
				remove_entity_relationship($user->guid, 'operator', $group->guid);
			}
			break;
		case "2":
		default:
			// Autre : simple membre aussi ? ou rien du tout ?
			if (check_entity_relationship($user->guid, 'operator', $group->guid)) {
				remove_entity_relationship($user->guid, 'operator', $group->guid);
			}
	}
	
	/*
	$user_groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
	$group = $user_groups[0];
	*/
	
	return $group->guid;
}

// Returns user role for Methode, based on actual role
function cocon_methode_get_user_role($user = false) {
	if (!$user) { $user = elgg_get_logged_in_user_entity(); }
	if (!elgg_instanceof($user, 'user')) { return false; }
	
	switch($user->cocon_fonction) {
		case 'principal':
		case 'chef':
		case 'chefadjoint':
		case 'direction':
			$role = 0;
			break;
		case 'cpe':
		case 'equipe':
		case 'projet':
		case 'enseignant':
		case 'autre':
			$role = 1;
			break;
		default:
			$role = 2;
	}
	return $role;
}


function cocon_create_group($code = false) {
	global $CONFIG;
	if (!$code) { return false; }
	
	// Avoid duplicates
	$user_group = elgg_get_entities_from_metadata(array('type' => 'group', 'metadata_name_value_pairs' => array('name' => 'cocon_etablissement', 'value' => $code)));
	$group = $user_group[0];
	if (elgg_instanceof($group, 'group')) { return $group; }
	
	// Liste des établissements
	$etablissements = esope_build_options($values, true);
	//$etablissement_name = $etablissements["$code"];
	$etablissement_name = "Etablissement $code";
	
	// Create new group
	$group = new ElggGroup();
	$group->access_id = ACCESS_PUBLIC; // Public first, private after ACL created
	$group->owner_guid = $CONFIG->site->guid;
	$group->name = $etablissement_name;
	$group->membership = $is_public_membership ? ACCESS_PUBLIC : ACCESS_PRIVATE;
	$group->save();
	
	// Set ACL and access
	$visibility = $group->group_acl;
	$group->access_id = $visibility;
	$group->save();
	
	// Set main metadata for Kit Méthode Cocon
	$group->cocon_etablissement = $code;
	
	// Set group tool options : disable all, enable discussions
	$tool_options = elgg_get_config('group_tool_options');
	if ($tool_options) {
		foreach ($tool_options as $group_option) {
			$option_toggle_name = $group_option->name . "_enable";
			$group->$option_toggle_name = 'no';
			//error_log("Group tool : $option_toggle_name");
		}
	}
	// Enable discussions
	$group->forum_enable = 'yes';
	
	return $group;
}


