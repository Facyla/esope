<?php

namespace Facyla\SocialShare;

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
		elgg_extend_view('elgg.css', 'socialshare/main.css');
	
		/*
		//$extended = 'owner_block/extend';
		$extension = 'socialshare/extend';
		$extendviews = elgg_get_plugin_setting('extendviews', 'socialshare');
		if (!empty($extendviews)) {
			$extendviews = str_replace(array(';', ' ', '\n', '\r', '\t'), ',', $extendviews);
			$extendviews = explode(',', $extendviews);
			$extendviews = array_filter($extendviews);
			foreach($extendviews as $view) {
				$view = trim($view);
				if (!empty($view)) {
					elgg_extend_view($view, $extension);
				}
			}
		}
		*/
		
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
