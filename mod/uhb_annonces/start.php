<?php
/**
 * uhb_annonces plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'uhb_annonces_init');


/**
 * Init uhb_annonces plugin.
 */
function uhb_annonces_init() {
	global $CONFIG; // All site useful vars
	
	elgg_extend_view('css', 'uhb_annonces/css');
	elgg_extend_view('css/admin', 'uhb_annonces/css');
	
	// Register table sorter JS
	elgg_register_js('jquery-tablesorter', 'mod/uhb_annonces/vendors/tablesorter/jquery.tablesorter.min.js', 'head');
	elgg_register_js('validate-js', 'mod/uhb_annonces/vendors/validate_fr.js', 'head');
	
	// Register a page handler on "uhb_annonces/"
	elgg_register_page_handler('annonces', 'uhb_annonces_page_handler');
	
	// Register a URL handler for bookmarks
	elgg_register_entity_url_handler('object', 'uhb_offer', 'uhb_offer_url');
	
	// Register entity type for search
	elgg_register_entity_type('object', 'uhb_offer');
	
	// Note neither route nor export hook will prevent exporting a public entity or some metadata...
	// See page_handler for details on access implementation
	
	
	// Permission check : we have to use this to allow new object creation by non-users
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'uhb_offer_write_permission_check');
	// Container permission check : we have to use this to allow new object creation by non-users
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'uhb_offer_container_permission_check');
	
	// Register cron hook
	elgg_register_plugin_hook_handler('cron', 'daily', 'uhb_annonces_cron');
	
	
	// ACTIONS
	$action_url = dirname(__FILE__) . '/actions/uhb_annonces/';
	
	// Add and edit for all user types
	elgg_register_action("uhb_annonces/edit", $action_url . 'edit.php', 'public');
	
	// Memorise an offer
	elgg_register_action("uhb_annonces/memorise", $action_url . 'memorise.php');
	elgg_register_action("uhb_annonces/removememorise", $action_url . 'removememorise.php');
	// Apply to an offer
	elgg_register_action("uhb_annonces/candidate", $action_url . 'candidate.php');
	// Report a filled offer
	elgg_register_action("uhb_annonces/report", $action_url . 'report.php', 'public');
	// Un-report a filled offer
	elgg_register_action("uhb_annonces/unreport", $action_url . 'unreport.php', 'public');
	
	// Email (public) actions
	// Note : we use a page_handler instead of actions to avoid warning about missing tokens
	// Confirm manager email
	// Reactivate offer (archive limit - 7 days)
	// Archive offer
	
	// Admin actions
	// Resend confirmation email
	elgg_register_action("uhb_annonces/resendconfirm", $action_url . 'resendconfirm.php');
	// Force email validation
	elgg_register_action("uhb_annonces/validate", $action_url . 'validate.php');
	// Publish offer
	elgg_register_action("uhb_annonces/publish", $action_url . 'publish.php');
	// Remove filled counter
	elgg_register_action("uhb_annonces/removereport", $action_url . 'removereport.php');
	// Archive offer (admin version)
	elgg_register_action("uhb_annonces/archive", $action_url . 'archive.php', 'public');
	// Filled offer (admin version)
	elgg_register_action("uhb_annonces/filled", $action_url . 'filled.php', 'public');
	
}


/* Annonces page handler
 * Loads pages located in uhb_annonces/pages/uhb_annonces/
 * Important note on access rights : regular access rights are not sufficient to prevent access to any metadata
 * And also using access rights (with owner set to the site or potentially to any member) is not either
 * So we use the disabling trick which to prevent any unwanted access : 
 *  - access rights are always public - so we don't bother with metadata editing, etc. (which are handled in this plugin)
 *  - but entity is *always* disabled (which blocks any uncontrolled access)
 *  -> and we override these disabled entities only when needed, using our own page_handler
 */
function uhb_annonces_page_handler($page) {
	$base = elgg_get_plugins_path() . 'uhb_annonces/pages/uhb_annonces';
	access_show_hidden_entities(true);
	switch ($page[0]) {
		// Note : we do not use actions for public action links to avoid warning about missing tokens
		case 'action':
			if (!empty($page[1])) { set_input('request', $page[1]); }
			include "$base/actions.php";
			break;
			
		case 'view':
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			include "$base/view.php";
			break;
			
		// Not used because we prefer to embed the form directly into the view page
		/*
		case 'candidate':
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			include "$base/candidate.php";
			break;
		*/
			
		case 'edit':
			if (!empty($page[1])) { set_input('guid', $page[1]); }
		case 'add':
			include "$base/edit.php";
			break;
			
		case 'search':
			if (!empty($page[1])) { set_input('filter', $page[1]); }
			include "$base/search.php";
			break;
		/* DEV - Benchmark SQL queries
		case 'search_A':
		case 'search_B':
		case 'search_C':
			if (!empty($page[1])) { set_input('filter', $page[1]); }
			include "$base/{$page[0]}.php";
			break;
		*/
		
		case 'list':
			if (!empty($page[1])) { set_input('filter', $page[1]); }
			include "$base/list.php";
			break;
			
		case 'admin':
			if (!empty($page[1])) { set_input('filter', $page[1]); }
			include "$base/admin.php";
			break;
			
		default:
			include "$base/index.php";
	}
	access_show_hidden_entities(false);
	return true;
}

// The offer view URL
function uhb_offer_url($entity) {
	global $CONFIG;
	$title = $entity->offerposition;
	$title = elgg_get_friendly_title($title);
	return $CONFIG->url . "annonces/view/" . $entity->guid . "/" . $title;
}


/* Cron tasks
 * Check obsolete offers and send reminder
 * Archive passed out offers
 */
