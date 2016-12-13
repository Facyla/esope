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

// Allow changes to entity
elgg_set_ignore_access(true);

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



/* ACTION : mark as filled and archive are allowed to both admins and owner (so anyone who can edit)
// ACTION : archive is restricted to admins
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types != 'admin') {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	forward();
}
*/

// Remember some data for further actions processing
$previous_state = $offer->followstate;

if ($offer->followstate != 'filled') {
	$offer->followstate = 'filled';
	system_message(elgg_echo('uhb_annonces:action:filled:success'));
	// Handle state changes and trigger actions
	$offer = uhb_annonces_state_change($offer, $previous_state);
}


// Forward to offer view page
/*
$forward = $offer->getURL();
if (!elgg_is_logged_in()) { $forward .= '?' . uhb_annonces_add_keys(); }
*/
$forward = 'annonces';
forward($forward);

