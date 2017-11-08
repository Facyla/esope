<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2015
* @link http://id.facyla.fr/
*/

$title = "Titre";

$content = "Plugin_template main page";

$sidebar = "Contenu de la sidebar";

// Render the page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);