function uhb_annonces_cron($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;
	
	elgg_set_context('cron');
	
	// Avoid any time limit while processing offers
	set_time_limit(0);
	access_show_hidden_entities(true);
	elgg_set_ignore_access(true);
	
	// Encode the name. If may content nos ASCII chars.
	$from_name = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=";
	$from = $from_name . ' <' . $CONFIG->site->email . '>';
	define('UHB_ANNONCES_EMAIL_FROM', $from);
	
	// Archive offers if followend < time()
	$archive_options = array(
			'types' => 'object', 'subtypes' => 'uhb_offer', 
			'metadata_name_value_pairs' => array(
				array('name' => 'followend', 'value' => time(), 'operand' => '<'), 
				array('name' => 'followstate', 'value' => 'published')
			), 
			'limit' => 0,
		);
	$batch = new ElggBatch('elgg_get_entities_from_metadata', $archive_options, 'uhb_annonces_cron_archive', 25);
	/*
	$archives = elgg_get_entities_from_metadata($archive_options);
	foreach ($archives as $offer) {
		$offer->followstate = 'archive';
		uhb_annonces_state_change($offer, 'published');
	}
	*/
	
	// Send reminder if offers if followend < time() + 7 days
	// Annonces obsolètes = publiées mais dont la date de fin de publication est dans moins de 7 jours
	$obsolete_options = array(
			'types' => 'object', 'subtypes' => 'uhb_offer', 'limit' => 0,
			'metadata_name_value_pairs' => array(
				array('name' => 'followend', 'value' => time() + 7*24*3600, 'operand' => '<='), 
				array('name' => 'followend', 'value' => time() + 6*24*3600, 'operand' => '>'), 
				array('name' => 'followstate', 'value' => 'published')
			), 
		);
	$batch = new ElggBatch('elgg_get_entities_from_metadata', $obsolete_options, 'uhb_annonces_cron_reminder', 25);
	/*
	$obsoletes = elgg_get_entities_from_metadata($obsolete_options);
	foreach ($obsoletes as $offer) {
		// Encode the name. If may content nos ASCII chars.
		$to_name = "=?UTF-8?B?" . base64_encode($offer->managername) . "?=";
		$to = $to_name . ' <' . $offer->manageremail . '>';
		$managergender = elgg_echo('uhb_annonces:managergender:'.$offer->managergender);
		$managername = $offer->managername;
		$typeoffer = elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer);
		$offerposition = $offer->offerposition;
		$followvalidation = $offer->followvalidation;
		if (!empty($followvalidation)) {
			if (is_numeric($followvalidation)) { $followvalidation = date('d/m/Y', $followvalidation); }
		} else { $followvalidation = elgg_echo('uhb_annonces:view:followvalidation:no'); }
		$add_editkey = '?guid=' . $offer->guid . '&editkey=' . $offer->editkey;
		$confirmurl = $CONFIG->url . 'annonces/action/confirm' . $add_editkey;
		$reactivateurl = $CONFIG->url . 'annonces/action/reactivate' . $add_editkey;
		$archiveurl = $CONFIG->url . 'annonces/action/archive' . $add_editkey;
		
		// Send end of publication email to manageremail
		$subject = elgg_echo('uhb_annonces:notification:endofpublication:subject');
		$message = elgg_echo('uhb_annonces:notification:endofpublication:body', array($managergender, $managername, $typeoffer, $offerposition, $followvalidation, $reactivateurl, $archiveurl));
		// Send email
		$html_message = html_email_handler_make_html_body($subject, $message);
		html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
	}
	*/
	
	echo "UHB ANNONCES CRON : done.";
}

