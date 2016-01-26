<?php
/**
 * Confirm manager email
 *
 */

global $CONFIG;

$request = get_input('request');
$guid = get_input('guid');

// Allow access to entity
access_show_hidden_entities(true);

$offer = get_entity($guid);

// Si offre demandée mais non valide => eject
if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
	register_error(elgg_echo('uhb_annonces:error:noentity'));
	forward();
}
// Tentative d'édition d'une offre sans les droits nécessaires => eject
if (!uhb_annonces_can_edit_offer($offer)) {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	forward();
}



// ACTION : resend confirmation email is restricted to admins
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types != 'admin') {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	forward();
}

// Allow changes to entity
elgg_set_ignore_access(true);


// Note : force update to send a new email
$offer->followstate = 'new';
	// Handle state changes and trigger actions
$offer = uhb_annonces_state_change($offer, '');

system_message(elgg_echo('uhb_annonces:action:resendconfirm:success'));


// Forward to offer view page
$forward = $offer->getURL();
forward($forward);


