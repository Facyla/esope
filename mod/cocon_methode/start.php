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
	
	// @TODO : déterminer le groupe associé à l'utilisateur - a priori celui de l'établissement correspondant
	// Peut dépendre aussi du rôle de l'utilisateur
	/*
	$user_group = elgg_get_entities_from_metdata(array('type' => 'group', 'metadata_name_pair_values' => array('metadata_name' => 'code_etablissement', 'metadata_value' => $user->code_etablissement)));
	*/
	
	$user_groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
	$group = $user_groups[0];
	return $group->guid;
}

// Returns user role for Methode, based on actual role
function cocon_methode_get_user_role($user = false) {
	if (!$user) { $user = elgg_get_logged_in_user_entity(); }
	if (!elgg_instanceof($user, 'user')) { return false; }
	
	switch($user->fonction_etab) {
		case 'principal':
		case 'direction':
			$role = 0;
			break;
		case 'equipe':
			$role = 1;
			break;
		default:
			$role = 2;
	}
	return $role;
}

