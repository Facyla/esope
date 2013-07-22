<?php
/**
 * dossierdepreuve plugin
 *
 */

elgg_register_event_handler('init', 'system', 'dossierdepreuve_init'); // Init
elgg_register_event_handler("pagesetup", "system", "dossierdepreuve_pagesetup"); // Menu

// Actions
$action_path = dirname(__FILE__) . "/actions/dossierdepreuve/";
elgg_register_action("dossierdepreuve/autopositionnement_new", $action_path . "autopositionnement_edit.php");
elgg_register_action("dossierdepreuve/autopositionnement_edit", $action_path . "autopositionnement_edit.php");
elgg_register_action("dossierdepreuve/new", $action_path . "edit.php");
elgg_register_action("dossierdepreuve/edit", $action_path . "edit.php");
elgg_register_action("dossierdepreuve/delete", $action_path . "delete.php");
elgg_register_action("dossierdepreuve/edit_members", $action_path . "edit_members.php");
elgg_register_action("dossierdepreuve/inscription", $action_path . "inscriptions.php");


/**
 * Init dossierdepreuve plugin.
 */
function dossierdepreuve_init() {
	global $CONFIG;
	
	elgg_extend_view('css', 'dossierdepreuve/css');
	elgg_extend_view("js/elgg", "dossierdepreuve/js");
	
	// Register entity_type (for search)
	elgg_register_entity_type('object', 'dossierdepreuve');
	
	// Register a page handler
	elgg_register_page_handler('dossierdepreuve','dossierdepreuve_page_handler');
	
	// Register a URL handler
	elgg_register_entity_url_handler('object', 'dossierdepreuve', 'dossierdepreuve_url');
	
	// Group tool view
	add_group_tool_option('dossierdepreuve', elgg_echo('dossierdepreuve:groupenable'), false);
	elgg_extend_view('groups/tool_latest', 'dossierdepreuve/group_module');
	
	// Group owner_block menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'dossierdepreuve_group_menu');
	
	// Ajout sélection des compétences du référentiel
	elgg_register_action('blog/save', elgg_get_plugins_path() . 'dossierdepreuve/actions/blog/save.php');
	elgg_register_action('file/upload', elgg_get_plugins_path() . 'dossierdepreuve/actions/file/upload.php');
	
	// Widgets
	elgg_register_widget_type('dossierdepreuve', elgg_echo('dossierdepreuve:widget:title'), elgg_echo('dossierdepreuve:widget:description'), 'all', true);
	elgg_register_widget_type('mydossierdepreuve', elgg_echo('dossierdepreuve:widget:mydossier:title'), elgg_echo('dossierdepreuve:widget:mydossier:description'));
	
	elgg_unregister_widget_type('friends');
	elgg_register_widget_type('friends', elgg_echo('dossierdepreuve:widget:friends:title'), elgg_echo('dossierdepreuve:widget:friends:description'), 'all', true); // Multiple instances
	
	// Edit hook so that we can use ->canEdit() instead of per-view edit check
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'dossierdepreuve_edit_permission_check');
	
}



function dossierdepreuve_pagesetup() {
	global $CONFIG;
	if (elgg_is_logged_in()) {
		$profiletype = dossierdepreuve_get_user_profile_type();
		if (elgg_in_context('groups')) {
			// Création de groupe ssi organisation ou admin
			//if (!in_array($profiletype, array('organisation', 'evaluator', 'tutor')) && !elgg_is_admin_logged_in() ) 
			if (!in_array($profiletype, array('organisation')) && !elgg_is_admin_logged_in() ) {
				elgg_unregister_menu_item('title', 'add');
			}
		}
	}
	return true;
}


/** Dossierdepreuve page handler */
function dossierdepreuve_page_handler($page) {
	global $CONFIG;
	elgg_push_breadcrumb(elgg_echo('dossierdepreuve:all'), "dossierdepreuve/all");
	if (!isset($page[0])) { $page[0] = 'all'; }
	$dossierdepreuve_root = dirname(__FILE__);
	switch($page[0]) {
		case "view":
			set_input('guid',$page[1]);
			require($dossierdepreuve_root . "/pages/dossierdepreuve/view.php");
			break;
		case "edit": set_input('guid',$page[1]);
		case "new":
			require($dossierdepreuve_root . "/pages/dossierdepreuve/edit.php");
			break;
		case "autopositionnement":
			require($dossierdepreuve_root . "/pages/dossierdepreuve/autopositionnement.php");
			break;
		case "gestion":
			require($dossierdepreuve_root . "/pages/dossierdepreuve/gestion_apprenants.php");
			break;
		case "register":
		case "inscription":
			require($dossierdepreuve_root . "/pages/dossierdepreuve/inscription_apprenants.php");
			break;
		case "owner": set_input('username',$page[1]);
			require($dossierdepreuve_root . "/pages/dossierdepreuve/owner.php");
			break;
		case "group": set_input('group',$page[1]);
			require($dossierdepreuve_root . "/pages/dossierdepreuve/group.php");
			break;
		case "export": set_input('guid',$page[1]);
			require($dossierdepreuve_root . "/pages/dossierdepreuve/export.php");
			break;
		case "pdfexport": set_input('guid',$page[1]);
			require($dossierdepreuve_root . "/pages/dossierdepreuve/export_pdf.php");
			break;
		case "search": set_input('q',$page[1]);
		case "all":
		default:
			require($dossierdepreuve_root . "/pages/dossierdepreuve/world.php");
	}
	elgg_pop_context();
	return true;
}


