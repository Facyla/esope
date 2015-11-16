<?php
/**
* Elgg directory page - Displays directory content into site interface
* 
* @package ElggDirectory
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2015
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

// Allow public display ?  required for external embed
//gatekeeper();

$guid = get_input('guid', false);
$embed = get_input('embed', false);
$full_view = get_input('full_view', true);
$full_content = get_input('full_content', false);

// BREADCRUMBS - Add main directory breadcrumb
elgg_push_breadcrumb(elgg_echo('directory'), 'directory');

// Get directory by GUID or name
$object = get_entity($guid);
if (elgg_instanceof($object, 'object', 'directory') || elgg_instanceof($object, 'object', 'person') || elgg_instanceof($object, 'object', 'organisation')) {
	//$content = elgg_view('directory/view', array('entity' => $object, 'embed' => $embed));
	$content = elgg_view_entity($object, array('embed' => $embed, 'full_view' => $full_view, 'full_content' => $full_content));
	if ($object->canEdit()) {
		switch($subtype) {
			case 'person':
				break;
			case 'directory':
			case 'organisation':
			default:
				$content .= elgg_view_form('directory/add_entity', array(), array('entity' => $object));
		}
	}
	$title = $object->title;
	$subtype = $object->getSubtype();
	elgg_push_breadcrumb(elgg_echo("directory:$subtype"), "directory/$subtype");
	if (!empty($object->name)) {
		elgg_push_breadcrumb($object->name);
	} else {
		elgg_push_breadcrumb($object->title);
	}
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
$content = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'class' => "directory-view"));



// Display page (using default pageshell)
echo elgg_view_page($title, $content);


