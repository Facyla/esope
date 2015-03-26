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
$pagetype = elgg_get_friendly_title(get_input('pagetype'));
// Fallback on page title, if provided (new page)
$newpage_title = get_input('title');
if (empty($pagetype) && !empty($newpage_title)) { $pagetype = elgg_get_friendly_title($newpage_title); }

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
	$display = $cmspage->display; // Can it be displayed in its own page ? ('no' => no, empty or not set => default layout, other value => use custom layout $value)
	$template = $cmspage->template; // This page will use the custom cmspage template
	$css = $cmspage->css;
	$js = $cmspage->js;
} else {
	// New page : set only default access
	$title = $newpage_title; // Set it from pagetype only at creation, never later (would override title)
	$access = (defined("ACCESS_DEFAULT")) ? ACCESS_DEFAULT : ACCESS_PUBLIC;
	$newpage_notice = elgg_echo('cmspages:notice:newpage');
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
	} else {
		$(".cmspages-seo").show();
		//$(".cmspages-categories").show();
		$(".cmspages-featured-image").show();
	}
}
</script>';


// SIDEBAR : information and rendering tools

// Type de contenu : HTML ou module => définit les champs affichés
// This if for a closer integration with externalblog, as a generic edition tool
//$content_type_input = "Type de contenu : par défaut = HTML avec éditeur, rawhtml = HTML sans éditeur<br />" . elgg_view('input/text', array('name' => 'content_type', 'value' => $content_type)) . '<br />';
// elgg_view('input/dropdown', array('name' => 'content_type', 'value' => $content_type, 'options_values' => $content_type_opts)) . '</label></p>';
$type_content = elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:content_type:details'))) . '<p><label>' . elgg_echo('cmspages:content_type') . "&nbsp; ";
//$type_content .= '<select onchange="javascript:$(\'.cmspages-field\').hide(); $(\'.cmspages-field.cmspages-field-\'+this.value).show();" name="content_type">';
$type_content .= '<select onchange="javascript:cmspages_toggle_content_type(this.value);" name="content_type">';
foreach ($content_type_opts as $val => $text) {
	if ($val == $content_type) $type_content .= '<option value="' . $val . '" selected="selected">' . $text . '</option>';
	else $type_content .= '<option value="' . $val . '">' . $text . '</option>';
}
$type_content .= '</select></label></p>';
// @TODO ? When using templates, allow to define sub-categories : pageshells, wrappers (content templates), blocks (content using templates)


// Accès et visibilité
$pub_content = '<fieldset><legend>' . elgg_echo('cmspages:fieldset:publication') . '</legend>';
	// Accès à la page ou au module
	$pub_content .= '<p><label>' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $access, 'options' => $access_opt)) . '</label>';
	//if ($cmspage) $pub_content .= '<br />' . elgg_echo('cmspages:access:current') . ' : ' . elgg_view('output/access', array('entity' => $cmspage));
	$pub_content .= '</p>';
	
	// Protection par mot de passe
	$pub_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:password:details'))) . '<p><label>' . elgg_echo('cmspages:password') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'password', 'value' => $password)) . '</label></p>';
	
	// Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou tous si aucun filtre défini)
	$pub_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:contexts:details'))) . '<p><label>' . elgg_echo('cmspages:contexts') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'contexts', 'value' => $contexts)) . '</label></p>';
$pub_content .= '</fieldset>';


$cat_content = '<fieldset class="cmspages-categories"><legend>' . elgg_echo('cmspages:fieldset:categories') . '</legend>';
	// @TODO Categories should work like a custom menu - and may be edited by that tool
	//$cat_content .= '<p><label>' . elgg_echo('cmspages:categories') . ' ' . elgg_view('input/text', array('name' => 'categories', 'value' => $categories, 'style' => "width:70%;")) . '</label></p>';
	$cat_content .= '<p>' . elgg_view('input/cmspages_categories', array('name' => 'categories', 'value' => $categories, 'style' => "max-width:50%;")) . '</p>';
	// Tags
	$cat_content .= '<p><label>' . elgg_echo('tags') . ' ' . elgg_view('input/tags', array('name' => 'cmspage_tags', 'value' => $tags, 'style' => "width:70%;")) . '</label></p>';
