<?php
/**
* Elgg CMS pages
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();
global $CONFIG;

// Facyla : this tool is for admins but also webmasters and authors, so use custom access rights
// OK if custom rights match, or use default behaviour
if (!cmspage_is_editor()) { forward(); }

// The URL-friendly name of the page, can be automaticaaly generated using the full title
$pagetype = elgg_get_friendly_title(get_input('pagetype'));

// Check wether we can display an editing form or not
$display_form = false;
if (!empty($pagetype) && (strlen($pagetype) > 0)) {
	$display_form = true;
	// Get current page, if it exists
	$cmspage = cmspages_get_entity($pagetype);
} else {
	// Empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
	register_error(elgg_echo('cmspages:unsettooshort'));
}

// Set owner to site, for all "global" cmspages
elgg_set_page_owner_guid($CONFIG->site->guid);
elgg_set_context('cmspages_admin');


// Build the page content
$content = '';
$menu = '';

// Page title
$title = elgg_echo('cmspages');

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('cmspages'), 'cmspages');
if ($cmspage) {
	if (!empty($cmspage->pagetitle)) {
		$title = elgg_echo('cmspages:edit:title', array($cmspage->pagetitle));
	} else {
		$title = elgg_echo('cmspages:edit:title', array($pagetype));
	}
	elgg_push_breadcrumb($title);
}

// Count Total pages
$cmspages_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'count' => true));

// MENU : cmspages selector
$menu .= '<div class="clearfloat"></div>';
$menu .= elgg_echo('cmspages:pagescreated', array($cmspages_count));
$menu .= elgg_view('cmspages/menu', array('pagetype' => $pagetype));


// Edit page content
// Existing pages will use the entity - new ones the pagetype
if ($display_form) {
	$content .= elgg_view('forms/cmspages/edit', array('pagetype' => $pagetype, 'entity' => $cmspage));
}


//$page = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $menu));
$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $menu . $content));

echo elgg_view_page($title, $page, 'cms_admin');

