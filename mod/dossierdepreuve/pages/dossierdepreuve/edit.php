<?php
/**
 * Elgg dossierdepreuve dossier edit/create page
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

dossierdepreuve_gatekeeper();

$dossierdepreuve_guid = (int) get_input('guid', false);
$owner_guid = get_input('owner_guid', elgg_get_logged_in_user_guid());
$editor_guid = elgg_get_logged_in_user_guid();

// Si on a un GUID, on regarde si le dossier est valide
if ($dossierdepreuve_guid) {
	// Si le GUID est invalide, on prévient
	if (!($dossierdepreuve = get_entity($dossierdepreuve_guid))) {
		register_error('Le dossier spécifié est invalide.');
		// On oublie le GUID pour pouvoir tenter de récupérer le dossier du membre connecté
		$dossierdepreuve_guid = false;
	}
}

// Si on n'a pas de GUID ou si le GUID passé est invalide, on récupère le dossier du membre demandé
if (!$dossierdepreuve_guid) {
	$dossierdepreuve = dossierdepreuve_get_user_dossier($owner_guid);
	if ($dossierdepreuve) { system_message('Le bon dossier de preuve a pu être retrouvé automatiquement.'); }
}

// Si on a un dossier, il faut vérifier qu'on peut l'éditer..
if ($dossierdepreuve) {
	if (!($dossierdepreuve->canEdit())) {
		register_error(elgg_echo('dossierdepreuve:error:cantedit'));
		forward(REFERRER);
	}
} else {
	// @TODO : si nouveau dossier mais qu'on n'a pas les droits pour éditer => eject
	if (!dossierdepreuve_can_create_for_user($owner_guid, $editor_guid, true)) {
		register_error(elgg_echo('dossierdepreuve:error:onlyforlearners'));
		forward(REFERRER);
	}
}


// Render the dossierdepreuve edit/create page
// Edit page if we have an object
if (elgg_instanceof($dossierdepreuve, 'object', 'dossierdepreuve')) {
	// Set the page owner to the object owner
	$owner_guid = $dossierdepreuve->owner_guid;
	if (!empty($owner_guid)) {
		if ($page_owner = get_entity($owner_guid)) {
			elgg_set_page_owner_guid($owner_guid);
		}
	}
	$title = elgg_view_title(elgg_echo('dossierdepreuve:edit', array($page_owner->name)));
	if ($dossierdepreuve->canEdit()) {
		$content = elgg_view("forms/dossierdepreuve/edit",array('entity' => $dossierdepreuve));
		$pagetitle = elgg_echo("dossierdepreuve:edit");
	} else {
		$content = "Vous n'avez pas accès en écriture à ce dossier de preuve.";
		$pagetitle = elgg_echo("dossierdepreuve:canedit");
	}

} else {
	// Create a new dossier !
	if ($page_owner = get_entity($owner_guid)) {}
	if ($page_owner === false || is_null($page_owner)) {
		$page_owner = elgg_get_logged_in_user_entity();
		elgg_set_page_owner_guid($page_owner->guid);
	}
	$pagetitle = elgg_echo('dossierdepreuve:new', array($page_owner->name));
	$title = elgg_view_title($pagetitle);
	$content = elgg_view("forms/dossierdepreuve/edit",array());
}


// Compose & render page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));
echo elgg_view_page($pagetitle, $body);


