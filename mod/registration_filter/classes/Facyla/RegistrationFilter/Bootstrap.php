<?php

namespace Facyla\RegistrationFilter;

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
		elgg_extend_view('elgg.css', 'registration_filter/main.css', 900);
		//elgg_extend_view('admin.css', 'registration_filter/admin.css', 900);
		
		elgg_extend_view('forms/register', 'forms/registration_filter_register_extend', 0);
		
	}
	
	public function activate() {
		// Dirty hack to update classes (use Bootstrap activate)
		
	}
	
	
}
