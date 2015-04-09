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


$content = '';
$title = elgg_echo('cmspages:tags');

$tag = get_input('tag');
if (empty($tag)) { forward(); }
$title = $tag;
elgg_push_breadcrumb($title);

$tag_url = elgg_get_site_url() . 't/';

// Get rendering params
$embed = get_input('embed', false);
$layout = elgg_get_plugin_setting('layout', 'cmspages');
$pageshell = elgg_get_plugin_setting('pageshell', 'cmspages');


$cmspages = cmspages_get_pages_by_tag($tag);
foreach ($cmspages as $ent) {
	$content .= '<div class="cmspages-tag cmspages-tag-' . $tag . '">';
	$content .= '<h2><a href="' . $ent->getURL() . '">';
	if (!empty($ent->pagetitle)) $content .= $ent->pagetitle; else $content .= $ent->pagetype;
	$content .= '</a></h2>';
	$content .= elgg_view('cmspages/read', array('entity' => $ent));
	$content .= '</div>';
}



/*
// SET SEO META
if ($cmspage) {
	// Update page outer title
	if (!empty($cmspage->seo_title)) $title = $cmspage->seo_title;
	// Set META description
	if (!empty($cmspage->seo_description)) $vars['meta_description'] = strip_tags($cmspage->seo_description);
	// Set META keywords
	if (!empty($cmspage->tags)) {
		if ($is_array($cmspage->tags)) $vars['meta_keywords'] = implode(', ', $cmspage->tags);
		else $vars['meta_keywords'] = $cmspage->tags;
	}
	// Set robots information : index/noindex, follow,nofollow  => all / none
	if ($cmspage->seo_index == 'no') $robots = 'noindex,'; else $robots = 'index,';
	if ($cmspage->seo_follow == 'no') $robots .= 'nofollow'; else $robots .= 'index,';
	$vars['meta_robots'] = $robots;
	// Set canonical URL
	$vars['canonical_url'] = $cmspage->getURL();
}
*/



// EMBED MODE - Display earlier, without any wrapper.
// Determine pageshell depending on embed type
// Note : inner mode remains default embed mode for BC reasons, but embedding content should use full mode to render styles
if ($embed) {
	switch($embed) {
		// Full embed, for external use (so we need CSS as well then)
		case 'full':
			$pageshell = 'iframe';
			break;
		// Default and Inner mode : for use in Elgg (lightbox...)
		default:
		$pageshell = 'inner';
	}
	// Display page, using wanted pageshell
	echo elgg_view_page($title, $content, $pageshell, $vars);
	exit;
}



// FULL PAGE MODE - use also customisable layout and pageshell

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

$params = array('content' => $content, 'title' => $title);
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

// Wrap into custom pageshell (apply only if exists)
switch ($pageshell) {
	case 'custom':
		if (cmspages_exists('cms-pageshell')) {
			$content = elgg_view('cmspages/view', array('pagetype' => 'cms-pageshell', 'body' => $content));
		}
		$pageshell = 'inner';
		break;
	
	default:
		// Use wanted pageshell if exists
		if (empty($pageshell) || !elgg_view_exists($pageshell)) $pageshell = 'default';
}


// Display page (using default pageshell)
echo elgg_view_page($title, $content, $pageshell, $vars);


