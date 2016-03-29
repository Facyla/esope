<?php
/**
 * Elgg cmspages edit form
 *
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 *
*/

$cmspage = elgg_extract('entity', $vars); // we can use directly the entity
// or get the page type - used as a user-friendly guid
// @TODO : this concept could be extend to provide custom URL for any given GUID...
$pagetype = elgg_get_friendly_title(get_input('pagetype'));
// Fallback on page title, if provided (new page)
$newpage_title = get_input('title');
if (empty($pagetype) && !empty($newpage_title)) { $pagetype = elgg_get_friendly_title($newpage_title); }

// If entity not set, use the pagetype instead
if (!$cmspage && $pagetype) { $cmspage = cmspages_get_entity($pagetype); }
if (!$pagetype && $cmspage) { $pagetype = $cmspage->pagetype; }



// Advanced editor mode by default for admins only
$advanced_mode = get_input('edit_mode', '');
if (!empty($advanced_mode)) {
	if ($advanced_mode == 'basic') $advanced_mode = false;
	else $advanced_mode = true;
} else {
	//$advanced_mode = elgg_is_admin_logged_in();
	$advanced_mode = false;
}


$edit_mode_toggle = '<p>' . elgg_echo('cmspages:edit_mode') . '&nbsp;: 
	<strong class="cmspages-mode-basic">' . elgg_echo('cmspages:edit_mode:basic') . '</strong>
	<a href="javascript:void(0);" onClick="javascript:cmspages_edit_mode(\'basic\');" class="cmspages-mode-full">' . elgg_echo('cmspages:edit_mode:basic') . '</a>
	 / 
	<strong class="cmspages-mode-full">' . elgg_echo('cmspages:edit_mode:full') . '</strong>
	<a href="javascript:void(0);" onClick="javascript:cmspages_edit_mode(\'full\')" class="cmspages-mode-basic">' . elgg_echo('cmspages:edit_mode:full') . '</a>
	</p>';


// Form selects options_values
$yesno_opts = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$module_opts = array(
	'' => elgg_echo('cmspages:module:'), 
	'title' => elgg_echo('cmspages:module:title'), 
	'listing' => elgg_echo('cmspages:module:listing'), 
	'search' => elgg_echo('cmspages:module:search'), 
	'entity' => elgg_echo('cmspages:module:entity'), 
	'view' => elgg_echo('cmspages:module:view')
);

$content_type_opts = array(
	'' => elgg_echo('cmspages:content_type:editor'), 
	'rawhtml' => elgg_echo('cmspages:content_type:rawhtml'), 
	'module' => elgg_echo('cmspages:content_type:module'), 
	'template' => elgg_echo('cmspages:content_type:template')
);

$access_opt = array(
	ACCESS_PUBLIC => elgg_echo('PUBLIC'), 
	ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'), 
	ACCESS_PRIVATE => elgg_echo('PRIVATE'), 
	//ACCESS_DEFAULT => elgg_echo('default_access:label'), //("accès par défaut")
);

// Empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
// No pagetype set => no form
if (empty($pagetype)) {
	// Too short pagetype : warn and do not display any form
	register_error(elgg_echo('cmspages:unsettooshort'));
	return;
}


// Page already exists : load data
if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
	$title = $cmspage->pagetitle;
	$description = $cmspage->description;
	$tags = $cmspage->tags;
	$cmspage_guid = $cmspage->guid;
	$access = $cmspage->access_id;
	// These are for future developments
	$container_guid = $cmspage->container_guid;
	$parent_guid = $cmspage->parent_guid;
	$sibling_guid = $cmspage->sibling_guid;
	$categories = $cmspage->categories;
	$featured_image = $cmspage->featured_image;
	//$slurl = $cmspage->slurl;
	// This if for a closer integration with externalblog, as a generic edition tool
	$content_type = $cmspage->content_type; // Default : use editor, rawhtml = no wysiwyg, module (php ?)
	$password = $cmspage->password; // Optional password-protection for page
	$contexts = $cmspage->contexts; // Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou all)
	$module = $cmspage->module; // Load other content : entity listing / search results / view
	$module_config = $cmspage->module_config; // Load other content : parameters
	if (!empty($module) && empty($module_config)) {
		$module_change = explode('?', $module);
		$module = $module_change[0];
		$module_config = $module_change[1];
	}
	$display = $cmspage->display; // Can it be displayed in its own page ? empty = all allowed, no = view only, noview = page only
	$template = $cmspage->template; // This page will use the custom cmspage template
	$layout = $cmspage->layout; // Use a custom layout ?
	$pageshell = $cmspage->pageshell; // Use a custom pageshell ?
	$header = $cmspage->header; // Use a custom header ?
	$menu = $cmspage->menu; // Use a custom menu ?
	$footer = $cmspage->footer; // Use a custom footer ?
	$css = $cmspage->css;
	$js = $cmspage->js;

	// Add current access level if it has been set to non-core levels
	if (!isset($access_opt[$access])) { $access_opt[$access] = get_readable_access_level($access); }
} else {
	// New page : set only default access
	$title = $newpage_title; // Set it from pagetype only at creation, never later (would override title)
	$access = (defined("ACCESS_DEFAULT")) ? ACCESS_DEFAULT : ACCESS_PUBLIC;
	$newpage_notice = elgg_echo('cmspages:notice:newpage');
	// Force full edit mode for new content
	$advanced_mode = true;
}



