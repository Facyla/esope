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

// Facyla : this tool is for admins but also webmasters and authors, so use custom access rights
// OK if custom rights match, or use default behaviour
if (!cmspage_is_editor()) { forward(); }

// The URL-friendly name of the page, can be automaticaaly generated using the full title
$pagetype = elgg_get_friendly_title(get_input('pagetype'));
if (!empty($pagetype)) {
	//system_message(elgg_echo('cmspages:notice:changedurl'));
	forward("cmspages/edit/$pagetype");
}

// Set owner to site, for all "global" cmspages
elgg_set_page_owner_guid(elgg_get_site_entity()->guid);
elgg_set_context('admin');
elgg_push_context('cmspages_admin');

// Build the page content
$content = '';

// Page title
$title = elgg_echo('cmspages');

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('admin'), 'admin');
elgg_push_breadcrumb(elgg_echo('cmspages'));

// Count Total pages
$cmspages_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'count' => true));
$title .= " ($cmspages_count)";

// MENU : cmspages selector
$content .= '<div class="clearfloat"></div>';
//$content .= elgg_echo('cmspages:pagescreated', array($cmspages_count));
//$content .= elgg_view('cmspages/menu', array('pagetype' => $pagetype));
$content .= '<blockquote style="padding:6px 12px; margin: 1ex 0;">
		<strong><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#cmspages_instructions\').toggle();">' . elgg_echo('cmspages:showinstructions') . '</a></strong>
		<div id="cmspages_instructions" class="elgg-output hidden">' . elgg_echo('cmspages:instructions') . '</div>
	</blockquote>';

$content .= elgg_view('cmspages/listing');

$content .= print_r(elgg_get_context_stack(),true);
//$page = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
$page = elgg_view_layout('admin', array('title' => $title, 'content' => $content));

echo elgg_view_page($title, $page);

