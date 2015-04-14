<?php
/**
 * Elgg external pages: add/edit action
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Facyla : this tool is rather for local admins and webmasters than main admins, so we use also custom access rights
// OK if custom rights match, or use default behaviour
// Check if allowed user = admin or GUID in editors list
if (!cmspage_is_editor()) { forward(); }

$site_guid = elgg_get_site_entity()->guid;

// Cache to the session
elgg_make_sticky_form('cmspages');

/* Get input data */
$description = get_input('cmspage_content', '', false); // We do *not want to filter HTML
$cmspage_title = get_input('cmspage_title');
$pagetype = elgg_get_friendly_title(get_input('pagetype')); // Needs to be URL-friendly
// Empty or very short pagetypes are not allowed
if (empty($pagetype) || strlen($pagetype) < 3 ) {
	register_error(elgg_echo('cmspages:unsettooshort'));
	forward("cmspages");
}
$tags = get_input('cmspage_tags');
//$cmspage_guid = (int)get_input('cmspage_guid'); // not really used (pagetype are unique, as URL rely on them rather than GUID)
$access = get_input('access_id', ACCESS_DEFAULT);
$password = get_input('password');
// These are for future developments/features, such as page hierarchy, conditional display based on container
$container_guid = get_input('container_guid', $site_guid);
$parent_guid = get_input('parent_guid');
$sibling_guid = get_input('sibling_guid');
$categories = get_input('categories');
//$featured_image = get_input('featured_image');
$slurl = get_input('slurl');
// Externalblog/templating system integration
$content_type = get_input('content_type');
$contexts = get_input('contexts');
$module = get_input('module');
$module_config = get_input('module_config');
$display = get_input('display');
$template = get_input('template');
$layout = get_input('layout');
$pageshell = get_input('pageshell');
$header = get_input('header');
$menu = get_input('menu');
$footer = get_input('footer');
$page_css = get_input('page_css');
$page_js = get_input('page_js');
// SEO
$seo_title = get_input('seo_title');
$seo_tags = get_input('seo_tags');
$seo_description = get_input('seo_description');
$seo_index = get_input('seo_index');
$seo_follow = get_input('seo_follow');

// Cache to the session - @todo handle by sticky form
$_SESSION['cmspage_title'] = $cmspage_title;
$_SESSION['cmspage_content'] = $description;
$_SESSION['cmspage_pagetype'] = $pagetype;
$_SESSION['cmspage_tags'] = $tags;
$_SESSION['cmspage_access'] = $access;
$_SESSION['cmspage_container_guid'] = $container_guid;
$_SESSION['cmspage_parent_guid'] = $parent_guid;
$_SESSION['cmspage_sibling_guid'] = $sibling_guid;
$_SESSION['cmspage_categories'] = $categories;
//$_SESSION['cmspage_featured_image'] = $featured_image;
$_SESSION['cmspage_slurl'] = $slurl;
$_SESSION['cmspage_content_type'] = $content_type;
$_SESSION['cmspage_contexts'] = $contexts;
$_SESSION['cmspage_module'] = $module;
$_SESSION['cmspage_module_config'] = $module_config;
$_SESSION['cmspage_display'] = $display;
$_SESSION['cmspage_template'] = $template;
$_SESSION['cmspage_page_css'] = $page_css;
$_SESSION['cmspage_page_js'] = $page_js;

// Facyla 20110214 : following bypass is necessary when using Private access level, which causes objects not to be saved correctly (+doubles), depending on author
elgg_set_ignore_access(true);

// Get existing object corresponding to wanted pagetype
// Note : this may be another page, but pagetype selection is kept for BC reasons
$cmspage = NULL;
if (strlen($pagetype)>0) {
	$cmspage = cmspages_get_entity($pagetype);
}

// Also check entity through GUID, so we can update the pagetype
// This is used only to update pagetype
$guid = get_input('guid', false);
if ($guid) {
	// Get our original cmspage (the real one, for sure)
	$original_cmspage = get_entity($guid);
	// Applies only when the page already exists (from known guid)
	if (elgg_instanceof($original_cmspage, 'object', 'cmspage')) {
		// Check if pagetype has changed
		if ($original_cmspage->pagetype != $pagetype) {
			// Check if a page already exists with this pagetype
			// We can proceed if it does not exist
			if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
				// Page already exists
				// Cannot update, so revert to original pagetype
				register_error(elgg_echo('cmspages:alreadyexists', array($pagetype)));
				$pagetype = $original_cmspage->pagetype;
			}
		}
		// Always edit original page if it exists
		$cmspage = $original_cmspage;
	}
	
}