// CRON : Send reminder email for obsoletes offers
function uhb_annonces_cron_reminder($offer, $getter, $options) {
	global $CONFIG;
	// Encode the name. If may content nos ASCII chars.
	$from_name = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=";
	$from = $from_name . ' <' . $CONFIG->site->email . '>';
	
	// Encode the name. If may content nos ASCII chars.
	$to_name = "=?UTF-8?B?" . base64_encode($offer->managername) . "?=";
	$to = $to_name . ' <' . $offer->manageremail . '>';
	$managergender = elgg_echo('uhb_annonces:managergender:'.$offer->managergender);
	$managername = $offer->managername;
	$typeoffer = elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer);
	$offerposition = $offer->offerposition;
	$followvalidation = $offer->followvalidation;
	if (!empty($followvalidation)) {
		if (is_numeric($followvalidation)) { $followvalidation = date('d/m/Y', $followvalidation); }
	} else { $followvalidation = elgg_echo('uhb_annonces:view:followvalidation:no'); }
	$add_editkey = '?guid=' . $offer->guid . '&editkey=' . $offer->editkey;
	$confirmurl = $CONFIG->url . 'annonces/action/confirm' . $add_editkey;
	$reactivateurl = $CONFIG->url . 'annonces/action/reactivate' . $add_editkey;
	$archiveurl = $CONFIG->url . 'annonces/action/archive' . $add_editkey;
	
	// Send end of publication email to manageremail
	$subject = elgg_echo('uhb_annonces:notification:endofpublication:subject');
	$message = elgg_echo('uhb_annonces:notification:endofpublication:body', array($managergender, $managername, $typeoffer, $offerposition, $followvalidation, $reactivateurl, $archiveurl));
	
	// Send email
	// Suppression du lien vers notifications
	uhb_annonces_hide_notification_link($offer);
	$html_message = html_email_handler_make_html_body($subject, $message);
	html_email_handler_send_email(array('from' => UHB_ANNONCES_EMAIL_FROM, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
}

// CRON : Archive old offers
function uhb_annonces_cron_archive($offer, $getter, $options) {
	$offer->followstate = 'archive';
	uhb_annonces_state_change($offer, 'published');
}


/* Passe une variable qui peut être utilisée dans la vue html_email_handler/notification/body 
 * pour ne pas affichier le lien vers la gestion de ses notifications
 * Comportement : masquage si annonce anonyme
 * @TODO : masquer systématiquement pour les envois faits par ce plugin ?
 */
function uhb_annonces_hide_notification_link($offer){
	$owner = $offer->getOwnerEntity();
	if (!elgg_instanceof($owner, 'user')) {
		set_input('hide_html_email_handler_link', 'yes');
		return true;
	}
	return false;
}


/* Return field values for dropdown
 * Returns admin for UHB_annonces plugin admins, user types for members, public for invalid or not logged in users
 * Known types include : student, faculty, staff, other, pro, )
 * Defaults to logged in user
 * Logic : elevate privileges at each step, cache result as global variable (computed once per request)
 */
function uhb_annonces_get_profile_type($user = false) {
	global $uhb_annonces_profile_type;
	if (!empty($uhb_annonces_profile_type)) return $uhb_annonces_profile_type;
	
	// Not logged in, or no valid user specified, return public
	$uhb_annonces_profile_type = 'public';
	
	if (!$user) $user = elgg_get_logged_in_user_entity();
	if (elgg_instanceof($user, 'user')) {
		// Add a special case for valid users (should not happen as types should be always set)
		$uhb_annonces_profile_type = 'user';
		
		// Check admin profile type
		$admin_guids = elgg_get_plugin_setting('adminlist');
		$admin_guids = esope_get_users_from_setting($admin_guids);
		if (array_key_exists($user->guid, $admin_guids)) {
			$uhb_annonces_profile_type = 'admin';
		} else {
			// Check other profile types
			$types = $user->types;
			if ($types) {
				if (is_array($types)) {
					$types = $types[0];
					error_log("UHB annonces DEBUG : types multiples associés à un profil (" . implode(', ', $types) . ") - seul le premier ($types) est pris en compte.");
				}
				$uhb_annonces_profile_type = $types;
			}
		}
	}
	return $uhb_annonces_profile_type;
}


// Determines if a given profile is complete enough for candidature
function uhb_annonces_is_profile_complete($user = false) {
	if (!$user) { $user = elgg_get_logged_in_user_entity(); }
	if (elgg_instanceof($user, 'user')) {
		// Do we have the required fields ?
		$education = elgg_get_entities(array('owner_guid' => $user->guid, 'types' => 'object', 'subtypes' => 'uhb_profile_education', 'limit' => 1));
		$experience = elgg_get_entities(array('owner_guid' => $user->guid, 'types' => 'object', 'subtypes' => 'uhb_profile_experience', 'limit' => 1));
		$competence = elgg_get_entities(array('owner_guid' => $user->guid, 'types' => 'object', 'subtypes' => 'uhb_profile_competence', 'limit' => 1));
		// Now are the access rights OK ?
		if (($education[0]->access_id == 2) && ($experience[0]->access_id == 2) && ($competence[0]->access_id == 2)) { return true; }
	}
	return false;
}


// Short-hand function to determine is a given user can search / browse / read offers
function uhb_annonces_can_view($user = false) {
	$types = uhb_annonces_get_profile_type($user);
	if ($types == 'admin') {
		return true;
	} else if ($types == 'public') {
		if (uhb_annonces_public_gatekeeper()) { return true; }
	} else {
		$allowed_types = elgg_get_plugin_setting('whitelist');
		$allowed_types = esope_get_input_array($allowed_types);
		if (in_array($types, $allowed_types)) { return true; }
	}
	return false;
}


// Short-hand function to determine is a given user can candidate to an offer
function uhb_annonces_can_candidate($user = false) {
	$types = uhb_annonces_get_profile_type($user);
	// Admins can not candidate
	if ($types == 'admin') { return false; }
	$allowed_types = elgg_get_plugin_setting('candidate_whitelist');
	$allowed_types = esope_get_input_array($allowed_types);
	if (elgg_is_logged_in() && in_array($types, $allowed_types)) { return true; }
	return false;
}


/* Get offers based on states - designed to quickly get statistics
 * $state : offer state (new, confirmed, published, filled, archive)
 * $count : get only count
 * $params : additional params such as limit, offset, etc.
 */
function uhb_annonces_get_from_state($state, $count = false, $addparams = false) {
	$params = array('types' => 'object', 'subtypes' => 'uhb_offer');
	if (is_array($addparams)) $params = array_merge($params, $addparams);
	if (!empty($state)) $params['metadata_name_value_pairs'] = array('name' => 'followstate', 'value' => $state);
	if ($count) $params['count'] = true;
	
	$results = elgg_get_entities_from_metadata($params);
	if ($count) { return (int) $results; }
	return $results;
}


/* Get offers based on relations
 * $relation : offer relation (memorised, has_candidated)
 * $value : offer relation value
 * $count : get only count
 * $params : additional params such as limit, offset, etc.
 */
function uhb_annonces_get_from_relationship($relation, $guid = null, $inverse = false, $count = false, $addparams = false) {
	$params = array('types' => 'object', 'subtypes' => 'uhb_offer');
	if (is_array($addparams)) $params = array_merge($params, $addparams);
	if (!empty($relation)) $params['relationship'] = $relation;
	if (!empty($guid)) $params['relationship_guid'] = $guid;
	if ($inverse) $params['inverse_relationship'] = true;
	if ($count) $params['count'] = true;
	
	$results = elgg_get_entities_from_relationship($params);
	if ($count) { return (int) $results; }
	return $results;
}


/* Returns true if public access is authorised
 * ie. matches a specific IP range
 * masks are defined by setting ip addresses, eg. 127, 82.234.*, etc. (".*" are optional and stripped afterwards, used only for settings clarity)
 * $ip : the user IP adress, defaults to current visitor IP address
 * Returns : true is allowed, false otherwise
 */
function uhb_annonces_public_gatekeeper($ip = false) {
	if (!$ip) $ip = $_SERVER['REMOTE_ADDR'];
	$masks = elgg_get_plugin_setting('ipallowed');
	$masks = esope_get_input_array($masks);
	//echo "$ip / " . implode(', ', $mask) . " => ";
	foreach ($masks as $mask) {
		$mask = str_replace('.*', '', $mask);
		if (strpos($ip, $mask) === 0) return true;
	}
	return false;
}


/* Can user view entity ?
 * Visitor can view if he the proper membership type OR matches the required IPs OR can provide view/edit keys
 * $entity : Requires valid entity to be viewed
 * $user : Requires valid user OR no user and valid read public key or valid edit public key
 */
function uhb_annonces_can_view_offer($entity = false, $user = false) {
	if (elgg_instanceof($entity, 'object', 'uhb_offer')) {
		// Check global access to offers
		if (uhb_annonces_can_view($user)) { return true; }
		// Also allow valid view key
		$viewkey = get_input('viewkey');
		if (!empty($viewkey) && ($viewkey == $entity->viewkey)) { return true; }
		// Also allow edit key (who can edit, can also view)
		$editkey = get_input('editkey');
		if (!empty($editkey) && ($editkey == $entity->editkey)) { return true; }
		// Allow owner (can view and copy content from previous offer)
		if ($entity->owner_guid == elgg_get_logged_in_user_guid()) { return true; }
	}
	// Other cases are forbidden
	return false;
}


/* Can user edit entity ?
 * Création ouverte à tous, identifié ou pas, quel que soit le type de profil
 * Edition d'une offre existante réservée à l'auteur (soit via URL, soit si connecté) et aux admins des annonces
 */
function uhb_annonces_can_edit_offer($entity = false, $user = false, $alert = false) {
	if (!$entity) {
		return true;
	} else if (elgg_instanceof($entity, 'object', 'uhb_offer')) {
		if (!$user) { $user = elgg_get_logged_in_user_entity(); }
		if (elgg_instanceof($user, 'user')) {
			// Once filled or archive, owner cannot edit anymore
			if (in_array($entity->followstate, array('new', 'confirmed', 'published'))) {
				// Owner can edit own content
				if ($entity->owner_guid == $user->guid) { return true; }
			}
			// If not owner, only uhb_annonces admins can edit too
			$types = uhb_annonces_get_profile_type();
			if ($types == 'admin') { return true; }
		}
		// Auth key can provide access while logged in or not
		if (in_array($entity->followstate, array('new', 'confirmed', 'published'))) {
			$editkey = get_input('editkey');
			if (!empty($editkey) && ($editkey == $entity->editkey)) { return true; }
			if ($alert) register_error(elgg_echo('uhb_annonces:error:invalidkey'));
		}
	}
	if ($alert) register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	return false;
}


/* Is user the offer owner (not admin) ?
 * Ne s'applique qu'aux offres existantes, et vise à distinguer les auteurs des droits d'édition donnés en tant qu'admin
 * Auteur déterminé soit via URL, soit si connecté
 */
function uhb_annonces_is_owner($entity = false, $user = false, $alert = false) {
	if (elgg_instanceof($entity, 'object', 'uhb_offer')) {
		if (!$user) { $user = elgg_get_logged_in_user_entity(); }
		if (elgg_instanceof($user, 'user')) {
			// Once filled or archive, owner cannot edit anymore
			if (in_array($entity->followstate, array('new', 'confirmed', 'published'))) {
				// Owner can edit own content
				if ($entity->owner_guid == $user->guid) { return true; }
			}
		}
		// Auth key can also identify offer owner, even if not logged in
		// or also if using another account (eg access to offers created before the user account creation)
		$editkey = get_input('editkey');
		if (!empty($editkey) && ($editkey == $entity->editkey)) { return true; }
		if ($alert) register_error(elgg_echo('uhb_annonces:error:invalidkey'));
	}
	if ($alert) register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	return false;
}


// Pass view and edit keys as URL param
function uhb_annonces_add_keys($form = false) {
	$keys = '';
	$viewkey = get_input('viewkey');
	$editkey = get_input('editkey');
	if ($form) {
		if (!empty($viewkey)) $keys .= elgg_view('input/hidden', array('name' => 'viewkey', 'value' => $viewkey));
		if (!empty($editkey)) $keys .= elgg_view('input/hidden', array('name' => 'editkey', 'value' => $editkey));
	} else {
		if (!empty($viewkey)) $keys .= 'viewkey=' . $viewkey;
		if (!empty($editkey)) {
			if (!empty($keys)) $keys .= '&';
			$keys .= 'editkey=' . $editkey;
		}
	}
	return $keys;
}


// Tells if a given user has already created an offer
function uhb_annonces_has_offer($user) {
	if (!$user) { $user = elgg_get_logged_in_user_entity(); }
	if (elgg_instanceof($user, 'user')) {
		$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'count' => true, 'limit' => 1, 'owner_guid' => $user->guid);
		$count = elgg_get_entities($params);
		if ($count > 0) { return $count; }
	}
	return false;
}


