<?php
/**
* Elgg CMS page article page - Displays CMSPage in an convenient interface and URLs for a custom site interface
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
define('cmspage', true);
global $CONFIG;

$pagetype = get_input('pagetype', false);

if (!$pagetype) {
	register_error(elgg_echo('cmspages:notset'));
	forward();
}

// Get entity
$cmspage = cmspages_get_entity($pagetype);
// Display only valid pages - except for editors
if (!elgg_instanceof($cmspage, 'object', 'cmspage') && !cmspage_is_editor()) {
	register_error('cmspages:notset');
	forward();
}


// Get layout params
$layout = elgg_get_plugin_setting('layout', 'cmspages');
$pageshell = elgg_get_plugin_setting('pageshell', 'cmspages');

// Set outer title (page title)
$title = $pagetype;
if ($cmspage->pagetitle) { $title = $cmspage->pagetitle; }
$page_title = $CONFIG->sitename . ' (' . $CONFIG->url . ') - ' . $title;
$vars['title'] = $page_title;


/* BREADCRUMBS
 * Logic : 
 * - Articles : p/seo-friendly-article-title
 * - Categories : r/seo-friendly-category-title
 * - Tags : t/seo-friendly-tag
 */
//if (elgg_is_admin_logged_in()) {
if (cmspage_is_editor()) {
	elgg_push_breadcrumb(elgg_echo('cmspages'), 'cmspages');
}
elgg_push_breadcrumb($title);


// cmspages/read may render more content
$content = elgg_view('cmspages/read', array('pagetype' => $pagetype, 'entity' => $cmspage));
// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $page_title;


/*
// EMBED MODE - Determine pageshell depending on optional embed type
// Note : inner mode remains default embed mode for BC reasons, but embedding content should use full mode to render styles
$pageshell = 'default';
if ($embed) {
	// Inner mode : for use in Elgg (lightbox...)
	$pageshell = 'inner';
	// Full embed, for external use (so we need CSS as well then)
	if ($embed == 'full') { $pageshell = 'iframe'; }
	// Display page, using wanted pageshell
	echo elgg_view_page($title, $content, $pageshell);
	exit;
}
*/



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

$params = array('content' => $content, 'title' => false, 'header' => false, 'nav' => false, 'footer' => false, 'sidebar' => false, 'sidebar_alt' => false);
switch ($layout) {
	case 'custom':
		// Wrap into custom layout (apply only if exists)
		if (cmspages_exists('cms-layout')) {
			$content = elgg_view('cmspages/view', array('pagetype' => 'cms-layout', 'body' => $content));
		}
		break;
	
	case 'two_sidebar':
		$params['sidebar_alt'] = elgg_view('cmspages/view', array('pagetype' => 'cms-layout-sidebar-alt'));
	case 'one_sidebar':
		$params['sidebar'] = elgg_view('cmspages/view', array('pagetype' => 'cms-layout-sidebar'));
	case 'one_column':
		$content = elgg_view_layout($layout, $params);
		break;
	
	default:
		$content = elgg_view_layout('one_column', $params);
}


switch ($pageshell) {
	case 'custom':
		// @TODO wrap into custom pageshell
		// @TODO wrap into custom layout (apply only if exists)
		if (cmspages_exists('cms-pageshell')) {
			$content = elgg_view('cmspages/view', array('pagetype' => 'cms-pageshell', 'body' => $content));
		}
		$pageshell = 'inner';
		break;
	
	default:
}


// Display page (using default pageshell)
echo elgg_view_page($title, $content, $pageshell);


