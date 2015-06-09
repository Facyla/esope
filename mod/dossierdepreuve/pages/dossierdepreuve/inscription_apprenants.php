<?php
/**
 * Elgg dossierdepreuve users registration
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

global $CONFIG;
dossierdepreuve_gatekeeper();

$content = '';

// Set the current page's owner to the site
elgg_set_page_owner_guid(0);
elgg_set_context('dossierdepreuve');

$editor_profile_type = dossierdepreuve_get_user_profile_type(elgg_get_logged_in_user_entity());

// Infos diverses et mode d'emploi
$content .= '<p>' . elgg_echo('dossierdepreuve:inscription:help') . '</p>';
$content .= elgg_view_form('dossierdepreuve/inscription', array());


// Composition de la page
elgg_set_context('dossierdepreuve');
elgg_push_context('inscription_apprenants');


$nav = elgg_view('dossierdepreuve/nav', array('selected' => 'inscription_apprenants', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content, 'sidebar' => $area1));

$title = elgg_echo("dossierdepreuve:inscription");

echo elgg_view_page($title, $body); // Finally draw the page

