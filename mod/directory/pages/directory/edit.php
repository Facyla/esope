<?php
/**
* Elgg directory page - Displays directory content into site interface
* 
* @package Elggdirectory
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2015
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

gatekeeper();

$guid = get_input('guid', false);
$subtype = get_input('subtype', false);
if (empty($subtype) && !in_array($subtype, array('directory', 'person', 'organisation'))) {
	$subtype = 'directory';
}

// BREADCRUMBS - Add main directory breadcrumb
$title = elgg_echo($subtype);
elgg_push_breadcrumb($title, 'directory');

// Get directory by GUID or name
$object = get_entity($guid);
if (elgg_instanceof($object, 'object')) {
	$title = $object->title;
	elgg_push_breadcrumb($title, $object->getURL());
	$subtype = $object->getSubtype();
	$title = elgg_echo("directory:edit:$subtype");
	elgg_push_breadcrumb($title);
} else {
	$title = elgg_echo('directory:add');
	elgg_push_breadcrumb($title, 'directory');
	$title = elgg_echo("directory:add:$subtype");
	elgg_push_breadcrumb($title);
}

// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $title;

// Add embed support for Contacts
$item = ElggMenuItem::factory(array(
	'name' => 'directory',
	'text' => elgg_echo('directory'),
	'priority' => 10,
	'data' => array(
		'options' => array(
			'type' => 'object',
			//'subtype' => 'transitions',
		),
	),
));
elgg_register_menu_item('embed', $item);

$item = ElggMenuItem::factory(array(
	'name' => 'directory_search',
	'text' => elgg_echo('directory:upload'),
	'priority' => 100,
	'data' => array(
		'view' => 'embed/directory/content',
	),
));
elgg_register_menu_item('embed', $item);


$content .= elgg_view("forms/directory/edit_$subtype", array('entity' => $object));
//$content .= elgg_view_form('directory/edit', array('entity' => $object));


// Wrap into default, full-page layout
$content = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));


// Display page (using default pageshell)
echo elgg_view_page($title, $content);