// Check existing object, or create a new one
if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
	// History
	// Keep some history from previous content and settings
	
	// Save previous description as an annotation
	if (!empty($cmspage->description) && ($cmspage->description != $description)) {
		$cmspage->annotate('history_description', $cmspage->description, 0);
	}
	// Save previous module config as an annotation
	if (($cmspage->module != $module) || ($cmspage->module_config != $module_config)) {
		$cmspage->annotate('history_module', $cmspage->module, 0);
		$cmspage->annotate('history_module_config', $cmspage->module_config, 0);
	}
	
	// Save previous css as an annotation
	if (!empty($cmspage->css) && ($cmspage->css != $page_css)) {
		$cmspage->annotate('history_css', $cmspage->css, 0);
	}
	// Save previous js as an annotation
	if (!empty($cmspage->js) && ($cmspage->js != $page_js)) {
		$cmspage->annotate('history_js', $cmspage->js, 0);
	}
	
	
} else {
	$cmspage = new CMSPage();
	$cmspage->owner_guid = $site_guid; // Set owner to the current site (nothing personal, hey !)
	$cmspage->pagetype = $pagetype;
	$cmspage->save();
}


// Edition de l'objet existant ou nouvellement créé
$cmspage->pagetype = $pagetype; // Allow to update pagetype
$cmspage->pagetitle = $cmspage_title;
$cmspage->description = $description;
$cmspage->access_id = $access;
$cmspage->password = $password;
// Modules & templates integration
$cmspage->content_type = $content_type;
$cmspage->module = $module;
$cmspage->module_config = $module_config;
$tagarray = string_to_tag_array($tags); // Convert string of tags into a preformatted array
$cmspage->tags = $tagarray;
$cmspage->contexts = $contexts;
$cmspage->display = $display;
$cmspage->template = $template;
$cmspage->layout = $layout;
$cmspage->pageshell = $pageshell;
$cmspage->header = $header;
$cmspage->menu = $menu;
$cmspage->footer = $footer;
$cmspage->css = $page_css;
$cmspage->js = $page_js;
// @todo unused yet
$cmspage->owner_guid = $site_guid; // Set owner to the current site (nothing personal, hey !)
$cmspage->container_guid = $container_guid;
$cmspage->parent_guid = $parent_guid;
$cmspage->sibling_guid = $sibling_guid;
//$categories = string_to_tag_array($categories);
$cmspage->categories = $categories;
// Function will add the filename if upload is OK
if (esope_add_file_to_entity($cmspage, 'featured_image')) {} else {}
$cmspage->seo_title = $seo_title;
$cmspage->seo_tags = $seo_tags;
$cmspage->seo_description = $seo_description;
$cmspage->seo_index = $seo_index;
$cmspage->seo_follow = $seo_follow;


// Save new/updated content
if ($cmspage->save()) {
	system_message(elgg_echo("cmspages:posted")); // Success message
	/*
	if ($new) add_to_river('river/cmspages/create','create',$_SESSION['user']->guid, $cmspages->guid); // add to river - not really useful here, but who knows..
	else add_to_river('river/cmspages/update','update',$_SESSION['user']->guid, $cmspages->guid); // add to river - not really useful here, but who knows..
	*/
	elgg_clear_sticky_form('cmspages'); // Remove the cache
	unset($_SESSION['cmspage_content']); unset($_SESSION['cmspage_title']); unset($_SESSION['cmspage_pagetype']); unset($_SESSION['cmspage_tags']); unset($_SESSION['cmspage_access']); unset($_SESSION['cmspage_container_guid']); unset($_SESSION['cmspage_$parent_guid']); unset($_SESSION['cmspage_sibling_guid']); unset($_SESSION['cmspage_categories']); unset($_SESSION['cmspage_slurl']); unset($_SESSION['cmspage_featured_image']); unset($_SESSION['cmspage_content_type']); unset($_SESSION['cmspage_contexts']); unset($_SESSION['cmspage_module']); unset($_SESSION['cmspage_module_config']); unset($_SESSION['cmspage_display']); unset($_SESSION['cmspage_template']); unset($_SESSION['cmspage_page_css']); unset($_SESSION['cmspage_page_js']);
} else {
	register_error(elgg_echo("cmspages:error") . elgg_get_logged_in_user_guid() . '=> ' . elgg_get_plugin_setting('editors', 'cmspages'));
	
}

elgg_set_ignore_access(false);

// Forward back to the page
forward("cmspages/edit/$pagetype");

