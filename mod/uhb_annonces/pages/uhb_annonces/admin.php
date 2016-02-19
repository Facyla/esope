<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;


// Accès à l'administration : membres autorisés seulement
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types != 'admin') {
	register_error(elgg_echo('uhb_annonces:error:unauthorisedadmin'));
	forward('annonces');
}


$title = elgg_echo('uhb_annonces:admin:title');

/*
$filter = get_input('filter', 'all');
if ($filter) $title .= " ($filter)";
*/

// Breacrumbs
elgg_push_breadcrumb($title);


// SIDEBAR
$sidebar = '';
$sidebar .= elgg_view('uhb_annonces/sidebar');


// CONTENT
$content = '';
// Suppression de certaines metadonnées au-delà d'une durée précise
$content .= "Suppression de certaines métadonnées selon des critères de dates.";



// Compose page content
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

