<?php

namespace Facyla\RssSimplepie;

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
		elgg_extend_view('elgg.css', 'rss_simplepie/rss_simplepie.css');
		elgg_extend_view('admin.css', 'rss_simplepie/rss_simplepie.css');
		require_once elgg_get_plugins_path() . 'rss_simplepie/vendors/SimplePie/SimplePie_1-6-0.php';
	}

	public function activate() {
		// Dirty hack to update classes (use Bootstrap activate)

	}


}
