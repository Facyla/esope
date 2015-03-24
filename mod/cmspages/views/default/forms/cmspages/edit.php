<?php
/**
 * Elgg cmspages edit form
 *
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2013
 * @link http://id.facyla.net/
 *
*/

$cmspage = $vars['entity']; // we can use directly the entity
// or get the page type - used as a user-friendly guid
// @TODO : this concept could be extend to provide custom URL for any given GUID...
$pagetype = elgg_get_friendly_title($vars['pagetype']);

// If entity not set, use the pagetype instead
if (!$cmspage && $pagetype) { $cmspage = cmspages_get_entity($pagetype); }
if (!$pagetype && $cmspage) { $pagetype = $cmspage->pagetype; }


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
if (empty($pagetype) || strlen($pagetype) < 1) {
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
	$contexts = $cmspage->contexts; // Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou all)
	$module = $cmspage->module; // Load other content : entity listing / search results / view
	$module_config = $cmspage->module_config; // Load other content : parameters
	if (!empty($module) && empty($module_config)) {
		$module_change = explode('?', $module);
		$module = $module_change[0];
		$module_config = $module_change[1];
	}
	$display = $cmspage->display; // Can it be displayed in its own page ? ('no' => no, empty or not set => default layout, other value => use custom layout $value)
	$template = $cmspage->template; // This page will use the custom cmspage template
	$css = $cmspage->css;
	$js = $cmspage->js;
} else {
	// New page : set only default access
	$access = (defined("ACCESS_DEFAULT")) ? ACCESS_DEFAULT : ACCESS_PUBLIC;
}



// COMPOSITION DU FORMULAIRE
$content = '';
$sidebar = '';


// SIDEBAR : information and rendering tools

// Type de contenu : HTML ou module => définit les champs affichés
// This if for a closer integration with externalblog, as a generic edition tool
//$content_type_input = "Type de contenu : par défaut = HTML avec éditeur, rawhtml = HTML sans éditeur<br />" . elgg_view('input/text', array('name' => 'content_type', 'value' => $content_type)) . '<br />';
// elgg_view('input/dropdown', array('name' => 'content_type', 'value' => $content_type, 'options_values' => $content_type_opts)) . '</label></p>';
$sidebar .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:content_type:details'))) . '<label>' . elgg_echo('cmspages:content_type') . "&nbsp; ";
$sidebar .= '<select onchange="javascript:$(\'.toggle_detail\').hide(); $(\'.toggle_detail.field_\'+this.value).show();" name="content_type">';
foreach ($content_type_opts as $val => $text) {
	if ($val == $content_type) $sidebar .= '<option value="' . $val . '" selected="selected">' . $text . '</option>';
	else $sidebar .= '<option value="' . $val . '">' . $text . '</option>';
}
$sidebar .= '</select></label></p>';

// @TODO ? When using templates, allow to define sub-categories : pageshells, wrappers (content templates), blocks (content using templates)
// More infos on chosen content type
if ($content_type == 'template') { $sidebar .= '<p>' . elgg_echo('cmspages:content_type:template:details') . '</p>'; }


// Accès et visibilité
$sidebar .= '<fieldset><legend>' . elgg_echo('cmspages:fieldset:publication') . '</legend>';
	// Accès à la page ou au module
	$sidebar .= '<p><label>' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $access, 'options' => $access_opt)) . '</label>';
	if ($cmspage) $sidebar .= '<br />' . elgg_echo('cmspages:access:current') . ' : ' . elgg_view('output/access', array('entity' => $cmspage));
	$sidebar .= '</p>';
	
	// Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou tous si aucun filtre défini)
	$sidebar .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:contexts:details'))) . '<label>' . elgg_echo('cmspages:contexts') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'contexts', 'value' => $contexts)) . '</label></p>';
	
	// Informations utiles : URL de la page + vue à utiliser pour charger la page
	if ($cmspage) {
		$sidebar .= '<p>' . elgg_echo('cmspages:cmspage_url') . '<br /><code><a href="' . $vars['url'] . 'cmspages/read/' . $pagetype . '" target="_blank" >' . $vars['url'] . 'cmspages/read/' . $pagetype . '</a></code></p>';
		$sidebar .= '<p>' . elgg_echo('cmspages:cmspage_view') . '<br /><code>echo elgg_view(\'cmspages/view\',array(\'pagetype\'=>"' . $pagetype . '"));</code>';
		$sidebar .= '</p>';
		if (elgg_is_active_plugin('shorturls')) {
			$sidebar .= '<p>' . elgg_echo('cmspages:shorturl') . ' ' . elgg_get_site_url() . 's/' . $cmspage->guid . '</p>';
		}
	}
	