// DÉFINITIION DES BLOCS DU FORMULAIRES

// JS fields switch
$js_content = '<script>
function cmspages_toggle_content_type(val) {
	$(".cmspages-field").hide();
	if (val == "template") {
		$(".cmspages-field.cmspages-field-template").show();
	} else if (val == "module") {
		$(".cmspages-field.cmspages-field-module").show();
	} else if (val == "rawhtml") {
		$(".cmspages-field.cmspages-field-rawhtml").show();
	} else {
		$(".cmspages-field.cmspages-field-editor").show();
	}
		//$(".uhb_annonces-typework").removeClass(\'uhb_annonces-disabled\');
		//$("select[name=typework] option[value=\'\']").prop(\'selected\', true);
		//$("select[name=typework]").prop(\'disabled\', true);
	return true;
}

function cmspages_toggle_display(val) {
	if (val == "no") {
		$(".cmspages-seo").hide();
		//$(".cmspages-categories").hide();
		$(".cmspages-featured-image").hide();
		$(".cmspages-layout").hide();
		$(".cmspages-pageshell").hide();
		$(".cmspages-header").hide();
		$(".cmspages-menu").hide();
		$(".cmspages-footer").hide();
	} else {
		$(".cmspages-seo").show();
		//$(".cmspages-categories").show();
		$(".cmspages-featured-image").show();
		$(".cmspages-layout").show();
		$(".cmspages-pageshell").show();
		$(".cmspages-header").show();
		$(".cmspages-menu").show();
		$(".cmspages-footer").show();
	}
}

