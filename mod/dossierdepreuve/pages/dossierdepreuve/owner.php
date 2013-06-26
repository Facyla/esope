<?php
/**
 * Elgg dossierdepreuve owner view
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

dossierdepreuve_gatekeeper();
global $CONFIG;
$url = $CONFIG->url;

$limit = get_input("limit", 30);
$offset = get_input("offset", 0);
$username = get_input("username", false);

if ($username) $page_owner = get_user_by_username($username);
else $page_owner = $_SESSION['user'];

// Set the current page's owner to the.. owner
elgg_set_page_owner_guid($page_owner);


$cloudtags = array();

$sidebar = '';

$content = '';

elgg_set_context('search');
$dossiers = dossierdepreuve_get_user_dossiers($page_owner->guid, false);
if ($dossiers) {
	foreach ($dossiers as $dossier) {
		$content .= elgg_view_entity($dossier) . '<hr />';
	}
} else {
	$content .= "<p>Vous n'avez pas encore de dossier de preuve.</p>" . '<p><a class="elgg-button elgg-button-action" href="' . $url . 'dossierdepreuve/new">Créer mon dossier de preuve</a></p>';
}



// Compose page
elgg_push_context('dossierdepreuve');
$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

$title = elgg_echo("dossierdepreuve:owner");

echo elgg_view_page($title, $body);

