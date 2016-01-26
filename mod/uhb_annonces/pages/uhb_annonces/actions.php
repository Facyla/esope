<?php
/**
 * Confirm manager email
 *
 */

global $CONFIG;

$request = get_input('request');
$guid = get_input('guid');

// Allow changes
elgg_set_ignore_access(true);

$offer = get_entity($guid);

// Si offre demandée mais non valide => eject
if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
	register_error(elgg_echo('uhb_annonces:noentity'));
	forward();
}
// Tentative d'édition d'une offre sans les droits nécessaires => eject
if (!uhb_annonces_can_edit_offer($offer)) {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	forward();
}

// Remember some data for further actions processing
$previous_state = $offer->followstate;

/*
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }
*/


// ACTIONS
switch($request) {
	case 'confirm':
		// Validate email
		if ($offer->managervalidated == 'yes') {
			system_message(elgg_echo('uhb_annonces:action:confirmed:success'));
			$content .= elgg_echo('uhb_annonces:action:confirmed:success:message');
		} else {
			$offer->managervalidated = 'yes';
			system_message(elgg_echo('uhb_annonces:action:confirm:success'));
			$content .= elgg_echo('uhb_annonces:action:confirm:success:message');
		}
		// Promote to confirmed only if previous state was new (do not change if other state set by admin)
		if ($offer->followstate == 'new') {
			$offer->followstate = 'confirmed';
			// Handle state changes and trigger actions
			$offer = uhb_annonces_state_change($offer, $previous_state);
		}
		$forward = $offer->getURL();
		$forward .= '?' . uhb_annonces_add_keys();
		break;
	
	case 'reactivate':
		if ($offer->followstate == 'published') {
			$offer->followend = time() + (30*24*3600);
			system_message(elgg_echo('uhb_annonces:action:reactivate:success'));
			$content .= elgg_echo('uhb_annonces:action:reactivate:success:message');
		} else { register_error(elgg_echo('uhb_annonces:action:reactivate:error')); }
		$forward = $offer->getURL();
		$forward .= '?' . uhb_annonces_add_keys();
		break;
	
	case 'archive':
		if (!in_array($offer->followstate, array('filled', 'archive'))) {
		$offer->followstate = 'archive';
			// Handle state changes and trigger actions
			$offer = uhb_annonces_state_change($offer, $previous_state);
			system_message(elgg_echo('uhb_annonces:action:archive:success'));
		} else { register_error(elgg_echo('uhb_annonces:action:archive:alreadydone')); }
		if (elgg_is_logged_in()) {
			$forward = 'annonces';
		} else {
			$title = elgg_echo('uhb_annonces:action:archive:success:title');
			$content .= elgg_echo('uhb_annonces:action:archive:success:message');
		}
		break;
}



// Compose page content
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Forward to the appropriate page
if ($forward) forward($forward);

// Render the page
//echo elgg_view_page(strip_tags($title), $body);