$sidebar .= '</fieldset>';


$sidebar .= '<fieldset><legend>' . elgg_echo('cmspages:fieldset:categories') . '</legend>';
	// @TODO Categories should work like a custom menu - and may be edited by that tool
	$sidebar .= '<p><label>' . elgg_echo('cmspages:categories') . ' ' . elgg_view('input/text', array('name' => 'categories', 'value' => $categories, 'style' => "width:70%;")) . '</label></p>';
	// @TODO Images embeddding should work with site as owner (shared library)
	
	// Tags
	$sidebar .= '<p><label>' . elgg_echo('tags') . ' ' . elgg_view('input/tags', array('name' => 'cmspage_tags', 'value' => $tags, 'style' => "width:70%;")) . '</label></p>';
$sidebar .= '</fieldset>';


// Options du rendu
$sidebar .= '<fieldset><legend>' . elgg_echo('cmspages:fieldset:rendering') . '</legend>';
	// Use custom template for rendering
	//$content .= '<p><label>' . elgg_echo('cmspages:template:use') . '</label> ' . elgg_view('input/text', array('name' => 'template', 'value' => $template, 'style' => "width:200px;")) . '<br /><em>' . elgg_echo('cmspages:template:details') . '</em></p>';
	$sidebar .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:template:details'))) . '<label>' . elgg_echo('cmspages:template:use') . '&nbsp;:</label> ' . elgg_view('input/dropdown', array('name' => 'template', 'value' => $display, 'options_values' => cmspages_templates_opts())) . '</p>';
	
	// Affichage autonome et choix du layout personnalisé (si autonome)
	// Allow own page or not ('no' => no, empty or not set => default layout, other value => use display value as layout)
	//$content .= '<p><label>' . elgg_echo('cmspages:display') . '&nbsp;:</label> ' . elgg_view('input/text', array('name' => 'display', 'value' => $display, 'style' => "width:200px;")) . '<br /><em>' . elgg_echo('cmspages:display:details') . '</em></p>';
	$sidebar .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:display:details'))) . '<label>' . elgg_echo('cmspages:display') . '&nbsp;:</label> ' . elgg_view('input/dropdown', array('name' => 'display', 'value' => $display, 'options_values' => cmspages_display_opts())) . '</p>';
$sidebar .= '</fieldset>';


// Featured image
// @TODO : create a site-wide image gallery ? or better : a wider access to published content + no-owner publication tool for admins
$sidebar .= '<fieldset><legend>' . elgg_echo('cmspages:featured_image') . '</legend>';
	// Featured image is linked to the cmspage entity
	$sidebar .= '<p>';
	if (!empty($featured_image)) {
		$sidebar .= elgg_view('output/url', array(
				'text' => elgg_echo('cmspages:featured_image:view'), 'href' => '#cmspage-featured-image',
				'class' => 'elgg-lightbox', 'style' => 'float:right;',
			));
		$sidebar .= '<div class="hidden">' . elgg_view_module('aside', elgg_echo('cmspages:featured_image'), '<img src="' . elgg_get_site_url() . 'esope/download_entity_file/' . $cmspage->guid . '/featured_image" style="max-width:100%; max-height:100%; " />', array('id' => 'cmspage-featured-image')) . '</div>';
		//$sidebar .= '<img src="' . elgg_get_site_url() . 'esope/download_entity_file/' . $cmspage->guid . '/featured_image" style="float:right; max-width:30%; max-height:100px; " />';
	}
	$sidebar .= elgg_view('input/file', array('name' => 'featured_image', 'value' => $featured_image, 'style' => 'width:auto;')) . '</p>';
