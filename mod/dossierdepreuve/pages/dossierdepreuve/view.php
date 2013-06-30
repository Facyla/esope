<?php
/**
 * Elgg dossierdepreuve dossier viewer
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

global $CONFIG;
dossierdepreuve_gatekeeper();

$content = '';
$sidebar = '';

// @TODO : virer le flux RSS


// Tout le monde a accès à ce stade : on affichera des choses différentes selon les profils dans la vue

// Render the dossierdepreuve page
$dossierdepreuve = (int) get_input('guid');
if ($dossierdepreuve = get_entity($dossierdepreuve)) {
	// Set the page owner
	$page_owner = elgg_get_page_owner_entity();
	if ($page_owner === false || is_null($page_owner)) {
	  elgg_set_page_owner(1);
		$container_guid = $dossierdepreuve->container_guid;
		if (!empty($container_guid)) {
			if ($page_owner = get_entity($container_guid)) { elgg_set_page_owner($container_guid); }
		}
	}
	
	$title = $entity->title;
	$content .= elgg_view("object/dossierdepreuve", array('entity' => $dossierdepreuve, 'full_view' => true));
	
	// SIDEBAR
	$sidebar .= '<a href="' . $CONFIG->url . 'dossierdepreuve/autopositionnement" class="elgg-button elgg-button-action">Tester mon niveau</a><br /><br />';
	if ($dossierdepreuve->canEdit()) {
		//$sidebar .= elgg_view('dossierdepreuve/sidebar', array('tags' => $tagstring));
		$sidebar .= '<a href="' . $CONFIG->url . 'blog/add/' . $page_owner->guid . '" class="elgg-button elgg-button-action">Créer un nouvel article</a><br /><br />';
		$sidebar .= '<a href="' . $CONFIG->url . 'file/add/' . $page_owner->guid . '" class="elgg-button elgg-button-action">Ajouter un nouveau fichier</a><br /><br />';
		$sidebar .= '<a href="' . $CONFIG->url . 'dossierdepreuve/edit/' . $dossierdepreuve->guid . '" class="elgg-button elgg-button-action">Mettre à jour mon dossier</a><br /><br />';
		$sidebar .= '<a href="' . $CONFIG->url . 'dossierdepreuve/export/' . $dossierdepreuve->guid . '" class="elgg-button elgg-button-action">Exporter mon dossier en HTML/PDF</a><br /><br />';
		/*
		$edit_links .= elgg_view('output/confirmlink',array(
				'href' => $vars['url'] . "action/dossierdepreuve/delete?dossierdepreuve=" . $dossierdepreuve->getGUID(),
				'text' => elgg_echo("delete"), 'confirm' => elgg_echo("dossierdepreuve:delete:confirm"),
				'class' => 'elgg-button elgg-button-action',
			));
		*/
	}
	
}
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);