/**
 * Add a menu item to the group ownerblock
 */
function dossierdepreuve_group_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
		if ($params['entity']->dossierdepreuve_enable == "yes") {
			$url = "dossierdepreuve/group/{$params['entity']->guid}";
			$item = new ElggMenuItem('dossierdepreuve', elgg_echo('dossierdepreuve:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}


/** Populates the ->getUrl() method for dossierdepreuve objects
 * @param ElggEntity $entity dossierdepreuve entity
 * @return string dossierdepreuve URL
 */
function dossierdepreuve_url($entity) {
	global $CONFIG;
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return $CONFIG->url . "dossierdepreuve/view/" . $entity->getGUID() . "/" . $title;
}


/* Renvoie le nom du profil en clair, ou false si aucun trouvé/valide */
function dossierdepreuve_get_user_profile_type($user = false) {
	if (!elgg_instanceof($user, 'user')) $user = elgg_get_logged_in_user_entity();
	$profile_type = false;
	// Type de profil
	if ($profile_type_guid = $user->custom_profile_type) {
		if (($custom_profile_type = get_entity($profile_type_guid)) && ($custom_profile_type instanceof ProfileManagerCustomProfileType)) {
			$profile_type = $custom_profile_type->metadata_name;
		}
	}
	return $profile_type;
}


/* A définir pour renvoyer les autorisations pour un user donné, en lecture ou en édition, selon le type de profil */
function dossierdepreuve_get_rights($action, $user = false) {
	$profile_type = dossierdepreuve_get_user_profile_type($user);
	//$profile_type = $user->profile_type;
	/*
	switch ($profile_type) {
		case 'learner':
			// Seul l'auteur peut modifier les infos auto-évaluatives
			break;
		case 'tutor':
			// Le formateur peut modifier les infos formatives
			break;
		case 'evaluator':
			// L'évaluateur peut modifier les infos formatives + évaluer le dossier
			break;
		default:
			// Les autres sont rejetés
	}
	*/
	return $profile_type;
}


/* Dossierdepreuve gatekeeper
 * generic deny access to non-authorized people
 * Note on generic access : Ok except if we find some unmet condition
 */
function dossierdepreuve_gatekeeper($forward = true, $user_guid = false, $admin_bypass = true) {
	$allowed = true;
	
	// Loggedin users only
	if (elgg_is_logged_in()) {
		if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();
		// Valid users only
		if ($user = get_entity($user_guid)) {
		} else { $allowed = false; }
		if ($admin_bypass && elgg_is_admin_user($user_guid)) { $allowed = true; } // Admin bypass
	} else { $allowed = false; }
	
	// Return true if everything is OK
	if ($allowed) return true;
	// Otherwise, return result or forward (depending on params)
	if ($forward) { register_error(elgg_echo('dossierdepreuve:noaccess')); forward(); } 
	else { return false; }
}


/* Dossierdepreuve gatekeeper
 * deny access to a specific dossier to non-authorized people
 * Note on per-dossier access : no access until we can tell for sure it's OK
 */
function dossierdepreuve_dossier_gatekeeper($dossier_guid = false, $forward = true, $user_guid = false, $admin_bypass = true) {
	$allowed = false;
	// Loggedin users only
	if (elgg_is_logged_in()) {
		if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();
		// Valid users only
		if ($user = get_entity($user_guid)) {
			// Valid dossiers only
			if ($dossier = get_entity($dossier_guid)) {
				// Profiles specific accesses
				$profiletype = dossierdepreuve_get_user_profile_type($user);
				switch ($profiletype) {
					case 'learner':
						// Owner only
						if ($user_guid == $dossier->owner_guid) $allowed = true;
						break;
					case 'tutor':
					case 'evaluator':
					case 'organisation':
					case 'other_administrative':
						if ($dossier_owner = get_entity($dossier->owner_guid)) {
							// Only if owner belongs to one of the user's group
							$myadmin_groups = theme_compnum_myadmin_groups($user);
							if ($myadmin_groups) foreach ($myadmin_groups as $ent) {
								// If user is member of any of theses groups => OK
								if ($ent->isMember($dossier_owner)) $allowed = true;
							}
						} else $allowed = false; // @TODO : Can't get owner => access denied or bypass ?
						break;
					default:
						// Unspecified profile => denied access
				}
			}
			// Admin bypass - Note: $user_guid MUST be a valid guid
			if ($admin_bypass && elgg_is_admin_user($user_guid)) { $allowed = true; }
		}
	}
	
	// Return true if everything is OK
	if ($allowed) return true;
	// Otherwise, return result or forward (depending on params)
	if ($forward) { register_error(elgg_echo('dossierdepreuve:noaccess')); forward(); } 
	else { return false; }
}


/* Dossierdepreuve can create new dossier for someone
 * deny access to creation form to non-authorized people
 * Note on per-dossier access : no access until we can tell for sure it's OK
 */
function dossierdepreuve_can_create_for_user($owner_guid = false, $editor_guid = false, $admin_bypass = true) {
	$allowed = false;
	// Loggedin users only
	if (elgg_is_logged_in()) {
		// Set defaults to loggedin user
		if (!$owner_guid) $owner_guid = elgg_get_logged_in_user_guid();
		if (!$editor_guid) $editor_guid = elgg_get_logged_in_user_guid();
		// Valid users only (both !)
		if (($owner = get_entity($owner_guid)) && ($editor = get_entity($editor_guid))) {
			/*
			// Owner can edit own dossier..
			if ($owner_guid == $editor_guid) $allowed = true;
			*/
			// Profiles specific accesses - for the owner
			$owner_profiletype = dossierdepreuve_get_user_profile_type($owner);
			// Pas de dossier pour les autres profils que 'learner'
			if ($owner_profiletype == 'learner') {
				// Profiles specific accesses - as an editor
				$editor_profiletype = dossierdepreuve_get_user_profile_type($editor);
				switch ($editor_profiletype) {
					case 'learner':
						// Owner can create own dossier
						if ($owner_guid == $editor_guid) $allowed = true;
						break;
					case 'tutor':
					case 'evaluator':
					case 'organisation':
					case 'other_administrative':
						// Editor can create dossier only if owner belongs to one of the editor's group
						$myadmin_groups = theme_compnum_myadmin_groups($editor);
						if ($myadmin_groups) foreach ($myadmin_groups as $ent) {
							// If user is member of any of theses groups => OK
							if ($ent->isMember($owner)) $allowed = true;
						}
						break;
					default:
						// Unspecified profile => can't create any dossier
				}
			}
			// Admin bypass - Note: $editor_guid MUST be a valid guid
			if ($admin_bypass && elgg_is_admin_user($editor_guid)) { $allowed = true; }
		}
	}
	
	// Return true if everything is OK
	if ($allowed) return true;
	// Otherwise, return result or forward (depending on params)
	if ($forward) { register_error(elgg_echo('dossierdepreuve:error:cantedit')); forward(); } 
	else { return false; }
}


function dossierdepreuve_edit_permission_check($hook, $entity_type, $returnvalue, $params) {
	if ($params['entity']->getSubtype() == 'dossierdepreuve') {
		$user = $params['user'];
		// Check access to this entity : we don't want to forward, and use admin bypass
		$has_access = dossierdepreuve_dossier_gatekeeper($params['entity']->guid, false, $user->guid, true);
		// We want to override Elgg default decision, so return true or false, not null
		if ($has_access) { return true; } else { return false; }
	}
	// Don't return anything if we're not handling a dossierdepreuve object !
}


/* Returns all Dossiers from a given user
 * @param $user_guid : the selected user GUID (defaults to loggedin user)
 * @param $typedossier : filter a specific Dossier type (b2iadultes, etc.)
 * @return Array of Dossiers (indexed by GUID), or false if no Dossier found
 */
function dossierdepreuve_get_user_dossiers($user_guid = false, $typedossier = 'b2iadultes') {
	$returnvalue = false;
	if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();
	$params = array('type_subtype_pairs' => array('object' => 'dossierdepreuve'), 'owner_guid' => $user_guid);
	$dossiers = elgg_get_entities($params);
	if ($dossiers) foreach ($dossiers as $ent) {
		// Filter Dossier type if asked
		if ($typedossier) $returnvalue[$ent->guid] = $ent;
		else $returnvalue[$ent->guid] = $ent;
	}
	return $returnvalue;
}

function dossierdepreuve_get_user_dossier($user_guid = false, $typedossier = 'b2iadultes') {
	$returnvalue = false;
	if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();
	$params = array('type_subtype_pairs' => array('object' => 'dossierdepreuve'), 'owner_guid' => $user_guid);
	$dossiers = elgg_get_entities($params);
	if ($dossiers) return $dossiers[0];
	return false;
}


/* Returns all profile types as $profiletype_guid => $profiletype_name */
function dossierdepreuve_get_profiletypes() {
	$profile_types_options = array(
			"type" => "object", "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"owner_guid" => elgg_get_site_entity()->getGUID(), "limit" => false,
		);
	if ($custom_profile_types = elgg_get_entities($profile_types_options)) {
		foreach($custom_profile_types as $type) {
			$profiletypes[$type->guid] = $type->metadata_name;
		}
	}
	return $profiletypes;
}

/* Returns guid for a specific profile type (false if not found) */
function dossierdepreuve_get_profiletype_guid($profiletype) {
	$profile_types = dossierdepreuve_get_profiletypes();
	if ($profile_types) foreach ($profile_types as $guid => $name) {
		if ($name == $profiletype) { return $guid; }
	}
	return false;
}


/* Returns all members of a specific profile_type */
function dossierdepreuve_get_members_by_profiletype($profiletype = 'learner', $options = null) {
	$returnvalue = false;
	$profiletype_guid = dossierdepreuve_get_profiletype_guid($profiletype);
	if ($profiletype_guid) {
		$options['type'] = 'user';
		$options['metadata_names'] = 'custom_profile_type';
		$options['metadata_values'] = $profiletype_guid;
		$options['inverse_relationship'] = true;
		$returnvalue = elgg_get_entities_from_metadata($options);
	}
	return $returnvalue;
}

/* Returns a list of members of a specific profile_type */
function dossierdepreuve_list_members_by_profiletype($profiletype = 'learner', $options = null) {
	$returnvalue = false;
	$profiletype_guid = dossierdepreuve_get_profiletype_guid($profiletype);
	if ($profiletype_guid) {
		$options['type'] = 'user';
		$options['metadata_name_value_pairs'] = array('name' =>'custom_profile_type', 'value' => $profiletype_guid);
		$options['inverse_relationship'] = true;
		$returnvalue = elgg_list_entities_from_metadata($options);
	}
	return $returnvalue;
}

/* Returns all group learners as an array of $guid => $user */
function dossierdepreuve_get_group_profiletype($group = false, $profiletype = 'learner') {
	if (!elgg_instanceof($group, 'group')) return false;
	$returnvalue = false;
	$ignore_access = elgg_get_ignore_access(); elgg_set_ignore_access(true);
	// Membres du groupe, et filtrage des apprenants
	//$group_members_count = get_group_members($group->guid, 10, 0, 0, true);
	//$group_members = get_group_members($group->guid, $group_members_count, 0, 0, false);
	$group_members_count = $group->getMembers(10, 0, true);
	$group_members = $group->getMembers($group_members_count);
	if ($group_members) foreach ($group_members as $ent) {
		$profile_type = dossierdepreuve_get_user_profile_type($ent);
		if ($profile_type == $profiletype) { $returnvalue[$ent->guid] = $ent; }
	}
	elgg_set_ignore_access($ignore_access);
	return $returnvalue;
}

/* Returns all group learners as an array of $guid => $user */
function dossierdepreuve_get_group_learners($group = false) {
	return dossierdepreuve_get_group_profiletype($group, 'learner');
}

/* Returns all group tutors as an array of $guid => $user */
function dossierdepreuve_get_group_tutors($group = false) {
	$return = false;
	$tutors = dossierdepreuve_get_group_profiletype($group, 'evaluator');
	$evaluators = dossierdepreuve_get_group_profiletype($group, 'tutor');
	if ($tutors && $evaluators) $return = array_merge($tutors, $evaluators);
	else if ($tutors) $return = $tutors;
	else if ($evaluators) $return = $evaluators;
	return $return;
}

/* Returns all group dossiers */
function dossierdepreuve_get_group_dossiers($group = false, $typedossier = 'b2iadultes') {
	if (!elgg_instanceof($group, 'group')) return false;
	$returnvalue = false;
	$ignore_access = elgg_get_ignore_access(); elgg_set_ignore_access(true);
	// Apprenants du groupe
	$learners = dossierdepreuve_get_group_learners($group, $typedossier);
	if ($learners) foreach ($learners as $user) {
		$dossiers = dossierdepreuve_get_user_dossiers($user->guid, 'b2iadultes');
		if ($dossiers) foreach ($dossiers as $guid => $ent) {
			$returnvalue[$ent->guid] = $ent;
		}
	}
	elgg_set_ignore_access($ignore_access);
	return $returnvalue;
}



