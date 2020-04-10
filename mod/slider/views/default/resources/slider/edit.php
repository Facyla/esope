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

elgg_gatekeeper();

// Allow access to members ? or admins only..
$slider_access = elgg_get_plugin_setting('slider_access', 'slider');
if ($slider_access != 'yes') { admin_gatekeeper(); }

$guid = get_input('guid', false);

// BREADCRUMBS - Add main slider breadcrumb
$page_title = elgg_echo('slider');
elgg_push_breadcrumb($page_title, 'slider');

// slider/read may render more content
// Add support for unique identifiers
$slider = slider_get_entity_by_name($guid);
if ($slider instanceof ElggSlider) {
	$page_title = $slider->title;
	elgg_push_breadcrumb($page_title);
} else {
	$page_title = elgg_echo('slider:add');
	elgg_push_breadcrumb($page_title);
}

// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
//$CONFIG->title = $page_title;

// slider/read may render more content
if (!$slider || (($slider instanceof ElggSlider) && $slider->canEdit())) {
	$content .= elgg_view('forms/slider/edit', array('entity' => $slider));
	$content .= elgg_view('forms/slider/clone', array('entity' => $slider));
}


// Wrap into default, full-page layout
$content = elgg_view_layout('default', array('content' => $content));


// Display page (using default pageshell)
echo elgg_view_page($title, $content);