$cat_content .= '</fieldset>';


// Options du rendu
$render_content = '<fieldset><legend>' . elgg_echo('cmspages:fieldset:rendering') . '</legend>';
	// Use custom template for rendering
	//$render_content .= '<p><label>' . elgg_echo('cmspages:template:use') . '</label> ' . elgg_view('input/text', array('name' => 'template', 'value' => $template, 'style' => "width:200px;")) . '<br /><em>' . elgg_echo('cmspages:template:details') . '</em></p>';
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:template:details'))) . '<p><label>' . elgg_echo('cmspages:template:use') . '&nbsp;:</label> ' . elgg_view('input/dropdown', array('name' => 'template', 'value' => $template, 'options_values' => cmspages_templates_opts())) . '</p>';
	
	// Affichage autonome et choix du layout personnalisé (si autonome)
	// Allow own page or not ('no' => no, empty or not set => default layout, other value => use display value as layout)
	//$render_content .= '<p><label>' . elgg_echo('cmspages:display') . '&nbsp;:</label> ' . elgg_view('input/text', array('name' => 'display', 'value' => $display, 'style' => "width:200px;")) . '<br /><em>' . elgg_echo('cmspages:display:details') . '</em></p>';
	$render_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:display:details'))) . '<p><label>' . elgg_echo('cmspages:display') . '&nbsp;:</label> ' . elgg_view('input/dropdown', array('name' => 'display', 'value' => $display, 'options_values' => cmspages_display_opts(), 'onchange' => "javascript:cmspages_toggle_display(this.value);")) . '</p>';
$render_content .= '</fieldset>';


// Featured image
// @TODO Images embeddding should work with site as owner (shared library)
// @TODO : create a site-wide image gallery ? or better : a wider access to published content + no-owner publication tool for admins
$image_content = '<fieldset class="cmspages-featured-image"><legend>' . elgg_echo('cmspages:featured_image') . '</legend>';
	// Featured image is linked to the cmspage entity
	$image_content .= '<p>';
	if (!empty($featured_image)) {
		$image_content .= elgg_view('output/url', array(
				'text' => elgg_echo('cmspages:featured_image:view'), 'href' => '#cmspage-featured-image',
				'class' => 'elgg-lightbox', 'style' => 'float:right;',
			));
		$image_content .= '<div class="hidden">' . elgg_view_module('aside', elgg_echo('cmspages:featured_image'), '<img src="' . elgg_get_site_url() . 'esope/download_entity_file/' . $cmspage->guid . '/featured_image" style="max-width:100%; max-height:100%; " />', array('id' => 'cmspage-featured-image')) . '</div>';
		//$image_content .= '<img src="' . elgg_get_site_url() . 'esope/download_entity_file/' . $cmspage->guid . '/featured_image" style="float:right; max-width:30%; max-height:100px; " />';
	}
	$image_content .= elgg_view('input/file', array('name' => 'featured_image', 'value' => $featured_image, 'style' => 'width:auto;')) . '</p>';
$image_content .= '</fieldset>';



// CORPS DU FORMULAIRE

// Display more infos and help on chosen content type
$help_content = '<div class="cmspages-types-tips elgg-output">';
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
$hide = ($content_type != 'module') ? '' : 'hidden';
$editor_content = '<div class="cmspages-field cmspages-field- cmspages-field-rawhtml cmspages-field-template ' . $hide . '">';
	// Contenu du bloc / de la page
	if (in_array($content_type, array('rawhtml'))) {
		$editor_content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:rawhtml') . "</label>" . elgg_view('input/plaintext', array('name' => 'cmspage_content', 'value' => $description));
	} else if ($content_type == 'template') {
		$editor_content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:template') . "</label>" . elgg_view('input/longtext', array('name' => 'cmspage_content', 'value' => $description, 'class' => 'elgg-input-rawtext'));
	} else {
		//$editor_content .= '<label for="cmspage_content">' . elgg_echo('cmspages:content:') . "</label>";
		$editor_content .= elgg_view('input/longtext', array('name' => 'cmspage_content', 'id' => 'cmspage_content', 'value' => $description));
	}
	// Templates utilisés par le contenu
	if ($content_type == 'template') { $editor_content .= elgg_echo('cmspages:templates:list') . '&nbsp;:<br />' . cmspages_list_subtemplates($cmspage->description); }
	$editor_content .= '<div class="clearfloat"></div><br />';