// Mode switch
function cmspages_edit_mode(mode) {
	if (mode == \'basic\') {
		$(".cmspages-mode-full").addClass(\'hidden\');
		$(".cmspages-mode-basic").removeClass(\'hidden\');
	} else if (mode == \'full\') {
		$(".cmspages-mode-full").removeClass(\'hidden\');
		$(".cmspages-mode-basic").addClass(\'hidden\');
	}
	$("input[name=edit_mode]").val(mode);
}
';
if (!$advanced_mode) {
	$js_content .= '
		$(document).ready(function() {
			cmspages_edit_mode(\'basic\');
		});
		';
} else {
	$js_content .= '
		$(document).ready(function() {
			cmspages_edit_mode(\'full\');
		});
		';
}
$js_content .= '</script>';


// SIDEBAR : information and rendering tools

// Type de contenu : HTML ou module => définit les champs affichés
// This if for a closer integration with externalblog, as a generic edition tool
//$content_type_input = "Type de contenu : par défaut = HTML avec éditeur, rawhtml = HTML sans éditeur<br />" . elgg_view('input/text', array('name' => 'content_type', 'value' => $content_type)) . '<br />';
// elgg_view('input/dropdown', array('name' => 'content_type', 'value' => $content_type, 'options_values' => $content_type_opts)) . '</label></p>';
$type_content = '<span class="cmspages-mode-full">' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:content_type:details'))) . '<p><label>' . elgg_echo('cmspages:content_type') . "&nbsp; ";
//$type_content .= '<select onchange="javascript:$(\'.cmspages-field\').hide(); $(\'.cmspages-field.cmspages-field-\'+this.value).show();" name="content_type">';
$type_content .= '<select onchange="javascript:cmspages_toggle_content_type(this.value);" name="content_type">';
foreach ($content_type_opts as $val => $text) {
	if ($val == $content_type) $type_content .= '<option value="' . $val . '" selected="selected">' . $text . '</option>';
	else $type_content .= '<option value="' . $val . '">' . $text . '</option>';
}
$type_content .= '</select></label></p></span>';
// @TODO ? When using templates, allow to define sub-categories : pageshells, wrappers (content templates), blocks (content using templates)


// Accès et visibilité
$pub_content = '<fieldset class="cmspages-mode-full"><legend>' . elgg_echo('cmspages:fieldset:publication') . '</legend>';
	// Accès à la page ou au module
	$pub_content .= '<p><label>' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $access, 'options_values' => $access_opt)) . '</label>';
	//if ($cmspage) $pub_content .= '<br />' . elgg_echo('cmspages:access:current') . ' : ' . elgg_view('output/access', array('entity' => $cmspage));
	$pub_content .= '</p>';
	
	// Protection par mot de passe
	$pub_content .= '<span class="cmspages-mode-full">' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:password:details'))) . '<p><label>' . elgg_echo('cmspages:password') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'password', 'value' => $password)) . '</label></p></span>';
	
	// Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou tous si aucun filtre défini)
	$pub_content .= '<span class="cmspages-mode-full">' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:contexts:details'))) . '<p><label>' . elgg_echo('cmspages:contexts') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'contexts', 'value' => $contexts)) . '</label></p>';
$pub_content .= '</fieldset></p>';


$cat_content = '<fieldset class="cmspages-categories cmspages-mode-full"><legend>' . elgg_echo('cmspages:fieldset:categories') . '</legend>';
	// Categories work like a custom menu + tags
	//$cat_content .= '<p><label>' . elgg_echo('cmspages:categories') . ' ' . elgg_view('input/text', array('name' => 'categories', 'value' => $categories, 'style' => "width:70%;")) . '</label></p>';
	$cat_content .= '<p>' . elgg_view('input/cmspages_categories', array('name' => 'categories', 'value' => $categories, 'style' => "max-width:50%;")) . '</p>';
	// Tags
	$cat_content .= '<p><label>' . elgg_echo('tags') . ' ' . elgg_view('input/tags', array('name' => 'cmspage_tags', 'value' => $tags, 'style' => "width:70%;")) . '</label></p>';
$cat_content .= '</fieldset>';


// Options du rendu
$render_content = '<fieldset class="cmspages-mode-full"><legend>' . elgg_echo('cmspages:fieldset:rendering') . '</legend>';
	// Use custom template for rendering
	//$render_content .= '<p><label>' . elgg_echo('cmspages:template:use') . '</label> ' . elgg_view('input/text', array('name' => 'template', 'value' => $template, 'style' => "width:200px;")) . '<br /><em>' . elgg_echo('cmspages:template:details') . '</em></p>';
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:template:details'))) . '<p><label>' . elgg_echo('cmspages:template:use') . ' ' . elgg_view('input/dropdown', array('name' => 'template', 'value' => $template, 'options_values' => cmspages_templates_opts())) . '</label>';
	if (!empty($template)) $render_content .= ' &nbsp; <a href="' . elgg_get_site_url() . 'cmspages/edit/' . $template . '" target="_blank">' . $template . '</a>';
	$render_content .= '</p>';
	
	// Affichage autonome
	// Allow own page or not ('no' => no, empty or not set => default, 'noview' => full page only
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:display:details'))) . '<p><label>' . elgg_echo('cmspages:display') . ' ' . elgg_view('input/dropdown', array('name' => 'display', 'value' => $display, 'options_values' => cmspages_display_opts(), 'onchange' => "javascript:cmspages_toggle_display(this.value);")) . '</label></p>';
	
	// Layout
	$hidden = ($display == 'no') ? 'hidden' : '';
	$render_content .= '<span class="cmspages-layout ' . $hidden . '">';
		$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:layout:details'))) . '<p><label>' . elgg_echo('cmspages:layout:use') . ' ' . elgg_view('input/dropdown', array('name' => 'layout', 'value' => $layout, 'options_values' => cmspages_layouts_opts())) . '</label></p>';
	$render_content .= '</span>';
	
	// Pageshell
	$hidden = ($display == 'no') ? 'hidden' : '';
	$render_content .= '<span class="cmspages-pageshell ' . $hidden . '">';
		$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:pageshell:details'))) . '<p><label>' . elgg_echo('cmspages:pageshell:use') . ' ' . elgg_view('input/dropdown', array('name' => 'pageshell', 'value' => $pageshell, 'options_values' => cmspages_pageshells_opts())) . '</label></p>';
	$render_content .= '</span>';
	
	// Header
	$hidden = ($display == 'no') ? 'hidden' : '';
	$render_content .= '<span class="cmspages-header ' . $hidden . '">';
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:cms_header:details'))) . '<p><label>' . elgg_echo('cmspages:settings:cms_header') . ' ' . elgg_view('input/dropdown', array('name' => 'header', 'value' => $header, 'options_values' => cmspages_headers_opts())) . '</label></p>';
	$render_content .= '</span>';
	
	// Menu CMS : categories ?  ou menu personnalisé
	$hidden = ($display == 'no') ? 'hidden' : '';
	$render_content .= '<span class="cmspages-menu ' . $hidden . '">';
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:cms_menu:details'))) . '<p><label>' . elgg_echo('cmspages:settings:cms_menu') . ' ' . elgg_view('input/dropdown', array('name' => 'menu', 'value' => $menu, 'options_values' => cmspages_menus_opts())) . '</label></p>';
	$render_content .= '</span>';
	
	// Footer
	$hidden = ($display == 'no') ? 'hidden' : '';
	$render_content .= '<span class="cmspages-footer ' . $hidden . '">';
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:cms_footer:details'))) . '<p><label>' . elgg_echo('cmspages:settings:cms_footer') . ' ' . elgg_view('input/dropdown', array('name' => 'footer', 'value' => $footer, 'options_values' => cmspages_footers_opts())) . '</label></p>';
	$render_content .= '</span>';
	
$render_content .= '</fieldset>';



// Featured image
// @TODO Images embeddding should work with site as owner (shared library) => that's another plugin ((shared_)image_gallery)
// @TODO : create a site-wide image gallery ? or better : a wider access to published content + no-owner publication tool for admins
$hidden = ($display == 'no') ? 'hidden' : '';
$image_content = '<fieldset class="cmspages-featured-image ' . $hidden . '"><legend>' . elgg_echo('cmspages:featured_image') . '</legend>';
	// Featured image is linked to the cmspage entity
	$image_content .= '<p>';
	if (!empty($featured_image)) {
		/*
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
		$image_content .= elgg_view('output/url', array(
				'text' => '<img src="' . elgg_get_site_url() . 'cmspages/file/' . $cmspage->guid . '/featured_image/medium" />', 
				'title' => elgg_echo('cmspages:featured_image:view'), 
				'href' => elgg_get_site_url() . 'cmspages/file/' . $cmspage->guid . '/featured_image/original',
				//'rel' => '#cmspage-featured-image',
				'class' => 'elgg-lightbox', 'style' => 'float:left; margin-right:1em;',
			));
		*/
		$image_content .= elgg_view('output/url', array(
				'text' => '<img src="' . elgg_get_site_url() . 'cmspages/file/' . $cmspage->guid . '/featured_image/medium" />', 
				'title' => elgg_echo('cmspages:featured_image:view'), 
				'href' => elgg_get_site_url() . 'cmspages/file/' . $cmspage->guid . '/featured_image/original',
				'style' => 'float:left; margin-right:1em;',
				'target' => "_blank",
			));
		// Remove featured image
		$image_content .= '<p>' . elgg_view("input/checkbox", array('name' => "remove_featured_image", 'value' => "yes")) . '</p>';
		$image_content .= elgg_echo("cmspages:featured_image:remove");
	}
	$image_content .= elgg_view('input/file', array('name' => 'featured_image')) . '</p>';
$image_content .= '</fieldset>';



// CORPS DU FORMULAIRE

// Display more infos and help on chosen content type
$help_content = '<div class="cmspages-types-tips elgg-output cmspages-mode-full">';
	$hide = ($content_type == 'template') ? '' : 'hidden';
	$help_content .= '<div class="cmspages-field cmspages-field-template ' . $hide . '" >' . elgg_echo('cmspages:content_type:template:details') . '</div>';

	$hide = ($content_type == 'module') ? '' : 'hidden';
	$help_content .= '<div class="cmspages-field cmspages-field-module ' . $hide . '" >' . elgg_echo('cmspages:content_type:module:details') . '</div>';

	$hide = ($content_type == 'rawhtml') ? '' : 'hidden';
	$help_content .= '<div class="cmspages-field cmspages-field-rawhtml ' . $hide . '" >' . elgg_echo('cmspages:content_type:rawhtml:details') . '</div>';

	$hide = (empty($content_type) || ($content_type == 'editor')) ? '' : 'hidden';
	$help_content .= '<div class="cmspages-field cmspages-field-editor ' . $hide . '" >' . elgg_echo('cmspages:content_type:editor:details') . '</div>';
$help_content .= '</div>';


// CONTENT EDITOR - Bloc conditionnel : tout sauf module
$editor_content = '<fieldset>';
	$editor_content .= '<legend>' . elgg_echo('cmspages:fieldset:editor') . '</legend>';
	$hide = ($content_type != 'module') ? '' : 'hidden';
	$editor_content .= '<div class="cmspages-field cmspages-field- cmspages-field-rawhtml cmspages-field-template ' . $hide . '">';
		// Contenu du bloc / de la page
		if (in_array($content_type, array('rawhtml'))) {
			$editor_content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:rawhtml') . "</label>" . elgg_view('input/plaintext', array('name' => 'cmspage_content', 'value' => $description));
		} else if ($content_type == 'template') {
			$editor_content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:template') . "</label>" . elgg_view('input/longtext', array('name' => 'cmspage_content', 'value' => $description, 'class' => 'elgg-input-rawtext'));
		} else {
			//$editor_content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:') . "</label>";
			$editor_content .= elgg_view('input/longtext', array('name' => 'cmspage_content', 'id' => 'cmspage_content', 'value' => $description));
		}
		// Page content history
		$editor_content .= cmspages_history_list($cmspage, 'description');
	
		// Templates utilisés par le contenu
		if ($content_type == 'template') { $editor_content .= elgg_echo('cmspages:templates:list') . '&nbsp;:<br />' . cmspages_list_subtemplates($cmspage->description); }
		$editor_content .= '<div class="clearfloat"></div><br />';
	$editor_content .= '</div>';
$editor_content .= '</fieldset>';


// MODULE - Bloc conditionnel : seulement si module
$hide = ($content_type == 'module') ? '' : 'hidden';
$module_content = '<div class="cmspages-field cmspages-field-module ' . $hide . '">';
	// Load other content as a configurable module
	$module_content .= '<p><label>' . elgg_echo('cmspages:module') . '&nbsp; ' . elgg_view('input/dropdown', array('name' => 'module', 'value' => $module, 'options_values' => $module_opts)) . '</label></p>';
	$module_content .= cmspages_history_list($cmspage, 'module');
	// Infos
	$module_content .= '<p>' . elgg_echo('cmspages:module:infos') . '</p>';
	// Config du module
	$module_content .= '<p><label>' . elgg_echo('cmspages:module:config') . '<br />' . elgg_view('input/text', array('name' => 'module_config', 'value' => $module_config)) . '</label></p>';
	$module_content .= cmspages_history_list($cmspage, 'module_config');
$module_content .= '</div>';
$module_content .= '<br />';


// JS & CSS
$jscss_content = '<fieldset class="cmspages-mode-full">';
	$jscss_content .= '<legend>' . elgg_echo('cmspages:fieldset:advanced') . '</legend>';
	// CSS
	$jscss_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:css:details'))) . '<p><label>' . elgg_echo('cmspages:css') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_css', 'value' => $css)) . '</label>' . '</p>';
	$jscss_content .= cmspages_history_list($cmspage, 'js');
	
	// JS
	$jscss_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:js:details'))) . '<p><label>' . elgg_echo('cmspages:js') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_js', 'value' => $js)) . '</label>' . '</p>';
	$jscss_content .= cmspages_history_list($cmspage, 'css');
