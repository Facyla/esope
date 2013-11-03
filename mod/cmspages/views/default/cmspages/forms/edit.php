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

$pagetype = elgg_get_friendly_title($vars['pagetype']); //get the page type - used as a user-friendly guid

// empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
if (empty($pagetype)) {} 
else if (strlen($pagetype) < 3) { register_error(elgg_echo('cmspages:unsettooshort')); } 
else {
	//$cmspages = get_entities_from_metadata('pagetype', $pagetype, "object", "cmspage", 0, 1, 0, "", 0, false); // 1.6
	$options = array('metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1, 'offset' => 0, 'order_by' => '', 'count' => false );
	$cmspages = elgg_get_entities_from_metadata($options);

	if ($cmspages) {
		$cmspage = $cmspages[0];
		$title = $cmspage->pagetitle;
		$description = $cmspage->description;
		$tags = $cmspage->tags;
		$cmspage_guid = $cmspage->guid;
		$access = $cmspage->access_id;
		// These are for future developments
		$container_guid = $cmspage->container_guid;
		$parent_guid = $cmspage->parent_guid;
		$sibling_guid = $cmspage->sibling_guid;
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
		$css = $cmspage->css;
		$js = $cmspage->js;
	} else { $access = (defined("ACCESS_DEFAULT")) ? ACCESS_DEFAULT : ACCESS_PUBLIC; }
	
	
	// COMPOSITION DU FORMULAIRE
	$form_body = '';
	// Nom de la page : non éditable (= identifiant de la page)
	$form_body .= '<label>' . elgg_echo('cmspages:pagetype') . ' <input type="text" value="'.$pagetype.'" disabled="disabled" style="width:300px;" /></label>' . elgg_view('input/hidden', array('name' => 'pagetype', 'value' => $pagetype)) . '</label>';
	// Informations utiles : URL de la page + vue à utiliser pour charger la page
	if ($cmspage instanceof ElggObject) {
		$form_body .= '<br />' . elgg_echo('cmspages:cmspage_url') . ' <a href="' . $vars['url'] . 'pg/cmspages/read/' . $pagetype . '" target="_new" >' . $vars['url'] . 'pg/cmspages/read/' . $pagetype . '</a><br />';
		$form_body .= elgg_echo('cmspages:cmspage_view') . ' elgg_view(\'cmspages/view\',array(\'pagetype\'=>"' . $pagetype . '"))<br /><br />';
	}
	
	// Type de contenu : HTML ou module => définit les champs affichés
	// This if for a closer integration with externalblog, as a generic edition tool
	$content_type_opts = array('' => "HTML (avec éditeur de texte)", 'rawhtml' => "HTML (ne pas charger l'éditeur)", 'module' => "Module configurable", 'template' => "Template (agencement de pages et modules CMS)");
	//$content_type_input = "Type de contenu : par défaut = HTML avec éditeur, rawhtml = HTML sans éditeur<br />" . elgg_view('input/text', array('name' => 'content_type', 'value' => $content_type)) . '<br />';
	// elgg_view('input/dropdown', array('name' => 'content_type', 'value' => $content_type, 'options_values' => $content_type_opts)) . '</label><br /><br />';
	$form_body .= "<label>Type de contenu&nbsp; ";
	$form_body .= '<select onchange="javascript:$(\'.toggle_detail\').hide(); $(\'.toggle_detail.field_\'+this.value).show();" name="content_type">';
	foreach ($content_type_opts as $val => $text) {
		if ($val == $content_type) $form_body .= '<option value="' . $val . '" selected="selected">' . $text . '</option>';
		else $form_body .= '<option value="' . $val . '">' . $text . '</option>';
	}
	$form_body .= '</select></label><br /><br />';
	
	// More infos on chosen content type
	if ($content_type == 'template') $form_body .= "<p>Utilisation des templates :<ul>
		<li>{{cmspages-pagetype}} : insère le contenu de la page CMS 'cmspages-pagetype'</li>
		<li>{{%CONTENT%}} : insère le contenu chargé par un outil tiers (blogs externes typiquement)</li>
		</ul></p>';
	
	// Titre de la page
	$form_body .= '<label>' . elgg_echo('title') . " " . elgg_view('input/text', array('name' => 'cmspage_title', 'value' => $title, 'js' => ' style="width:500px;"')) . '</label><br /><br />';
	
	// Blocs conditionnels : masqué si module, affiché si HTML ou template
	if ($content_type == 'module') $hideifmodule = 'style="display:none;" '; else $hideifmodule = '';
	if ($content_type != 'module') $hideifnotmodule = 'style="display:none;" '; else $hideifnotmodule = '';
	
	$form_body .= '<div ' . $hideifmodule . 'class="toggle_detail field_ field_rawhtml field_template">';
		// Contenu de la page
		if (in_array($content_type, array('rawhtml', 'template'))) $form_body .= "<label>Contenu de la page ou du bloc<br/>" . elgg_view('input/plaintext', array('name' => 'cmspage_content', 'value' => $description)) . '</label><div class="clearfloat"></div>';
		else $form_body .= "<label>Contenu de la page ou du bloc<br/>" . elgg_view('input/longtext', array('name' => 'cmspage_content', 'value' => $description)) . '</label><div class="clearfloat"></div>';
		// We don't really care (not used)
		//$cmspage_input = elgg_view('input/hidden', array('name' => 'cmspage_guid', 'value' => $cmspage_guid));
		// Tags
		$form_body .= '<br /><label>' . elgg_echo('tags') . " " . elgg_view('input/tags', array('name' => 'cmspage_tags', 'value' => $tags, 'js' => ' style="width:500px;"')) . '</label><br /><br />';
		// Allow own page or not ('no' => no, empty or not set => default layout, other value => use display value as layout)
	$form_body .= '</div>';
	
	$form_body .= "<label>CSS personnalisées pour cette page, ce module ou ce bloc<br/>" . elgg_view('input/plaintext', array('name' => 'page_css', 'value' => $css)) . '</label><div class="clearfloat"></div>';
	
	$form_body .= "<label>JS personnalisées pour cette page, ce module ou ce bloc<br/>" . elgg_view('input/plaintext', array('name' => 'page_js', 'value' => $js)) . '</label><div class="clearfloat"></div>';
	
	// Bloc conditionnel : masqué si pas un module
	$form_body .= '<div ' . $hideifnotmodule . 'class="toggle_detail field_module">';
		// Load other content as a configurable module
		$module_opts = array('' => 'Aucun (bloc vide)', 'title' => 'Titre', 'listing' => 'Liste d\'entités', 'search' => 'Résultats de recherche', 'entity' => 'Entité', 'view' => 'Vue configurable');
		$form_body .= "<label>Module&nbsp; " . elgg_view('input/dropdown', array('name' => 'module', 'value' => $module, 'options_values' => $module_opts)) . '</label><br /><br />';
		// Config du module
		$form_body .= "<label>Configuration du module (param=value&amp;param2=value2...)<br />" . elgg_view('input/text', array('name' => 'module_config', 'value' => $module_config)) . '</label><br />';
	$form_body .= '</div>';
	
	// Contexte d'utilisation : ne s'affiche que si dans ces contextes (ou all)
	$form_body .= "<label>Filtre des contextes autorisés (liste, ou rien)&nbsp;: " . elgg_view('input/text', array('name' => 'contexts', 'value' => $contexts, 'js' => ' style="width:400px;"')) . '</label><br /><br />';
	
	// Affichage autonome et Layout personnalisé
	$form_body .= "<label>Affichage autonome :</label>vide = oui (par défaut), 'no' pour non (élément d'interface seulement), 'noview' exclusif (page seulement, pas élément d'interface), nom du layout pour utiliser un layout spécifique&nbsp;: " . elgg_view('input/text', array('name' => 'display', 'value' => $display, 'js' => ' style="width:200px;"')) . '<br /><br />';
	// $display_opts = array('' => "Oui (par défaut)", 'no' => "Non (seulement comme vue)", 'noview' => "Page seulement (pas comme vue)");
	// elgg_view('input/dropdown', array('name' => 'display', 'value' => $display, 'options_values' => $display_opts));
	
	// Bloc conditionnel : masqué si module, affiché si HTML ou template
	$form_body .= "<em>Note : These are for future developments</em>";
	$form_body .= '<div ' . $hideifmodule . 'class="toggle_detail field_ field_rawhtml field_template">';
		$form_body .= '<div style="float:left; width:32%; margin-right:2%;">';
		$form_body .= "<label>GUID du container " . elgg_view('input/text', array('name' => 'container_guid', 'value' => $container_guid, 'js' => ' style="width:10ex;"')) . '</label><br /><br />';
		$form_body .= '</div><div style="float:left; width:32%; margin-right:2%;">';
		$form_body .= "<label>GUID du parent " . elgg_view('input/text', array('name' => 'parent_guid', 'value' => $parent_guid, 'js' => ' style="width:10ex;"')) . '</label><br /><br />';
		$form_body .= '</div><div style="float:right; width:32%;">';
		$form_body .= "<label>GUID du frère " . elgg_view('input/text', array('name' => 'sibling_guid', 'value' => $sibling_guid, 'js' => ' style="width:10ex;"')) . '</label><br />';
		$form_body .= '</div>';
	$form_body .= '</div>';
	$form_body .= '<div class="clearfloat"></div>';
	
	// Accès à la page ou du module
	$form_body .= '<label>' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $access, 'options' => array(
				ACCESS_PUBLIC => elgg_echo('PUBLIC'), 
				ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'), 
				ACCESS_PRIVATE => elgg_echo('PRIVATE'))
		)) . '</label><br /><br />';
	// ACCESS_DEFAULT => elgg_echo('default_access:label') //("accès par défaut")
	
	
	// Bouton d'envoi
	if ($cmspage instanceof ElggObject) $form_body .= elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:save')));
	else $form_body .= elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('cmspages:create')));

	// Display the form - Affichage du formulaire
	echo elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/edit", 'body' => $form_body));
}

