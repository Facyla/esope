<?php
/**
* Elgg slider page - Displays slider content into site interface
* 
* @package Elggslider
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

//gatekeeper();

$guid = get_input('guid', false);

// BREADCRUMBS - Add main slider breadcrumb
$page_title = elgg_echo('slider');
elgg_push_breadcrumb($page_title, 'slider');

// slider/read may render more content
$slider = get_entity($guid);
if (elgg_instanceof($slider, 'object', 'slider')) {
	$page_title = $slider->title;
	elgg_push_breadcrumb($page_title);
} else {
	$page_title = elgg_echo('slider:add');
	elgg_push_breadcrumb($page_title);
}

// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $page_title;

// slider/read may render more content
$content .= elgg_view('forms/slider/edit', array('entity' => $slider));


// Wrap into default, full-page layout
$content = elgg_view_layout('one_column', array('content' => $content));


// Display page (using default pageshell)
echo elgg_view_page($title, $content);

