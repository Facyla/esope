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

// Facyla : this tool is admins but also webmasters, so use custom access rights
// OK if custom rights match, or use default behaviour
if (in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) {
} else {
	admin_gatekeeper();
}

$pagetype = elgg_get_friendly_title(get_input('pagetype')); // the pagetype e.g about, terms, etc. - default to "mainpage"
$tooshort = (strlen($pagetype)<3) ? true : false;

$content = '';
$sidebar = '';
$cmspage_infos = '';

// Check wether we can display a form or not
$display_form = true;
// Empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
if (empty($pagetype)) { $display_form = false; }
if ($tooshort) {
	register_error(elgg_echo('cmspages:unsettooshort'));
	$display_form = false;
}
// Get current page, if it exists
if ($display_form) {
	$options = array('metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1);
	$cmspages = elgg_get_entities_from_metadata($options);
	// Page already exists : load data
	if ($cmspages) { $cmspage = $cmspages[0]; }
}


// Build the page content
$title = elgg_echo('cmspages');
//elgg_set_page_owner_guid($_SESSION['guid']); // Set admin user for owner block
elgg_set_page_owner_guid($CONFIG->site->guid);



if (elgg_instanceof($cmspage, 'object')) {
	
	// Useful infos
	if (empty($cmspage->pagetitle)) $cmspage_details = ''; else $cmspage_details = $cmspage->pagetitle . ', ';
	$cmspage_details .= $cmspage->content_type . ', access = ' . $cmspage->access_id;
	if (!empty($cmspage->display)) $cmspage_details .= ', display = ' . $cmspage->display;
	$cmspage_title = $pagetype . ' (' . $cmspage_details . ')'; // Use var because it's reused
	if ($new_page) {
		$cmspage_title = ($tooshort) ? elgg_echo('cmspages:createmenu', array($pagetype)) : elgg_echo('cmspages:newpage', array($pagetype));
	}


	
	// Informations utiles : URL de la page + vue à utiliser pour charger la page
	/*
	$cmspage_infos .= '<blockquote>' . elgg_echo('cmspages:cmspage_url') . ' <a href="' . $vars['url'] . 'cmspages/read/' . $pagetype . '" target="_new" >' . $vars['url'] . 'cmspages/read/' . $pagetype . '</a><br />';
	$cmspage_infos .= elgg_echo('cmspages:cmspage_view') . ' ' . elgg_view('input/text', array('value' => 'elgg_view(\'cmspages/view\',array(\'pagetype\'=>"' . $pagetype . '"))', 'disabled' => "disabled", 'style' => "width:70ex"));
	$cmspage_infos .= '</blockquote>';
	*/
	
	// Delete link
	$delete_link .= '<span style="float:right; font-weight:bold; color:red;" class="delete">';
	$delete_form_body = '<input type="hidden" name="cmspage_guid" value="' . $cmspage->guid . '" /><input type="submit" name="delete" value="' . elgg_echo('cmspages:delete') . '" onclick="javascript:return confirm(\'' . elgg_echo('cmspages:deletewarning') . '\');" style="border:0; font-weight:bold; color:red;" class="elgg-button delete" />';
	$delete_link .= '<div style="float:right;" id="delete_group_option">' . elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/delete", 'body' => $delete_form_body, 'js' => ' style="background:transparent;"')) . '</div>';
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
	$content .= '<h3><a href="' . $url . '">' . $cmspage_title . '</a></h3>';
	$content .= elgg_view('forms/cmspages/edit', array('pagetype' => $pagetype, 'entity' => $cmspage));
}



$params = array('title' => $title, 'content' => $content, 'sidebar' => $sidebar);

$page = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $page);

