<?php
/**
 * Create or edit an offer
 *
 */

global $CONFIG;

$guid = get_input('guid', false);

elgg_make_sticky_form('uhb_offer');
elgg_set_context('uhb_offer');

// Entities are always disabled, so we don't have to worry about people trying to access unwanted metadata...
// See page_handler note for more details
elgg_set_ignore_access(true);
access_show_hidden_entities(true);

// Set initial values (can be promoted)
$new = true;
$must_revalidate = false;
$must_confirm = false;
// Remember some data for further actions processing
$previous_state = ''; // Init to new, and override once we get the entity, if any
// Champs autorisés (à utiliser pour filtrer chacun des champs)
$editable_fields = uhb_annonces_get_fields('edit');
// All available fields
//$all_fields = uhb_annonces_get_fields();


// CREATE / EDIT ENTITY
if (!$guid || empty($guid)) {
	// Define authorship for once
	if (elgg_is_logged_in()) {
		$author = elgg_get_logged_in_user_entity();
	} else {
		$author = $CONFIG->site;
	}
	
	// Add captcha hook if new offer and no edit key
	if (!elgg_is_logged_in() && (!elgg_instanceof($offer, 'object', 'uhb_offer') || ($offer->editkey != get_input('editkey'))) ) {
		if (elgg_is_active_plugin('image_captcha')) {
			$token = get_input('image_captcha');
			if (($token) && ($token == $_SESSION["image_captcha"])){
			} else {
				register_error(elgg_echo('uhb_annonces:image_captcha:verify:fail'));
				forward(REFERER);
			}
		}
	}
	
	
	// Email check : double verification
	$email_confirm1 = get_input('manageremail');
	if (!is_email_address($email_confirm1)) {
		register_error(elgg_echo('uhb_annonces:error:invalidemail'));
		forward(REFERER);
	}
	$email_confirm2 = get_input('manageremail_confirm');
	if (empty($email_confirm1) || ($email_confirm1 != $email_confirm2)) {
		register_error(elgg_echo('uhb_annonces:error:emailmatch'));
		forward(REFERER);
	}
	
	$offer = new ElggObject;
	$offer->subtype = 'uhb_offer';
	// Access is public, so we can always access the metadata, but we display them using a custom logic
	$offer->access_id = 2;
	$offer->container_guid = $CONFIG->site->guid;
	$offer->owner_guid = $author->guid;
	$offer->save();
	// Entities are always disabled, so we don't have to worry about people trying to access unwanted metadata...
	// See page_handler note for more details
	disable_entity($offer->guid);
	
	// Set initial/default values
	$offer->managervalidated = 'no';
	$offer->followcreation = time();
	$offer->followvalidation = false;
	$offer->followend = false;
	$offer->followstate = 'new';
	$offer->followcomments = '';
	// Note : it is essential to initialize counters because search relies on it
	$offer->followinterested = 0;
	$offer->followcandidates = 0;
	$offer->followreport = 0;
	
	// Generate view/edit keys
	uhb_annonces_generate_keys($offer);
	
} else {
	$new = false;
	$offer = get_entity($guid);
	// Si offre demandée mais non valide => eject
	if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
		register_error(elgg_echo('uhb_annonces:noentity'));
		forward(REFERER);
	}
	// Tentative d'édition d'une offre sans les droits nécessaires => eject
	if (!uhb_annonces_can_edit_offer($offer)) {
		register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
		forward(REFERER);
	}
	
	// Remember some data for further actions processing
	$previous_state = $offer->followstate;
	
	// Champs autorisés (à utiliser pour filtrer chacun des champs)
	$editable_fields = uhb_annonces_get_fields('edit', $offer);
	
	// Check keys, and create them if needed for some reason
	uhb_annonces_generate_keys($offer);
}


// Auto-validate manager email if email has already been validated once
$manageremail = get_input('manageremail');
if (uhb_annonces_has_valid_email($manageremail)) {
	$autovalidate_email = true; // Use as bypass to avoid further controls
	$offer->managervalidated = 'yes';
	$new_state = get_input('followstate');
	// If wannabe new offer, set inputs to skip email validation step
	if ($new_state == 'new') { set_input('followstate', 'confirmed'); }
	// If new offer, immediately set new state and skip email validation step
	if (($offer->followstate == 'new') || ($new_state == 'new')) {
		$offer->followstate = 'confirmed';
	}
}


// Admin ?
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }


// Ownership change after creation is reserved to admins or new entities
// Defaults has already been set otherwise
$owner_guid = get_input('owner_guid');
if ($admin && !empty($owner_guid)) { $offer->owner_guid = $owner_guid; }


// Edit allowed fields
// Special cases : radio, checkboxes, longtext
$tag_fields = array();
$radio_fields = array();
$dropdown_fields = array();
$longtext_fields = array();
$checkboxes_fields = array();
// Dates : convert to timestamp ?
foreach ($editable_fields as $field) {
	$value = get_input($field, false);
	if ($value === false) continue;
	
	if ($field == 'manageremail') {
		// Manager email needs to be confirmed again if changed
		if (!$admin && !$autovalidate_email && !empty($offer->manageremail) && ($offer->manageremail != $value)) {
			$must_revalidate = true;
		}
	}
	
	// Automatically add http:// to relative URL
	if (($field == 'structurewebsite') && !empty($value)) {
		if ((substr($value, 0, 7) != 'http://') && (substr($value, 0, 8) != 'https://')) {
			$value = 'http://' . $value;
		}
	}
	
	// Handle special fields
	if (in_array($field, array($tag_fields))) { $value = string_to_tag_array($input[$name]); }
	
	// Handle counter fields
	if (empty($value) && in_array($field, array('followinterested', 'followcandidates', 'followreport'))) $value = 0;
	
	// Save value
	//error_log("$field => $value"); // debug
	//echo "$field => $value<br />"; // debug
	$offer->$field = $value;
}


// Any change by a non-admin ?
// Offer update => confirm again
if (!$admin && ($offer->followstate == 'published')) {
	$offer->followstate = 'confirmed';
	system_message(elgg_echo('uhb_annonces:updated:mustconfirm'));
}
// Email update => validate email again
if (!$admin && $must_revalidate) {
	$offer->followstate = 'new';
	system_message(elgg_echo('uhb_annonces:mustrevalidate'));
}


// Handle state changes and trigger actions
$offer = uhb_annonces_state_change($offer, $previous_state);


// Update Title and Description, not necessary but looks cleaner...
$offer->title = $offer->offerposition;
$offer->description = $offer->offertask;


//echo "Type = $types / Object = " . print_r($offer, true); exit;
if ($offer->save()) {
	system_message(elgg_echo('uhb_annonces:save:success'));
	elgg_clear_sticky_form('uhb_offer');
} else {
	register_error(elgg_echo('uhb_annonces:error:cannotsave'));
	return;
}

// Forward to offer view page
$offer_url = $offer->getURL();
// Note : we need to forward with edit key, because view bypasses only with an edit key. Basically view key is not used yet. 
// Could be used to provide access to other people to some offers ("share" functionnality)
//$offer_url .= '?viewkey=' . $offer->viewkey;

// Add edit key if user is usually not allowed to see offers
$allowed_types = elgg_get_plugin_setting('whitelist');
$allowed_types = esope_get_input_array($allowed_types);
if (!elgg_is_logged_in() || !in_array($types, $allowed_types)) { $offer_url .= '?editkey=' . $offer->editkey; }
//echo "$types / " . implode(', ', $allowed_types) . '<br />' . $offer_url; exit;
forward($offer_url);


