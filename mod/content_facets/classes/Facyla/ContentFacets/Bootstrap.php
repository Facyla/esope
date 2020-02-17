<?php

namespace Facyla\ContentFacets;

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
		elgg_extend_view('elgg.css', 'content_facets/main.css');
	
		// Main functionnality
		elgg_extend_view('output/longtext', 'content_facets/longtext_extend');
		
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