$editor_content .= '</div>';


// MODULE - Bloc conditionnel : seulement si module
$hide = ($content_type == 'module') ? '' : 'hidden';
$module_content = '<div class="cmspages-field cmspages-field-module ' . $hide . '">';
	// Load other content as a configurable module
	$module_content .= '<p><label>' . elgg_echo('cmspages:module') . '&nbsp; ' . elgg_view('input/dropdown', array('name' => 'module', 'value' => $module, 'options_values' => $module_opts)) . '</label></p>';
	// Infos
	$module_content .= '<p>' . elgg_echo('cmspages:module:infos') . '</p>';
	// Config du module
	$module_content .= '<p><label>' . elgg_echo('cmspages:module:config') . '<br />' . elgg_view('input/text', array('name' => 'module_config', 'value' => $module_config)) . '</label></p>';
$module_content .= '</div>';
$module_content .= '<br />';


// JS & CSS
$jscss_content = '<fieldset>';
	$jscss_content .= '<legend>' . elgg_echo('cmspages:fieldset:advanced') . '</legend>';
	// CSS
	$jscss_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:css:details'))) . '<p><label>' . elgg_echo('cmspages:css') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_css', 'value' => $css)) . '</label>' . '</p>';
	
	// JS
	$jscss_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:js:details'))) . '<p><label>' . elgg_echo('cmspages:js') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_js', 'value' => $js)) . '</label>' . '</p>';
$jscss_content .= '</fieldset>';
$jscss_content .= '<br />';


// SEO and METATAGS FIELDS
$seo_content = '<fieldset class="cmspages-seo">';
	$seo_content .= '<legend>' . elgg_echo('cmspages:fieldset:seo') . '</legend>';
	//$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:tags:details'))) . '<p><label>' . elgg_echo('cmspages:seo:tags') . '</label></p>';
	$seo_content .= '<p><strong>' . elgg_echo('cmspages:seo:tags') . '</strong> ' . elgg_echo('cmspages:seo:tags:details') . '</p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:title:details'))) . '<p><label>' . elgg_echo('cmspages:seo:title') . ' ' . elgg_view('input/text', array('name' => 'seo_title', 'value' => $cmspage->seo_title)) . '</label></p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:description:details'))) . '<p><label>' . elgg_echo('cmspages:seo:description') . ' ' . elgg_view('input/text', array('name' => 'seo_description', 'value' => $cmspage->seo_description)) . '</label></p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:index:details'))) . '<p><label>' . elgg_echo('cmspages:seo:index') . ' ' . elgg_view('input/dropdown', array('name' => 'seo_index', 'value' => $cmspage->seo_index, 'options_values' => $yesno_opts)) . '</label></p>';
	$seo_content .= elgg_view('output/cmspage_help', array('content' => elgg_echo('cmspages:seo:follow:details'))) . '<p><label>' . elgg_echo('cmspages:seo:follow') . ' ' . elgg_view('input/dropdown', array('name' => 'seo_follow', 'value' => $cmspage->seo_follow, 'options_values' => $yesno_opts)) . '</label></p>';
$seo_content .= '</fieldset>';


// EXPERIMENTAL FIELDS - NON UTILISE
$rel_content = '<fieldset ' . $hideifmodule . '>';
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

