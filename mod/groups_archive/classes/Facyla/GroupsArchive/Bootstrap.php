<?php

namespace Facyla\AccountLifeCycle;

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
		elgg_extend_view('elgg.css', 'account_lifecycle/account_lifecycle.css');
		elgg_extend_view('admin.css', 'account_lifecycle/account_lifecycle.css');
		
		//elgg_extend_view('forms/register', 'forms/account_lifecycle_register_extend', 0);
		
	}
	
	public function activate() {
		// Dirty hack to update classes (use Bootstrap activate)
		
	}
	
	
}