// Tells if a given email has already been validated, at least once
function uhb_annonces_has_valid_email($email) {
	if (empty($email) || !is_email_address($email)) { return false; }
	$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'count' => true, 'limit' => 1, 
			'metadata_name_value_pairs' => array(
				array('name' => 'manageremail', 'value' => $email),
				array('name' => 'managervalidated', 'value' => 'yes'),
			)
		);
	$count = elgg_get_entities_from_metadata($params);
	if ($count > 0) { return true; }
	return false;
}


/* Checks (view) access to entity, depending on its current state
 * Note : this function throws alert messages explaining why access is blocked
 * Note 2 : edit functions handle the allowed states directly
 * $entity : requires valid uhb_offer
 * $user : requires valid user, or false will default to public access
 * Access rules to offer, depending of its current state :
 * new : owner + admin
 * confirmed : owner + admin
 * published : all
 * filled : admin + membres "intéressés par"
 * archive : admin + membres "intéressés par"
 */
function uhb_annonces_has_access_to_offer($entity = false) {
	// Check if current state allows viewing by members...
	if (elgg_instanceof($entity, 'object', 'uhb_offer')) {
		$ownguid = elgg_get_logged_in_user_guid();
		switch($entity->followstate) {
			
			// Only owner + admin (= people who can edit)
			case 'new':
			case 'confirmed':
				if (uhb_annonces_can_edit_offer($entity)) { return true; }
				register_error(elgg_echo('uhb_annonces:error:unpublished'));
				break;
			
			// Everyone can access published offers (gatekeeper is handled by page handler)
			// Note : pro/other types should not access offers
			case 'published':
				if (uhb_annonces_can_view()) { return true; }
				if (uhb_annonces_can_edit_offer($entity)) { return true; }
				//return true;
				break;
			
			// Admin + members with "memorised" relation
			case 'filled':
				if (elgg_is_logged_in()) {
					$types = uhb_annonces_get_profile_type();
					if ($types == 'admin') { return true; }
					if (check_entity_relationship($ownguid, 'memorised', $entity->guid)) { return true; }
				}
				register_error(elgg_echo('uhb_annonces:error:filled'));
				break;
			
			// Admin + members with "memorised" relation
			case 'archive':
				if (elgg_is_logged_in()) {
					$types = uhb_annonces_get_profile_type();
					if ($types == 'admin') { return true; }
					if (check_entity_relationship($ownguid, 'memorised', $entity->guid)) { return true; }
					if ($entity->owner_guid == $ownguid) { return true; }
				}
				register_error(elgg_echo('uhb_annonces:error:filled'));
				break;
		}
	}
	return false;
}