$sidebar .= '</fieldset>';





// CORPS DU FORMULAIRE
// GUID - We don't really care (not used)
$content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $cmspage_guid));

//$content .= '<fieldset>';
//	$content .= '<legend>' . elgg_echo('cmspages:fieldset:main') . '</legend>';


// Titre de la page
$content .= '<p><label>' . elgg_echo('title') . ' ' . elgg_view('input/text', array('name' => 'cmspage_title', 'value' => $title, 'style' => "width:500px;")) . '</label></p>';

// Nom du permalien de la page : non éditable (= identifiant de la page)
$content .= '<p><label for="pagetype">' . elgg_echo('cmspages:pagetype') . '</label> ' . elgg_get_site_url() . 'p/' . elgg_view('input/text', array('name' => 'pagetype', 'value' => $pagetype, 'style' => "width:40ex;")) . '</p>';


// Blocs conditionnels : masqué si module, affiché si HTML ou template
$hideifmodule = '';
if ($content_type == 'module') { $hideifmodule = 'style="display:none;" '; }
$hideifnotmodule = '';
if ($content_type != 'module') { $hideifnotmodule = 'style="display:none;" '; }

// Bloc conditionnel : tout sauf module
$content .= '<div ' . $hideifmodule . 'class="toggle_detail field_ field_rawhtml field_template">';

	// Contenu du bloc / de la page
	if (in_array($content_type, array('rawhtml'))) {
		$content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:rawhtml') . "</label>" . elgg_view('input/plaintext', array('name' => 'cmspage_content', 'value' => $description));
	} else if ($content_type == 'template') {
		$content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:template') . "</label>" . elgg_view('input/longtext', array('name' => 'cmspage_content', 'value' => $description, 'class' => 'elgg-input-rawtext'));
	} else {
		//$content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:') . "</label>";
		$content .= elgg_view('input/longtext', array('name' => 'cmspage_content', 'id' => 'cmspage_content', 'value' => $description));
	}
	// Templates utilisés par le contenu
	if ($content_type == 'template') { $content .= elgg_echo('cmspages:templates:list') . '&nbsp;:<br />' . cmspages_list_subtemplates($cmspage->description); }
	$content .= '<div class="clearfloat"></div><br />';

$content .= '</div>';

// Bloc conditionnel : seulement si module
$content .= '<div ' . $hideifnotmodule . 'class="toggle_detail field_module">';
	// Load other content as a configurable module
	$content .= '<p><label>' . elgg_echo('cmspages:module') . '&nbsp; ' . elgg_view('input/dropdown', array('name' => 'module', 'value' => $module, 'options_values' => $module_opts)) . '</label></p>';
	// Infos
	$content .= '<p>' . elgg_echo('cmspages:module:infos') . '</p>';
	// Config du module
	$content .= '<p><label>' . elgg_echo('cmspages:module:config') . '<br />' . elgg_view('input/text', array('name' => 'module_config', 'value' => $module_config)) . '</label></p>';
$content .= '</div>';

//$content .= '</fieldset><br />';
$content .= '<br />';


// JS & CSS
$content .= '<fieldset>';
	$content .= '<legend>' . elgg_echo('cmspages:fieldset:advanced') . '</legend>';
	// CSS
	$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:css:details'))) . '<label>' . elgg_echo('cmspages:css') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_css', 'value' => $css)) . '</label>' . '</p>';
	
	// JS
	$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:js:details'))) . '<label>' . elgg_echo('cmspages:js') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_js', 'value' => $js)) . '</label>' . '</p>';
$content .= '</fieldset><br />';
$content .= '<br />';



