<?php
/**
 * Elgg export embeddable content
 * 
 * @package Elggexport_embed
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2012-2015
 * @link http://id.facyla.net/
*/

// Initialise log browser
elgg_register_event_handler('init','system','export_embed_init');


function export_embed_init() {
	//elgg_extend_view('css','export_embed/css');
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('export_embed','export_embed_page_handler');
	// Attention : we can't use 'embed' because it breaks embedding files into text areas...
	
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'export_embed_public_pages');
	
	// Widget : view an external Elgg widget
	elgg_register_widget_type('export_embed', elgg_echo('export_embed:widget:title'), elgg_echo('export_embed:widget:description'), array('all'), true);
	
}


/* Handles export embed URLs
 * 
 * All URLs should respect this logic : 
 * ELGG_SITE_URL/embed/$embedtype/?param1=value1&...
 * 
 */
function export_embed_page_handler($page) {
	if (isset($page[0])) set_input('embedtype', $page[0]);
	include(dirname(__FILE__) . "/external_embed.php");
	return false;
}


// Permet l'accès aux pages des blocs exportables en mode "walled garden"
function export_embed_public_pages($hook, $type, $return_value, $params) {
	$return_value[] = 'export_embed/.*'; // URL pour les embed externes
	return $return_value;
}