/* Return object fields names
 * This functions facilitates the fields retrieval + identification of a specific field as viewable/editable by a specific profile
 * $filter : false (all fields) | view (filter for profiles who can view) | edit (filter for profiles who can edit) | search | results | preload
 * $entity : some rights can vary depending on the viewed/edited entity
 */
function uhb_annonces_get_fields($filter = false, $entity = false) {
	// All fields
	$all_fields = array(
		'typeoffer', 'typework', 
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurewebsite', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 'structureworkforce', 'structuredetails', 
		'offerposition', 'offerreference', 'offertask', 'offerpay', 
		'workstart', 'worklength', 'worktime', 'worktrip', 'workcomment', 
		'profileformation', 'profilelevel', 'profilecomment', 
		'managergender', 'managername', 'manageremail', 'managerphone', 'managervalidated', 
		'followcreation', 'followvalidation', 'followend', 'followstate', 'followinterested', 'followcandidates', 'followreport', 'followcomments',
	);
	
	// Admin fields : same as all
	// @TODO : filter some computed fields ?
	$admin_view_fields = $all_fields;
	$admin_edit_fields = $all_fields;
	
	// Owner fields (view / add / edit)
	$owner_view_fields = array(
		'typeoffer', 'typework', 
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurewebsite', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 'structureworkforce', 'structuredetails', 
		'offerposition', 'offerreference', 'offertask', 'offerpay', 
		'workstart', 'worklength', 'worktime', 'worktrip', 'workcomment', 
		'profileformation', 'profilelevel', 'profilecomment', 
		'managergender', 'managername', 'manageremail', 'managerphone', 'managervalidated', 
		'followcreation', 'followvalidation', 'followend', 'followstate', 'followcandidates', 
		// Hidden : 'followinterested', 'followreport', 'followcomments',
	);
	$owner_add_fields = array(
		'typeoffer', 'typework', 
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurewebsite', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 'structureworkforce', 'structuredetails', 
		'offerposition', 'offerreference', 'offertask', 'offerpay', 
		'workstart', 'worklength', 'worktime', 'worktrip', 'workcomment', 
		'profileformation', 'profilelevel', 'profilecomment', 
		'managergender', 'managername', 'manageremail', 'managerphone', 
		// Hidden : 'managervalidated', 'followcreation', 'followvalidation', 'followend', 'followstate', 'followcandidates', 'followreport', 'followcomments',
	);
	$owner_edit_fields = array(
		'typeoffer', 'typework', 
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurewebsite', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 'structureworkforce', 'structuredetails', 
		'offerposition', 'offerreference', 'offertask', 'offerpay', 
		'workstart', 'worklength', 'worktime', 'worktrip', 'workcomment', 
		'profileformation', 'profilelevel', 'profilecomment', 
		'managergender', 'managername', 'manageremail', 'managerphone', 
		// Hidden : 'managervalidated', 'followcreation', 'followvalidation', 'followend', 'followstate', 'followcandidates', 'followreport', 'followcomments',
	);
	
	// Regular user view fields
	$view_fields = array(
		'typeoffer', 'typework', 
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurewebsite', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 'structureworkforce', 'structuredetails', 
		'offerposition', 'offerreference', 'offertask', 'offerpay', 
		'workstart', 'worklength', 'worktime', 'worktrip', 'workcomment', 
		'profileformation', 'profilelevel', 'profilecomment', 
		'managergender', 'managername', 'manageremail', 'managerphone', 
		'followstate', 
		// Hidden : 'managervalidated', 'followcreation', 'followvalidation', 'followend', 'followinterested', 'followcandidates', 'followreport', 'followcomments', 
	);
	
	$search_fields = array(
		'typeoffer', 'typework', 
		'structurepostalcode', 'structurelegalstatus', 
		'workstart', 'worklength', 
		'profileformation', 'profilelevel', 
		'followvalidation', 
	);
	
	$admin_search_fields = array(
		'typeoffer', 'typework', 
		'structurename', 'structurepostalcode', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 
		'workstart', 'worklength', 
		'profileformation', 'profilelevel', 
		'managervalidated', 
		'followcreation', 'followvalidation', 'followend', 'followstate', 'followinterested', 'followcandidates', 'followreport', 
	);
	
	// Important : l'ordre de ces champs déterminera celui du rendu dans le tableau des résultats de recherche
	$results_fields = array(
		'offerposition', 
		'typeoffer', 
		'profilelevel', 
		'structurename', 'structurecity', 
		'workstart', 'worklength', 
		'followvalidation', 
	);
	
	$admin_results_fields = array(
		'offerposition', 
		'typeoffer', 
		'profilelevel', 
		'structurename', 'structurecity', 
		'worklength', 
		'managervalidated', 
		'followstate', 'followvalidation', 'followend', 'followinterested', 'followcandidates', 'followreport', 
	);
	
	$preload_fields = array(
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurewebsite', 'structuresiret', 'structurenaf2008', 'structurelegalstatus', 'structureworkforce', 'structuredetails', 
		'managergender', 'managername', 'manageremail', 'managerphone', 'managervalidated', 
	);
	
	// Return all existing fields
	if (!$filter || !in_array($filter, array('view', 'edit', 'search', 'results', 'preload'))) { return $all_fields; }
	
	// Use view/edit filter : requires user role
	$types = uhb_annonces_get_profile_type();
	switch($filter) {
		case 'view':
			if (elgg_instanceof($entity, 'object', 'uhb_offer')) {
				if (uhb_annonces_can_view_offer($entity)) {
					// Admins can view all fields
					if ($types == 'admin') { return $admin_view_fields; }
					// Owners can view some more fields than regular readers
					if (uhb_annonces_can_edit_offer($entity)) { return $owner_view_fields; }
					// Regular readers view
					return $view_fields;
				}
			}
			break;
		
		// Only owner, admin, and people with proper edit key can edit fields
		// Note : new entity creation is open to anyone
		case 'edit':
			if (uhb_annonces_can_edit_offer($entity)) {
				// Admins can edit all fields
				if ($types == 'admin') { return $admin_edit_fields; }
				// New entity
				if (!$entity) { return $owner_add_fields; }
				return $owner_edit_fields;
			}
			break;
		
		// Only allowed profiles and admin can search offers
		case 'search':
			if (uhb_annonces_can_view()) {
				if ($types == 'admin') { return $admin_search_fields; }
				return $search_fields;
			}
			break;
		
		// Only allowed profiles and admin can view search results
		case 'results':
			if (uhb_annonces_can_view()) {
				if ($types == 'admin') { return $admin_results_fields; }
				return $results_fields;
			}
			break;
		
		// Preload fields are restricted to offer editors duplicating some data
		case 'preload':
			return $preload_fields;
			break;
	}
	
	return false;
}


