<?php
/**
 * plugin_template plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'link_preview_init');


/**
 * Init plugin_template plugin.
 */
function link_preview_init() {
	
	elgg_extend_view('css', 'link_preview/css');
	
	//elgg_extend_view('object/bookmarks', 'link_preview/extend');
	
	// Register JS script - use with : elgg_load_js('plugin_template');
	elgg_register_js('jquery.live-preview', elgg_get_site_url() . 'mod/link_preview/vendors/jquery-live-preview/js/jquery-live-preview.min.js', 'head');
	elgg_register_css('jquery.live-preview', elgg_get_site_url() . 'mod/link_preview/vendors/jquery-live-preview/css/livepreview-demo.css');
	
		// Adds menu to page owner block - user and group only
	elgg_register_event_handler("pagesetup", "system", "link_preview_pagesetup");
	
}


// @TODO pagesetup et charger les JS une seule fois si contexte bookmarks...
function link_preview_pagesetup(){
	if (elgg_in_context('bookmarks')) {
		elgg_load_js('jquery.live-preview');
		elgg_extend_view('page/elements/head', 'link_preview/extend');
	}
}


