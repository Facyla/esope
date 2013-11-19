<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : this view is designed for inclusion into other views
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

$vars['body'] // Templates only : Loads additional content that will be rendered in {{%CONTENT%}}
*/


if ($vars['pagetype']) {
	
	// Is viewer a page editor ?
	$is_editor = false;
	if ( (elgg_is_logged_in() && (in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) ) || elgg_is_admin_logged_in() ) {
		$is_editor = true;
		// Editors can also edit any cmspage - including private ones
		elgg_set_ignore_access(true);
	}
	
	$options = array(
			'metadata_names' => 'pagetype', 'metadata_values' => $vars['pagetype'],
			'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1
		);
	$cmspages = elgg_get_entities_from_metadata($options);
	
	if ($cmspages) {
		$cmspage = $cmspages[0];
		if($cmspage) {
			// Check if allowed display (if not : no display) - Exit si pas d'affichage comme vue
			if ($cmspage->display == 'noview') { exit; }
			// Check allowed contexts - Exit si contexte non autorisé
			if (!empty($cmspage->contexts) && ($cmspage->contexts != 'all')) {
				$exit = true;
				$allowed_contexts = explode(',', $cmspage->contexts);
				foreach ($allowed_contexts as $context) {
					if (elgg_in_context(trim($context))) $exit = false;
				}
				if ($exit) return;
			}
			
			// Contexte spécifique
			elgg_push_context('cmspages');
			elgg_push_context('cmspages:pagetype:' . $vars['pagetype']);
			
			$title = $cmspage->pagetitle;
			$content = '';
			switch ($cmspage->content_type) {
				case 'module':
					// Load a specific module
					if (!empty($cmspage->module)) {
						$module_config = cmspages_extract_module_config($cmspage->module, $cmspage->module_config);
						foreach ($module_config as $module_name => $config) {
							$content .= cmspages_compose_module($module_name, $config);
						}
					}
					break;
				case 'template':
					// Replace wildcards with values.. {{pagetype}}
					$content .= cmspages_render_template($cmspage->description, $vars['body']);
					break;
				case 'rawhtml':
				default:
					/*
					$content .= '<span style="display:none;">';
					$content .= elgg_view('output/tags', array('tags' => $cmspage->tags));
					$content .= '</span>';
					*/
					//$content .= $cmspage->description;
					// we need elgg-output class for lists, also added a custom class for finer output control
					// Can't use output/longtext view because of filtering
					$content .= '<div class="elgg-output elgg-cmspage-output">' . $cmspage->description . '</div>';
					// Set container as page_owner - not really useful as a view..
					//if (!empty($cmspage->container_guid)) elgg_set_page_owner_guid($cmspage->container_guid);
					// Use parent entity as hierarchical navigation link
					/*
					if (!empty($cmspage->parent_guid)) {
						$parent = get_entity($cmspage->parent_guid);
						$content .= '<br /><a href="' . $parent->getURl() . '">Parent : ' . $parent->title . $parent->name . '</a>';
					}
					// Use sibling entity as horizontal navigation link
					if (!empty($cmspage->sibling_guid)) {
						$sibling = get_entity($cmspage->sibling_guid);
						$content .= '<br /><a href="' . $sibling->getURl() . '">Lien connexe : ' . $sibling->title . $sibling->name . '</a>';
					}
					*/
			}
			
			// Ajout des feuilles de style personnalisées
			if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
			// Ajout des JS personnalisés
			if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";
			
			// On retire les contextes spécifiques à ce bloc
			elgg_pop_context();
			elgg_pop_context();
		}
	}
	
	// Admin links : direct edit link fr users who can edit this
	if ($is_editor) {
		if ($cmspage) {
			$content .= '<small><p style="text-align:right;"><a href="' . $vars['url'] . 'cmspages?pagetype=' . $vars['pagetype'] . '"><kbd>[&nbsp;Modifier ' . $vars['pagetype'] . '&nbsp;]</kbd></a></p></small>';
		} else {
			$content .= "<p><blockquote>Vue non définie.</blockquote></p>";
			$content .= '<small><p style="text-align:right;"><a href="' . $vars['url'] . 'cmspages?pagetype=' . $vars['pagetype'] . '"><kbd>[&nbsp;Créer ' . $vars['pagetype'] . '&nbsp;]</kbd></a></p></small>';
		}
	}
	
}

echo $content;