/* Builds an options_values array for dropdowns, from plugin settings
 * Can be used both for publication and search (depending on $search)
 * $addempty can be set to false (no empty value), or true, or to a specific string for custom display
 */
function uhb_annonces_build_options($name, $addempty = true, $search = false, $prefix = 'uhb_annonces', $keys = false) {
	// Some key metadata cannot be set on plugin admin
	if (!$keys) {
		if ($name == 'followstate') {
			$keys = 'new, confirmed, published, filled, archive';
		} else if ($name == 'managergender') {
			$keys = 'mr, mrs';
		} else {
			if ($search) $keys = elgg_get_plugin_setting('search_'.$name);
			else $keys = elgg_get_plugin_setting($name);
		}
		$keys = esope_get_input_array($keys);
	}
	$options_values = array();
	if ($addempty) {
		if ($addempty === true) { $options_values[''] = ""; } else { $options_values[''] = $addempty; }
	}
	foreach($keys as $key) { $options_values[$key] = elgg_echo("$prefix:$name:$key"); }
	return $options_values;
}


// Handle state changes and trigger actions
// Note : changes may occur in every direction, so we should focus on target state
// When calling this function, new state should have been already set !
function uhb_annonces_state_change($offer = false, $from_state = '') {
	if (!elgg_instanceof($offer, 'object', 'uhb_offer')) return false;
	global $CONFIG;
	$cron = false;
	if (elgg_in_context('cron')) { $cron = true; }
	
	$managergender = elgg_echo('uhb_annonces:managergender:'.$offer->managergender);
	$managername = $offer->managername;
	$typeoffer = elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer);
	$offerposition = $offer->offerposition;
	$followvalidation = $offer->followvalidation;
	if (!empty($followvalidation)) {
		if (is_numeric($followvalidation)) { $followvalidation = date('d/m/Y', $followvalidation); }
		$followvalidation = elgg_echo('uhb_annonces:view:followvalidation', array($followvalidation));
	} else { $followvalidation = elgg_echo('uhb_annonces:view:followvalidation:no'); }
	$add_editkey = '?guid=' . $offer->guid . '&editkey=' . $offer->editkey;
	$viewurl = $CONFIG->url . 'annonces/view/' . $offer->guid . $add_editkey;
	$editurl = $CONFIG->url . 'annonces/edit/' . $offer->guid . $add_editkey;
	$team_email = elgg_get_plugin_setting('contact_email', 'uhb_annonces');
	$confirmurl = $CONFIG->url . 'annonces/action/confirm' . $add_editkey;
	$reactivateurl = $CONFIG->url . 'annonces/action/reactivate' . $add_editkey;
	$archiveurl = $CONFIG->url . 'annonces/action/archive' . $add_editkey;
	
	// Encode the name. If may content nos ASCII chars.
	$from_name = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=";
	$from = $from_name . ' <' . $CONFIG->site->email . '>';
	// Encode the name. If may content nos ASCII chars.
	$to_name = "=?UTF-8?B?" . base64_encode($offer->managername) . "?=";
	$to = $to_name . ' <' . $offer->manageremail . '>';
	$to = $offer->managername . ' <' . $offer->manageremail . '>';
	$mailsuccess = elgg_echo('uhb_annonces:notification:mail:success');
	$mailerror = elgg_echo('uhb_annonces:notification:mail:error');
	
	// Suppression du lien vers notifications
	uhb_annonces_hide_notification_link($offer);

	switch($offer->followstate) {
		
		case 'new':
			// Send confirmation email to manageremail
			if ($from_state != $offer->followstate) {
				$subject = elgg_echo('uhb_annonces:notification:confirm1:subject');
				$message = elgg_echo('uhb_annonces:notification:confirm1:body', array($managergender, $managername, $typeoffer, $confirmurl));
				$html_message = html_email_handler_make_html_body($subject, $message);
				$result = html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
				if (!$cron) {
					if ($result) { system_message($mailsuccess); } else { register_error($mailerror); }
				}
			}
			break;
	
		case 'confirmed':
			// Mark managervalidated as 'yes'
			//if ($offer->managervalidated == 'yes') {
			if ($from_state != 'new') {
				$confirm_msg = elgg_echo('uhb_annonces:notification:confirm2:edit');
			} else {
				$confirm_msg = elgg_echo('uhb_annonces:notification:confirm2:validate');
			}
			$offer->managervalidated = 'yes';
			if ($from_state != $offer->followstate) {
				// Send confirmation email 2 to manageremail (validated)
				$subject = elgg_echo('uhb_annonces:notification:confirm2:subject');
				$message = elgg_echo('uhb_annonces:notification:confirm2:body', array($managergender, $managername, $confirm_msg));
				$html_message = html_email_handler_make_html_body($subject, $message);
				$result = html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
				if (!$cron) {
					if ($result) { system_message($mailsuccess); } else { register_error($mailerror); }
				}
			}
			break;
	
		case 'published':
			//if ($from_state != $offer->followstate) {}
			// Set validation date, only if it has not be done before
			if (empty($offer->followvalidation)) $offer->followvalidation = time();
			// When publishing, or re-publishing, always validate by default for 30 days
			// Note : this can be overrided only by admins when directly editing an offer
			// In that case, value has already been changed so do not update it again
			$manual_edit = get_input('followend', '');
			$types = uhb_annonces_get_profile_type();
			if (empty($manual_edit) || ($types != 'admin')) { $offer->followend = time() + (30*24*3600); }
			// Envoi email seulement si modification de l'état de l'offre
			if ($from_state != $offer->followstate) {
				// Send publication email to manageremail
				$subject = elgg_echo('uhb_annonces:notification:publication:subject');
				$message = elgg_echo('uhb_annonces:notification:publication:body', array($managergender, $managername, $typeoffer, $offerposition, $editurl, $team_email));
				$html_message = html_email_handler_make_html_body($subject, $message);
				$result = html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
				if (!$cron) {
					if ($result) { system_message($mailsuccess); } else { register_error($mailerror); }
				}
			}
			break;
	
		case 'filled':
		case 'archive':
			if (!in_array($from_state, array('filled', 'archive'))) {
				// Remove reported relations
				remove_entity_relationships($offer->guid, 'reported', true);
				// Note 1 : counters are incremented on the fly
				// Note 2 : other relationships besides reporting should not be cleared, because they are used
			}
			// Envoi email seulement si modification de l'état de l'offre
			if ($from_state != $offer->followstate) {
				// Send end of publication email to manageremail
				$subject = elgg_echo('uhb_annonces:notification:archive:subject');
				$message = elgg_echo('uhb_annonces:notification:archive:body', array($managergender, $managername, $typeoffer, $offerposition));
				$html_message = html_email_handler_make_html_body($subject, $message);
				$result = html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
				if (!$cron) {
					if ($result) { system_message($mailsuccess); } else { register_error($mailerror); }
				}
			}
			break;
	}
	
	return $offer;
}


