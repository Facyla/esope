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

$pagetype = elgg_get_friendly_title(get_input('pagetype')); // the pagetype e.g about, terms, etc. - default to "mainpage"

$content = '';
$sidebar = '';
$cmspage_infos = '';

// Check wether we can display an editing form or not
$display_form = true;
// Empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
if (empty($pagetype) || (strlen($pagetype) < 1)) {
	register_error(elgg_echo('cmspages:unsettooshort'));
	$display_form = false;
}


// Build the page content
$title = elgg_echo('cmspages');
//elgg_set_page_owner_guid($_SESSION['guid']); // Set admin user for owner block
elgg_set_page_owner_guid($CONFIG->site->guid);

// Total pages
$cmspages_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'count' => true));
$title .= ' ~ ' . elgg_echo('cmspages:pagescreated', array($cmspages_count));


// Get current page, if it exists
if ($display_form) { $cmspage = cmspages_get_entity($pagetype); }

if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
	// Useful infos
	if (empty($cmspage->pagetitle)) $cmspage_details = ''; else $cmspage_details = $cmspage->pagetitle . ', ';
	$cmspage_details .= $cmspage->content_type . ', access = ' . $cmspage->access_id;
	if (!empty($cmspage->display)) $cmspage_details .= ', display = ' . $cmspage->display;
	$cmspage_title = $pagetype . ' (' . $cmspage_details . ')'; // Use var because it's reused
	if ($new_page) {
		$cmspage_title = ($tooshort) ? elgg_echo('cmspages:createmenu', array($pagetype)) : elgg_echo('cmspages:newpage', array($pagetype));
	}
	
	// Delete link
	$delete_link .= '<span style="float:right; font-weight:bold; color:red;" class="delete">';
	$delete_form_body = '<input type="hidden" name="cmspage_guid" value="' . $cmspage->guid . '" /><input type="submit" name="delete" value="' . elgg_echo('cmspages:delete') . '" onclick="javascript:return confirm(\'' . elgg_echo('cmspages:deletewarning') . '\');" style="border:0; font-weight:bold; color:red;" class="elgg-button delete" />';
	$delete_link .= '<div style="float:right;" id="delete_group_option">' . elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/delete", 'body' => $delete_form_body, 'style' => "background:transparent;")) . '</div>';
	$delete_link .= '</span>';
}



// Sidebar menu
$sidebar .= '<div class="clearfloat"></div>';
$sidebar .= elgg_view('cmspages/menu', array('pagetype' => $pagetype));
$sidebar .= $cmspage_infos;

// Edit page content
// Existing pages will use the entity - new ones the pagetype
if ($display_form) {
	$content .= $delete_link;
	$content .= '<h3>' . $cmspage_title . '</h3>';
	$content .= elgg_view('forms/cmspages/edit', array('pagetype' => $pagetype, 'entity' => $cmspage));
}


//$page = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $sidebar . $content));

echo elgg_view_page($title, $page);

