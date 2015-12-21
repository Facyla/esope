<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2015
* @link http://id.facyla.fr/
*/

$title = elgg_echo('directory');
$subtype = get_input('subtype', 'all');
if (!in_array($subtype, array('all', 'directory', 'person', 'organisation'))) { $subtype = 'all'; }
$content = '';

$sidebar = "Sidebar";


elgg_push_context('listing');
elgg_push_context('directory');


if (elgg_is_logged_in()) {
	$sidebar .= '<blockquote style="padding:6px 12px; margin: 1ex 0;">' . elgg_echo('directory:instructions') . '</blockquote>';
	
	$sidebar .= '<p><a href="' . elgg_get_site_url() . 'directory/add/directory" class="elgg-button elgg-button-action">' . elgg_echo('directory:add:directory') . '</a></p>';
	$sidebar .= '<p><a href="' . elgg_get_site_url() . 'directory/add/person" class="elgg-button elgg-button-action">' . elgg_echo('directory:add:person') . '</a></p>';
	$sidebar .= '<p><a href="' . elgg_get_site_url() . 'directory/add/organisation" class="elgg-button elgg-button-action">' . elgg_echo('directory:add:organisation') . '</a></p>';
}

// Count total directories
if (in_array($subtype, array('all', 'directory'))) {
	$directory_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'directory', 'order_by' => 'time_created desc', 'count' => true));
	if ($directory_count > 0) $title .= " ($directory_count)";
	// Display directories
	if ($directory_count > 0) {
		$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'directory', 'order_by' => 'time_created desc', 'limit' => 10, 'list_class' => "elgg-list-directory"));
		//$content .= elgg_view('directory/listing');
	}
}

// Display organisations
if (in_array($subtype, array('all', 'organisation'))) {
	$organisation_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'organisation', 'order_by' => 'time_created desc', 'count' => true));
	if ($organisation_count > 0) {
		$content .= elgg_view_title(elgg_echo('directory:organisation'));
		$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'organisation', 'order_by' => 'time_created desc', 'limit' => 10, 'list_class' => "elgg-list-person"));
		//$content .= elgg_view('directory/listing');
	}
}


// Display persons
if (in_array($subtype, array('all', 'person'))) {
	$person_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'person', 'order_by' => 'time_created desc', 'count' => true));
	if ($person_count > 0) {
		$content .= elgg_view_title(elgg_echo('directory:person'));
		$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'person', 'order_by' => 'time_created desc', 'limit' => 10, 'list_class' => "elgg-list-person"));
		//$content .= elgg_view('directory/listing');
	}
}


// Render the page
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'class' => "directory-index"));
echo elgg_view_page($title, $body);


