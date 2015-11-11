<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2015
* @link http://id.facyla.fr/
*/

$title = "Répertoire";

$content = "Accueil du répertoire";

$sidebar = "Sidebar";


elgg_push_context('listing');
elgg_push_context('directory');


// Count Total pages
$directory_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'directory', 'order_by' => 'time_created desc', 'count' => true));
if ($directory_count > 0) $title .= " ($directory_count)";

if (elgg_is_logged_in()) {

	$sidebar .= '<blockquote style="padding:6px 12px; margin: 1ex 0;">' . elgg_echo('directory:instructions') . '</blockquote>';
}

// Display directory
if ($directory_count > 0) {
	$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'directory', 'order_by' => 'time_created desc', 'limit' => 10, 'list_class' => "elgg-list-directory"));
	//$content .= elgg_view('directory/listing');
}





// Render the page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'class' => "directory-index"));
echo elgg_view_page($title, $body);


