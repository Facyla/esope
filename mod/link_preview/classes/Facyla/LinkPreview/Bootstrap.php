<?php

namespace Facyla\LinkPreview;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function boot() {
		
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		elgg_extend_view('css', 'link_preview/css');
		
		//elgg_extend_view('object/bookmarks', 'link_preview/extend');
		
		// Register JS script - use with : elgg_load_js('plugin_template');
		elgg_register_js('jquery.live-preview', elgg_get_site_url() . 'mod/link_preview/vendors/jquery-live-preview/js/jquery-live-preview.min.js', 'head');
		elgg_register_css('jquery.live-preview', elgg_get_site_url() . 'mod/link_preview/vendors/jquery-live-preview/css/livepreview-demo.css');
		
		// Adds menu to page owner block - user and group only
		elgg_register_event_handler("pagesetup", "system", "link_preview_pagesetup");
		
		//if (elgg_in_context('bookmarks')) {
			elgg_load_js('jquery.live-preview');
			elgg_extend_view('page/elements/head', 'link_preview/extend');
		//}
	
		
	}
	
	/**
	 * Register plugin hooks
	 *
	 * @return void
	 */
	protected function registerHooks() {
		//$hooks = $this->elgg()->hooks;
		
		//$hooks->registerHandler('prepare', 'system:email', __NAMESPACE__ . '\Email::limitSubjectLength');
	}
	
}