// Allow object creation by non-users #1
function uhb_offer_write_permission_check($hook, $entity_type, $returnvalue, $params) {
	if (elgg_get_context() == "uhb_offer") { return true; }
	if ($params['entity']->getSubtype() == 'uhb_offer') {
		$user = $params['user'];
		return uhb_annonces_can_edit_offer($params['entity'], $user);
	}
	return $returnvalue;
}
// Allow object creation by non-users #2
function uhb_offer_container_permission_check($hook, $entity_type, $returnvalue, $params) {
	if (elgg_get_context() == "uhb_offer") { return true; }
	return $returnvalue;
}


/* Filter values by metadata query iterations
 * $values : list of GUIDs
 * $md_filter : metdata array, as in metadata_name_value_pairs
 */
function uhb_annonces_filter_entity_guid_by_metadata(array $values, array $md_filter) {
	$values = implode(', ', $values);
	if (empty($values)) { return false; }
	$dbprefix = elgg_get_config('dbprefix');
	$select = "SELECT DISTINCT md.entity_guid FROM {$dbprefix}metadata as md ";
	$join .= "JOIN {$dbprefix}metastrings as msn ON md.name_id=msn.id ";
	$join .= "JOIN {$dbprefix}metastrings as msv ON md.value_id=msv.id ";
	switch($md_filter['operand']) {
		case '=':
		case '':
			$where = "msn.string = '{$md_filter['name']}' AND msv.string = '{$md_filter['value']}'";
			break;
		case 'LIKE':
			$where = "msn.string = '{$md_filter['name']}' AND msv.string {$md_filter['operand']} '{$md_filter['value']}'";
			break;
		default:
			$where = "msn.string = '{$md_filter['name']}' AND msv.string {$md_filter['operand']} {$md_filter['value']}";
	}
	//$search_results .= 'Filter MD query : <pre>' . $query . '</pre>';
	
	$results = get_data("$select $join WHERE $where AND md.entity_guid IN ($values);");
	if ($results) {
		$guids = array();
		foreach ($results as $row) { $guids[] = $row->entity_guid; }
		return $guids;
	}
	return false;
}


