<?php
/**
* Elgg Collections
* 
* @package Elggcollection
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

//gatekeeper();

// Build the page content
$content = '';
$sidebar = '';

// Page title
$title = elgg_echo('collections');

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('collections'));

elgg_register_title_button();

elgg_push_context('listing');
elgg_push_context('collections');


// Count Total pages
$collection_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'collection', 'order_by' => 'time_created desc', 'count' => true));
if ($collection_count > 0) $title .= " ($collection_count)";

if (elgg_is_logged_in()) {
	//$sidebar .= '<p><a href="' . elgg_get_site_url() . 'collection/edit" class="elgg-button elgg-button-action">' . elgg_echo('collections:add') . '</a></p>';

	$sidebar .= '<blockquote style="padding:6px 12px; margin: 1ex 0;">' . elgg_echo('collections:instructions') . '</blockquote>';
}

// Display collections
if ($collection_count > 0) {
	$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'collection', 'order_by' => 'time_created desc', 'limit' => 10, 'list_class' => "elgg-list-collections"));
	//$content .= elgg_view('collection/listing');
}

//$page = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
/*
if (elgg_is_logged_in()) {
	$page = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
} else {
	$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));
}
*/
$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'class' => "collections-index"));

echo elgg_view_page($title, $page);

