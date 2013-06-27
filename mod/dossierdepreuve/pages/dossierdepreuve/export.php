<?php
/**
 * Elgg dossierdepreuve dossier export page
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

dossierdepreuve_gatekeeper();

$dossierdepreuve_guid = (int) get_input('guid', false);

// Si on a un GUID, on regarde si le dossier est valide
if ($dossierdepreuve_guid && ($dossierdepreuve = get_entity($dossierdepreuve_guid))) {
	if (!($dossierdepreuve = get_entity($dossierdepreuve_guid))) {
		register_error(elgg_echo('dossierdepreuve:error:invalid'));
		forward(REFERRER);
	}
}

// Si on n'a pas de GUID ou si le dossier est invalide, c'est terminé
if (!elgg_instanceof($dossierdepreuve, 'object', 'dossierdepreuve')) {
	register_error(elgg_echo('dossierdepreuve:error:invalid'));
	forward(REFERRER);
}

// Si on a un dossier, il faut encore vérifier qu'on peut l'éditer..
if (!($dossierdepreuve->canEdit())) {
	register_error(elgg_echo('dossierdepreuve:error:cantedit'));
	forward(REFERRER);
}


$export_type = get_input('type', '');

// Set the page owner
$page_owner = $dossierdepreuve->getOwnerEntity();
elgg_set_page_owner_guid($page_owner->guid);

// Render the dossierdepreuve export page
$title = elgg_view_title(elgg_echo('dossierdepreuve:export', array($page_owner->name)));
$content = elgg_view("dossierdepreuve/export",array('entity' => $dossierdepreuve));
$pagetitle = elgg_echo("dossierdepreuve:export");

if ($export_type == 'html') {
	echo $content;
	exit;
}

// Compose & render page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));
echo elgg_view_page($pagetitle, $body);

