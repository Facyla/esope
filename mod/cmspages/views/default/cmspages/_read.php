<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : This view is designed to provide a full interface to CMS Pages viewing
*/

/*
$content .= $cmspage->guid; // who cares ?
$content .= $cmspage->access_id;
// These are for future developments
$content .= $cmspage->container_guid; // should be set as page_owner
$content .= $cmspage->parent_guid; // can be used for vertical links
$content .= $cmspage->sibling_guid; // can be used for horizontal links
// This if for a closer integration with externalblog, as a generic edition tool
$content .= $cmspage->content_type; // Type of content (default = HTML)
$content .= $cmspage->contexts; // Allowed contexts (empty or all => all)
$content .= $cmspage->module; // Load a specific module (use content as intro ? param ?)
$content .= $cmspage->display; // Allow to use own page (not concerned in a view)
*/

$pagetype = elgg_extract('pagetype', $vars);
$cmspage = elgg_extract('entity', $vars);

// We need at least entity or pagetype
if (!$pagetype && !$cmspage) { return; }

// Is viewer a page editor ?
$is_editor = false;
if (cmspage_is_editor()) {
	$is_editor = true;
	// Editors can also edit any cmspage - including private ones
	$ia = elgg_set_ignore_access(true);
}

// Get pagetype from entity
if (!$pagetype) { $pagetype = $cmspage->pagetype; }
// Or optional entity from pagetype
if (!$cmspage) { $cmspage = cmspages_get_entity($pagetype); }

// Page existante ? Seuls les éditeurs peuvent rester (ils pourront créer la page)
if (!elgg_instanceof($cmspage, 'object', 'cmspage')) {
	if (!$is_editor) {
		register_error(elgg_echo('cmspages:notset'));
		forward();
	}
}

// Check if full page display is allowed - Exit si pas d'affichage pleine page autorisé
if ($cmspage->display == 'no') { return; }

// Check if using a password, and if user has access, or display auth form
// If form is displayed, user does not have access so return right after form
if ($cmspage && !cmspages_check_password($cmspage)) { return; }

// Check allowed contexts - Exit si contexte non autorisé
if (!empty($cmspage->contexts) && ($cmspage->contexts != 'all')) {
	$exit = true;
	$allowed_contexts = explode(',', $cmspage->contexts);
	foreach ($allowed_contexts as $context) {
			if (elgg_in_context(trim($context))) {
				$exit = false;
				break;
			}
	}
	if ($exit) { register_error('cmspages:wrongcontext'); return; }
}


// Contexte spécifique
elgg_push_context('cmspages');
elgg_push_context('cmspages:pagetype:' . $pagetype);



/* Start composing content */
$content = '';

// Set page inner title : readable title or none
$title = '';
if (!empty($cmspage->pagetitle)) $title = $cmspage->pagetitle;


// Use various rendering modes depending on cmspage content type
switch ($cmspage->content_type) {
	
	// Load a specific module
	case 'module':
		if (!empty($cmspage->module)) {
			$module_config = cmspages_extract_module_config($cmspage->module, $cmspage->module_config);
			foreach ($module_config as $module_name => $config) {
				$content .= cmspages_compose_module($module_name, $config);
			}
		}
		break;
	
	/* Use as a templating system
	 * see cmspages_render_template() for allowed template syntax
	 * Replace tags : {{pagetype}}, {{:view}}, {{:view|param=value}}, {{%VARS%}}, {{[shortcode]}}
	 */
	case 'template':
		// Replace wildcards with values.. {{pagetype}}
		$content .= cmspages_render_template($cmspage->description);
		break;
	
	// Basically render cmspage raw content (text or HTML)
	case 'rawhtml':
	default:
		$content .= elgg_view('output/cmspages_tags', array('tags' => $cmspage->tags));
		$content .= elgg_view('output/cmspages_categories', array('categories' => $cmspage->categories));
		//$content .= $cmspage->description;
		// we need elgg-output class for lists, also added a custom class for finer output control
		// Note : cannot use output/longtext view because of filtering
		$content .= '<div class="elgg-output elgg-cmspage-output">' . $cmspage->description . '</div>';
		// Set container as page_owner - useful mainly when displayed as a full page
		if (!empty($cmspage->container_guid)) { elgg_set_page_owner_guid($cmspage->container_guid); }
		// Use parent entity as hierarchical navigation link
		if (!empty($cmspage->parent_guid)) {
			$parent = get_entity($cmspage->parent_guid);
			$content .= '<br /><a href="' . $parent->getURl() . '">Parent : ' . $parent->title . $parent->name . '</a>';
		}
		// Use sibling entity as horizontal navigation link
		if (!empty($cmspage->sibling_guid)) {
			$sibling = get_entity($cmspage->sibling_guid);
			$content .= '<br /><a href="' . $sibling->getURl() . '">Lien connexe : ' . $sibling->title . $sibling->name . '</a>';
		}
	
}

// Ajout des feuilles de style personnalisées
if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
// Ajout des JS personnalisés
if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";

// TEMPLATE - Use another cmspage as wrapper template
// Do we use a custom cmspages template ? : not for templates (recursive risks)
// If yes, we'll fetch the rendered content into the template cmspage before sending it to the display rendering
// Content will be passed to the template as 'CONTENT'
	// @TODO permettre d'inclure des templates dans d'autres, mais avec un stack pour cesser si l'on rencontre un template déjà utilisé
	// @TODO fonction de rendu du contenu, avec 2 modes 'read' et 'view'
if ($cmspage->content_type != 'template') {
	if (!empty($cmspage->template)) {
		$template_options = array('metadata_names' => array('pagetype'), 'metadata_values' => array($cmspage->template), 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1);
		$templates = elgg_get_entities_from_metadata($options);
		if ($templates) { $template = $templates[0]; }
		$content = elgg_view('cmspages/view', array('pagetype' => $cmspage->template, 'body' => $content));
	}
}


// Admin links : direct edit link fr users who can edit this
if ($is_editor) {
	$content .= '<i class="fa fa-edit"></i><div class="cmspages-admin-link">';
	if ($cmspage) {
		$content .= '<a href="' . $vars['url'] . 'cmspages?pagetype=' . $pagetype . '"><kbd>' . elgg_echo('cmspages:edit', array($pagetype)) . '</kbd></a>';
	} else {
		$content .= '<blockquote>' . elgg_echo('cmspages:notexist:create') . '</blockquote>';
		$content .= '<a href="' . $vars['url'] . 'cmspages?pagetype=' . $pagetype . '"><kbd>' . elgg_echo('cmspages:createnew', array($pagetype)) . '</kbd></a>';
	}
	$content .= '</div>';
} else {
	//elgg_pop_breadcrumb(); // Removes main cmspages link
}
//elgg_push_breadcrumb($title); // Fil d'Ariane revu : Adds page title


echo $content;

