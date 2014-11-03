<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

$title = "Titre";

$content = "Plugin_template page content";

$sidebar = "Contenu de la sidebar";

// Render the page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);


