<?php
/**
 * Candidate to an offer
 *
 */

global $CONFIG;

$guid = get_input('guid');

elgg_make_sticky_form('uhb_candidate');
elgg_set_context('uhb_offer');

// Allow access to entity
access_show_hidden_entities(true);

$offer = get_entity($guid);

// Si offre demandée mais non valide => eject
if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
	register_error(elgg_echo('uhb_annonces:error:noentity'));
	return;
}
// Action restricted to members
if (!elgg_is_logged_in()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	return;
}
// Seuls les candidats potentiels peuvent mémoriser l'offre
if (!uhb_annonces_can_candidate()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	return;
}

// Email file attachment support is required
// And it relies on html_email_handler
if (!elgg_is_active_plugin('html_email_handler')) {
	register_error('uhb_annonces:error:attachmentsupport');
	return;
}


// ACTION
// Allow changes to entity
elgg_set_ignore_access(true);

$own = elgg_get_logged_in_user_entity();
$addprofile = get_input('addprofile');
if ($addprofile == 'on') { $addprofile = true; } else { $addprofile = false; }

// Check profile completeness - block sending if not complete
$complete = uhb_annonces_is_profile_complete();
if ($addprofile && !$complete) { $addprofile = false; }


// Candidate form processing
// Save file to user before sending them - is it useful ?
/* We could save the file before sending it, but it's pointless if we don't keep that file anyway...
$error = false;
// Attached file 1
$saved = uhb_add_file_attachment($own, 'uhb_offer_file1');
if (!$saved) {
	register_error(elgg_echo('uhb_annonces:error:downloadattachment'));
	register_error(elgg_echo('uhb_annonces:error:missingattachment'));
	$error = true;
	return;
}
// Attached file 2
$saved = uhb_add_file_attachment($own, 'uhb_offer_file2');
if (!$saved) { register_error(elgg_echo('uhb_annonces:error:downloadattachment')); }

// Break if error
if ($error) { return; }
*/

// Build attachment(s)
$attachments = array();
$filename = $_FILES['uhb_offer_file1']['name'];
if ($filename && ($_FILES['uhb_offer_file1']['size'] > 0)) {
	$mimetype = 'application/octet-stream'; // Default
	if (!empty($_FILES['uhb_offer_file1']['type'])) { $mimetype = $_FILES['uhb_offer_file1']['type']; }
	$file_content = get_uploaded_file('uhb_offer_file1');
	//$file_content = file_get_contents($own->uhb_offer_file1);
	$file_content = chunk_split(base64_encode($file_content));
	$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
} else {
	register_error(elgg_echo('uhb_annonces:error:missingattachment'));
	return;
}

// Other file is optional, so let's check we have something first
$filename = $_FILES['uhb_offer_file2']['name'];
if ($filename && ($_FILES['uhb_offer_file2']['size'] > 0)) {
	$mimetype = 'application/octet-stream'; // Default
	if (!empty($_FILES['uhb_offer_file2']['type'])) { $mimetype = $_FILES['uhb_offer_file2']['type']; }
	$file_content = get_uploaded_file('uhb_offer_file2');
	$file_content = chunk_split(base64_encode($file_content));
	$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
}

//echo print_r($attachments, true); exit;


// Define useful vars for notification
// Encode the name. If may content nos ASCII chars.
$from_name = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=";
$from = $from_name . ' <' . $CONFIG->site->email . '>';

$managergender = elgg_echo('uhb_annonces:managergender:'.$offer->managergender);
$managername = $offer->managername;
$typeoffer = elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer);
$typeoffer_full = $typeoffer;
if (($offer->typeoffer == 'emploi') && !empty($offer->typework)) {
	$typeoffer_full .= ' (' . elgg_echo('uhb_annonces:typework:'.$offer->typework) . ')';
}
$offerposition = $offer->offerposition;
$followvalidation = $offer->followvalidation;
if (!empty($followvalidation)) {
	if (is_numeric($followvalidation)) { $followvalidation = date('d/m/Y', $followvalidation); }
	$followvalidation = elgg_echo('uhb_annonces:view:followvalidation', array($followvalidation));
} else { $followvalidation = elgg_echo('uhb_annonces:view:followvalidation:no'); }
$offer_url = $offer->getURL();
$add_editkey = '?guid=' . $offer->guid . '&editkey=' . $offer->editkey;
$editurl = $CONFIG->url . 'annonces/edit/' . $offer->guid . $add_editkey;
$confirmurl = $CONFIG->url . 'annonces/action/confirm' . $add_editkey;
$reactivateurl = $CONFIG->url . 'annonces/action/reactivate' . $add_editkey;
$archiveurl = $CONFIG->url . 'annonces/action/archive' . $add_editkey;
$candidate_name = $own->name;
$candidate_url = $own->getURL();

$count_attachments = count($attachments);
if ($count_attachments > 1) {
	$num_uhb_offer_file = elgg_echo('uhb_annonces:notification:attached:multiple', array($count_attachments));
} else {
	$num_uhb_offer_file = elgg_echo('uhb_annonces:notification:attached:single');
}
$addprofile_text = '';
if ($addprofile) {
	$addprofile_text = elgg_echo('uhb_annonces:notification:candidate:body:profile', array($candidate_name, $candidate_url));
}


// Send mail to manager
// Encode the name. If may content nos ASCII chars.
$to_name = "=?UTF-8?B?" . base64_encode($offer->managername) . "?=";
$to = $to_name . ' <' . $offer->manageremail . '>';
$subject = elgg_echo('uhb_annonces:notification:candidate:subject', array($typeoffer_full));
$message = elgg_echo('uhb_annonces:notification:candidate:body', array($managergender, $managername, $typeoffer, $offerposition, $own->name, $num_uhb_offer_file, $addprofile_text, $editurl));
$html_message = html_email_handler_make_html_body($subject, $message);
// Suppression du lien vers notifications
uhb_annonces_hide_notification_link($offer);// Send email + attachments
$result1 = html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message, 'attachments' => $attachments));


// Send specific mail to candidate
$to_name = "=?UTF-8?B?" . base64_encode($own->name) . "?=";
$to = $to_name . ' <' . $own->email . '>';
$subject = elgg_echo('uhb_annonces:notification:application:subject');
$message = elgg_echo('uhb_annonces:notification:application:body', array($candidate_name, $typeoffer, $offer_url, $candidate_url));
$html_message = html_email_handler_make_html_body($subject, $message);
// Réactivation du lien vers la gestion des notifications du candidat
set_input('hide_html_email_handler_link', 'no');
// Send email + attachments
$result2 = html_email_handler_send_email(array('from' => $from, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message, 'attachments' => $attachments));


// Finish the process if no error occurred
if ($result1 && $result2) {
	// Add relation
	add_entity_relationship($own->guid, 'has_candidated', $offer->guid);
	$offer->followcandidates++;
	system_message(elgg_echo('uhb_annonces:action:candidate:success'));
	
	elgg_clear_sticky_form('uhb_candidate');
	
	// Remove attached files
	
	// Forward to offer view page
	$forward = $offer->getURL();
	forward($forward);
} else {
	register_error(elgg_echo('uhb_annonces:action:candidate:error'));
}



