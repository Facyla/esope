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
// Action restricted to members
if (!elgg_is_logged_in()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorisededit'));
	forward();
}


// ACTION
// Allow changes to entity
elgg_set_ignore_access(true);

// Increment report counter
//$offer->followreport++;
// Report offer
$ownguid = elgg_get_logged_in_user_guid();
if ($request == 'remove') {
	// Remove memorised offer
	remove_entity_relationship($ownguid, 'reported', $offer->guid);
	// Update counter
	if (!in_array($offer->followstate, array('filled', 'archive'))) $offer->followreport--;
	system_message(elgg_echo('uhb_annonces:action:unreport:success'));
} else {
	// Report offer as filled
	add_entity_relationship($ownguid, 'reported', $offer->guid);
//echo "add_entity_relationship($ownguid, 'reported', $offer->guid);"; echo $test; exit;
	// Update counter
	if (!in_array($offer->followstate, array('filled', 'archive'))) $offer->followreport++;
	system_message(elgg_echo('uhb_annonces:action:report:success'));
}


