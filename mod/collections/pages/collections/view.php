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

// Allow public display ?  required for external embed
//gatekeeper();

$guid = get_input('guid', false);
$embed = get_input('embed', false);


// BREADCRUMBS - Add main collection breadcrumb
elgg_push_breadcrumb(elgg_echo('collections'), 'collection');

// Get collection by GUID or name
$collection = get_entity($guid);
if (!elgg_instanceof($collection, 'object', 'collection')) { $collection = collections_get_entity_by_name($guid); }
if (elgg_instanceof($collection, 'object', 'collection')) {
	$content = elgg_view('collections/view', array('entity' => $collection, 'embed' => $embed));
	$title = $collection->title;
	elgg_push_breadcrumb($title);
}
// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $title;


// EMBED MODE - Determine pageshell depending on optional embed type
// Note : inner mode remains default embed mode for BC reasons, but embedding content should use full mode to render styles
if ($embed) {
	// Inner mode : for use in Elgg (lightbox...)
	$pageshell = 'inner';
	// Full embed, for external use (so we need CSS as well then)
	if ($embed == 'full') { $pageshell = 'iframe'; }
	// Display page, using wanted pageshell
	echo elgg_view_page($title, $content, $pageshell);
	exit;
}


// Wrap into default, full-page layout
$content = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'class' => "collections-view "));



// Display page (using default pageshell)
echo elgg_view_page($title, $content);


