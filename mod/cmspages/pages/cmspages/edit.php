<?php
/**
* Elgg CMS pages
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

gatekeeper();
$site = elgg_get_site_entity();

// Facyla : this tool is for admins but also webmasters and authors, so use custom access rights
// OK if custom rights match, or use default behaviour
if (!cmspage_is_editor()) { forward(); }

// The URL-friendly name of the page, can be automatically generated using the full title
$pagetype = elgg_get_friendly_title(get_input('pagetype'));
// Fallback on page title, if provided (new page)
$newpage_title = get_input('title');
if (empty($pagetype) && !empty($newpage_title)) { $pagetype = elgg_get_friendly_title($newpage_title); }
if (empty($newpage_title) && !empty($pagetype)) { $newpage_title = $pagetype; }

// Check wether we can display an editing form or not
if (empty($pagetype)) {
	// Empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
	register_error(elgg_echo('cmspages:unsettooshort'));
	//forward('cmspages');
}

// Get current page, if it exists
$cmspage = cmspages_get_entity($pagetype);

// Set owner to site, for all "global" cmspages
elgg_set_page_owner_guid($site->guid);
elgg_set_context('cmspages_admin');
elgg_push_context('admin');


// Build the page content
$content = '';

// Page title
$title = elgg_echo('cmspages');

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('admin'), 'admin');
elgg_push_breadcrumb(elgg_echo('cmspages'), 'cmspages');
if ($cmspage) {
	if (!empty($cmspage->pagetitle)) {
		$title = elgg_echo('cmspages:edit:title', array($cmspage->pagetitle));
	} else {
		$title = elgg_echo('cmspages:edit:title', array($pagetype));
	}
	elgg_push_breadcrumb($title);
} else if (!empty($newpage_title)) {
	elgg_push_breadcrumb(elgg_echo('cmspages:createmenu', $newpage_title));
}


// Edit page content
// Existing pages will use the entity - new ones the pagetype
$content .= elgg_view('forms/cmspages/edit', array('pagetype' => $pagetype, 'entity' => $cmspage));

$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));

//echo elgg_view_page($title, $page, 'cmspages');
echo elgg_view_page($title, $page, 'admin');