$jscss_content .= '</fieldset>';
$jscss_content .= '<br />';


// SEO and METATAGS FIELDS
$hidden = ($display == 'no') ? 'hidden' : '';
$seo_content = '<fieldset class="cmspages-seo ' . $hidden . ' cmspages-mode-full">';
	$seo_content .= '<legend>' . elgg_echo('cmspages:fieldset:seo') . '</legend>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:title:details'))) . '<p><label>' . elgg_echo('cmspages:seo:title') . ' ' . elgg_view('input/text', array('name' => 'seo_title', 'value' => $cmspage->seo_title)) . '</label></p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:description:details'))) . '<p><label>' . elgg_echo('cmspages:seo:description') . ' ' . elgg_view('input/text', array('name' => 'seo_description', 'value' => $cmspage->seo_description)) . '</label></p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:tags:details'))) . '<p><label>' . elgg_echo('cmspages:seo:tags') . ' ' . elgg_view('input/tags', array('name' => 'seo_tags', 'value' => $cmspage->seo_tags)) . '</label></p>';
	//$seo_content .= '<p><strong>' . elgg_echo('cmspages:seo:tags') . '</strong> ' . elgg_echo('cmspages:seo:tags:details') . '</p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:index:details'))) . '<p><label>' . elgg_echo('cmspages:seo:index') . ' ' . elgg_view('input/dropdown', array('name' => 'seo_index', 'value' => $cmspage->seo_index, 'options_values' => $yesno_opts)) . '</label></p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:follow:details'))) . '<p><label>' . elgg_echo('cmspages:seo:follow') . ' ' . elgg_view('input/dropdown', array('name' => 'seo_follow', 'value' => $cmspage->seo_follow, 'options_values' => $yesno_opts)) . '</label></p>';
