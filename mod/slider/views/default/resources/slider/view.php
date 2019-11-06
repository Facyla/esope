<?php
/**
* Elgg slider page - Displays slider content into site interface
* 
* @package ElggSlider
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2019
* @link https://facyla.fr/
*/

// Allow public display ?  required for external embed
//gatekeeper();

$guid = get_input('guid', false);
$embed = get_input('embed', false);


// Full page mode : read view
// Note : slider/view view should return description only (and other elements should be hidden), 
// as it's designed for inclusion into other views

// BREADCRUMBS - Add main slider breadcrumb
elgg_push_breadcrumb(elgg_echo('slider'), 'slider');

// slider/read may render more content
$slider = get_entity($guid);
// Add support for unique identifiers
if (!$slider) $slider = slider_get_entity_by_name($guid);
if ($slider instanceof ElggSlider) {
	$content = elgg_view('slider/view', array('entity' => $slider));
	$page_title = $slider->title;
	elgg_push_breadcrumb($page_title);
}
// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $page_title;


// EMBED MODE - Determine pageshell depending on optional embed type
// Note : inner mode remains default embed mode for BC reasons, but embedding content should use full mode to render styles
if ($embed) {
	// Inner mode : for use in Elgg (lightbox...)
	$pageshell = 'inner';
	// Full embed, for external use (so we need CSS as well then)
	if ($embed == 'full') { $pageshell = 'iframe'; }
	// Display page, using wanted pageshell
	echo elgg_view_page($title, $content, $pageshell);
	return;
}


// Wrap into default, full-page layout
$content = elgg_view_layout('one_column', array('content' => $content));


// Display page (using default pageshell)
echo elgg_view_page($title, $content);

