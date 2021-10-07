<?php

namespace Facyla\TarteAuCitron;

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
		elgg_extend_view('elgg.css', 'tarteaucitron/main.css');
		elgg_extend_view('walled_garden.css', 'tarteaucitron/main.css');
		
		elgg_extend_view('page/elements/head', 'tarteaucitron/extend_head', 600);
		
		// Mise en cache des vues
		elgg_register_simplecache_view('tarteaucitron/tarteaucitron.js');
		elgg_register_simplecache_view('tarteaucitron/tarteaucitron.services.js');
		elgg_register_simplecache_view('tarteaucitron/css/tarteaucitron.css');
		
		/*
				elgg_define_js('leaflet-draw', [
			'src' => elgg_get_simplecache_url('leaflet.draw.js'),
			'deps' => ['leaflet'],
		]);
		*/
		
	}
	
}