if ($cmspage) {
	// Informations utiles : URL de la page + vue à utiliser pour charger la page
	$info_content = '<fieldset><legend>' . elgg_echo('cmspages:fieldset:information') . '</legend>';
		$info_content .= '<p><strong>' . elgg_echo('cmspages:status') . '&nbsp;</strong>: ';
		if ($cmspage->access_id === 0) {
			$info_content .= '<span class="cmspages-unpublished">' . elgg_echo('cmspages:status:notpublished') . '</span>';
		} else {
			$info_content .= '<span class="cmspages-published">' . elgg_echo('cmspages:status:published') . '</span>';
		}
		$info_content .= '</span></p>';
		$info_content .= '<p><strong>' . elgg_echo('cmspages:access:current') . '&nbsp;:</strong> ' . elgg_view('output/access', array('entity' => $cmspage, 'hide_text' => true)) . $access_opt[$cmspage->access_id] . '</p>';
		$info_content .= '<p><strong>' . elgg_echo('cmspages:cmspage_url') . '&nbsp;:</strong> <code><a href="' . $cmspage->getURL() . '" target="_blank" >' . $cmspage->getURL() . '</a></code></p>';
		if (elgg_is_active_plugin('shorturls')) {
			$info_content .= '<p><strong>' . elgg_echo('cmspages:shorturl') . '&nbsp;:</strong> <code>' . elgg_get_site_url() . 's/' . $cmspage->guid . '</code></p>';
		}
		$info_content .= '<p><strong>' . elgg_echo('cmspages:cmspage_template') . '&nbsp;:</strong> <code>{{$pagetype}}</code>';
		$info_content .= '<p><strong>' . elgg_echo('cmspages:cmspage_embed') . '&nbsp;:</strong> <code>&lt;iframe src="' . $cmspage->getURL() . '?embed=full"&gt;&lt;/iframe&gt;</code>';
		$info_content .= '<p><strong>' . elgg_echo('cmspages:cmspage_view') . '&nbsp;:</strong> <code>echo elgg_view(\'cmspages/view\',array(\'pagetype\'=>"' . $pagetype . '"));</code>';
		$info_content .= '</p>';
	$info_content .= '</fieldset>';
	
	
	// Boutons de suppression et d'enregistrement
	// Delete link
	$delete_button = elgg_view('output/confirmlink', array(
			'href' => elgg_get_site_url() . 'action/cmspages/delete?guid=' . $cmspage->guid,
			'text' => '<i class="fa fa-trash"></i>' . elgg_echo('cmspages:delete'),
			//'title' => elgg_echo('cmspages:delete:details'),
			'class' => 'elgg-button elgg-button-delete',
			'confirm' => elgg_echo('cmspages:deletewarning'),
		));
	// Update submit link
	$submit_button = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:save')));
}



// COMPOSITION DU FORMULAIRE
$content = '';
$sidebar = '';

$sidebar .= $pub_content;
$sidebar .= $cat_content;
$sidebar .= $render_content;
$sidebar .= $image_content;
$sidebar .= $seo_content;

$content .= $js_content;
$content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $cmspage_guid));
$content .= '<span style="float:right;">' . $submit_button . '</span>';
$content .= $type_content;
$content .= $help_content;

// Titre de la page CMS
$content .= '<p><label>' . elgg_echo('title') . ' ' . elgg_view('input/text', array('name' => 'cmspage_title', 'value' => $title, 'style' => "width:500px;")) . '</label></p>';

// Nom du permalien de la page : non éditable (= identifiant de la page)
$content .= '<p><label for="pagetype">' . elgg_echo('cmspages:pagetype') . '</label> ' . elgg_get_site_url() . 'p/' . elgg_view('input/text', array('name' => 'pagetype', 'value' => $pagetype, 'style' => "width:40ex;")) . '</p>';

$content .= $editor_content;
$content .= $module_content;
$content .= $jscss_content;
$content .= $rel_content;
$content .= $delete_button;
$content .= $submit_button;



// Use a 2 column layout for better readability
$content = $info_content . '<div style="float:right; width:30%;">' . $sidebar . '</div><div style="float:left; width:66%;">' . $content . '</div><div class="clearfloat"></div>';

/* AFFICHAGE DU CONTENU DE LA PAGE */
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/edit", 'body' => $content, 'id' => "cmspages-edit-form", 'enctype' => 'multipart/form-data'));


