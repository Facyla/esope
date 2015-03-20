<?php
/**
 * Elgg cmspages edit
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


// Form selects options_values
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

$display_form = true;

// Empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
// No pagetype set => no form
if (empty($pagetype)) {
	$display_form = false;
}
if (strlen($pagetype) < 3) {
	// Too short pagetype : warn and do not display any form
	register_error(elgg_echo('cmspages:unsettooshort'));
	$display_form = false;
}

if ($display_form) {
	
	// If entity not set, use the pagetype instead
	if (!elgg_instanceof($cmspage, 'object', 'cmspage')) {
		$options = array('metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1);
		$cmspages = elgg_get_entities_from_metadata($options);
		$cmspage = $cmspages[0];
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
	$form_body = '';
	
	// PRINCIPAUX PARAMETRES
	//$form_body .= '<fieldset>';
	//	$form_body .= '<legend>' . elgg_echo('cmspages:fieldset:main') . '</legend>';
	
		// Nom de la page : non éditable (= identifiant de la page)
		$form_body .= '<p><label>' . elgg_echo('cmspages:pagetype') . ' ' . elgg_view('input/text', array('value' => $pagetype, 'readonly' => "readonly", 'style' => "width:40ex;")) . '</label>' . elgg_view('input/hidden', array('name' => 'pagetype', 'value' => $pagetype)) . '</label>';
		$form_body .= '</p>';
	
		// Type de contenu : HTML ou module => définit les champs affichés
		// This if for a closer integration with externalblog, as a generic edition tool
		//$content_type_input = "Type de contenu : par défaut = HTML avec éditeur, rawhtml = HTML sans éditeur<br />" . elgg_view('input/text', array('name' => 'content_type', 'value' => $content_type)) . '<br />';
		// elgg_view('input/dropdown', array('name' => 'content_type', 'value' => $content_type, 'options_values' => $content_type_opts)) . '</label></p>';
		$form_body .= "<p><label>" . elgg_echo('cmspages:content_type') . "&nbsp; ";
		$form_body .= '<select onchange="javascript:$(\'.toggle_detail\').hide(); $(\'.toggle_detail.field_\'+this.value).show();" name="content_type">';
		foreach ($content_type_opts as $val => $text) {
			if ($val == $content_type) $form_body .= '<option value="' . $val . '" selected="selected">' . $text . '</option>';
			else $form_body .= '<option value="' . $val . '">' . $text . '</option>';
		}
		$form_body .= '</select></label></p>';
	
		// More infos on chosen content type
		if ($content_type == 'template') {
			$form_body .= '<p>' . elgg_echo('cmspages:content_type:template:details') . '</p>';
		}
	
		// Titre de la page
		$form_body .= '<p><label>' . elgg_echo('title') . " " . elgg_view('input/text', array('name' => 'cmspage_title', 'value' => $title, 'js' => ' style="width:500px;"')) . '</label></p>';
	
		// Blocs conditionnels : masqué si module, affiché si HTML ou template
		$hideifmodule = '';
		if ($content_type == 'module') { $hideifmodule = 'style="display:none;" '; }
		$hideifnotmodule = '';
		if ($content_type != 'module') { $hideifnotmodule = 'style="display:none;" '; }
	
		// Bloc conditionnel : tout sauf module
		$form_body .= '<div ' . $hideifmodule . 'class="toggle_detail field_ field_rawhtml field_template">';
		
			// Contenu du bloc / de la page
			$form_body .= '<label for="cmspage_content">';
			if (in_array($content_type, array('rawhtml'))) {
				$form_body .= elgg_echo('cmspages:content:rawhtml') . "</label>" . elgg_view('input/plaintext', array('name' => 'cmspage_content', 'value' => $description));
			} else if ($content_type == 'template') {
				$form_body .= elgg_echo('cmspages:content:template') . "</label>" . elgg_view('input/longtext', array('name' => 'cmspage_content', 'value' => $description, 'class' => 'elgg-input-rawtext'));
			} else {
				$form_body .= elgg_echo('cmspages:content:') . "</label>" . elgg_view('input/longtext', array('name' => 'cmspage_content', 'id' => 'cmspage_content', 'value' => $description));
			}
			// Templates utilisés par le contenu
			if ($content_type == 'template') { $form_body .= elgg_echo('cmspages:templates:list') . '&nbsp;:<br />' . cmspages_list_subtemplates($cmspage->description); }
			$form_body .= '<div class="clearfloat"></div><br />';
		
			// GUID - We don't really care (not used)
			//$cmspage_input = elgg_view('input/hidden', array('name' => 'cmspage_guid', 'value' => $cmspage_guid));
		
			// Tags
			$form_body .= '<p><label>' . elgg_echo('tags') . " " . elgg_view('input/tags', array('name' => 'cmspage_tags', 'value' => $tags, 'js' => ' style="width:70%;"')) . '</label></p>';
		
		$form_body .= '</div>';
		
		// Bloc conditionnel : seulement si module
		$form_body .= '<div ' . $hideifnotmodule . 'class="toggle_detail field_module">';
			// Load other content as a configurable module
			$form_body .= '<p><label>' . elgg_echo('cmspages:module') . '&nbsp; ' . elgg_view('input/dropdown', array('name' => 'module', 'value' => $module, 'options_values' => $module_opts)) . '</label></p>';
			// Infos
			$form_body .= '<p>' . elgg_echo('cmspages:module:infos') . '</p>';
			// Config du module
			$form_body .= '<p><label>' . elgg_echo('cmspages:module:config') . '<br />' . elgg_view('input/text', array('name' => 'module_config', 'value' => $module_config)) . '</label></p>';
		$form_body .= '</div>';
		
		
		// Accès à la page ou au module
		$form_body .= '<p><label>' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $access, 'options' => $access_opt)) . '</label></p>';
	
	//$form_body .= '</fieldset><br />';
	$form_body .= '<br />';
	
	
	// PARAMETRES AVANCES
	$form_body .= '<fieldset>';
		$form_body .= '<legend>' . elgg_echo('cmspages:fieldset:advanced') . '</legend>';
	
		// CSS
		$form_body .= '<p><label>' . elgg_echo('cmspages:css') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_css', 'value' => $css)) . '</label>' . '<br /><em>' . elgg_echo('cmspages:css:details') . '</em></p>';
	
		// JS
		$form_body .= '<p><label>' . elgg_echo('cmspages:js') . '<br/>' . elgg_view('input/plaintext', array('name' => 'page_js', 'value' => $js)) . '</label>' . '<br /><em>' . elgg_echo('cmspages:js:details') . '</em></p>';
		
		// Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou tous si aucun filtre défini)
		$form_body .= '<p><label>' . elgg_echo('cmspages:contexts') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'contexts', 'value' => $contexts, 'js' => ' style="width:400px;"')) . '</label><br /><em>' . elgg_echo('cmspages:contexts:details') . '</em></p>';
		
		// Affichage autonome et choix du layout personnalisé (si autonome)
		// Allow own page or not ('no' => no, empty or not set => default layout, other value => use display value as layout)
		$form_body .= '<p><label>' . elgg_echo('cmspages:display') . '&nbsp;:</label> ' . elgg_view('input/text', array('name' => 'display', 'value' => $display, 'js' => ' style="width:200px;"')) . '<br /><em>' . elgg_echo('cmspages:display:details') . '</em></p>';
		
		// Use custom template for rendering
		$form_body .= '<p><label>' . elgg_echo('cmspages:template:use') . '</label> ' . elgg_view('input/text', array('name' => 'template', 'value' => $template, 'js' => ' style="width:200px;"')) . '<br /><em>' . elgg_echo('cmspages:template:details') . '</em></p>';
		
	$form_body .= '</fieldset><br />';
	$form_body .= '<br />';
	
	
	// NON UTILISE
	$form_body .= '<fieldset ' . $hideifmodule . '>';
		$form_body .= '<legend>' . elgg_echo('cmspages:fieldset:unused') . '</legend>';
		
		// Bloc conditionnel : masqué si module, affiché si HTML ou template
		$form_body .= '<div ' . $hideifmodule . 'class="toggle_detail field_ field_rawhtml field_template">';
			$form_body .= '<div style="float:left; width:32%; margin-right:2%;">';
			$form_body .= "<p><label>" . elgg_echo('cmspages:container_guid') . " " . elgg_view('input/text', array('name' => 'container_guid', 'value' => $container_guid, 'js' => ' style="width:10ex;"')) . '</label></p>';
			$form_body .= '</div><div style="float:left; width:32%; margin-right:2%;">';
			$form_body .= "<p><label>" . elgg_echo('cmspages:parent_guid') . " " . elgg_view('input/text', array('name' => 'parent_guid', 'value' => $parent_guid, 'js' => ' style="width:10ex;"')) . '</label></p>';
			$form_body .= '</div><div style="float:right; width:32%;">';
			$form_body .= "<label>" . elgg_echo('cmspages:sibling_guid') . " " . elgg_view('input/text', array('name' => 'sibling_guid', 'value' => $sibling_guid, 'js' => ' style="width:10ex;"')) . '</label><br />';
			$form_body .= '</div>';
		$form_body .= '</div>';
		$form_body .= '<div class="clearfloat"></div>';
		
		// @TODO Categories should work like a custom menu
		$form_body .= "<p><label>" . elgg_echo('cmspages:categories') . " " . elgg_view('input/text', array('name' => 'categories', 'value' => $categories, 'js' => ' style="width:10ex;"')) . '</label></p>';
		// @TODO Images embeddding should work with site as owner (shared library)
		// @TODO Featured image should work by linking an image to the cmspage entity
		$form_body .= "<p><label>" . elgg_echo('cmspages:image') . " " . elgg_view('input/file', array('name' => 'featured_image', 'value' => $featured_image)) . '</label></p>';
		// @TODO : content embedding : embed any type of content into the page
		// @TODO : content linking : add relationships to any other entity types
	
	$form_body .= '</fieldset><br />';
	
	
	// Bouton d'envoi
	if ($cmspage instanceof ElggObject) {
		$form_body .= elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:save')));
	} else {
		$form_body .= elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:create')));
	}
	
	
	
	/* AFFICHAGE DU CONTENU DE LA PAGE */
	
	// Informations utiles : URL de la page + vue à utiliser pour charger la page
	if (elgg_instanceof($cmspage, 'object')) {
		echo '<blockquote>' . elgg_echo('cmspages:cmspage_url') . ' <a href="' . $vars['url'] . 'cmspages/read/' . $pagetype . '" target="_new" >' . $vars['url'] . 'cmspages/read/' . $pagetype . '</a><br />';
		echo elgg_echo('cmspages:cmspage_view') . ' ' . elgg_view('input/text', array('value' => 'elgg_view(\'cmspages/view\',array(\'pagetype\'=>"' . $pagetype . '"))', 'disabled' => "disabled", 'style' => "width:70ex"));
		echo '</blockquote>';
	}
	
	// Display the form - Affichage du formulaire
	echo elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/edit", 'body' => $form_body, 'id' => "cmspages-edit-form"));
}


