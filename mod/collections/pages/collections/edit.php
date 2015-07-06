<?php
/**
* Elgg collection page - Displays collection content into site interface
* 
* @package Elggcollection
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

gatekeeper();

$guid = get_input('guid', false);

// BREADCRUMBS - Add main collection breadcrumb
$page_title = elgg_echo('collection');
elgg_push_breadcrumb($page_title, 'collection');

// collection/read may render more content
$collection = get_entity($guid);
if (elgg_instanceof($collection, 'object', 'collection')) {
	$page_title = $collection->title;
	elgg_push_breadcrumb($page_title);
} else {
	$page_title = elgg_echo('collection:add');
	elgg_push_breadcrumb($page_title);
}

// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $page_title;

$content .= elgg_view('forms/collection/edit', array('entity' => $collection));


// Wrap into default, full-page layout
$content = elgg_view_layout('one_column', array('content' => $content));


// Display page (using default pageshell)
echo elgg_view_page($title, $content);

