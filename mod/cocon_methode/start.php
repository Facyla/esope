<?php

// Initialise log browser
elgg_register_event_handler('init','system','cocon_methode_init');


/* Initialise the theme */
function cocon_methode_init(){
	
	// Gives access to the module at SITE_URL/methode/
	elgg_register_page_handler("methode", "cocon_methode_page_handler");
	
	
	$tmp_dir = elgg_get_plugins_path() . 'cocon_methode/vendors/cocon_methode/_tmp';
	if (!file_exists($tmp_dir) || !is_dir($tmp_dir)) {
		mkdir($tmp_dir, 0777);
	}
	
	// Tout le Kit Méthode n'est accessible qu'aux membres connectés
	// Certaines lib interrompent l'exécution si non connecté
	if (elgg_is_logged_in()) {
		// Include Methode libs
		$path = elgg_get_plugins_path() . 'cocon_methode/vendors/cocon_methode/php/inc';
		$libs = array("$path/config.inc.php", "$path/database.inc.php", "$path/utils.inc.php", "$path/mail.inc.php", "$path/xml.inc.php", "$path/cycle.inc.php");
		foreach ($libs as $lib) { require_once($lib); }
	
	// Set secret for Methode app actionsMay be updated afterwards, if cycle of group changed
		$gid = cocon_methode_get_user_group();
		$cid = getCurrentCycleID($gid);
		//error_log("Cocon Kit START : $gid / $cid => " . md5($gid.'_'.$cid)); // debug
		if ($gid && $cid) $_SESSION['check_id'] = md5($gid.'_'.$cid);
	}
	
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
	
	// Ignore access during creation process
	$ia = elgg_set_ignore_access(true);
	
	// Détermine le groupe associé à l'utilisateur - a priori celui de l'établissement correspondant
	$user_group = elgg_get_entities_from_metadata(array('type' => 'group', 'metadata_name_value_pairs' => array('name' => 'cocon_etablissement', 'value' => $user->cocon_etablissement)));
	$group = $user_group[0];
	
	// Create group if it does not exist
	if (!elgg_instanceof($group, 'group')) {
		$group = cocon_create_group($user->cocon_etablissement);
		$msg = elgg_echo('cocon_methode:group:created');
		system_message($msg);
		//error_log("COCON : group for {$user->cocon_etablissement} did not exist. Created as {$group->guid}.");
	} else {
		// @TODO update group data ?  not essential, as it is not used, but todo if contact email or address is displayed and/or used
		
	}
	
	// Join group if not member yet
	if (elgg_instanceof($group, 'group') && !$group->isMember($user)) {
		groups_join_group($group, $user);
		
		// Add notification
		$groupjoin_enablenotif = elgg_get_plugin_setting('groupjoin_enablenotif', 'adf_public_platform');
		if (empty($groupjoin_enablenotif) || ($groupjoin_enablenotif != 'no')) {
			switch($groupjoin_enablenotif) {
				case 'site':
					add_entity_relationship($user->guid, 'notifysite', $group->guid);
					break;
				case 'all':
					foreach($NOTIFICATION_HANDLERS as $method => $foo) {
						add_entity_relationship($user->guid, "notify{$method}", $group->guid);
					}
					break;
				case 'email':
				default:
					add_entity_relationship($user->guid, 'notifyemail', $group->guid);
			}
		} else if ($groupjoin_enablenotif == 'no') {
			// loop through all notification types
			foreach($NOTIFICATION_HANDLERS as $method => $foo) {
				remove_entity_relationship($user->guid, "notify{$method}", $group->guid);
			}
		}
		
		// add_user_to_access_collection($user->guid, $acl); // Force access collection
		$msg = elgg_echo('cocon_methode:group:joined', array($group->name));
		system_message($msg);
		//error_log("COCON : group joined");
	}
	
	// Update group role according to user role
	$user_role = cocon_methode_get_user_role();
	switch($user_role) {
		case "0":
			// Direction : admin groupe
			if (!check_entity_relationship($user->guid, 'operator', $group->guid)) {
				add_entity_relationship($user->guid, 'operator', $group->guid);
				$msg = elgg_echo('cocon_methode:group:admin', array($group->name));
				system_message($msg);
				// Notification du mail de contact du collège
				$site = elgg_get_site_entity();
				// Set From and default To
				if (is_email_address($site->email)) {
					$from = $site->email;
					$to = $group->cocon_mail;
				}
				// Use wanted to if valid (failsafe to site email so someone is notified)
				if (is_email_address($group->cocon_mail)) { $to = $group->cocon_mail; }
				// Send notification
				if ($from && $to) {
					// Lists all existing functions
					$fonctions = elgg_get_plugin_setting("fonctions", 'theme_cocon');
					$fonctions = esope_build_options($fonctions, true);
					$fonction = $fonctions[$user->cocon_fonction];
					$subject = elgg_echo('cocon_methode:groupadmin:subject', array($user->name, $group->name));
					$body = elgg_echo('cocon_methode:groupadmin:body', array($user->name, $group->name, $fonction, $site->url, $site->email));
					elgg_send_email($from, $to, $subject, $body, NULL);
				}
				
			}
			break;
		case "1":
			// Equipe : simple membre
			/*
			if (check_entity_relationship($user->guid, 'operator', $group->guid)) {
				remove_entity_relationship($user->guid, 'operator', $group->guid);
				$msg = elgg_echo('cocon_methode:group:nomoreadmin', array($group->name));
				system_message($msg);
			}
			*/
			break;
		case "2":
		default:
			// Autre : simple membre aussi ? ou rien du tout ?
			/*
			if (check_entity_relationship($user->guid, 'operator', $group->guid)) {
				remove_entity_relationship($user->guid, 'operator', $group->guid);
				$msg = elgg_echo('cocon_methode:group:nomoreadmin', array($group->name));
				system_message($msg);
			}
			*/
	}
	
	/*
	$user_groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
	$group = $user_groups[0];
	*/
	
	// Restore original access
	elgg_set_ignore_access($ia);
	
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


// Permet de créer un groupe pour un établissement
function cocon_create_group($code = false) {
	global $CONFIG;
	if (!$code) { return false; }
	
	// Ignore access during creation process
	$ia = elgg_set_ignore_access(true);
	
	// Avoid duplicates
	$user_group = elgg_get_entities_from_metadata(array('type' => 'group', 'metadata_name_value_pairs' => array('name' => 'cocon_etablissement', 'value' => $code)));
	$group = $user_group[0];
	if (elgg_instanceof($group, 'group')) { return $group; }
	
	// Liste des établissements
	$values = elgg_get_plugin_setting("etablissements", 'theme_cocon');
	// CSV = Recursive array : split on \n, then ;
	$etablissements_csv = esope_get_input_recursive_array($values, array(array("|", "\r", "\t"), ';'), true);
	//echo '<pre>' . print_r($etablissements, true) . '</pre>';
	// Build array as code => array('Nom', 'Académie', 'UAI code', 'Département', 'Adresse', 'mail')
	$etablissements = array();
	foreach ($etablissements_csv as $etablissement) {
		// Structure : Nom (0) ; Académie (1) ; UAI (2) ; Département (3) ; Adresse (4) ; mail (5)
		$etablissements["{$etablissement[2]}"] = $etablissement;
	}
	
	$etablissement_name = $etablissements["$code"][0];
	$etablissement_academie = $etablissements["$code"][1];
	$etablissement_departement = $etablissements["$code"][3];
	$etablissement_adresse = $etablissements["$code"][4];
	$etablissement_mail = $etablissements["$code"][5];
	
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
	// Add also some useful metadata
	$group->cocon_academie = $etablissement_academie;
	$group->cocon_departement = $etablissement_departement;
	$group->cocon_adresse = $etablissement_adresse;
	$group->cocon_mail = $etablissement_mail;
	
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
	
	// Restore original access
	elgg_set_ignore_access($ia);
	
	return $group;
}