$seo_content .= '</fieldset>';


// EXPERIMENTAL FIELDS - NON UTILISE
$rel_content = '<fieldset ' . $hideifmodule . ' class="cmspages-mode-full">';
	$rel_content .= '<legend>' . elgg_echo('cmspages:fieldset:unused') . '</legend>';
	
	// Bloc conditionnel : masqué si module, affiché si HTML ou template
	$rel_content .= '<div ' . $hideifmodule . 'class="cmspages-field cmspages-field- cmspages-field-rawhtml cmspages-field-template">';
		$rel_content .= '<div style="float:left; width:32%; margin-right:2%;">';
		$rel_content .= '<p><label>' . elgg_echo('cmspages:container_guid') . ' ' . elgg_view('input/text', array('name' => 'container_guid', 'value' => $container_guid, 'style' => "width:10ex;")) . '</label></p>';
		$rel_content .= '</div><div style="float:left; width:32%; margin-right:2%;">';
		$rel_content .= '<p><label>' . elgg_echo('cmspages:parent_guid') . ' ' . elgg_view('input/text', array('name' => 'parent_guid', 'value' => $parent_guid, 'style' => "width:10ex;")) . '</label></p>';
		$rel_content .= '</div><div style="float:right; width:32%;">';
		$rel_content .= "<label>" . elgg_echo('cmspages:sibling_guid') . ' ' . elgg_view('input/text', array('name' => 'sibling_guid', 'value' => $sibling_guid, 'style' => "width:10ex;")) . '</label><br />';
		$rel_content .= '</div>';
	$rel_content .= '</div>';
	$rel_content .= '<div class="clearfloat"></div>';
	
	// @TODO : content embedding : embed any type of content into the page
	// @TODO : content linking : add relationships to any other entity types
	