// SEO and METATAGS FIELDS
$content .= '<fieldset>';
	$content .= '<legend>' . elgg_echo('cmspages:fieldset:seo') . '</legend>';
	//$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:tags:details'))) . '<label>' . elgg_echo('cmspages:seo:tags') . '</label></p>';
	$content .= '<p><strong>' . elgg_echo('cmspages:seo:tags') . '</strong> ' . elgg_echo('cmspages:seo:tags:details') . '</p>';
	$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:title:details'))) . '<label>' . elgg_echo('cmspages:seo:title') . ' ' . elgg_view('input/text', array('name' => 'seo_title', 'value' => $cmspage->seo_title)) . '</label></p>';
	$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:description:details'))) . '<label>' . elgg_echo('cmspages:seo:description') . ' ' . elgg_view('input/text', array('name' => 'seo_description', 'value' => $cmspage->seo_description)) . '</label></p>';
	$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:index:details'))) . '<label>' . elgg_echo('cmspages:seo:index') . ' ' . elgg_view('input/dropdown', array('name' => 'seo_index', 'value' => $cmspage->seo_index, 'options_values' => $yesno_opts)) . '</label></p>';
	$content .= '<p>' . elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:follow:details'))) . '<label>' . elgg_echo('cmspages:seo:follow') . ' ' . elgg_view('input/dropdown', array('name' => 'seo_follow', 'value' => $cmspage->seo_follow, 'options_values' => $yesno_opts)) . '</label></p>';
$content .= '</fieldset><br />';



// EXPERIMENTAL FIELDS - NON UTILISE
$content .= '<fieldset ' . $hideifmodule . '>';
	$content .= '<legend>' . elgg_echo('cmspages:fieldset:unused') . '</legend>';
	
	// Bloc conditionnel : masqué si module, affiché si HTML ou template
	$content .= '<div ' . $hideifmodule . 'class="toggle_detail field_ field_rawhtml field_template">';
		$content .= '<div style="float:left; width:32%; margin-right:2%;">';
		$content .= '<p><label>' . elgg_echo('cmspages:container_guid') . ' ' . elgg_view('input/text', array('name' => 'container_guid', 'value' => $container_guid, 'style' => "width:10ex;")) . '</label></p>';
		$content .= '</div><div style="float:left; width:32%; margin-right:2%;">';
		$content .= '<p><label>' . elgg_echo('cmspages:parent_guid') . ' ' . elgg_view('input/text', array('name' => 'parent_guid', 'value' => $parent_guid, 'style' => "width:10ex;")) . '</label></p>';
		$content .= '</div><div style="float:right; width:32%;">';
		$content .= "<label>" . elgg_echo('cmspages:sibling_guid') . ' ' . elgg_view('input/text', array('name' => 'sibling_guid', 'value' => $sibling_guid, 'style' => "width:10ex;")) . '</label><br />';
		$content .= '</div>';
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';
	
	// @TODO : content embedding : embed any type of content into the page
	// @TODO : content linking : add relationships to any other entity types
	
$content .= '</fieldset><br />';



// Boutons de suppression et d'enregistrement
if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
	// Delete link
	$content .= elgg_view('output/confirmlink', array(
			'href' => elgg_get_site_url() . 'action/cmspages/delete?guid=' . $cmspage->guid,
			'text' => '<i class="fa fa-trash"></i>' . elgg_echo('cmspages:delete'),
			//'title' => elgg_echo('cmspages:delete:details'),
			'class' => 'elgg-button elgg-button-delete',
			'confirm' => elgg_echo('cmspages:deletewarning'),
		));
	
	$content .= elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:save')));
} else {
	$content .= elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:create')));
}



/* AFFICHAGE DU CONTENU DE LA PAGE */




// Use a 2 column layout for better readability
$content = '<div style="float:right; width:30%;">' . $sidebar . '</div><div style="float:left; width:66%;">' . $content . '</div><div class="clearfloat"></div>';

// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/edit", 'body' => $content, 'id' => "cmspages-edit-form", 'enctype' => 'multipart/form-data'));


