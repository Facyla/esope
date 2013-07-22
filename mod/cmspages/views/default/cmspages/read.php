<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : This view may render more than the pure content (description), as it's used 
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

if ($vars['pagetype']) {
	$options = array(
			'metadata_names' => array('pagetype'), 'metadata_values' => array($vars['pagetype']),
			'types' => 'object', 'subtypes' => 'cmspage',
			//'owner_guid' => 0, 'site_guid' => 0,
			'limit' => 1, 'offset' => 0, 'order_by' => '', 'count' => false,
		);
	$cmspages = elgg_get_entities_from_metadata($options);
	if ($cmspages) { $cmspage = $cmspages[0]; }

	// Is viewer a page editor ?
	$is_editor = false;
	if ( (elgg_is_logged_in() && (in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) ) || elgg_is_admin_logged_in() ) { $is_editor = true; }

	if ($cmspage) {
		// Check if allowed context - Forward si pas d'affichage pleine page autorisé
		if ($cmspage->display == 'no') { exit; }
		// Check allowed contexts - Exit si contexte non autorisé
		if (!empty($cmspage->contexts) && ($cmspage->contexts != 'all')) {
			$exit = true;
			$allowed_contexts = explode(',', $cmspage->contexts);
			foreach ($allowed_contexts as $context) {
				if (elgg_in_context(trim($context))) $exit = false;
			}
			if ($exit) { register_error('cmspages:wrongcontext'); forward(); }
		}
		
		$title = $cmspage->pagetitle;
		$content = '';
		
		// Contexte spécifique
		elgg_push_context('cmspages');
		elgg_push_context('cmspages:pagetype:' . $vars['pagetype']);
		
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
				$content .= cmspages_render_template($cmspage->description);
				break;
			case 'rawhtml':
			default:
				$content .= elgg_view('output/tags', array('tags' => $cmspage->tags));
				//$content .= $cmspage->description;
				// we need elgg-output class for lists, also added a custom class for finer output control
				// Can't use output/longtext view because of filtering
				$content .= '<div class="elgg-output elgg-cmspage-output">' . $cmspage->description . '</div>';
				// Set container as page_owner - useful mainly when displayed as a full page
				if (!empty($cmspage->container_guid)) elgg_set_page_owner_guid($cmspage->container_guid);
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
		$content .= "\n<style>" . $cmspage->css . "</style>\n";
		
	} else {
		register_error(elgg_echo('cmspages:notset'));
		// Les éditeurs peuvent rester.. ils pourront créer la page
		if (!$is_editor) { forward(); }
	}
	
	// Admin links : direct edit link fr users who can edit this
	if ($is_editor) {
		if ($cmspage) {
			$content .= '<small><p style="text-align:right;"><a href="' . $vars['url'] . 'cmspages?pagetype=' . $vars['pagetype'] . '"><kbd>[&nbsp;Modifier ' . $vars['pagetype'] . '&nbsp;]</kbd></a></p></small>';
		} else {
			$content .= "<p><blockquote>Cette page n'existe pas. Vous avez pu faire une erreur dans l'URL (attention aux '_', remplacés par des '-'), sinon vous pouvez cliquer sur le lien ci-dessous pour créer une nouvelle page à cette adresse.</blockquote></p>";
			$content .= '<small><p style="text-align:right;"><a href="' . $vars['url'] . 'cmspages?pagetype=' . $vars['pagetype'] . '"><kbd>[&nbsp;Créer ' . $vars['pagetype'] . '&nbsp;]</kbd></a></p></small>';
		}
	} else {
		elgg_pop_breadcrumb(); // Removes main cmspages link
	}
	elgg_push_breadcrumb($title); // Fil d'Ariane revu : Adds page title
	
	// Display through the correct canvas area
	//$content = elgg_view('page/elements/wrapper', array('body' => $content));
	// Allow to use own page (not concerned in a view)
	if (!empty($cmspage->display)) { $layout = $cmspage->display; }
	else { $layout = 'one_column'; }
}


//echo elgg_view_layout($layout, elgg_view_title($title) . $content);
$params = array('content' => elgg_view_title($title).$content, 'sidebar' => '');
echo elgg_view_layout($layout, $params);


