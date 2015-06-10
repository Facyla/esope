<?php
/**
* Elgg CMS page read page - Displays CMSPage content into site interface
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

// Load Elgg engine
define('cmspage', true);
global $CONFIG;

//gatekeeper();

$pagetype = get_input('pagetype', false);
// Enables content embedding (as pure content, iframe, etc.)
$embed = get_input('embed', false);
// Enables admin links removal (page will look the same for regular readers and editors)
$noedit = get_input('noedit', false);

if (!$pagetype) {
	// $content = elgg_echo('cmspages:notset');
	register_error(elgg_echo('cmspages:notset'));
	forward();
}

// Get entity
$cmspage = cmspages_get_entity($pagetype);

// Set outer title (page title)
$title = $pagetype;
if ($cmspage->pagetitle) { $title = $cmspage->pagetitle; }
$page_title = $CONFIG->sitename . ' (' . $CONFIG->url . ') - ' . $title;
$vars['title'] = $page_title;


// Full page mode : read view
// Note : cmspages/view view should return description only (and other elements should be hidden), 
// as it's designed for inclusion into other views


// BREADCRUMBS - Make main cmspages breadcrumb clickable only if editor
//if (elgg_is_admin_logged_in()) {
if (cmspage_is_editor()) {
	elgg_push_breadcrumb(elgg_echo('cmspages'), 'cmspages');
} else {
	//elgg_push_breadcrumb(elgg_echo('cmspages'));
}
elgg_push_breadcrumb($title);


// Render cmspages/read content
$content = elgg_view('cmspages/read', array('pagetype' => $pagetype, 'entity' => $cmspage, 'embed' => $embed, 'noedit' => $noedit));
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
	exit;
}


// FULL PAGE MODE - use also layout

// LAYOUT - Render through the correct canvas area
// @TODO : in a CMS mode, we should be able to define the other layout areas (sidebar, sidebar2, etc.)
// So maybe use it mainly (only) for CMS page handler mode
/*
//$content = elgg_view('page/elements/wrapper', array('body' => $content));
$layout = 'one_column';
// Use optional external layout
if (!empty($cmspage->display)) {
	$layout = $cmspage->display;
	$params = array('content' => $content, 'title' => false, 'header' => false, 'nav' => false, 'footer' => false, 'sidebar' => false, 'sidebar_alt' => false);
	//if (!empty($sidebar)) $params['sidebar'] = $sidebar;
	//if (!empty($sidebar_alt)) $params['sidebar_alt'] = $sidebar;
	//if (!empty($footer)) $params['footer'] = $footer;
}
if (!empty($title)) $params['title'] = $title;
$content = elgg_view_layout($layout, $params);
*/

// Wrap into default, full-page layout
$content = elgg_view_layout('one_column', array('content' => $content));


// Display page (using default pageshell)
echo elgg_view_page($title, $content);


