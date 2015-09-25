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



// ACTION : email validation is restricted to admins
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types != 'admin') {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	forward();
}

// Allow changes to entity
elgg_set_ignore_access(true);

// Remember some data for further actions processing
$previous_state = $offer->followstate;

// Always force email validation
$offer->managervalidated = 'yes';
// But update state only to promote to next step
if ($offer->followstate == 'new') {
	$offer->followstate = 'confirmed';
	// Handle state changes and trigger actions
	$offer = uhb_annonces_state_change($offer, $previous_state);
}
system_message(elgg_echo('uhb_annonces:action:validate:success'));


// Forward to offer view page
$forward = $offer->getURL();
forward($forward);

