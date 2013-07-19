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

// Suppression du flux RSS : à faire après tout affichage d'annotation
global $autofeed;

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
	$sidebar .= '<div class="elgg-module elgg-owner-block"><div class="elgg-menu">';
	
	$sidebar .= '<ul class="elgg-menu elgg-menu-page elgg-menu-page-default">';
	$sidebar .= '<li><a href="' . $CONFIG->url . 'dossierdepreuve/autopositionnement">Tester mon niveau</a></li>';
	if ($dossierdepreuve->canEdit()) {
		$sidebar .= '<li><a href="' . $CONFIG->url . 'blog/add/' . $page_owner->guid . '">Créer un nouvel article</a></li>';
		$sidebar .= '<li><a href="' . $CONFIG->url . 'file/add/' . $page_owner->guid . '">Ajouter un nouveau fichier</a></li>';
		$sidebar .= '<li><a href="' . $CONFIG->url . 'dossierdepreuve/edit/' . $dossierdepreuve->guid . '">Mettre à jour mon dossier</a></li>';
		$sidebar .= '<li><a href="' . $CONFIG->url . 'dossierdepreuve/export/' . $dossierdepreuve->guid . '">Exporter mon dossier en HTML/PDF</a></li>';
		/*
		$sidebar .= '<li>' . elgg_view('output/confirmlink',array(
				'href' => $vars['url'] . "action/dossierdepreuve/delete?dossierdepreuve=" . $dossierdepreuve->getGUID(),
				'text' => elgg_echo("delete"), 'confirm' => elgg_echo("dossierdepreuve:delete:confirm"),
			)) . '</li>';
		*/
	}
	$sidebar .= '</ul>';
	$sidebar .= '</div></div>';
	
}

$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

$autofeed = false;
echo elgg_view_page($title, $body);

