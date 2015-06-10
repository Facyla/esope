<?php
/**
 * Elgg dossierdepreuve group browser
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
global $CONFIG;
dossierdepreuve_gatekeeper();

$limit = get_input("limit", 30);
$offset = get_input("offset", 0);
$group_guid = get_input("group", false);

if (!$group = get_entity($group_guid)) { forward(REFERER); }

// Affiche tous les dossiers de preuve - filtrage par OF / groupe / formateur de ratachement => à définir

// Get the current page's owner to the group
elgg_set_page_owner_guid($group_guid);

$cloudtags = array();

$content = '';
$dossiersdepreuves = '';
elgg_set_context('search');


$ia = elgg_set_ignore_access(true);
$learners = dossierdepreuve_get_group_learners($group);
// Les éléments du dossier
foreach ($learners as $user) {
	$dossiers = dossierdepreuve_get_user_dossiers($user->guid, 'b2iadultes');
	$content .= '<h3>' . $user->name . '</h3>';
	if ($dossiers) {
		foreach ($dossiers as $guid => $ent) {
			$content .= '<p>' . elgg_view('object/dossierdepreuve', array('entity' => $ent)) . '</p>';
		}
	} else $content .= '<p>' . elgg_echo('dossierdepreuve:nodossier') . '</p>';
	$content .= '<hr />';
}
elgg_set_ignore_access($ia);


elgg_push_context('dossierdepreuve');


// Compose page
$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

$title = elgg_echo("dossierdepreuve:all");

echo elgg_view_page($title, $body);