$rel_content .= '</fieldset>';


// Submit button
$submit_button = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:create')));


// Informations utiles : URL de la page + vue à utiliser pour charger la page
if ($cmspage) {
	//$info_content = '<fieldset><legend>' . elgg_echo('cmspages:fieldset:information') . '</legend>';
	$info_content = '<blockquote style="padding: 6px 12px; margin-top:2ex;"><strong><a href="javascript:void(0);" onClick="javascript:$(\'#cmspages-information\').toggle()">' . elgg_echo('cmspages:fieldset:information') . '</a></strong>';
	$info_content .= '<div id="cmspages-information" class="elgg-output hidden">';
		$info_content .= '<ul>';
		$info_content .= '<li><strong>' . elgg_echo('cmspages:status') . '&nbsp;</strong>: ';
		if ($cmspage->access_id === 0) {
			$info_content .= '<span class="cmspages-unpublished">' . elgg_echo('cmspages:status:notpublished') . '</span>';
		} else {
			$info_content .= '<span class="cmspages-published">' . elgg_echo('cmspages:status:published') . '</span>';
		}
		$info_content .= '</span></li>';
		$info_content .= '<li><strong>' . elgg_echo('cmspages:access:current') . '&nbsp;:</strong> ' . elgg_view('output/access', array('entity' => $cmspage, 'hide_text' => true)) . $access_opt[$cmspage->access_id] . '</li>';
		$info_content .= '<li><strong>' . elgg_echo('cmspages:cmspage_url') . '&nbsp;:</strong> <code><a href="' . $cmspage->getURL() . '" target="_blank" >' . $cmspage->getURL() . '</a></code></li>';
		if (elgg_is_active_plugin('shorturls')) {
			$info_content .= '<li><strong>' . elgg_echo('cmspages:shorturl') . '&nbsp;:</strong> <code>' . elgg_get_site_url() . 's/' . $cmspage->guid . '</code></li>';
		}
		$info_content .= '<li><strong>' . elgg_echo('cmspages:cmspage_template') . '&nbsp;:</strong> <code>{{' . $pagetype . '}}</code></li>';
		$info_content .= '<li><strong>' . elgg_echo('cmspages:cmspage_embed') . '&nbsp;:</strong> <code>&lt;iframe src="' . $cmspage->getURL() . '?embed=full"&gt;&lt;/iframe&gt;</code></li>';
		$info_content .= '<li><strong>' . elgg_echo('cmspages:cmspage_view') . '&nbsp;:</strong> <code>echo elgg_view(\'cmspages/view\',array(\'pagetype\'=>"' . $pagetype . '"));</code>';
		$info_content .= '</li>';
		$info_content .= '</ul>';
	$info_content .= '</div>';
	$info_content .= '</blockquote>';
	$info_content .= '<div class="clearfloat"></div><br />';
	
	
	// Boutons de suppression et d'enregistrement
	// Delete link
	$delete_button = '<span class="cmspages-mode-full cmspages-delete">' . elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/cmspages/delete?guid=' . $cmspage->guid,
			'text' => '<i class="fa fa-trash"></i>&nbsp;' . elgg_echo('cmspages:delete'),
			//'title' => elgg_echo('cmspages:delete:details'),
			'class' => 'elgg-button elgg-button-action elgg-button-delete',
			'title' => '',
			'rel' => '',
			'style' => 'background-color:#A00;',
			'confirm' => elgg_echo('cmspages:deletewarning'),
		)) . '</span>';
	// Update submit link
	$submit_button = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:save')));
}