// Generate view/edit keys, or force keys renewal
// Note : md5 is less random, but it's only to generate a random access key, so no cryptographic issue here
function uhb_annonces_generate_keys($offer, $force_renew = false) {
	if (elgg_instanceof($offer, 'object', 'uhb_offer')) {
		// Generate view key
		if ($force_renew || (empty($offer->viewkey))) {
			if (function_exists('openssl_random_pseudo_bytes')) {
				$viewkey = openssl_random_pseudo_bytes(16);
				$viewkey = bin2hex($viewkey);
			} else {
				$viewkey = md5($offer->guid . uniqid(mt_rand(), true));
			}
			$offer->viewkey = $viewkey;
		}
		// Generate edit key
		if ($force_renew || (empty($offer->editkey))) {
			if (function_exists('openssl_random_pseudo_bytes')) {
				$editkey = openssl_random_pseudo_bytes(16);
				$editkey = bin2hex($editkey);
			} else {
				$editkey = md5($offer->guid . uniqid(mt_rand(), true));
			}
			$offer->editkey = $editkey;
		}
		return true;
	}
	return false;
}



/**********************************************************/
/* ESOPE functions used to facilitate fields manipulation */
/**********************************************************/

if (!function_exists('esope_get_users_from_setting')) {
	/* Return a list of valid users from a string
	 * Input string can be a GUID or username list
	 */
	function esope_get_users_from_setting($setting) {
		$userlist = explode(',', trim($setting));
		$users = array();
		if ($userlist) foreach($userlist as $id) {
			$id = trim($id);
			if (($user = get_entity($id)) && elgg_instanceof($user, 'user')) {
				$users[$user->guid] = $user;
			} else if (($user = get_user_by_username($id)) && elgg_instanceof($user, 'user')) {
				$users[$user->guid] = $user;
			}
		}
		return $users;
	}
}

if (!function_exists('esope_get_meta_values')) {
	// Return distinct metadata values for a given metadata name
	// @TODO : we could get it more quickly with a direct SQL query
	function esope_get_meta_values($meta_name) {
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT DISTINCT ms.string FROM `" . $dbprefix . "metadata` as md 
			JOIN `" . $dbprefix . "metastrings` as ms ON md.value_id = ms.id 
			WHERE md.name_id = (SELECT id FROM `" . $dbprefix . "metastrings` WHERE string = '$meta_name');";
		$rows = get_data($query);
		foreach ($rows as $row) { $results[] = $row->string; }
		return $results;
	}
}

if (!function_exists('esope_get_meta_max')) {
	// Returns the max value for a given metadata
	function esope_get_meta_max($name = '', $subtype = '', $type = 'object') {
		if (!empty($name)) return elgg_get_metadata(array('types' => $type, 'subtypes' => $subtype, 'metadata_names' => $name, 'metadata_calculation' => "MAX"));
		return false;
	}
}
if (!function_exists('esope_get_meta_min')) {
	// Returns the min value for a given metadata
	function esope_get_meta_min($name = '', $subtype = '', $type = 'object') {
		if (!empty($name)) return elgg_get_metadata(array('types' => $type, 'subtypes' => $subtype, 'metadata_names' => $name, 'metadata_calculation' => "MIN"));
		return false;
	}
}

if (!function_exists('esope_get_input_array')) {
	/* Renvoie un array d'emails, de GUID, etc. à partir d'un textarea ou d'un input text
	 * e.g. 123, email;test \n hello => array('123', 'email', 'test', 'hello')
	 * Return : Tableau filtré, ou false
	 */
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

if (!function_exists('esope_build_options')) {
	/* Build options suitable array from settings
	 * Allowed separators are *only* one option per line, or | separator (we want to accept commas and other into fields)
	 * Accepts key::value and list of keys
	 * e.g. val1 | val2, or val1::Name 1 | val2::Name 2
	 * $input : the settings string
	 * $addempty : add empty option
	 * prefix : translation key prefix
	 */
	function esope_build_options($input, $addempty = true, $prefix = 'option') {
		$options = str_replace(array("\r", "\t", "|"), "\n", $input);
		$options = explode("\n", $options);
		$options_values = array();
		if ($addempty) $options_values[''] = "";
		foreach($options as $option) {
			$option = trim($option);
			if (!empty($option)) {
				if (strpos($option, '::')) {
					$value = explode('::', $option);
					$key = trim($value[0]);
					$options_values[$key] = trim($value[1]);
				} else {
					$options_values[$option] = elgg_echo("$prefix:$option");
				}
			}
		}
		return $options_values;
	}
}


// Based on ESOPE esope_add_file_to_entity
// Used to temporarly store file attachments to offers
// Saves file using a specific folder in datastore
function uhb_add_file_attachment($entity, $input_name = 'file') {
	if (elgg_instanceof($entity, 'object') || elgg_instanceof($entity, 'user')) {
		$filename = $_FILES[$input_name]['name'];
		if ($uploaded_file = get_uploaded_file($input_name)) {
			// Remove previous file, if any
			if (!empty($entity->{$input_name})) {
				if (file_exists($filename)) { unlink($filename); }
			}
			// Create new file
			$prefix = "uhb_annonces/{$input_name}/";
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $entity->guid;
			$filehandler->setFilename($prefix . $filename);
			if ($filehandler->open("write")){
				$filehandler->write($uploaded_file);
				$filehandler->close();
			}
			$filename = $filehandler->getFilenameOnFilestore();
			$entity->{$input_name} = $filename;
			return true;
		}
	}
	return false;
}

// Based on ESOPE esope_remove_file_from_entity
// Used to removed a file from user profile after upload
function uhb_remove_file_attachment($entity, $input_name = 'file') {
	if (elgg_instanceof($entity, 'object') || elgg_instanceof($entity, 'user')) {
		if (!empty($entity->{$input_name})){
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $entity->guid;
			$filehandler->setFilename($entity->{$input_name});
			if ($filehandler->exists()) { $filehandler->delete(); }
			unset($entity->{$input_name});
			return true;
		} else {
			return true;
		}
	}
	return false;
}





