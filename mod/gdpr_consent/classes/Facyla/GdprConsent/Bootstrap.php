<?php

namespace Facyla\GdprConsent;

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
		// Extend CSS with custom styles
		elgg_extend_view('elgg.css', 'gdpr_consent/main.css');
		elgg_extend_view('walled_garden.css', 'gdpr_consent/main.css');
		
		elgg_extend_view('page/elements/footer', 'gdpr_consent/extend_footer', 400);
		
	}
	
}