// COMPOSITION DU FORMULAIRE
$content = '';
$sidebar = '';

// Menu latéral
$sidebar .= $pub_content;
$sidebar .= $cat_content;
$sidebar .= $render_content;
$sidebar .= $image_content;
$sidebar .= $seo_content;

// Colonne principale
$content .= $js_content;
$content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $cmspage_guid));
$content .= elgg_view('input/hidden', array('name' => 'edit_mode', 'value' => "")) . '</p>';
$content .= $edit_mode_toggle;
$content .= '<span style="float:right;">' . $submit_button . '</span>';
$content .= '<div class="clearfloat"></div>';
$content .= $type_content;
$content .= $help_content;
// Titre de la page CMS
$content .= '<p class=""><label>' . elgg_echo('title') . ' ' . elgg_view('input/text', array('name' => 'cmspage_title', 'value' => $title, 'style' => "width:500px;")) . '</label></p>';
// Nom du permalien de la page : non éditable (= identifiant de la page)
$content .= '<p class="cmspages-mode-full"><label for="pagetype">' . elgg_echo('cmspages:pagetype') . '</label><br />' . elgg_get_site_url() . 'p/' . elgg_view('input/text', array('name' => 'pagetype', 'value' => $pagetype, 'style' => "width:40ex;")) . '</p>';
$content .= $editor_content;
$content .= $module_content;
$content .= $jscss_content;
$content .= $rel_content;


// Use a 2 column layout for better readability
$content = $info_content . '<div style="float:right; width:30%;">' . $sidebar . '</div><div style="float:left; width:66%;">' . $content . '</div><div class="clearfloat"></div>';

$content .= $delete_button;
$content .= $submit_button;

/* AFFICHAGE DU CONTENU DE LA PAGE */
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/cmspages/edit", 'body' => $content, 'id' => "cmspages-edit-form", 'enctype' => 'multipart/form-data'));


